<?php

namespace DNABeast\TabMenu;

use Illuminate\Support\Facades\Request;

class TabMenu
{
	public function build($string){
		$HTMLFormattedList = $this->formatList($string, config('tabmenu.nowrap'));
		$this->countTags($HTMLFormattedList);
		return $HTMLFormattedList;
	}

	public function indentToTabs($string)
	{
		return str_replace(config('tabmenu.indent')??"\t", "\t", $string);
	}

	public function removeEmptylines($lines)
	{
		$lines = array_filter($lines, function($line) {
			return !ctype_space($line) && $line != '';
		});
		return array_values($lines);
	}

	public function lines($string){
		$lines = explode(PHP_EOL, $string);
		$lines = $this->removeEmptyLines($lines);
		return $lines;
	}

	public function countTabsArray($string)
	{
		$linesOfMenu = $this->lines($string);

		$linesOfMenu = array_map(function($item){
			$tabCount = substr_count($item, "\t");
			$linkData = str_replace("\t", '', $item);
			return [$tabCount, $linkData];
		}, $linesOfMenu);

		return $linesOfMenu;
	}

	public function formatAnchorTag($string)
	{
		$array = explode(',', $string);

		$array = array_map(function($item){
			return trim($item, ' ');
		}, $array);

		$array = $this->createSlugLink($array);
		$class = $this->AddClassToLink($array);

		return '<a href="'.$array[1].'"'.$class.'>'.$array[0].'</a>';
	}


	public function createSlugLink($linkArray){
		$prefix = $this->checkForPrefix();

		if (!isset($linkArray[1])){
			$linkArray[1] = '/'.str_slug($linkArray[0]);
		}
		if (isset($prefix)){
			$linkArray[1] = '/'.$prefix.$linkArray[1];
		}
		return $linkArray;
	}

	public function addClassToLink($linkArray){
		return (isset($linkArray[2]))?$class=' class="'.$linkArray[2].'"':'';
	}

	public function formatList($string, $nowrap=null){
		$array = $this->countTabsArray($string);

		$listHTML = '';
		$startTab = $array[0][0];
		$counter = $startTab-1;
		foreach ($array as $line){
			$diff = $line[0]-$counter;
			if ($diff==1){
				$listHTML .= "<ul>";
			}
			if ($diff>1){
				throw new \Exception('List Items should only indent one tab');
			}
			if ($diff<0){
				for($i=0; $i>$diff; $i--){
					$listHTML .= "</li></ul>";
				}
				$listHTML .= "</li>";
			}
			if ($diff==0){
				$listHTML .= "</li>";
			}

			$listHTML .= "<li>".$this->formatAnchorTag($line[1]);

			$counter = $line[0];
		}
		while($counter>$startTab){
			$listHTML .= "</li></ul>";
			$counter--;
		}

		$listHTML .= "</li></ul>";

		if ($nowrap){
			$listHTML = substr($listHTML, 4);
			$listHTML = substr($listHTML, 0, -5);
		}

		return $listHTML;

	}

	public function countTags($string)
	{
		$countOpen = substr_count($string, '<ul>');
		$countClose = substr_count($string, '</ul>');

		if ($countOpen!=$countClose) {
			throw new \Exception('Menu list didn\'t close properly');
		}

	}


	public function checkForPrefix()
	{
		$prefix = config('tabmenu.prefix')??'admin';
		return Request::segment(1)==$prefix?Request::segment(1):null;
	}

}

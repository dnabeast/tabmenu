HTML menu creation for Laravel Blade
====================================

This allows you to define your HTML menu system using easy to read syntax in a blade file.

It allows the menu urls to change if it's called from an admin directory.

Installing
==========

Add the dependency to your project:

```bash
composer require DNABeast/tabmenu
```

##Publish the config file

```
php artisan vendor:publish
```

### Laravel 5.5:

The ServiceProvider is automatically discovered.

### Laravel 5.2:

Add to your app.php config.
```
DNABeast\TabMenu\TabMenuServiceProvider::class,
```

You may need to clear the view cache
```
php artisan view:clear
```

Usage
=====

In your blade file enter the custom @menu directive, and the @endmenu directive.
Enter your menu as text list. You can indent if you wish.

```
@menu
[tab][tab]Menu 1
[tab][tab]Menu 2
[tab][tab]Menu 3
@endmenu
```

outputs

```
<ul>
	<li><a href="/menu-1">Menu 1</a></li>
	<li><a href="/menu-2">Menu 2</a></li>
	<li><a href="/menu-3">Menu 3</a></li>
</ul>
```

### Sub-menus

Add a tab and the menu item will become a sub-menu.

```
@menu
[tab][tab]Menu 1
[tab][tab][tab]Menu 1a
[tab][tab][tab][tab]Menu 1ax
[tab][tab]Menu 2
@endmenu
```
creates
```
<ul>
	<li><a href="/menu-1">Menu 1</a><ul>
		<li><a href="/menu-1a">Menu 1a</a><ul>
			<li><a href="/menu-1ax">Menu 1ax</a></li></ul>
		</li></ul>
	</li>
	<li><a href="/menu-2">Menu 2</a></li>
</ul>
```

### Set URLs

Put a comma and set the url when it's different to the menu name

```
@menu
Menu, /menu-one-location
Menu 2
@endmenu
```
becomes
```
<ul>
	<li><a href="/menu-one-location">Menu</a></li>
	<li><a href="/menu-2">Menu 2</a></li>
</ul>
```

### Set a Class

If your menu item requires a class name just add it after a second comma

```
@menu
Menu Item, /menu-item, action
@endmenu
```
becomes
```
<ul>
	<li><a href="/menu-item" class="action">Menu Item</a></li>
</ul>
```


### Unwrap the primary ul tag

If you need to add manual menu items it's useful to be able to remove the wrapping <ul\> tag.

Publish the config file
```
php artisan vendor:publish
```
and change the nowrap flag to true.


```
@menu
Menu Item, /menu-item, action
@endmenu
```
becomes
```
	<li><a href="/menu-item" class="action">Menu Item</a></li>
```

### Change the tabs to spaces

I get it. You prefer pragmatism over semantics. You can change the tab to 2 spaces or 4 spaces if you like.

In the published config file type whatever your preferred indentation is.
```
'indent' => '----'
```

### Alter the prefix for admin links

In the published config file enter the name of your admin folder.
```
'prefix' => 'dashboard'
```

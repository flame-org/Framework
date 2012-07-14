FLAME:CMS
======

Flame is simple but smart CMS based on php framework [Nette](http://nette.org/)

If you want to try FLAME:CMS (I recommend it), you should start with [Flame sandbox](https://github.com/jsifalda/flame-sandbox).

Flame is available over Composer. Please visit [PACKAGIST](http://packagist.org/packages/jsifalda/flame)

### Requirements
* PHP 5.3+
* MySQL 5+
* Composer
* Nette Framework 2.0
* Doctrine 2.2+

### Required Settings (Change the settings in the file: **CONFIG.NEON**)
Flame required:
* Setup database credentials
* Create database structure (use **DATABASE.SQL** file)
* Install dependencies with composer

### Features
* Access control list
* Creating / editing posts
* Comments
* TimyCME editor
* Managing of images
* Paginator for posts
* Users management
* Newsreel
* Pages management

### Global available settings
If you want to affect prepared options (set up in the options section)
* name (e.g. 'FLAME', default: null)
* thumbnail_width (default: 230)
* thumbnail_height (default: 230)
* items_per_page (Paginator, default: 10)
* items_in_newsreel_menu_list (default: 3)
* items_in_menu (default: 5)


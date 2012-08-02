#FLAME:CMS

Flame is simple but smart CMS based on php framework [Nette](http://nette.org/)

If you want to try FLAME:CMS (I recommend it), you should start with [Flame sandbox](https://github.com/jsifalda/flame-sandbox).

Flame is available over Composer. Please visit [PACKAGIST](http://packagist.org/packages/jsifalda/flame)

### Requirements
* PHP 5.3+
* MySQL 5+
* Nette Framework 2.0
* Doctrine 2.2+
* Composer (dependencies manager)

### Required Settings (Change the settings in the file: **CONFIG.NEON**)
Flame required:
* Setup database credentials
* Create database structure by Doctrine
* Install dependencies with composer

### Features
* Access control list
* Creating / editing posts (categories, tags)
* Comments
* TimyCME editor
* Managing of images
* Paginator for posts
* Users management
* Newsreel
* Pages management
* MarkDown syntax support
* Wordpress posts import

### Global available settings
If you want to affect prepared options (set up in the options section)
* name (e.g. 'FLAME', default: null)
* thumbnail_width (default: 230)
* thumbnail_height (default: 230)
* items_per_page (Paginator, default: 10)
* menu_items (default: 5)
* menu_newsreel_count (default: 3)
* menu_tags_count (default: 35)

If you want to sign in to backend part (Administration) of Flame, use email **user@demo.com** and password **PASSWORD12** (in lower case)



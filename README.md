FLAME
======

Flame is simple but smart CMS based on php framework [Nette](http://nette.org/)

WARNING: This package is under active development, and shouldn't be used at production!

### Requirements
* Nette framework

### Required Settings
JS-CMS required setup:
* Database credentials
* Create database structure (use **DATABASE.SQL** file)

Change the settings in the file: **CONFIG.NEON**

### Features
* Access control list
* Creating / editing posts
* Comments
* TimyCME editor
* Managing of images
* Paginator for posts
* Users management
* Newsreel

### Global variables
If you want to affect prepared options (set up in the options section)
* name (e.g. 'JSCMS')
* thumbnail_width (default: 230)
* thumbnail_height (defautl: 230)
* items_per_page (Paginator, default: 10)
* items_in_newsreel_menu_list (default: 3)


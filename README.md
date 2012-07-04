JS-CMS
======

Simple CMS based on php framework [Nette](http://nette.org/)

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

### Global variables
If you want to affect prepared options (set up in the options section)
* name (e.g. 'JSCMS')
* thumbnail_width (default: 230)
* thumbnail_height (defautl: 230)
* items_per_page (Paginator, default: 10)


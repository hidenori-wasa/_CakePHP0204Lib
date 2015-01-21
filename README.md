Wasa's Bootstrap3 form library.
===============================

Notice
------

* This cannot use because I have been implementing code yet.

Requirements
------------

* [CakePHP(2.4-)](http://cakephp.jp/)
* [Bootstrap(3.2-)](http://getbootstrap.com/)

Requirements of browser.
------------------------

* Windows: Newer Chrome browser. Newer FireFox browser. Newer Opera browser. Since Internet Explorer 8 browser.
* Mac:     Newer Chrome browser. Newer FireFox browser. Newer Opera browser. Newer Safari browser.
* Linux:   Newer Chrome browser. Newer FireFox browser.
* iOS:     Newer Chrome browser. Newer Safari browser.
* Android: Newer Chrome browser.

Installation
------------

* Procedure 1: Copy "app/Lib/Wasa/" directory to your "app/Lib/Wasa/" directory.
* Procedure 2: Make "Bootstrap" files with site which [customizes "Bootstrap".](http://getbootstrap.com/customize/)
* Procedure 3: Copy made "Bootstrap" files to your "app/webroot/css/", "app/webroot/fonts/" and "app/webroot/js/" directory.
* Procedure 4: Copy ["jQuery"](http://jquery.com/) file to your "app/webroot/js/" directory.
* Procedure 5: Add following into "app/Config/bootstrap.php" file.

```php
App::build(array ('Wasa/Controller' => array ('../Lib/Wasa/Controller/')));
App::build(array ('Wasa/Model' => array ('../Lib/Wasa/Model/')));
App::build(array ('View/Helper' => array ('../Lib/Wasa/View/Helper/')));
App::build(array ('Wasa/Cache' => array ('../Lib/Wasa/Cache/')));
CakePlugin::load('BoostCake');
```

* Procedure 6: Extend your classes of "Controller" and "Model" as below.

```php
\App::uses('WasaAppController', 'Wasa/Controller');
class SomethingController extends \WasaAppController

\App::uses('WasaAppModel', 'Wasa/Model');
class WasaBootstrap030200FormSample extends \WasaAppModel
```

* Procedure 7: Copy ["BoostCake" plugin](https://github.com/slywalker/cakephp-plugin-boost_cake) to your "app/Plugin/BoostCake/" directory.
* Procedure 8: Copy "_WasaManual" to "http://localhost/_WasaManual/".
* Procedure 9: Add following into "app/Config/core.php" file.

```php
const WASA_DEBUG_LEVEL = 2; // This value is 0-2.
Configure::write('debug', WASA_DEBUG_LEVEL);
```

Change log
----------

* I added "\WasaAppModel::__construct()" class method.
* I repaired "\WasaCache::__write()" class method.
* I repaired "\WasaBootstrap030200FormHelper" class.

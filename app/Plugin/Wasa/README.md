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

Please, follow procedure.

* Procedure 1: Make "Bootstrap" files with site which [customizes "Bootstrap".](http://getbootstrap.com/customize/)
* Procedure 2: Copy made "Bootstrap" files to your "app/webroot/css/", "app/webroot/fonts/" and "app/webroot/js/" directory.
* Procedure 3: Copy ["jQuery"](http://jquery.com/) file to your "app/webroot/js/" directory.
* Procedure 4: Copy "app/Plugin/Wasa/" and "app/Plugin/WasaBootstrap3/" directory.
* Procedure 5: Add following into "app/Config/bootstrap.php" file.

```php
\CakePlugin::load('WasaBootstrap3', array ('bootstrap' => true));
```

* Procedure 6: Extend your classes of "Controller" and "Model" as below.

```php
\App::uses('WasaBootstrap3AppController', 'WasaBootstrap3.Controller');
class SomethingController extends \WasaBootstrap3AppController

\App::uses('WasaAppModel', 'Wasa.Model');
class WasaBootstrap3FormSample extends \WasaAppModel
```

* Procedure 7: Copy ["BoostCake" plugin](https://github.com/slywalker/cakephp-plugin-boost_cake) to your "app/Plugin/BoostCake/" directory.
* Procedure 8: Copy "_WasaManual" to "http://localhost/_WasaManual/".
* Procedure 9: Read option procedure of "CakePHP" in "BreakpointDebugging_PHPUnit.php" file.

Change log
----------

* I transformed "Lib" to "Plugin".

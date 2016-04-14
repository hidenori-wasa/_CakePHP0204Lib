Wasa's Bootstrap3 form library.
===============================

Notice
------

* This cannot use because I have been implementing code yet.

Requirements
------------

* [CakePHP(2.4-)](http://cakephp.jp/)
* [Bootstrap(3.2-)](http://getbootstrap.com/)
* "BreakpointDebugging" PEAR package
* "BreakpointDebugging_PHPUnit" PEAR package (option)

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

* Procedure 1: Copy "app/Plugin/Wasa/" and "app/Plugin/WasaBootstrap3/" directory.
* Procedure 2: Add following in last of "app/Config/bootstrap.php" file.

```php
\CakePlugin::load('WasaBootstrap3', array ('bootstrap' => true));
\CakePlugin::load('WasaPhpUnit', array ('bootstrap' => true));
```

* Procedure 3: Extend your classes of "Controller" and "Model" as below.

```php
\App::uses('WasaBootstrap3AppController', 'WasaBootstrap3.Controller');
class SomethingController extends \WasaBootstrap3AppController

\App::uses('WasaAppModel', 'Wasa.Model');
class WasaBootstrap3FormSample extends \WasaAppModel
```

* Procedure 4: Copy ["BoostCake" plugin](https://github.com/slywalker/cakephp-plugin-boost_cake) to your "app/Plugin/BoostCake/" directory.
* Procedure 5: Copy "_WasaManual" to "http://localhost/_WasaManual/".
* Procedure 6: Read option procedure of "CakePHP" in "BreakpointDebugging_PHPUnit.php" file.
* Option procedure 1: Make "Bootstrap" files with site which [customizes "Bootstrap".](http://getbootstrap.com/customize/)
* Option procedure 2: Copy made "Bootstrap" files to your "app/Plugin/WasaBootstrap3/webroot/css/", "app/Plugin/WasaBootstrap3/webroot/fonts/" and "app/Plugin/WasaBootstrap3/webroot/js/" directory.
* Option procedure 3: Copy ["jQuery"](http://jquery.com/) file to your "app/Plugin/Wasa/webroot/js/" directory.

Change log
----------

* I excepted static backup and its check about framework class because framework supports unit test continuation execution.
* I changed "\BreakpointDebugging_ErrorInAllCase" class to support other autoload of "PEAR" autoload.
* I deleted "\BreakpointDebugging_InAllCase::registerNotFixedLocation()" feature because code coverage report is same feature.
* I have been doing debugging with "PHP5.4" on "Ubuntu12.04LTS".

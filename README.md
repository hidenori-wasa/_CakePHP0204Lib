Wasa's CakePHP2.4 library.
========================================

Notice
------

* Should not use draft.
* I have been implementing code yet.
* Manual is secret policy now.

Requirements
-----------------

* [CakePHP(2.4.x)](http://cakephp.jp/)
* [Bootstrap(3.2.0)](http://getbootstrap.com/)

Installation
-----------------

* Procedure 1: Copy "app/Lib/Wasa/" directory to your "app/Lib/Wasa/" directory.
* Procedure 2: Make "Bootstrap" files with site which [customizes "Bootstrap".](http://getbootstrap.com/customize/)
* Procedure 3: Copy made "Bootstrap" files to your "app/webroot/css/", "app/webroot/fonts/" and "app/webroot/js/" directory.
* Procedure 4: Copy ["jQuery"](http://jquery.com/) file to your "app/webroot/js/" directory.
* Procedure 5: Add following into "app/Config/bootstrap.php" file.

```php
App::build(array ('Controller' => array ('../Lib/Wasa/Controller/')));
App::build(array ('Model' => array ('../Lib/Wasa/Model/')));
App::build(array ('View/Helper' => array ('../Lib/Wasa/View/Helper/')));
CakePlugin::load('BoostCake');
```

* Procedure 6: Add following to "app/Controller/AppController.php".

```php
class AppController extends Controller
{
    /**
     * @var array Helpers for view.
     */
    public $helpers = array (
        'Form' => array ('className' => 'WasaForm'), // Uses "WasaForm" helper instead of "Form" helper.
        'Paginator' => array ('className' => 'BoostCake.BoostCakePaginator'), // Uses "BoostCakePaginator" helper instead of "Paginator" helper.
        'WasaHtml',
    );
}
```

* Procedure 7: Copy ["BoostCake" plugin](https://github.com/slywalker/cakephp-plugin-boost_cake) to your "app/Plugin/BoostCake/" directory.

Change log
----------

* I repaired ID of "\WasaBootstrap030200FormHelper::displayCheckboxes()" and "\WasaBootstrap030200FormHelper::displayRadioButtons()" class method.
* I created "\WasaBootstrap030200FormHelper::displayTelForGrid120()" class method.

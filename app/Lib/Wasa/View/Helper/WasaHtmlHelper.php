<?php

/**
 * Customized HTML helper.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @category  DUMMY
 * @package   DUMMY
 * @author    CakePHP(tm) <dummy@dummy.com>
 * @copyright 2005-2014 Copyright (c) , Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @version   2.4.9
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     CakePHP(tm) v 0.2.9
 */
//App::uses('HtmlHelper', 'View/Helper');
App::uses('AppHelper', 'View/Helper');
/**
 * Customized HTML helper.
 *
 * @category  DUMMY
 * @package   DUMMY
 * @author    CakePHP(tm) <dummy@dummy.com>
 * @copyright 2005-2014 Copyright (c) , Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @version   2.4.9
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     CakePHP(tm) v 0.2.9
 */
class WasaHtmlHelper extends AppHelper
{
    /**
     * @var string Images's URL.
     */
    private static $__imgURL;

    /**
     * Constructer which is called from system.
     *
     * @param View  $View     The View this helper is being attached to.
     * @param array $settings Configuration settings for the helper.
     *
     * @author Hidenori Wasa <public@hidenori-wasa.com>
     */
    function __construct(\View $View, $settings = array ())
    {
        self::$__imgURL = str_replace('\\', '/', substr(ROOT, strlen($_SERVER['DOCUMENT_ROOT']))) . '/' . Configure::read('App.imageBaseUrl');
        parent::__construct($View, $settings);
    }

    /**
     * Gets image URL.
     *
     * @return string The image URL.
     * @author Hidenori Wasa <public@hidenori-wasa.com>
     */
    static function getImgURL()
    {
        return self::$__imgURL;
    }

}

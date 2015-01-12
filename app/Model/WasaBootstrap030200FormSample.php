<?php

use \WasaBootstrap030200FormHelper as WF; // This is this file scope and priority is high.

\App::uses('WasaBootstrap030200FormHelper', 'View/Helper');
class WasaBootstrap030200FormSample extends \AppModel
{

    function __construct()
    {
        $this->validate = array (
            'email' => array (
                array (
                    //'rule' => array ('email', true, WF::generateEmailRegularExpression()),
                    'rule' => array ('custom', WF::generateEmailRegularExpression()),
                    'message' => 'メールアドレスが間違っています。',
                ),
                array (
                    'rule' => array ('custom', '`.{3,' . WF::EMAIL_ADDR_MAX_LEN . '}`xX'),
                    'message' => 'メールアドレスが長すぎます。',
                ),
            ),
            'tel1' => array (
                'rule' => array ('phone', '`^ 0 [[:digit:]]{1,4} $`xX'),
                'message' => '市外局番が間違っています。',
            // 'allowEmpty' => true,
            ),
            'tel2' => array (
                'rule' => array ('phone', '`^ [[:digit:]]{1,4} $`xX'),
                'message' => '市内局番１が間違っています。',
            // 'allowEmpty' => true,
            ),
            'tel3' => array (
                'rule' => array ('phone', '`^ [[:digit:]]{4} $`xX'),
                'message' => '市内局番２が間違っています。',
            // 'allowEmpty' => true,
            ),
        );

        parent::__construct();
    }

// \Validation:
}

/*
  CREATE TABLE IF NOT EXISTS `wasa_bootstrap030200_form_samples` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tel1` varchar(5) NOT NULL,
  `tel2` varchar(4) NOT NULL,
  `tel3` varchar(4) NOT NULL,
  `email` varchar(254) NOT NULL,
  `number` float NOT NULL,
  `text` varchar(10) NOT NULL,
  `password` varchar(60) NOT NULL,
  `textarea` text NOT NULL,
  `file` varchar(10) NOT NULL,
  `select1` varchar(10) NOT NULL,
  `select2` varchar(10) NOT NULL,
  `select3` varchar(10) NOT NULL,
  `radio1` int(4) unsigned,
  `radio2` int(4) unsigned,
  `radio3` int(4) unsigned,
  `radio4` int(4) unsigned,
  `checkbox11` tinyint(1) NOT NULL,
  `checkbox12` tinyint(1) NOT NULL,
  `checkbox21` tinyint(1) NOT NULL,
  `checkbox22` tinyint(1) NOT NULL,
  `checkbox31` tinyint(1) NOT NULL,
  `checkbox32` tinyint(1) NOT NULL,
  `checkbox41` tinyint(1) NOT NULL,
  `checkbox42` tinyint(1) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `datetime` datetime NOT NULL,
  `hidden` varchar(10) NOT NULL,
  `url` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
  ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;
 */

?>

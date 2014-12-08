<?php

class WasaBootstrap030200FormSample extends \AppModel
{

    function __construct()
    {
        $this->validate = array (
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

        $debugLevel = \Configure::read('debug');
        if ($debugLevel > 0) {
            $validate = array (
                'checkbox11' => array (
                    array (
                        'rule' => 'boolean',
                        'message' => 'checkbox11 フィールドの値または型はブールでなければなりません。',
                    ),
                ),
                'checkbox12' => array (
                    array (
                        'rule' => 'boolean',
                        'message' => 'checkbox12 フィールドの値または型はブールでなければなりません。',
                    ),
                ),
                'checkbox21' => array (
                    array (
                        'rule' => 'boolean',
                        'message' => 'checkbox21 フィールドの値または型はブールでなければなりません。',
                    ),
                ),
                'checkbox22' => array (
                    array (
                        'rule' => 'boolean',
                        'message' => 'checkbox22 フィールドの値または型はブールでなければなりません。',
                    ),
                ),
            );

            $this->validate += $validate;
        }

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
  `email` varchar(10) NOT NULL,
  `number` float NOT NULL,
  `text` varchar(10) NOT NULL,
  `password` varchar(60) NOT NULL,
  `textarea` text NOT NULL,
  `file` varchar(10) NOT NULL,
  `select1` varchar(10) NOT NULL,
  `select2` varchar(10) NOT NULL,
  `select3` varchar(10) NOT NULL,
  `radio1` int(10) unsigned,
  `radio2` int(10) unsigned,
  `radio3` int(10) unsigned,
  `radio4` int(10) unsigned,
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

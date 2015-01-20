<?php

\App::uses('WasaAppModel', 'Wasa/Model');
class WasaBootstrap030200FormSample extends \WasaAppModel
{

    function __construct()
    {
        $this->validate = $this->_getModelValidation();

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

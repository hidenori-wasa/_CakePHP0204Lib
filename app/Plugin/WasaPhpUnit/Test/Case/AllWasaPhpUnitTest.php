<?php

class AllWasaPhpUnitTest extends \CakeTestSuite
{

    public static function suite()
    {
        $suite = new \CakeTestSuite('All tests.');
        $suite->addTestDirectoryRecursive(__DIR__);
        return $suite;
    }

}

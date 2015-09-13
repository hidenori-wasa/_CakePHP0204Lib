<?php

/**
 * Static variable storage.
 *
 * LICENSE:
 * Copyright (c) 2014-, Hidenori Wasa
 * All rights reserved.
 *
 * License content is written in "PEAR/BreakpointDebugging/BREAKPOINTDEBUGGING_LICENSE.txt".
 *
 * @category PHP
 * @package  BreakpointDebugging_PHPUnit
 * @author   Hidenori Wasa <public@hidenori-wasa.com>
 * @license  http://opensource.org/licenses/mit-license.php  MIT License
 * @version  Release: @package_version@
 * @link     http://pear.php.net/package/BreakpointDebugging_PHPUnit
 */
use \BreakpointDebugging as B;
use \BreakpointDebugging_Window as BW;

/**
 * Static variable storage.
 *
 * PHP version 5.3.2-5.4.x
 *
 * @category PHP
 * @package  BreakpointDebugging_PHPUnit
 * @author   Hidenori Wasa <public@hidenori-wasa.com>
 * @license  http://opensource.org/licenses/mit-license.php  MIT License
 * @version  Release: @package_version@
 * @link     http://pear.php.net/package/BreakpointDebugging_PHPUnit
 */
class BreakpointDebugging_PHPUnit_StaticVariableStorage
{
    /**
     * Previous declared classes-number storage.
     *
     * @var int
     */
    private static $_prevDeclaredClassesNumberStorage = 0;

    /**
     * Once flag per test file.
     *
     * @var bool
     */
    private static $_onceFlagPerTestFile;

    /**
     * Global variable references.
     *
     * @var array
     */
    private static $_globalRefs = array ();

    /**
     * Global variables.
     *
     * @var array
     */
    private static $_globals = array ();

    /**
     * Static properties.
     *
     * @var array
     */
    private static $_staticProperties = array ();

    /**
     * Snapshot of global variables references.
     *
     * @var array
     */
    private static $_globalRefsSnapshot = array ();

    /**
     * Snapshot of global variables.
     *
     * @var array
     */
    private static $_globalsSnapshot = array ();

    /**
     * List to except to store global variable.
     *
     * @var array
     */
    private static $_backupGlobalsBlacklist = array ();

    /**
     * Static properties's snapshot.
     *
     * @var array
     */
    private static $_staticPropertiesSnapshot = array ();

    /**
     * List to except to store static properties values.
     *
     * @var array
     */
    private static $_backupStaticPropertiesBlacklist = array ();

    /**
     * Is it unit test class?
     *
     * @var Closure
     */
    private $_isUnitTestClass;

    /**
     * Sets whether or not unit test class is.
     *
     * @param Closure $isUnitTestClass Is it unit test class?
     */
    public function __construct($isUnitTestClass)
    {
        $this->_isUnitTestClass = $isUnitTestClass;
    }

    /**
     * Returns reference of flag of once per test file.
     *
     * @return bool& Reference value.
     */
    static function &refOnceFlagPerTestFile()
    {
        B::limitAccess(
            array ('BreakpointDebugging_PHPUnit.php',
            'BreakpointDebugging/PHPUnit/FrameworkTestCase.php',
            'BreakpointDebugging/PHPUnit/FrameworkTestCaseSimple.php',
            ), true
        );

        return self::$_onceFlagPerTestFile;
    }

    /**
     * It references "self::$_globalRefs".
     *
     * @return mixed& Reference value.
     */
    static function &refGlobalRefs()
    {
        B::limitAccess(
            array ('BreakpointDebugging_PHPUnit.php',
            'BreakpointDebugging/PHPUnit/FrameworkTestCase.php',
            'BreakpointDebugging/PHPUnit/FrameworkTestCaseSimple.php',
            ), true
        );

        return self::$_globalRefs;
    }

    /**
     * It references "self::$_globals".
     *
     * @return mixed& Reference value.
     */
    static function &refGlobals()
    {
        B::limitAccess(
            array ('BreakpointDebugging_PHPUnit.php',
            'BreakpointDebugging/PHPUnit/FrameworkTestCase.php',
            'BreakpointDebugging/PHPUnit/FrameworkTestCaseSimple.php',
            ), true
        );

        return self::$_globals;
    }

    /**
     * It references "self::$_staticProperties".
     *
     * @return mixed& Reference value.
     */
    static function &refStaticProperties2()
    {
        B::limitAccess(
            array ('BreakpointDebugging_PHPUnit.php',
            'BreakpointDebugging/PHPUnit/FrameworkTestCase.php',
            'BreakpointDebugging/PHPUnit/FrameworkTestCaseSimple.php',
            ), true
        );

        return self::$_staticProperties;
    }

    /**
     * It references "self::$_backupGlobalsBlacklist".
     *
     * @return mixed& Reference value.
     */
    static function &refBackupGlobalsBlacklist()
    {
        B::limitAccess('BreakpointDebugging/PHPUnit/FrameworkTestCase.php', true);

        return self::$_backupGlobalsBlacklist;
    }

    /**
     * It references "self::$_backupStaticPropertiesBlacklist".
     *
     * @return mixed& Reference value.
     */
    static function &refBackupStaticPropertiesBlacklist()
    {
        B::limitAccess('BreakpointDebugging/PHPUnit/FrameworkTestCase.php', true);

        return self::$_backupStaticPropertiesBlacklist;
    }

    /**
     * Stores static status inside autoload handler because static status may be changed.
     *
     * @param string $className The class name which calls class member of static.
     *                          Or, the class name which creates new instance.
     *                          Or, the class name when extends base class.
     *
     * @return void
     */
    function loadClass($className)
    {
        static $nestLevel = 0;

        // Excepts unit test classes.
        $isUnitTestClass = $this->_isUnitTestClass;
        if ($isUnitTestClass($className)) {
            $exception = B::loadClass($className);
            if ($exception) {
                throw $exception;
            }
            return;
        }

        // If class file has been loaded first.
        if ($nestLevel === 0) {
            if (self::$_onceFlagPerTestFile) {
                // Checks definition, deletion and change violation of global variables and global variable references in "setUp()".
                self::checkGlobals(self::$_globalRefs, self::$_globals, true);
                // Checks the change violation of static properties and static property child element references.
                $this->checkProperties(self::$_staticProperties, self::$_backupStaticPropertiesBlacklist);
            } else {
                // Snapshots global variables.
                self::storeGlobals(self::$_globalRefsSnapshot, self::$_globalsSnapshot, self::$_backupGlobalsBlacklist, true);
                // Snapshots static properties.
                $this->storeProperties(self::$_staticPropertiesSnapshot, self::$_backupStaticPropertiesBlacklist, true);

                // Restores global variables.
                self::restoreGlobals(self::$_globalRefs, self::$_globals);
                // Restores static properties.
                self::restoreProperties(self::$_staticProperties);
            }
            $nestLevel = 1;
            $exception = B::loadClass($className);
            // If class file has been loaded completely including dependency files.
            $nestLevel = 0;
            if ($exception) {
                throw $exception;
            }
            // Checks deletion and change violation of global variables and global variable references during autoload.
            self::checkGlobals(self::$_globalRefs, self::$_globals);
            // Checks the change violation of static properties and static property child element references.
            $this->checkProperties(self::$_staticProperties, self::$_backupStaticPropertiesBlacklist);
            // Stores global variables before variable value is changed in bootstrap file and "setUpBeforeClass()".
            self::storeGlobals(self::$_globalRefs, self::$_globals, self::$_backupGlobalsBlacklist);
            // Stores static properties before variable value is changed.
            $this->storeProperties(self::$_staticProperties, self::$_backupStaticPropertiesBlacklist);
            if (!self::$_onceFlagPerTestFile) {
                // Restores global variables snapshot.
                self::restoreGlobals(self::$_globalRefsSnapshot, self::$_globalsSnapshot);
                // Restores static properties snapshot.
                self::restoreProperties(self::$_staticPropertiesSnapshot);
            }
        } else { // In case of auto load inside auto load.
            $nestLevel++;
            $exception = B::loadClass($className);
            $nestLevel--;
            if ($exception) {
                throw $exception;
            }
        }
    }

    /**
     * Stores variables.
     *
     * NOTICE: Reference setting inside "__construct()" is not broken by "unset()" because it is reset.
     *         However, reference setting inside file scope of "autoload or including" is broken by "unset()".
     *
     * @param array $blacklist           The list to except from variables storing.
     * @param array $variables           Array variable to store.
     * @param array $variableRefsStorage Variable references storage.
     * @param array $variablesStorage    Variables storage.
     * @param bool  $isGlobal            Is this the global variables?
     *
     * @return void
     */
    private static function _storeVariables($blacklist, $variables, &$variableRefsStorage, &$variablesStorage, $isGlobal = false)
    {
        B::assert(is_array($blacklist));
        B::assert(is_array($variables));
        B::assert(is_array($variableRefsStorage));
        B::assert(is_array($variablesStorage));

        if ($isGlobal) {
            // Deletes "unset()" variable from storage because we can do "unset()" except property definition.
            foreach ($variablesStorage as $key => $value) {
                if (!array_key_exists($key, $variables)) {
                    unset($variablesStorage[$key]);
                }
            }
        }

        // Stores new variable by autoload or initialization.
        foreach ($variables as $key => &$value) {
            if (in_array($key, $blacklist) //
                || array_key_exists($key, $variablesStorage) //
                || $value instanceof Closure //
            ) {
                continue;
            }
            $variableRefsStorage[$key] = &$value;
            $variablesStorage[$key] = $value;
        }
    }

    /**
     * Restores variables.
     *
     * @param array $variables           Variables to restore.
     * @param array $variableRefsStorage Variable references storage.
     * @param array $variablesStorage    Variables storage.
     *
     * @return void
     */
    private static function _restoreVariables(array &$variables, array $variableRefsStorage, array $variablesStorage)
    {
        $variables = array ();
        if (empty($variablesStorage)) {
            return;
        }
        foreach ($variablesStorage as $key => $value) {
            if (array_key_exists($key, $variableRefsStorage)) {
                // Copies reference of storage to reference of variable itself.
                $variables[$key] = &$variableRefsStorage[$key];
            }
            // Copies value of storage to variable.
            $variables[$key] = $value;
        }
    }

    /**
     * Checks definition, deletion and change violation of global variables and global variable references.
     *
     * @param array $globalRefs          Global variable's references storage.
     * @param array $globals             Global variables storage.
     * @param bool  $doesDefinitionCheck Does definition check?
     *
     * @return void
     */
    static function checkGlobals($globalRefs, $globals, $doesDefinitionCheck = false)
    {
        B::limitAccess(
            array ('BreakpointDebugging/PHPUnit/FrameworkTestCase.php',
            'BreakpointDebugging/PHPUnit/FrameworkTestCaseSimple.php',
            'BreakpointDebugging/PHPUnit/StaticVariableStorage.php',
            ), true
        );
        $isError = false;
        if ($doesDefinitionCheck) {
            // Checks definition.
            $definitionGlobalVariables = array_diff_key($GLOBALS, $globalRefs);
            if (!empty($definitionGlobalVariables)) {
                $isError = true;
                $defineOrDelete = 'define';
            }

            $message2 = "\t" . 'The bootstrap file.' . PHP_EOL;
            $message2 .= "\t" . 'Code which is executed at autoload of unit test file (*Test.php, *TestSimple.php).' . PHP_EOL;
            $message2 .= "\t" . '"setUpBeforeClass()".' . PHP_EOL;
        } else {
            $message2 = "\t" . 'During autoload.' . PHP_EOL;
        }
        $message2 .= '</b>' . PHP_EOL;

        if (!$isError) {
            // Checks deletion.
            $deletionGlobalVariables = array_diff_key($globalRefs, $GLOBALS);
            if (!empty($deletionGlobalVariables)) {
                $isError = true;
                $defineOrDelete = 'delete';
            }
        }

        if ($isError) {
            // Displays definition or deletion error.
            $message = '<b>';
            $message .= 'Global variable has been ' . $defineOrDelete . 'd in the following place!' . PHP_EOL;
            $message .= $message2;
            $message .= 'We must not ' . $defineOrDelete . ' global variable in the above place.' . PHP_EOL;
            $message .= 'Because "php" version 5.3.0 cannot detect ' . $defineOrDelete . 'd global variable realtime.';
            BW::exitForError($message);
        }

        // Checks global variables values and global variables child element references.
        unset($globals['GLOBALS']);
        foreach ($globals as $key => $value) {
            if ($value !== $GLOBALS[$key]) {
                $isError = true;
                $message3 = 'value';
                break;
            }
        }
        if (!$isError) {
            // Checks global variables references.
            unset($globalRefs['GLOBALS']);
            foreach ($globalRefs as $key => &$value) {
                if ($key === 'GLOBALS') {
                    continue;
                }
                $cmpArray1 = array (&$value);
                $cmpArray2 = array (&$GLOBALS[$key]);
                if ($cmpArray1 !== $cmpArray2) {
                    $isError = true;
                    $message3 = 'reference';
                    break;
                }
            }
        }
        if ($isError) {
            // Displays error of overwritten value or overwritten reference.
            $message = '<b>';
            $message .= 'Global variable ' . $message3 . ' has been overwritten in the following place!' . PHP_EOL;
            $message .= $message2;
            $message .= 'We must not overwrite global variable ' . $message3 . ' in the above place.' . PHP_EOL;
            $message .= 'Because "php" version 5.3.0 cannot detect overwritten global variable ' . $message3 . ' realtime.';
            BW::exitForError($message);
        }
    }

    /**
     * Stores global variables.
     *
     * @param array $globalRefs Global variable's references storage.
     * @param array $globals    Global variables storage.
     * @param array $blacklist  The list to except from storage global variables.
     * @param bool  $isSnapshot Is this snapshot?
     *
     * @return void
     */
    static function storeGlobals(array &$globalRefs, array &$globals, array $blacklist, $isSnapshot = false)
    {
        B::limitAccess(
            array ('BreakpointDebugging/PHPUnit/StaticVariableStorage.php',
            'BreakpointDebugging_PHPUnit.php',
            ), true
        );

        if ($isSnapshot) {
            $globalRefs = array ();
            $globals = array ();
        }
        self::_storeVariables($blacklist, $GLOBALS, $globalRefs, $globals, true);
    }

    /**
     * Restores global variables.
     *
     * @param array $globalRefs Global variable's references storage.
     * @param array $globals    Global variables storage.
     *
     * @return void
     */
    static function restoreGlobals($globalRefs, $globals)
    {
        B::limitAccess(
            array ('BreakpointDebugging/PHPUnit/FrameworkTestCase.php',
            'BreakpointDebugging/PHPUnit/FrameworkTestCaseSimple.php',
            'BreakpointDebugging/PHPUnit/StaticVariableStorage.php',
            'BreakpointDebugging_PHPUnit.php',
            ), true
        );

        unset($globalRefs['GLOBALS']);
        unset($globals['GLOBALS']);
        self::_restoreVariables($GLOBALS, $globalRefs, $globals);

        $_COOKIE = &$GLOBALS['_COOKIE'];
        $_ENV = &$GLOBALS['_ENV'];
        $_FILES = &$GLOBALS['_FILES'];
        $_GET = &$GLOBALS['_GET'];
        $_POST = &$GLOBALS['_POST'];
        $_REQUEST = &$GLOBALS['_REQUEST'];
        $_SERVER = &$GLOBALS['_SERVER'];
        $GLOBALS['GLOBALS'] = &$GLOBALS;
    }

    /**
     * Checks the change violation of static properties and static property child element references.
     *
     * @param array $staticProperties Static properties storage.
     * @param array $blacklist        The list to except from static properties storage.
     * @param bool  $forAutoload      For autoload?
     *
     * @return void
     */
    function checkProperties($staticProperties, $blacklist, $forAutoload = true)
    {
        B::limitAccess(
            array ('BreakpointDebugging/PHPUnit/FrameworkTestCase.php',
            'BreakpointDebugging/PHPUnit/FrameworkTestCaseSimple.php',
            'BreakpointDebugging/PHPUnit/StaticVariableStorage.php',
            ), true
        );

        if ($forAutoload) {
            $message2 = "\t" . 'During autoload.' . PHP_EOL;
        } else {
            $message2 = "\t" . 'The bootstrap file.' . PHP_EOL;
            $message2 .= "\t" . 'Code which is executed at autoload of unit test file (*Test.php, *TestSimple.php).' . PHP_EOL;
            $message2 .= "\t" . '"setUpBeforeClass()".' . PHP_EOL;
            $message2 .= "\t" . '"setUp()".' . PHP_EOL;
        }
        $message2 .= '</b>' . PHP_EOL;

        // Scans the declared classes.
        $declaredClasses = get_declared_classes();
        $currentDeclaredClassesNumber = count($declaredClasses);
        $isUnitTestClass = $this->_isUnitTestClass;
        for ($key = $currentDeclaredClassesNumber - 1; $key >= 0; $key--) {
            $declaredClassName = $declaredClasses[$key];
            // Excepts unit test classes.
            if ($isUnitTestClass($declaredClassName) //
                || $declaredClassName === 'BreakpointDebugging' //
                || $declaredClassName === 'BreakpointDebugging_BlackList' //
                || $declaredClassName === 'BreakpointDebugging_InAllCase' //
                || $declaredClassName === 'BreakpointDebugging_Lock' //
                || $declaredClassName === 'BreakpointDebugging_PHPUnit' //
                || $declaredClassName === 'PEAR_Exception' //
                || $declaredClassName === 'Inflector' // "CakePHP" class.
                || $declaredClassName === 'Router' // "CakePHP" class.
                || $declaredClassName === 'CakeEventManager' // "CakePHP" class.
                || $declaredClassName === 'Configure' // "CakePHP" class.
            ) {
                continue;
            }
            // Class reflection.
            $classReflection = new \ReflectionClass($declaredClassName);
            // If it is not user defined class.
            if (!$classReflection->isUserDefined()) {
                continue;
            }
            // If class was declared inside unit test code.
            if (!array_key_exists($declaredClassName, $staticProperties)) {
                continue;
            }
            // Static properties reflection.
            $staticPropertiesOfClass = $staticProperties[$declaredClassName];
            foreach ($classReflection->getProperties(\ReflectionProperty::IS_STATIC) as $property) {
                // If it is not property of base class. Because reference variable cannot be extended.
                if ($property->class === $declaredClassName) {
                    $propertyName = $property->name;
                    // If static property does not exist in black list (PHPUnit_Framework_TestCase::$backupStaticAttributesBlacklist).
                    if (!isset($blacklist[$declaredClassName]) //
                        || !in_array($propertyName, $blacklist[$declaredClassName]) //
                    ) {
                        $property->setAccessible(true);
                        $propertyValue = $property->getValue();
                        if (!$propertyValue instanceof Closure) {
                            // Checks static property and static property child element references.
                            if (B::clearRecursiveArrayElement($staticPropertiesOfClass[$propertyName]) === B::clearRecursiveArrayElement($propertyValue)) {
                                continue;
                            }
                            $message = '<b>';
                            $message .= 'In "class ' . $declaredClassName . '".' . PHP_EOL;
                            $message .= '"$' . $propertyName . '" static property or reference has been overwritten in the following place!' . PHP_EOL;
                            $message .= $message2;
                            $message .= 'We must not overwrite static property or reference in the above place.' . PHP_EOL;
                            $message .= 'Because "php" version 5.3.0 cannot detect overwritten static property or reference realtime.';
                            B::exitForError('<pre>' . $message . '</pre>');
                        }
                    }
                }
            }
        }
    }

    /**
     * Stores static properties.
     *
     * @param array $staticProperties Static properties storage.
     * @param array $blacklist        The list to except from static properties storage.
     * @param bool  $isSnapshot       Is this snapshot?
     *
     * @return void
     */
    function storeProperties(array &$staticProperties, array $blacklist, $isSnapshot = false)
    {
        B::limitAccess(
            array ('BreakpointDebugging/PHPUnit/StaticVariableStorage.php',
            'BreakpointDebugging_PHPUnit.php',
            ), true
        );

        if ($isSnapshot) {
            $staticProperties = array ();
            $prevDeclaredClassesNumber = 0;
        } else {
            $prevDeclaredClassesNumber = self::$_prevDeclaredClassesNumberStorage;
        }
        // Scans the declared classes.
        $declaredClasses = get_declared_classes();
        $currentDeclaredClassesNumber = count($declaredClasses);
        $isUnitTestClass = $this->_isUnitTestClass;
        for ($key = $currentDeclaredClassesNumber - 1; $key >= $prevDeclaredClassesNumber; $key--) {
            $declaredClassName = $declaredClasses[$key];
            // Excepts unit test classes.
            if ($isUnitTestClass($declaredClassName)) {
                continue;
            }
            // Class reflection.
            $classReflection = new \ReflectionClass($declaredClassName);
            // If it is not user defined class.
            if (!$classReflection->isUserDefined()) {
                continue;
            }

            $storage = array ();
            // Static properties reflection.
            foreach ($classReflection->getProperties(\ReflectionProperty::IS_STATIC) as $property) {
                // If it is not property of base class. Because reference variable cannot be extended.
                if ($property->class === $declaredClassName) {
                    $propertyName = $property->name;
                    // If static property does not exist in black list (PHPUnit_Framework_TestCase::$backupStaticAttributesBlacklist).
                    if (!isset($blacklist[$declaredClassName]) //
                        || !in_array($propertyName, $blacklist[$declaredClassName]) //
                    ) {
                        $property->setAccessible(true);
                        $propertyValue = $property->getValue();
                        if (!$propertyValue instanceof Closure) {
                            $storage[$propertyName] = $propertyValue;
                        }
                    }
                }
            }

            if (!empty($storage)) {
                $staticProperties[$declaredClassName] = array ();
                // Stores static properties.
                $dummy = array ();
                self::_storeVariables(array (), $storage, $dummy, $staticProperties[$declaredClassName]);
            }
        }

        self::$_prevDeclaredClassesNumberStorage = $currentDeclaredClassesNumber;
    }

    /**
     * Restores static properties.
     *
     * @param array $staticPropertiesStorage Static properties storage.
     *
     * @return void
     */
    static function restoreProperties($staticPropertiesStorage)
    {
        B::limitAccess(
            array ('BreakpointDebugging/PHPUnit/FrameworkTestCase.php',
            'BreakpointDebugging/PHPUnit/FrameworkTestCaseSimple.php',
            'BreakpointDebugging/PHPUnit/StaticVariableStorage.php',
            'BreakpointDebugging_PHPUnit.php',
            ), true
        );

        foreach ($staticPropertiesStorage as $className => $staticProperties) {
            $properties = array ();
            self::_restoreVariables($properties, array (), $staticProperties);
            foreach ($staticProperties as $name => $value) {
                $reflector = new ReflectionProperty($className, $name);
                $reflector->setAccessible(true);
                $reflector->setValue($properties[$name]);
            }
        }
    }

    /**
     * Checks a function local static variable.
     *
     * @return void
     */
    function checkFunctionLocalStaticVariable()
    {
        B::limitAccess('BreakpointDebugging_PHPUnit.php', true);

        $componentFullPath = stream_resolve_include_path('BreakpointDebugging/Component/') . DIRECTORY_SEPARATOR;
        $definedFunctionsName = get_defined_functions();
        $isUnitTestClass = $this->_isUnitTestClass;
        foreach ($definedFunctionsName['user'] as $definedFunctionName) {
            $functionReflection = new ReflectionFunction($definedFunctionName);
            $staticVariables = $functionReflection->getStaticVariables();
            // If static variable has been existing.
            if (!empty($staticVariables)) {
                $fileName = $functionReflection->getFileName();
                if (strpos($fileName, $componentFullPath) === 0) {
                    $className = str_replace(array ('\\', '/'), '_', substr($fileName, strlen($componentFullPath)));
                    // Excepts unit test classes.
                    if ($isUnitTestClass($className)) {
                        continue;
                    }
                }
                echo PHP_EOL
                . 'Code which is tested must use private static property in class method instead of use local static variable in function' . PHP_EOL
                . 'because "php" version 5.3.0 cannot restore its value.' . PHP_EOL
                . "\t" . '<b>FILE: ' . $functionReflection->getFileName() . PHP_EOL
                . "\t" . 'LINE: ' . $functionReflection->getStartLine() . PHP_EOL
                . "\t" . 'FUNCTION: ' . $functionReflection->name . '</b>' . PHP_EOL;
            }
        }
    }

    /**
     * Checks a function local static variable.
     *
     * @return void
     */
    function checkMethodLocalStaticVariable()
    {
        B::limitAccess('BreakpointDebugging_PHPUnit.php', true);

        // Scans the declared classes.
        $declaredClasses = get_declared_classes();
        $currentDeclaredClassesNumber = count($declaredClasses);
        $isUnitTestClass = $this->_isUnitTestClass;
        for ($key = $currentDeclaredClassesNumber - 1; $key >= 0; $key--) {
            $declaredClassName = $declaredClasses[$key];
            // Excepts unit test classes.
            if ($isUnitTestClass($declaredClassName)) {
                continue;
            }
            // Class reflection.
            $classReflection = new \ReflectionClass($declaredClassName);
            // If it is not user defined class.
            if (!$classReflection->isUserDefined()) {
                continue;
            }
            // Checks existence of local static variable of static class method.
            foreach ($classReflection->getMethods(ReflectionMethod::IS_STATIC) as $methodReflection) {
                if ($methodReflection->class === $declaredClassName) {
                    $result = $methodReflection->getStaticVariables();
                    // If static variable has been existing.
                    if (!empty($result)) {
                        echo PHP_EOL
                        . 'Code which is tested must use private static property instead of use local static variable in static class method' . PHP_EOL
                        . 'because "php" version 5.3.0 cannot restore its value.' . PHP_EOL
                        . "\t" . '<b>FILE: ' . $methodReflection->getFileName() . PHP_EOL
                        . "\t" . 'LINE: ' . $methodReflection->getStartLine() . PHP_EOL
                        . "\t" . 'CLASS: ' . $methodReflection->class . PHP_EOL
                        . "\t" . 'METHOD: ' . $methodReflection->name . '</b>' . PHP_EOL;
                    }
                }
            }
        }
    }

}

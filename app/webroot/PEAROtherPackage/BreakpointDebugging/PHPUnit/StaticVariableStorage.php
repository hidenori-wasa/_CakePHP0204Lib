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
     * Current test class name.
     *
     * @var string
     */
    private static $_currentTestClassName;

    /**
     * Memorizes the defined classes.
     *
     * @var array
     */
    private static $_declaredClasses;

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
     * List to except to store global variable.
     *
     * @var array
     */
    private static $_backupGlobalsBlacklist = array ();

    /**
     * List to except to store static properties values.
     *
     * @var array
     */
    private static $_backupStaticPropertiesBlacklist = array (
        'BreakpointDebugging_InAllCase' => array ('_callLocations'),
    );

    /**
     * Is it unit test class?
     *
     * @var Closure
     */
    private static $_isUnitTestClass;

    /**
     * Initializes this static class.
     *
     * @param Closure $isUnitTestClass Is it unit test class?
     */
    static function initialize($isUnitTestClass)
    {
        B::limitAccess('BreakpointDebugging_PHPUnit.php');

        // "\Closure" object should be static because of function.
        self::$_isUnitTestClass = $isUnitTestClass;
    }

    /**
     * It references "self::$_currentTestClassName".
     *
     * @return string& Reference value.
     */
    static function &refCurrentTestClassName()
    {
        B::limitAccess('BreakpointDebugging/PHPUnit/FrameworkTestCase.php', true);

        return self::$_currentTestClassName;
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
    static function &refStaticProperties()
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
        B::limitAccess(array (
            'BreakpointDebugging_PHPUnit.php',
            'BreakpointDebugging/PHPUnit/FrameworkTestCase.php'
            ), true);

        return self::$_backupStaticPropertiesBlacklist;
    }

    /**
     * Display error.
     *
     * @param bool $isInclude  Is include?
     * @param bool $classNames The class name or the classes names.
     *
     * @return void
     */
    static function _displayError($isInclude, $classNames)
    {
        if ($isInclude) {
            $messageA = '"include"';
            $messageB = 'file path';
        } else {
            $messageA = 'Autoload';
            $messageB = 'code';
        }
        $message = $messageA . ' must not be executed during "setUp()", "test*()" or "tearDown()".' . PHP_EOL;
        $message .= 'Please, code the following into "';
        $message .= '<span style="color:aqua">';
        $message .= self::$_currentTestClassName . '::setUpBeforeClass()';
        $message .= '</span>';
        $message .= '".' . PHP_EOL;
        $message .= 'Before:' . PHP_EOL;
        $message .= '    parent::setUpBeforeClass();' . PHP_EOL;
        $message .= 'After:' . PHP_EOL;
        $message .= '<span style="color:aqua">';
        if ($isInclude) {
            foreach ($classNames as $className) {
                $message .= '    include_once \'&lt;the file path which loads "' . $className . '" class>\';' . PHP_EOL;
            }
        } else {
            $className = $classNames;
            $message .= '    &lt;the code which loads "' . $className . '" class>;' . PHP_EOL;
        }
        $message .= '</span>';
        $message .= '    parent::setUpBeforeClass();' . PHP_EOL;
        if ($isInclude) {
            $message .= 'Please, search "include*" or "require*" in "';
            $message .= '<span style="color:aqua">';
            $message .= 'class ' . self::$_currentTestClassName . ' { }';
            $message .= '</span>';
            $message .= '" definition.' . PHP_EOL;
            BW::exitForError($message);
        } else {
            $message .= 'Please, continue with step execution for &lt;the ' . $messageB . ' which loads "';
            $message .= '<span style="color:aqua">';
            $message .= $className;
            $message .= '</span>';
            $message .= '" class>.' . PHP_EOL;
            $message .= 'Then, double click call stack window when step execution exists on "';
            $message .= '<span style="color:aqua">';
            $message .= $className;
            $message .= '</span>';
            $message .= '" class file.' . PHP_EOL;
            BW::stopForError($message);
        }
    }

    /**
     * Prohibits autoload not to change static status by autoload during "setUp()", "test*()" or "tearDown()".
     *
     * @param string $className The class name for autoload of "new", "extends", "static class method call", "class_implements()", "class_exists()", "class_parents()", "class_uses()", "is_a()" or "is_subclass_of()" etc.
     *
     * @return void
     */
    static function displayAutoloadError($className)
    {
        static $isAutoloadDuringAutoload = false, $onceFlag = false, $serchClassName = '';

        // If this is not autoload during autoload.
        if (!$isAutoloadDuringAutoload) {
            if ($onceFlag) {
                B::exitForError('Autoload error must be fixed per a bug. Double click call stack window about "' . $serchClassName . '".');
            }
            $onceFlag = true;
            $serchClassName = $className;
            $isAutoloadDuringAutoload = true;
            // Loads classes files to continue step execution.
            spl_autoload_call($className);
            // If class file has been loaded completely including dependency files.
            $isAutoloadDuringAutoload = false;
            // If this autoload class method was called.
            self::_displayError(false, $className);
        }
    }

    /**
     * Restores an object.
     *
     * @param object $dest Destination variable.
     * @param array  $src  Source value.
     *
     * @return void
     */
    private static function _restoreObject($dest, &$src)
    {
        B::assert(is_object($dest));
        B::assert(is_array($src));

        $objectReflection = new ReflectionObject($dest);
        if (!$objectReflection->isUserDefined()) {
            return;
        }
        // Skips an object of "\stdClass" which judges type.
        list(, $className) = each($src);
        $className = $className->scalar;
        if ($className !== $objectReflection->name) {
            throw new \BreakpointDebugging_ErrorException('"\\' . $className . '" class object was changed the type.');
        }
        foreach ($objectReflection->getProperties() as $propertyReflection) {
            // Excepts static property.
            if ($propertyReflection->isStatic()) {
                continue;
            }
            $propertyReflection->setAccessible(true);
            list(, $value) = each($src);
            // Copies an array elements recursively.
            // Or, copies an object ID.
            // Or, copies a value of other type.
            $propertyReflection->setValue($dest, $value);
            if (is_array($value)) {
                // Delivers "$value" as array copy recursively.
                self::_iterateRestorationArrayRecursively($value, $src);
            } else if (is_object($value)) {
                // Delivers "$value" as object ID copy.
                self::_restoreObject($value, $src);
            }
        }
    }

    /**
     * Stores an object.
     *
     * @param array  $dest Destination variable.
     * @param object $src  Source value.
     *
     * @return void
     */
    private static function _storeObject(&$dest, $src)
    {
        B::assert(is_array($dest));
        B::assert(is_object($src));

        $objectReflection = new ReflectionObject($src);
        if (!$objectReflection->isUserDefined()) {
            return;
        }
        // Registers a class name as object type.
        $dest[] = (object) $objectReflection->name;
        foreach ($objectReflection->getProperties() as $propertyReflection) {
            // Excepts static property.
            if ($propertyReflection->isStatic()) {
                continue;
            }
            $propertyReflection->setAccessible(true);
            $value = $propertyReflection->getValue($src);
            // Copies an array elements recursively.
            // Or, copies an object ID.
            // Or, copies a value of other type.
            $dest[] = $value;
            if (is_array($value)) {
                self::_iterateStoreArrayRecursively($dest, $value);
            } else if (is_object($value)) {
                self::_storeObject($dest, $value);
            }
        }
    }

    /**
     * Iterates restoration array recursively.
     *
     * @param array $iterateArray Iteration array.
     * @param array $src          Source array to restore.
     *
     * @return void
     */
    private static function _iterateRestorationArrayRecursively($iterateArray, &$src)
    {
        B::assert(is_array($iterateArray));
        B::assert(is_array($src));

        foreach ($iterateArray as $key => $value) {
            if (is_array($value)) {
                if ($key === 'GLOBALS') {
                    continue;
                }
                // Delivers "$value" as array copy recursively.
                self::_iterateRestorationArrayRecursively($value, $src);
            } else if (is_object($value)) {
                // Delivers "$value" as object ID copy.
                self::_restoreObject($value, $src);
            }
        }
    }

    /**
     * Iterates a store array recursively.
     *
     * @param array $dest         Destination variable.
     * @param array $iterateArray Iteration array.
     *
     * @return void
     */
    private static function _iterateStoreArrayRecursively(&$dest, $iterateArray)
    {
        B::assert(is_array($dest));
        B::assert(is_array($iterateArray));

        foreach ($iterateArray as $key => $value) {
            if (is_array($value)) {
                if ($key === 'GLOBALS') {
                    continue;
                }
                self::_iterateStoreArrayRecursively($dest, $value);
            } else if (is_object($value)) {
                self::_storeObject($dest, $value);
            }
        }
    }

    /**
     * Restores a value.
     *
     * @param mixed $dest Destination variable.
     * @param array $src  Source value.
     *
     * @return void
     */
    private static function _restoreValue(&$dest, $src)
    {
        B::assert(is_array($src));

        reset($src);
        list(, $value) = each($src);
        // Copies an array elements recursively.
        // Or, Copies an object ID.
        // Or, Copies a value of other type.
        $dest = $value;
        if (is_array($value)) {
            // Delivers "$value" as array copy recursively.
            self::_iterateRestorationArrayRecursively($value, $src);
        } else if (is_object($value)) {
            // Delivers "$value" as object ID copy.
            self::_restoreObject($value, $src);
        }
        $result = each($src);
        B::assert($result === false);
    }

    /**
     * Stores a value.
     *
     * @param mixed $dest Destination variable.
     * @param mixed $src  Source value.
     *
     * @return void
     */
    private static function _storeValue(&$dest, $src)
    {
        B::checkRecursiveDataError($src);
        // Copies an array elements recursively.
        // Or, copies an object ID.
        // Or, copies a value of other type.
        $dest[] = $src;
        if (is_array($src)) {
            self::_iterateStoreArrayRecursively($dest, $src);
        } else if (is_object($src)) {
            self::_storeObject($dest, $src);
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
            self::_storeValue($variablesStorage[$key], $value);
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
            } else {
                // Generates the key.
                $variables[$key] = '';
            }
            // Copies value of storage to variable.
            self::_restoreValue($variables[$key], $value);
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
     * Stores static properties.
     *
     * @param array $staticProperties Static properties storage.
     * @param array $blacklist        The list to except from static properties storage.
     * @param bool  $isSnapshot       Is this snapshot?
     *
     * @return void
     */
    static function storeProperties(array &$staticProperties, array $blacklist, $isSnapshot = false)
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
        // Memorizes the declared classes.
        $declaredClasses = self::$_declaredClasses = get_declared_classes();
        $currentDeclaredClassesNumber = count($declaredClasses);
        // Copies property to local variable for closure function call.
        $isUnitTestClass = self::$_isUnitTestClass;
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
    static function checkFunctionLocalStaticVariable()
    {
        B::limitAccess('BreakpointDebugging_PHPUnit.php', true);

        $componentFullPath = stream_resolve_include_path('BreakpointDebugging/Component/') . DIRECTORY_SEPARATOR;
        $definedFunctionsName = get_defined_functions();
        // Copies property to local variable for closure function call.
        $isUnitTestClass = self::$_isUnitTestClass;
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
    static function checkMethodLocalStaticVariable()
    {
        B::limitAccess('BreakpointDebugging_PHPUnit.php', true);

        // Scans the declared classes.
        $declaredClasses = get_declared_classes();
        $currentDeclaredClassesNumber = count($declaredClasses);
        // Copies property to local variable for closure function call.
        $isUnitTestClass = self::$_isUnitTestClass;
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

    /**
     * Checks an "include" error at "setUp()", "test*()" or "tearDown()".
     *
     * @return void
     */
    static function checkIncludeError()
    {
        B::limitAccess(array (
            'BreakpointDebugging/PHPUnit/FrameworkTestCase.php',
            'BreakpointDebugging/PHPUnit/FrameworkTestCaseSimple.php'
        ));

        $currentDeclaredClasses = get_declared_classes();
        // If a class has not been declared.
        if (count($currentDeclaredClasses) === count(self::$_declaredClasses)) {
            return;
        }
        // Gets the included classes because autoloaded classes make error handling.
        $includedClassNames = array_diff($currentDeclaredClasses, self::$_declaredClasses);
        self::_displayError(true, $includedClassNames);
    }

}

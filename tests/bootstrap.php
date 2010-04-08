<?php
putenv('APPLICATION_ENV=testing');
require_once(dirname(__FILE__).'/../common.php');
$application = System_Application::getInstance();
$application->bootstrap();

// TODO: find a proper way to tell PHPUnit to ignore these classes
Zend_Loader::loadClass('System_Test_TestCase');
Zend_Loader::loadClass('System_Test_DatabaseTestCase');
Zend_Loader::loadClass('System_Test_AjaxTestCase');


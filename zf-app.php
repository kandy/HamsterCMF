<?php
putenv('APPLICATION_ENV=cli');
require_once('common.php');

$application = System_Application::getInstance();
$application
	->bootstrap('Log')
	->bootstrap('Db')
	->bootstrap('FrontController')
	->bootstrap('View')
	->bootstrap('Cli')
	->bootstrap('Autoload');
$application->run();

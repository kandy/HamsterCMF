<?php
$rootPath = dirname(__FILE__);
set_include_path(implode(PATH_SEPARATOR, array(
	realpath($rootPath . '/../system'),
	realpath($rootPath . '/library'),
	get_include_path(),
)));

$environment = getenv('APPLICATION_ENV');
$environment = empty($environment) ? 'main' : $environment;

require_once 'System/Application.php';
new System_Application($environment, $rootPath);

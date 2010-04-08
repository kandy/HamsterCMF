<?php
require_once('../common.php');
$application = System_Application::getInstance();
$application
	->bootstrap()
	->run();

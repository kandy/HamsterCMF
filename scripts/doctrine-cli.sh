#!/usr/bin/env php
<?php
require '../application/Bootstrap.php';
putenv('DEVELOPMENT=true');
Zend_Loader::registerAutoload();
Bootstrap::setupConfig();
Bootstrap::setupEnvironment();
My_Controller_Plugin_Doctrine::setupDoctrine();
$cli = new Doctrine_Cli(Zend_Registry::get('config_doctrine'));
$cli->run($_SERVER['argv']);
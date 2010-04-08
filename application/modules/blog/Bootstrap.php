<?php
/**
 * Module bootstrap.
 * Performs custom Module initialization.
 *
 * @package application.blog.bootstrap
 */
class Blog_Bootstrap extends Zend_Application_Module_Bootstrap 
{
	protected function _initAutoloading() {
		$resourceLoader = new Zend_Loader_Autoloader_Resource(array(
			'basePath' => dirname(__FILE__),
			'namespace' => 'Blog',
		));
		
		$resourceLoader->addResourceType('blog-form', 'forms', 'Form_');
	}
}

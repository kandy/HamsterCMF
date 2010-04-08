<?php
/**
 * @package application.action
 */
class ErrorController extends System_Controller_Action_Abstract 
{
	public function errorAction() {
		$error = $this->_getParam ('error_handler');
		$code = 500;
		if ($error->exception instanceof  Zend_Controller_Action_Exception) {
			$code = 404;
		}
		header('X-Error-Message:'. $error->exception->getMessage(), true, $code);
		echo '<h1>','Error: ', $error->exception->getMessage(),'</h1>';
		echo '<pre>',$error->exception,'</pre>';

		//var_dump($error->exception);
		die();

	}

	public function deniedAction() {
		echo '<h1>Access denied</h1>';
		header('X-Error-Message: Access denied', 403);
		die();

	}

}

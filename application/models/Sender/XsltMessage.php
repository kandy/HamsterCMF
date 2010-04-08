<?php
class Model_Sender_XsltMessage extends Model_Sender_AbstractMessage 
{
	/**
	 * View
	 * @var Zend_View_Abstract
	 */
	protected $_view = null;
	/**
	 * Template name
	 * @var string
	 */
	protected $_mailTemplate = null;
	
	/**
	 * Configurable object
	 * @param $options
	 */
	public function __construct($options = null) {
		System_Options::setConstructorOptions($this, $options);
	}
	
	/**
	 * Set view
	 * @param Zend_View_Abstract $view
	 */
	public function setView(Zend_View_Abstract $view){ 
		$this->_view = $view; 
	}
	/**
	 * Get view
	 * @return Zend_View_Abstract
	 */
	public function getView() {
		if (! $this->_view instanceof Zend_View_Abstract) {
			throw new System_Exception('View not set');
		}
		return $this->_view;
	}
	
	public function setMailTemplate($mailTemplate) { 
		$this->_mailTemplate = (string)$mailTemplate; 
	}
	
	public function getMailTemplate() {
		if (empty($this->_mailTemplate)) {
			throw new System_Exception('MailTemplate not set');
		}
		return $this->_mailTemplate;
	}
	
	public function getBody() {
		$view = $this->getView();
		$view->parameter = $this->_parameter; 
		return $view->render($this->getMailTemplate());
	}
	
	/**
	 * Get configured view
	 * @param Zend_Controller_Action $action
	 * @return System_View_Xslt
	 */
	public static function getViewFromAction(Zend_Controller_Action $action){
		$bootstrap = $action->getInvokeArg('bootstrap');
		if ($bootstrap instanceof Zend_Application_Bootstrap_Bootstrap &&
			$bootstrap->getResource('View') instanceof Zend_View_Abstract) {
			$view = clone $bootstrap->getResource('View');
		}else{
			$view = new System_View_Xslt();
		}
		$view->setScriptPath($action->view->getScriptPaths());
		return $view;
	}
}
<?php

require_once 'phing/Task.php';
require_once 'System/Application.php';

class BootstrapResourceTask extends Task 
{
	/**
	 * Application instance
	 * @var System_Application
	 */
	protected $_application;
	/**
	 * Resource name
	 * @var string
	 */
	protected $resource = null;

	/**
	 *  Set sesource name
	 * @param $name
	 */
	public function setResource($name) {
		$this->resource = $name;
	}

	/**
	 * Set Application instance
	 * @param System_Application $application
	 * @return ConfigAdapterTask
	 */
	public function setApplication(System_Application $application) {
		$this->_application = $application;
		return $this;
	}

	/**
	 * Get Application instance
	 * @return System_Application
	 */
	public function getApplication() {
		if (!$this->_application) {
			try{
				$this->_application = System_Application::getInstance();
			}catch (Zend_Exception $e){
				$root = $this->getProject()->getProperty('path.root');
				$environment = $this->getProject()->getProperty('environment');
				$this->_application = new System_Application($environment, $root);
			}
		}
		return $this->_application;
	}

	/**
	 * Main task method
	 */
	public function main() {
		$application = $this->getApplication();
		switch ($this->resource) {
			case 'null':
				break;
			case '*':
				$application->bootstrap();
				break;
			default:
				$application->getBootstrap()->bootstrap($this->resource);
		}
	}
}
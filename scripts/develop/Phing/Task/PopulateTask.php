<?php
// @codeCoverageIgnoreStart
require_once 'phing/Task.php';
require_once 'System/Application.php';

/**
 * Phing populate task.
 *
 * Populate DB with test data
 */
class PopulateTask extends Task 
{
	/**
	 * Application instance
	 * @var System_Application
	 */
	protected $_application;

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
			$this->setApplication(System_Application::getInstance());
		}
		return $this->_application;
	}

	/**
	 * Main task method
	 */
	public function main() {
		require_once 'common.php';
		$this->getApplication()->bootstrap();
		$this->_populate();
	}

	/**
	 * 
	 * @param $name
	 * @return Zend_Db_Table
	 */
	private function getTable($name) {
		return System_Locator_TableLocator::getInstance()->get($name);
	}
	/**
	 * Populate Db with test data
	 */
	protected function _populate() {
		$this->getTable('User')->createRow(
			array(
				'username' => 'test',
				'password' => 'test'
			)
		)->save();
		$this->log('Add user');
	}
}
// @codeCoverageIgnoreEnd

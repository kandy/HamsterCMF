<?php
/**
 * Model_Auth_Adapter_User implements Zend_Auth_Adapter_Interface for authentication of users
 * 
 * @author oleg
 * @package model.auth.adapter
 */
class Model_Auth_Adapter_User implements Zend_Auth_Adapter_Interface 
{
	/**
	 * @var string
	 */
	private $_username;

	/**
	 * @var string
	 */
	private $_password;

	/**
	 * @param string $username
	 * @param string $password
	 */
	public function __construct($username, $password) {
		$this->_username = $username;
		$this->_password = $password;
	}

	/**
	 * Performs an authentication attempt
	 *
	 * @throws Zend_Auth_Adapter_Exception If authentication cannot be performed
	 * @return Zend_Auth_Result
	 */
	public function authenticate() {
		$code = null;
		$identity = null;
		$messages = array();

		try {
			$users = System_Locator_TableLocator::getInstance()->get('User');
				
			$select = $users->select()
			->where('username = :username')
			->where('password = MD5(:password)')
			->bind(array(
					'username' => $this->_username,
					'password' => $this->_password,
			));

			$identity = $users->fetchRow($select);

			if ($identity != null) {
				unset($identity->password);
				$identity->setReadOnly(true);
				$code = Zend_Auth_Result::SUCCESS;
				$messages[] = 'Authentication successful';
			}
			else {
				$code = Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID;
				$messages[] = 'Authentication not successful';
			}

		} catch (Zend_Db_Exception $e) {
			$code = Zend_Auth_Result::FAILURE_UNCATEGORIZED;
			$messages[] = $e->getMessage();
		}

		return new Zend_Auth_Result(
		$code,
		$identity,
		$messages
		);
	}
}

<?php
/**
 * Creates Agent.
 *
 * @package model
 */
abstract class Model_Creator_Abstract 
{
	/**
	 * User name
	 * @var string
	 */
	protected $_username;

	/**
	 * User password
	 * @var string
	 */
	protected $_password;

	/**
	 * User email
	 * @var string
	 */
	protected $_email;
	
	/**
	 * User phone
	 * @var string
	 */
	protected $_phone;

	/**
	 * User countryCode
	 * @var string
	 */
	protected $_countryCode;
	
	/**
	 * Configurable object constructor 
	 * @param array $values
	 */
	public function __construct(array $values = null) {
		System_Options::setConstructorOptions($this, $values);
	}
	
	/**
	 * List of user settings
	 * @var array
	 */
	protected $_userSettings = array();

	/**
	 * Sets username
	 * @param string $username
	 */
	public function setUsername($username) {
		$this->_username = $username;
	}

	/**
	 * Returns username
	 * @return string
	 */
	public function getUsername() {
		if (!$this->_username) {
			throw new System_Exception('Username is not set');
		}
		return $this->_username;
	}

	/**
	 * Sets the user password
	 * @param string $password
	 */
	public function setPassword($password) {
		$this->_password = $password;
	}

	/**
	 * Returns user password
	 * @return string
	 */
	public function getPassword() {
		if (!$this->_password) {
			throw new System_Exception('User password is not set');
		}
		return $this->_password;
	}

	/**
	 * Sets the user email
	 * @param string $email 
	 */
	public function setEmail($email) {
		$this->_email = $email;
	}

	/**
	 * Returns the user email
	 * @return string
	 */
	public function getEmail() {
		if (!$this->_email) {
			throw new System_Exception('User email is not set');
		}
		return $this->_email;
	}
	
	/**
	 * Sets the user countryCode
	 * @param string $countryCode 
	 */
	public function setCountryCode($countryCode) {
		$this->_countryCode = $countryCode;
	}

	/**
	 * Returns the user countryCode
	 * @return string
	 */
	public function getCountryCode() {
		if (!$this->_countryCode) {
			throw new System_Exception('User countryCode is not set');
		}
		return $this->_countryCode;
	}
	
	/**
	 * Sets user settings array
	 * @param array $userSettings
	 */
	public function setUserSettings($userSettings) {
		$this->_userSettings = (array)$userSettings;
	}

	/**
	 * Returns user setting
	 * @return array
	 */
	public function getUserSettings() {
		return $this->_userSettings;
	}

	/**
	 * Creates a User entry
	 * @return Model_Row_User
	 */
	protected function _createUser() {
		$user = System_Locator_TableLocator::getInstance()->get('User')->createRow();
		$user->username = $this->getUsername();
		$user->setPassword($this->getPassword());
		$user->email = $this->getEmail();
		$user->countryCode = $this->getCountryCode();
		$user->createdAt = date(DATE_ISO8601); 
		return $user;
	}
	
}

<?php
/**
 * @package model.row
 */
class Model_Row_User extends System_Db_Table_Row_Abstract
	implements Zend_Acl_Role_Interface 
{
	/**
	 * System user id 
	 * @var integer
	 */
	const SYSTEM_USER_ID = 1;

	/**
	 * Returns user's settings
	 *
	 * @return Model_Row_UserSettings
	 */
	public function getUserSettings() {
		$userSettingsRowSet = $this->findDependentRowset('UserSettings');
		$userSettings = $userSettingsRowSet->current();
		if ($userSettings == null) {
			return array();
		} else {
			return $userSettings;
		}
	}

	/**
	 * Get role for acl
	 * @see Zend_Acl_Role_Interface::getRoleId
	 */
	public function getRoleId() {
		if (empty($this->email)) {
			return 'noemail';
		}
		return $this->role;
	}

	/**
	 * Checks if provided password is user password
	 * @param string $password
	 * @return boolean
	 */
	public function isUserPassword($password) {
		return ($this->password == $this->_getPasswordHash($password));
	}

	/**
	 * Return passwrod hash
	 * @param string $password
	 * @return string
	 */
	protected function _getPasswordHash($password) {
		return md5($password);
	}

	/**
	 * Sets user password
	 * @param string $password
	 * @return Model_Row_User
	 */
	public function setPassword($password) {
		$this->password = $this->_getPasswordHash($password);
		return $this;
	}
}

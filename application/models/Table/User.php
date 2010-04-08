<?php
/**
 * @package model.table
 */
class Model_Table_User extends System_Db_Table_Abstract 
{
	protected $_name = 'User';
	protected $_rowClass = 'Model_Row_User';

	protected $_dependentTables = array(
		'UserSettings',
	);

	/**
	 * Returns user by its name
	 *
	 * @param string $username
	 * @return Model_Row_User or null
	 */
	public function getUserByUsername($username) {
		return $this->fetchRow(
			$this->select()->where('username = ?', $username)
		);
	}
}

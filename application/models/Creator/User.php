<?php
/**
 * Creates Agent.
 *
 * @package model
 */
class Model_Creator_User extends Model_Creator_Abstract
{
	const PARTNER_STATUS = 5;
	/**
	 * User sponsor
	 * @var Model_Row_User
	 */
	protected $_sponsor;
	/**
	 * Sets the user sponsor
	 * @param Model_Row_User $sponsor 
	 */
	public function setSponsor(Model_Row_User $sponsor) {
		$this->_sponsor = $sponsor;
	}

	/**
	 * Returns the user sponsor
	 * @return Model_Row_User
	 */
	public function getSponsor() {
		return $this->_sponsor;
	}

	/**
	 * Creates user.
	 * Creates UserSettings entry, balance and commission user accounts, and user income center in current tree.
	 */
	public function create() {
		$db = System_Locator_TableLocator::getInstance()->get('User')->getAdapter();
		try {
			$db->beginTransaction();
			$user = $this->_createUser();
			$user->save();
			$db->commit();
		} catch (Exceptino $e) {
			$db->rollBack();
			throw $e;
		}

		return $user;		
	}

	/**
	 * Creates a User entry
	 * @return Model_Row_User
	 */
	protected function _createUser() {
		$user = parent::_createUser();
		$user->role = 'user';
		return $user;
	}
}

<?php
/**
 * Creates Agent.
 *
 * @package model
 */
class Model_Creator_Agent extends Model_Creator_Abstract 
{
	const PARTNER_STATUS = 3;
	
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
		if (!$this->_sponsor) {
			throw new System_Exception('User sponsor is not set');
		}
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
			$this->_createNode($user);
			
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
		$user->role = $this->getRole();
		$user->partnerStatus = Model_Creator_Agent::PARTNER_STATUS;
		return $user;
	}

	/**
	 * Creates node for agent tree
	 */
	protected function _createNode(Model_Row_User $user) {
		$node = System_Locator_TableLocator::getInstance()
			->get('AgentTree')
			->createRow();
		$node->id = $user->id;
		$node->parentId = $this->getSponsor()->id;
		$node->save();
	}
}

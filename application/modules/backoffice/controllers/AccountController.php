<?php
/**
 * @package application.action
 */
class Backoffice_AccountController extends System_Controller_Action_Json
{
	public function gridAction() {
		$table = $this->getTable('User');
		$select = $this->getHelper('GridFilter')->getSelect($table);
		//$select->where('ownerId = ?', Model_Row_User::SYSTEM_USER_ID);
		$this->view->assign($this->getHelper('GridFilter')->getData($select));
	}

}

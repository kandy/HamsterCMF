<?php
/**
 * @package model.table
 */
class Model_Table_UserSettings extends System_Db_Table_Abstract 
{
	protected $_name = 'UserSettings';
	protected $_rowClass = 'Model_Row_UserSettings';

	protected $_referenceMap = array(
		'User' => array(
			'columns' => 'userId',
			'refTableClass' => 'Model_Table_User',
			'refColumns' => 'id'
		),
	);
	
	/**
	 * Get settigns for user
	 * @param strinf $name
	 * @param $user
	 * @return Model_Row_UserSettings
	 */
	public function getSettings($name, Model_Row_User $user) {
		$select = $this->select()
			->where('userId = ?', $user->id)
			->where('name = ?', $name);
			
		$row = $this->fetchRow($select);
		if (!$row instanceof Model_Row_UserSettings) {
			//create row
			$row = $this->createRow();
			$row->name = $name;
			$row->userId = $user->id;
		}
		return $row;
	}
	
}

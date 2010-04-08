<?php
/**
 * @package model.row
 */
class Model_Row_UserSettings extends System_Db_Table_Row_Abstract 
{
	public function setValue($value){
		$this->value = $value;
		return $this;
	}
}

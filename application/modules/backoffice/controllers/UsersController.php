<?php
/**
 * @package application.action
 */
class Backoffice_UsersController extends System_Controller_Action_TableEditor
{
	public function init() 
	{
		$this->_table = System_Locator_TableLocator::getInstance()->get('User');
	}
}

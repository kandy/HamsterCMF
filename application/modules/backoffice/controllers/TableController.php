<?php
/**
 * @package application.backoffice.action
 */
class Backoffice_TableController extends System_Controller_Action_Json
{
	public function listAction() {
		$adapter = $this->getTable('User')->getAdapter();
		$tables = array();
		foreach ($adapter->listTables() as $tableName) {
			$table = array();
			
			$table['text'] = $tableName;
			$table['id'] = 'table/'.$tableName;
			$table['leaf'] = true;
			
			$tables[]= $table;
		}
		unset($this->view->success);
		$this->view->assign($tables);
	}
	
	public function showAction(){
		$table = $this->getTable($this->getRequest()->getParam('name'));
		$meta = $table->info(Zend_Db_Table::METADATA);
		$cols = array();
		foreach ($meta as $name => $set) {
			$col = array();
			$col['header'] = ucwords($name);
			$col['dataIndex'] = $name;
			$cols[] = $col;
		}
		$this->view->name = $this->getRequest()->getParam('name');
		$this->view->cols  = $cols;
		
	}
	
	public function gridAction() {
		$table = $this->getTable($this->getRequest()->getParam('name'));
		$select = $this->getHelper('GridFilter')->getSelect($table);
		$this->view->assign($this->getHelper('GridFilter')->getData($select));
	}
}
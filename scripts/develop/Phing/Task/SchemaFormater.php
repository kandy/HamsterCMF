<?php
// @codeCoverageIgnoreStart
require_once 'phing/Task.php';
require_once 'SchemaFormater/Parser.php';
require_once 'SchemaFormater/Sorter.php';
/**
 * Phing SchemaFormater task
 * Used to formater db schema files
 */
class SchemaFormater extends Task 
{
	protected $_schema = null;
	
	public function setSchema($schema) {
		$this->_schema = $schema;
	}
	
	public function getSchema() {
		if (empty($this->_schema)) {
			throw new BuildException('Schema is not set');
		}
		
		if (!is_readable($this->_schema)) {
			throw new BuildException('Schema '.$this->_schema.' is not readable');
		}
		
		return $this->_schema;
	}
	/**
	 * Main task method
	 */
	public function main() {
		$shema = $this->getSchema();
		
		$sorter = new SchemaFormater_Sorter($shema);
		$sorter->sort();
		
		$parser = new SchemaFormater_Parser($shema);
		$parser->parse();
		
	}
}
// @codeCoverageIgnoreEnd
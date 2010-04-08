<?php
require_once 'phing/tasks/ext/phpunit/PHPUnitTask.php';

/**
 * Class for run test with bootsrap
 * @author Andrii Kasian <to.kandy@gmail.com>
 */
class PHPUnit3Task extends PHPUnitTask 
{
	private $bootstrapfile = null;

	public function setBootstrapfile($value) {
		$this->bootstrapfile = $value;
	}

	/**
	 * The main entry point
	 */
	function main() {
		if ($this->bootstrapfile !== null){
			include_once $this->bootstrapfile;
		}
		parent::main();
	}
}
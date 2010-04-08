<?php
// @codeCoverageIgnoreStart
class Dependencies_Functions 
{
	
	/**
	 * Nested <function> elements
	 * 
	 * @var array
	 */
	private $functions = array();
	
	/**
	 * Creator for nested <function> element
	 * 
	 * @return array
	 */
	public function createFunction() {
		require_once 'Functions/Function.php';
		return $this->functions[] = new Dependencies_Functions_Function();
	}
	
	/**
	 * Check php environment has functions
	 *  
	 * Returns 0 on success, non-zero otherwise
	 *  
	 * @return integer
	 */
	public function check() {
		$status = 0;
		
		foreach($this->functions as $function) {
			$status |= $function->check();
		} 
		
		return $status;
	}
}
// @codeCoverageIgnoreEnd
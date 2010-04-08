<?php
// @codeCoverageIgnoreStart
class Dependencies_Constants 
{
	
	/**
	 * Nested <constant> elements
	 * 
	 * @var array
	 */
	private $constants = array();
	
	/**
	 * Creator for nested <constant> element
	 * 
	 * @return array
	 */
	public function createConstant() {
		require_once 'Constants/Constant.php';
		return $this->constants[] = new Dependencies_Constants_Constant();
	}
	
	/**
	 * Check php environment has constants
	 *  
	 * Returns 0 on success, non-zero otherwise
	 *  
	 * @return integer
	 */
	public function check() {
		$status = 0;
		
		foreach($this->constants as $constant) {
			$status |= $constant->check();
		} 
		
		return $status;
	}
}
// @codeCoverageIgnoreEnd
<?php
// @codeCoverageIgnoreStart
class Dependencies_Configuration 
{
	
	/**
	 * Nested <parameter> elements
	 * 
	 * @var array
	 */
	private $parameters = array();
	
	/**
	 * Creator for nested <parameter> element
	 * 
	 * @return array
	 */
	public function createParameter() {
		require_once 'Configuration/Parameter.php';
		return $this->parameters[] = new Dependencies_Configuration_Parameter();
	}
	
	/**
	 * Check php environment parameter is correct
	 *  
	 * Returns 0 on success, non-zero otherwise
	 *  
	 * @return integer
	 */
	public function check() {
		$status = 0;
		
		foreach($this->parameters as $parameter) {
			$status |= $parameter->check();
		} 
		
		return $status;
	}
}
// @codeCoverageIgnoreEnd
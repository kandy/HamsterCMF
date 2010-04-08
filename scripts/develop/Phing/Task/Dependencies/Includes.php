<?php
// @codeCoverageIgnoreStart
class Dependencies_Includes 
{
	
	/**
	 * Nested <include> elements
	 * 
	 * @var array
	 */
	private $includes = array();
	
	/**
	 * Creator for nested <include> element
	 * 
	 * @return array
	 */
	public function createInclude() {
		require_once 'Includes/Include.php';
		return $this->includes[] = new Dependencies_Includes_Include();
	}
	
	/**
	 * Check php environment has file able to be included
	 *  
	 * Returns 0 on success, non-zero otherwise
	 *  
	 * @return integer
	 */
	public function check() {
		$status = 0;
		
		foreach($this->includes as $include) {
			$status |= $include->check();
		} 
		
		return $status;
	}
}
// @codeCoverageIgnoreEnd
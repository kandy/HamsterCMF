<?php
// @codeCoverageIgnoreStart
class Dependencies_Shells 
{
	
	/**
	 * Nested <shell> elements
	 * 
	 * @var array
	 */
	private $shells = array();
	
	/**
	 * Creator for nested <shell> element
	 * 
	 * @return array
	 */
	public function createShell() {
		require_once 'Shells/Shell.php';
		return $this->shells[] = new Dependencies_Shells_Shell();
	}
	
	/**
	 * Check environment has installed shell application
	 *  
	 * Returns 0 on success, non-zero otherwise
	 *  
	 * @return integer
	 */
	public function check() {
		$status = 0;
		
		foreach($this->shells as $shells) {
			$status |= $shells->check();
		} 
		
		return $status;
	}
}
// @codeCoverageIgnoreEnd
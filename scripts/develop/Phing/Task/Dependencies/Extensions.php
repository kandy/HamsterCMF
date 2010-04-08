<?php
// @codeCoverageIgnoreStart
class Dependencies_Extensions 
{
	
	/**
	 * Nested <extension> elements
	 * 
	 * @var array
	 */
	private $extensions = array();
	
	/**
	 * Creator for nested <extension> element
	 * 
	 * @return array
	 */
	public function createExtension() {
		require_once 'Extensions/Extension.php';
		return $this->extensions[] = new Dependencies_Extensions_Extension();
	}
	
	/**
	 * Check php environment has extensions loaded
	 *  
	 * Returns 0 on success, non-zero otherwise
	 *  
	 * @return integer
	 */
	public function check() {
		$status = 0;
		
		foreach($this->extensions as $extension) {
			$status |= $extension->check();
		} 
		
		return $status;
	}
}
// @codeCoverageIgnoreEnd
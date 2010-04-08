<?php
// @codeCoverageIgnoreStart
class Dependencies_Pear 
{
	
	/**
	 * Nested <package> elements
	 * 
	 * @var array
	 */
	private $packages = array();
	
	/**
	 * Creator for nested <package> element
	 * 
	 * @return array
	 */
	public function createPackage() {
		require_once 'Pear/Package.php';
		return $this->packages[] = new Dependencies_Pear_Package();
	}
	
	/**
	 * Check php environment has pear package
	 *  
	 * Returns 0 on success, non-zero otherwise
	 *  
	 * @return integer
	 */
	public function check() {
		$status = 0;
		
		foreach($this->packages as $package) {
			$status |= $package->check();
		} 
		
		return $status;
	}
}
// @codeCoverageIgnoreEnd
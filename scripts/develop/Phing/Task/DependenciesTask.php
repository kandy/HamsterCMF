<?php
// @codeCoverageIgnoreStart
require_once 'phing/Task.php';
require_once 'Dependencies/Functions.php';
require_once 'Dependencies/Constants.php';
require_once 'Dependencies/PhpVersion.php';
require_once 'Dependencies/Extensions.php';
require_once 'Dependencies/Configuration.php';
require_once 'Dependencies/Includes.php';
require_once 'Dependencies/Pear.php';
require_once 'Dependencies/Shells.php';

/**
 * DependenciesTask is used to check dependencies of development/product/etc environment
 *  
 * @author oleg
 */
class DependenciesTask extends Task 
{

	/**
	 * Nested <functions> element
	 * @var Dependencies_Functions
	 */
	private $functions;

	/**
	 * Nested <constants> element
	 * @var Dependencies_Constants
	 */
	private $constants;
	
	/**
	 * Nested <phpversion> element
	 * @var Dependencies_PhpVersion
	 */
	private $phpVersion;
	
	/**
	 * Nested <extensions> element
	 * @var Dependencies_Extensions
	 */
	private $extensions;
	
	/**
	 * Nested <configuration> element
	 * @var Dependencies_Configuration
	 */
	private $configuration;
	
	/**
	 * Nested <includes> element
	 * @var Dependencies_Includes
	 */
	private $includes;
	
	/**
	 * Nested <pear> element
	 * @var Dependencies_Pear
	 */
	private $pear;
	
	/**
	 * Nested <shells> element
	 * @var Dependencies_Shells
	 */
	private $shells;
	
	/**
	 * Creator for support nested <functions> element
	 * @return Dependencies_Functions
	 */
	public function createFunctions() {
		return $this->functions = new Dependencies_Functions();
	}
	
	/**
	 * Creator for support nested <constants> element
	 * @return Dependencies_Constants
	 */
	public function createConstants() {
		return $this->constants = new Dependencies_Constants();
	}
	
	/**
	 * Creator for support nested <phpversion> element
	 * @return Dependencies_PhpVersion
	 */
	public function createPhpVersion() {
		return $this->phpVersion = new Dependencies_PhpVersion();
	}
	
	/**
	 * Creator for support nested <extensions> element
	 * @return Dependencies_Extensions
	 */
	public function createExtensions() {
		return $this->extensions = new Dependencies_Extensions();
	}
	
	/**
	 * Creator for support nested <configuration> element
	 * @return Dependencies_Configuration
	 */
	public function createConfiguration() {
		return $this->configuration = new Dependencies_Configuration();
	}
	
	/**
	 * Creator for support nested <includes> element
	 * @return Dependencies_Includes
	 */
	public function createIncludes() {
		return $this->includes = new Dependencies_Includes();
	}
	
	/**
	 * Creator for support nested <pear> element
	 * @return Dependencies_Pear
	 */
	public function createPear() {
		return $this->pear = new Dependencies_Pear();
	}
	
	/**
	 * Creator for support nested <shells> element
	 * @return Dependencies_Shells
	 */
	public function createShells() {
		return $this->shells = new Dependencies_Shells();
	}
	
	public function main() {
		$status = 0;
		$status |= (!$this->functions) ? 0 : $this->functions->check();
		$status |= (!$this->constants) ? 0 : $this->constants->check();
		$status |= (!$this->phpVersion) ? 0 : $this->phpVersion->check();
		$status |= (!$this->extensions) ? 0 : $this->extensions->check();
		$status |= (!$this->configuration) ? 0 : $this->configuration->check();
		$status |= (!$this->includes) ? 0 : $this->includes->check();
		$status |= (!$this->pear) ? 0 : $this->pear->check();
		$status |= (!$this->shells) ? 0 : $this->shells->check();
		
		if ($status == 0) {
			$this->log('Dependencies are OK');
		} else {
			$this->log('Some dependencies are not meet');
		}
	}
}
// @codeCoverageIgnoreEnd
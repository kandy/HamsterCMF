<?php
// @codeCoverageIgnoreStart
require_once 'phing/Task.php';
require_once 'Zend/Config/Ini.php';
require_once 'System/Config/Placeholder.php';


/**
 * Phing Config Adapter task.
 * Transfers all config parameters loaded by System_Application
 * to phing's properties so they are accessible in build.xml
 */
class ConfigAdapterTask extends Task 
{
	const NAME_PARTS_SEPARATOR = '.';
	protected $config = 'application/configs/application.common.ini';
	protected $environment = 'main';

	/**
	 * Set configuation file
	 * @param $value
	 */
	public function setConfig($value) {
		$this->config = $value;
	}

	/**
	 * Set environment type
	 * @param $value
	 */
	public function setEnvironment($value) {
		$this->environment = $value;
	}

	/**
	 * Main task method
	 */
	public function main() {
		$this->_populate($this->_loadConfig($this->config, $this->environment));
	}

	/**
	 * Load configuration file of options
	 *
	 * @param  string $file
	 * @return array
	 */
	protected function _loadConfig($file, $environment) {
		$configCommon = new Zend_Config_Ini($file, $environment, true);

		$configCustom = new Zend_Config_Ini(str_replace('.common.ini', '.ini', $file), $environment);

		$configCommon->merge($configCustom);
		$configCommon->path->root = getcwd();

		$config = new System_Config_Placeholder($configCommon);

		return $config->toArray();
	}

	/**
	 * Recursively populate phing's project with options.
	 * @var array
	 * @var string
	 */
	protected function _populate(array $options, $prefix = null) {
		foreach ($options as $key => $value) {
			$fullKey = ($prefix ? $prefix . self::NAME_PARTS_SEPARATOR . $key : $key);
			if (is_array($value)) {
				$this->_populate($value, $fullKey);
			} else {
				$this->project->setProperty($fullKey, $value);
			}
		}
	}
}
// @codeCoverageIgnoreEnd
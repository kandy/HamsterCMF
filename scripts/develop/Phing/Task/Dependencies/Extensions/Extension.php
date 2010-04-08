<?php
// @codeCoverageIgnoreStart
class Dependencies_Extensions_Extension extends ProjectComponent 
{

	/**
	 * Extension name
	 * @var string
	 */
	private $extensionName = '';
	
	/**
	 * Text adder function
	 * @param string $extensionName
	 */
	public function addText($extensionName) {
		$this->extensionName = trim($extensionName);
	}

	/**
	 * Check php extension loaded
	 * 
	 * Returns 0 on success, non-zero otherwise
	 * 
	 * @return int
	 */
	public function check() {
		$loadedExtensions = get_loaded_extensions();
		if (!in_array($this->extensionName, $loadedExtensions)) {
			$this->log('Extension '.$this->extensionName.' is required', Project::MSG_ERR);
			return 1;
		}
		$this->log('Extension '.$this->extensionName.' is passed', Project::MSG_VERBOSE);
		return 0;
	}
}
// @codeCoverageIgnoreEnd
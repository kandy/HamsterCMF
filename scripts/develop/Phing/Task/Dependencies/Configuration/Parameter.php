<?php
// @codeCoverageIgnoreStart
class Dependencies_Configuration_Parameter extends ProjectComponent 
{

	/**
	 * Parameter name
	 * @var string
	 */
	private $name;
	
	/**
	 * Parameter value
	 * @var string
	 */
	private $value;
	
	public function setName($name) {
		$this->name = $name;
	}
	
	public function setValue($value) {
		$this->value = $value;
	}

	/**
	 * Check php function exists
	 * 
	 * Returns 0 on success, non-zero otherwise
	 * 
	 * @return int
	 */
	public function check() {
		$values = array($this->value);
		if ($this->value == 'On') {
			$values[] = '1';
		}
		elseif ($this->value == 'Off') {
			// TODO check it, empty is default value
			$values[] = '';
			$values[] = '0';
		}
		if (!in_array(ini_get($this->name), $values)) {
			$this->log('Setting '.$this->name.'='.ini_get($this->name).'. "'.$this->value.'" is required', Project::MSG_ERR);
			return 1;
		}
		
		$this->log('Setting '.$this->name.' is passed', Project::MSG_VERBOSE);
		return 0;
	}
}
// @codeCoverageIgnoreEnd
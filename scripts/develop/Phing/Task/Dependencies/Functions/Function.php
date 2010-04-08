<?php
// @codeCoverageIgnoreStart
class Dependencies_Functions_Function extends ProjectComponent 
{

	/**
	 * Function name
	 * @var string
	 */
	private $functionName = '';
	
	/**
	 * Text adder function
	 * @param string $functionName
	 */
	public function addText($functionName) {
		$this->functionName = trim($functionName);
	}

	/**
	 * Check php function exists
	 * 
	 * Returns 0 on success, non-zero otherwise
	 * 
	 * @return int
	 */
	public function check() {
		if (!function_exists($this->functionName)) {
			$this->log('Function "'.$function.'" is required', Project::MSG_ERR);
			return 1;
		}
		$this->log('Function "'.$this->functionName.'" is passed', Project::MSG_VERBOSE);
		return 0;
	}
}
// @codeCoverageIgnoreEnd
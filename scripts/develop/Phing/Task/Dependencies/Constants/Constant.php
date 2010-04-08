<?php
// @codeCoverageIgnoreStart
class Dependencies_Constants_Constant extends ProjectComponent 
{

	/**
	 * Constant name
	 * @var string
	 */
	private $constantName = '';
	
	/**
	 * Text adder function
	 * @param string $constantName
	 */
	public function addText($constantName) {
		$this->constantName = trim($constantName);
	}

	/**
	 * Check php constant exists
	 * 
	 * Returns 0 on success, non-zero otherwise
	 * 
	 * @return int
	 */
	public function check() {
		if (!defined($this->constantName)) {
			$this->log('Constant "'.$this->constantName.'" is required', Project::MSG_ERR);
			return 1;
		}
		$this->log('Constant "'.$this->constantName.'" is passed', Project::MSG_VERBOSE);
		return 0;
	}
}
// @codeCoverageIgnoreEnd
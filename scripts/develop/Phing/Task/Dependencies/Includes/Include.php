<?php
// @codeCoverageIgnoreStart
class Dependencies_Includes_Include extends ProjectComponent 
{

	/**
	 * File name
	 * @var string
	 */
	private $fileName = '';
	
	/**
	 * Text adder function
	 * @param string $fileName
	 */
	public function addText($fileName) {
		$this->fileName = trim($fileName);
	}

	/**
	 * Check php file exists and able to be included
	 * 
	 * Returns 0 on success, non-zero otherwise
	 * 
	 * @return int
	 */
	public function check() {
		if (!@include_once $this->fileName) {
			$this->log('File "'.$this->fileName.'" is required to be includeable', Project::MSG_ERR);
			return 1;
		}
		
		$this->log('File "'.$this->fileName.'" is passed to be includeable', Project::MSG_VERBOSE);
		return 0;
	}
}
// @codeCoverageIgnoreEnd
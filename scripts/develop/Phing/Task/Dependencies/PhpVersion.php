<?php
// @codeCoverageIgnoreStart
class Dependencies_PhpVersion extends ProjectComponent 
{

	/**
	 * Minimal version
	 * @var string
	 */
	private $min;
	
	/**
	 * Maximal version
	 * @var string
	 */
	private $max;

	/**
	 * @param string $min
	 * @return string
	 */
	public function setMin($min) {
		$this->min = $min;
	}
	
	public function setMax($max) {
		$this->max = $max;
	}

	/**
	 * Check php environment version
	 *
	 * Returns 0 on success, non-zero otherwise
	 *
	 * @return integer
	 */
	public function check() {
		if (version_compare(PHP_VERSION, $this->min, '<')) {
			$this->log('PHP version is '.PHP_VERSION.'. >= '.$this->min.' is required', Project::MSG_ERR);
			return 1;
		}
		if (version_compare(PHP_VERSION, $this->max, '>')) {
			$this->log('PHP version is '.PHP_VERSION.'. <= '.$this->max.' is required', Project::MSG_ERR);
			return 1;
		}
		$this->log('PHP version '.PHP_VERSION.' is passed', Project::MSG_VERBOSE);
		return 0;
	}
}
// @codeCoverageIgnoreEnd
<?php
// @codeCoverageIgnoreStart
class Dependencies_Shells_Shell extends ProjectComponent 
{

	/**
	 * Shell name
	 * @var string
	 */
	private $name = '';

	/**
	 * Shell command
	 * @var string
	 */
	private $command = '';

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
	 * @param string $name
	 */
	public function setName($name) {
		$this->name = trim($name);
	}

	/**
	 *
	 * @param string $command
	 */
	public function setCommand($command) {
		$this->command = escapeshellcmd($command).' 2>&1';
	}

	/**
	 * @param string $min
	 */
	public function setMin($min) {
		$this->min = $min;
	}

	/**
	 * @param string $max
	 */
	public function setMax($max) {
		$this->max = $max;
	}

	/**
	 * Check environment has installed shell application
	 *
	 * Returns 0 on success, non-zero otherwise
	 *
	 * @return int
	 */
	public function check() {
		exec($this->command, $output);
		$output = join("\n", $output);
		if (!preg_match_all('/[0-9]+\.[0-9]+(\.[0-9]+)?/', $output, $matches)) {
			$this->log($this->name.' is required', Project::MSG_ERR);
			return 1;
		}

		$isPassed = false;
		foreach($matches[0] as $match) {
			$version = $match;
			if ($this->min && !$this->max && version_compare($version, $this->min, '>=')) {
				$isPassed = true;
				break;
			}
			if (!$this->min && $this->max && version_compare($version, $this->max, '<=')) {
				$isPassed = true;
				break;
			}
			if ($this->min && $this->max && version_compare($version, $this->min, '>=') && version_compare($version, $this->max, '<=')) {
				$isPassed = true;
				break;
			}
		}

		if (!$isPassed) {
			$this->log($this->name.' is required or other version is installed', Project::MSG_ERR);
			return 1;
		}

		$this->log($this->name.' version '.$version.' is passed', Project::MSG_VERBOSE);
		return 0;
	}
}
// @codeCoverageIgnoreEnd
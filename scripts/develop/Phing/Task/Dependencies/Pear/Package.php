<?php
// @codeCoverageIgnoreStart
class Dependencies_Pear_Package extends ProjectComponent 
{

	/**
	 * Package name
	 * @var string
	 */
	private $name = '';

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
	 * Channel name
	 * @var string
	 */
	private $channel;

	/**
	 * @param string $name
	 */
	public function setName($name) {
		$this->name = trim($name);
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
	 * @param string $channel
	 */
	public function setChannel($channel) {
		$this->channel = $channel;
	}

	/**
	 * Check php package exists and has corresponding version
	 *
	 * Returns 0 on success, non-zero otherwise
	 *
	 * @return int
	 */
	public function check() {
		require_once 'PEAR/Registry.php';
		$registry = new PEAR_Registry();

		$installedVersion = $registry->packageInfo($this->name, 'version', $this->channel);
		if (is_null($installedVersion)) {
			$this->log('Package "'.$this->name.'" from "'.$this->channel.'" is required', Project::MSG_ERR);
			return 1;
		}
		if ($this->min && version_compare($installedVersion, $this->min, '<')) {
			$this->log('Package "'.$this->name.'" from "'.$this->channel.'" is '.$installedVersion.'. >= '.$this->min.' is required', Project::MSG_ERR);
			return 1;
		}
		if ($this->max && (version_compare($installedVersion, $this->max, '>'))) {
			$this->log('Package "'.$this->name.'" from "'.$this->channel.'" is '.$installedVersion.'. <= '.$this->max.' is required', Project::MSG_ERR);
			return 1;
		}
		$this->log('Package "'.$this->name.'" '.$installedVersion.' is passed', Project::MSG_VERBOSE);

		return 0;
	}
}
// @codeCoverageIgnoreEnd
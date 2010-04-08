<?php
if (!isset($_SERVER['argv'][1])) {
	echo 'Usage: php scripts/php-minify.php class.list', PHP_EOL;
	die();
}
$rootPath = dirname(__FILE__).'/..';
set_include_path(implode(PATH_SEPARATOR, array(
	realpath($rootPath . '/library'),
	get_include_path()
)));


$loader = new CLoader();
$loader->process($_SERVER['argv'][1]);

class CLoader {
	protected $classes = array();
	protected $outputFile = 'full.php';
	
	public function process($fileName) {
		if (! file_exists($fileName)) {
			die('Error: '.$fileName." do not exists".PHP_EOL);
		}
		
		file_put_contents($this->outputFile, "<?php \n", LOCK_EX);
		
		foreach (file($fileName) as $name){
			$loader->loadClass($name);
		}
	} 

	public function loadClass($name) { 	
		$namePart = explode('_', trim($name));
		if (in_array($name, $this->classes)) {
			return;
		}
		if (in_array($namePart[0], array('Zend', 'System'))) {
			$name = implode('/', $namePart).'.php';
			$fileContents = file_get_contents($name, FILE_USE_INCLUDE_PATH);
			$fileContents = preg_replace("~require_once\(*\s*\'[^\']*\'\\s*\)*\s*;~ui", '', $fileContents);
			$fileContents = str_replace('<?php', '', $fileContents);
			$fileContents = preg_replace("~(/\*([^*]|[\r\n]|(\*+([^*/]|[\r\n])))*\*+/)~ui", '', $fileContents);
			if (preg_match('~implements([^\{]*)~ixmu', $fileContents, $m)) {
				foreach (explode(',',$m[1]) as $subName){
					$this->loadClass($subName);
				}
			}
			if (preg_match('~extends\s*([a-z_]*)~ixmu', $fileContents, $m)) {
				$this->loadClass($m[1]);
			}
			if (!in_array($name, $this->classes)) {
				$this->classes[] = $name;
				file_put_contents($this->outputFile, $fileContents, FILE_APPEND | LOCK_EX); 
			}
			
		}
	}
}
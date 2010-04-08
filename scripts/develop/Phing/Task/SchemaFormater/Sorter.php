<?php
// @codeCoverageIgnoreStart
class SchemaFormater_Sorter
{

	private $schemaFile;

	public function __construct($schemaFile) {
		$this->schemaFile = $schemaFile;
	}

	public function sort() {
		$doc = new DOMDocument;
		$doc->load($this->schemaFile);

		$this->sortRegions($doc);
		$this->sortTables($doc);
		
		$doc->save($this->schemaFile);
	}
	
	private function sortTables($doc) {
	$xpath = new DOMXPath($doc);

		$entriesList = $xpath->query('/DBMODEL/METADATA/TABLES');

		if ($entriesList->length != 1) {
			die('/DBMODEL/METADATA/TABLES return not 1 element');
		}

		$tablesEl = $entriesList->item(0);

		$tables = array();
		$tablesList = $tablesEl->getElementsByTagName('TABLE');
		foreach($tablesList as $tableEl) {
			$tables[$tableEl->getAttribute('Tablename')] = $tableEl;
		}

		foreach($tables as $tableEl) {
			$tablesEl->removeChild($tableEl);
		}
		
		ksort($tables);
		
		foreach($tables as $tableEl) {
			$tablesEl->appendChild($tableEl);
		}
	}

	private function sortRegions($doc) {
		$xpath = new DOMXPath($doc);

		$entriesList = $xpath->query('/DBMODEL/METADATA/REGIONS');

		if ($entriesList->length != 1) {
			die('/DBMODEL/METADATA/REGIONS return not 1 element');
		}

		$regionsEl = $entriesList->item(0);

		$regions = array();
		$regionsList = $regionsEl->getElementsByTagName('REGION');
		foreach($regionsList as $regionEl) {
			$regions[$regionEl->getAttribute('RegionName')] = $regionEl;
		}

		foreach($regions as $regionEl) {
			$regionsEl->removeChild($regionEl);
		}
		
		ksort($regions);
		
		foreach($regions as $regionEl) {
			$regionsEl->appendChild($regionEl);
		}
	}
}
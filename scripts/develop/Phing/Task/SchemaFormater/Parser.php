<?php
// @codeCoverageIgnoreStart
class SchemaFormater_Parser 
{

	private $schemaFile;

	private $formattedSchema;

	private $currentNodeName;
	
	private static $shortTags = array(
			'GLOBALSETTINGS',
			'DATATYPEGROUPS',
			'PARAM',
			'OPTION',
			'COMMON_DATATYPE',
			'TABLEPREFIX',
			'REGIONCOLOR',
			'POSITIONMARKER',
			'OPTIONSELECT',
			'RELATION_START',
			'RELATION_END',
			'INDEXCOLUMN',
			'RELATION',
			'REGION',
		);
	private static $longTags = array(
			'DATATYPEGROUP',
			'PARAMS',
			'OPTIONS',
			'DATATYPE',
			'DATATYPES',
			'COMMON_DATATYPES',
			'TABLEPREFIXES',
			'REGIONCOLORS',
			'POSITIONMARKERS',
			'SETTINGS',
			'REGIONS',
			'OPTIONSELECTED',
			'COLUMN',
			'COLUMNS',
			'RELATIONS_START',
			'RELATIONS_END',
			'INDEXCOLUMNS',
			'INDEX',
			'INDICES',
			'TABLE',
			'TABLES',
			'RELATIONS',
			'NOTES',
			'IMAGES',
			'METADATA',
			'PLUGINDATARECORDS',
			'PLUGINDATA',
			'QUERYRECORDS',
			'QUERYDATA',
			'LINKEDMODELS',
			'DBMODEL',
		);

	public function __construct($schemaFile) {
		$this->schemaFile = $schemaFile;
		$this->formattedSchema = "<?xml version=\"1.0\" standalone=\"yes\"?>\n";
	}

	private function startElement($parser, $elName, $elAttrs) {
		$this->currentNodeName = $elName;
		$this->formattedSchema .= "<".$elName;
		foreach ($elAttrs as $name => $val) {
			if ('StandardInserts' == $name) {
				$val = preg_replace_callback('~^([^"]*)~',array($this, "formatStandardInserts"), $val);
			}
			$this->formattedSchema .= "\n\t".$name."=\"".$val."\"";
		}
		$this->formattedSchema .= " >\n";
	}

	private function endElement($parser, $elName) {
		if ($this->currentNodeName == $elName && in_array($elName, self::$shortTags)) {
			// short tag
			$currElEndPos = strrpos($this->formattedSchema, " >\n");
			$this->formattedSchema = substr($this->formattedSchema, 0, $currElEndPos)." />\n";
		} else {
			// full tag
			$this->formattedSchema .= "</".$elName.">\n";
		}
	}

	private function formatStandardInserts($val) {
		$return = $val[0];
		$return = preg_replace('/(\\\\n\\s*)+\\\\n$/', '\n', $return);
		$return = str_replace('\n', '\n'.PHP_EOL, $return);
		$return = str_replace('\n'.PHP_EOL.' ', '\n'.PHP_EOL, $return);
		return $return;
	}

	public function parse()	{
		$parser = xml_parser_create();
		xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, false);
		xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, 'UTF-8');
		xml_set_element_handler($parser, array($this, 'startElement'), array($this, 'endElement'));
		$fp = fopen($this->schemaFile, 'r');
		while ($data = fgets($fp)) {
			xml_parse($parser, $data);
		}
		fclose($fp);
		xml_parser_free($parser);
		file_put_contents($this->schemaFile, $this->formattedSchema);
	}
}
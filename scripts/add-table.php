<?php
require_once 'common.php';
$path = System_Application::getInstance()->getOption('path');
$modelDir = $path['application'].'/models';

if (!isset($_SERVER['argv'][1])) {
	echo 'Add table and row class scrip
	Usege: add-table %TableName%';
	die("\n");
}

$tableName = $_SERVER['argv'][1];

$tableSource = "<?php
/**
 * ${tableName} table
 */
class Model_Table_${tableName} extends System_Db_Table_Abstract
{
	protected \$_name = '${tableName}';
	protected \$_rowClass = 'Model_Row_${tableName}';
}
";

$rowSource = "<?php
/**
 * ${tableName} row
 */
class Model_Row_${tableName} extends System_Db_Table_Row_Abstract
{
}
";

file_put_contents($modelDir.'/Table/'.$tableName.'.php', $tableSource);
file_put_contents($modelDir.'/Row/'.$tableName.'.php', $rowSource);

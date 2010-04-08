<?php
/**
 * BlogPost row
 */
class Model_Row_BlogPost extends System_Db_Table_Row_Abstract
{
	public function getTags() {
		return explode(', ',$this->tags);
	}
}

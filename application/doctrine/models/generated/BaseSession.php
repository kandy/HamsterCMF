<?php

/**
 * BaseSession
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $id
 * @property integer $modified
 * @property integer $lifetime
 * @property clob $data
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 5441 2009-01-30 22:58:43Z jwage $
 */
abstract class BaseSession extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('session');
        $this->hasColumn('id', 'string', 32, array('type' => 'string', 'primary' => true, 'length' => '32'));
        $this->hasColumn('modified', 'integer', 4, array('type' => 'integer', 'length' => '4'));
        $this->hasColumn('lifetime', 'integer', 4, array('type' => 'integer', 'length' => '4'));
        $this->hasColumn('data', 'clob', null, array('type' => 'clob'));
    }

}
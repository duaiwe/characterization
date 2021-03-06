<?php

/**
 * BaseArchetype
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property integer $health_first
 * @property integer $health_level
 * @property integer $surges
 * @property integer $fort
 * @property integer $ref
 * @property integer $will
 * @property Doctrine_Collection $Characters
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
abstract class BaseArchetype extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('archetype');
        $this->hasColumn('id', 'integer', 8, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'unsigned' => '1',
             'length' => '8',
             ));
        $this->hasColumn('name', 'string', 50, array(
             'type' => 'string',
             'length' => '50',
             ));
        $this->hasColumn('health_first', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('health_level', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('surges', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('fort', 'integer', null, array(
             'type' => 'integer',
             'default' => 0,
             ));
        $this->hasColumn('ref', 'integer', null, array(
             'type' => 'integer',
             'default' => 0,
             ));
        $this->hasColumn('will', 'integer', null, array(
             'type' => 'integer',
             'default' => 0,
             ));

        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
    $this->hasMany('Player as Characters', array(
             'local' => 'id',
             'foreign' => 'archetype_id'));
    }
}
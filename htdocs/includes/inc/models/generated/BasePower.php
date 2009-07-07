<?php

/**
 * BasePower
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property integer $level
 * @property enum $useType
 * @property boolean $used
 * @property integer $player_id
 * @property Player $Player
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 5845 2009-06-09 07:36:57Z jwage $
 */
abstract class BasePower extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('power');
        $this->hasColumn('id', 'integer', 8, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'unsigned' => '1',
             'length' => '8',
             ));
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('level', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('useType', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'at-will',
              1 => 'encounter',
              2 => 'daily',
             ),
             ));
        $this->hasColumn('used', 'boolean', null, array(
             'type' => 'boolean',
             ));
        $this->hasColumn('player_id', 'integer', null, array(
             'type' => 'integer',
             'unsigned' => '1',
             ));

        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        $this->hasOne('Player', array(
             'local' => 'player_id',
             'foreign' => 'id'));
    }
}
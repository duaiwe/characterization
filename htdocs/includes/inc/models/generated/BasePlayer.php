<?php

/**
 * BasePlayer
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property integer $level
 * @property integer $health_max
 * @property integer $health_cur
 * @property integer $surges_max
 * @property integer $surges_cur
 * @property integer $surge_value
 * @property integer $strength
 * @property integer $dexterity
 * @property integer $constitution
 * @property integer $intelligence
 * @property integer $wisdom
 * @property integer $charisma
 * @property integer $race_id
 * @property integer $archetype_id
 * @property Race $Race
 * @property Archetype $Archetype
 * @property Doctrine_Collection $Powers
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 5845 2009-06-09 07:36:57Z jwage $
 */
abstract class BasePlayer extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('player');
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
        $this->hasColumn('level', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('health_max', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('health_cur', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('surges_max', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('surges_cur', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('surge_value', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('strength', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('dexterity', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('constitution', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('intelligence', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('wisdom', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('charisma', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('race_id', 'integer', 8, array(
             'type' => 'integer',
             'unsigned' => '1',
             'length' => '8',
             ));
        $this->hasColumn('archetype_id', 'integer', 8, array(
             'type' => 'integer',
             'unsigned' => '1',
             'length' => '8',
             ));

        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        $this->hasOne('Race', array(
             'local' => 'race_id',
             'foreign' => 'id'));

        $this->hasOne('Archetype', array(
             'local' => 'archetype_id',
             'foreign' => 'id'));

        $this->hasMany('Power as Powers', array(
             'local' => 'id',
             'foreign' => 'player_id'));
    }
}
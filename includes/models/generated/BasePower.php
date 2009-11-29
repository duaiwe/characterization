<?php

/**
 * BasePower
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property integer $level
 * @property enum $use_type
 * @property enum $power_type
 * @property enum $action
 * @property string $power_range
 * @property string $target
 * @property enum $attack_ability
 * @property integer $attack_bonus
 * @property enum $defense
 * @property clob $hit
 * @property clob $miss
 * @property clob $effect
 * @property enum $sustain_action
 * @property clob $sustain
 * @property clob $notes
 * @property boolean $used
 * @property boolean $active
 * @property enum $charge_type
 * @property integer $charges_cur
 * @property integer $charges_max
 * @property integer $player_id
 * @property Player $Player
 * @property Doctrine_Collection $Keywords
 * @property Doctrine_Collection $PowerKeywords
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
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
        $this->hasColumn('use_type', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => '1_atwill',
              1 => '2_encounter',
              2 => '3_daily',
              3 => '4_surge',
             ),
             'default' => '1_atwill',
             ));
        $this->hasColumn('power_type', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'attack',
              1 => 'utility',
              2 => 'racial',
              3 => 'item',
              4 => 'other',
             ),
             'default' => 'attack',
             ));
        $this->hasColumn('action', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'standard',
              1 => 'move',
              2 => 'minor',
              3 => 'free',
              4 => 'reaction',
              5 => 'interrupt',
              6 => 'none',
             ),
             'default' => 'standard',
             ));
        $this->hasColumn('power_range', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('target', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('attack_ability', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'Str',
              1 => 'Dex',
              2 => 'Con',
              3 => 'Int',
              4 => 'Wis',
              5 => 'Cha',
              6 => 'none',
             ),
             'default' => 'none',
             ));
        $this->hasColumn('attack_bonus', 'integer', null, array(
             'type' => 'integer',
             'default' => 0,
             ));
        $this->hasColumn('defense', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'AC',
              1 => 'Fort',
              2 => 'Ref',
              3 => 'Will',
             ),
             'default' => 'AC',
             ));
        $this->hasColumn('hit', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('miss', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('effect', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('sustain_action', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'Standard',
              1 => 'Move',
              2 => 'Minor',
              3 => 'Free',
              4 => 'none',
             ),
             'default' => 'none',
             ));
        $this->hasColumn('sustain', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('notes', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('used', 'boolean', null, array(
             'type' => 'boolean',
             'default' => false,
             ));
        $this->hasColumn('active', 'boolean', null, array(
             'type' => 'boolean',
             'default' => true,
             ));
        $this->hasColumn('charge_type', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'encounter',
              1 => 'daily',
              2 => 'consumable',
              3 => 'none',
             ),
             'default' => 'none',
             ));
        $this->hasColumn('charges_cur', 'integer', null, array(
             'type' => 'integer',
             'default' => 0,
             ));
        $this->hasColumn('charges_max', 'integer', null, array(
             'type' => 'integer',
             'default' => 0,
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
        parent::setUp();
    $this->hasOne('Player', array(
             'local' => 'player_id',
             'foreign' => 'id'));

        $this->hasMany('Keyword as Keywords', array(
             'refClass' => 'PowerKeyword',
             'local' => 'power_id',
             'foreign' => 'keyword_id'));

        $this->hasMany('PowerKeyword as PowerKeywords', array(
             'local' => 'id',
             'foreign' => 'power_id'));
    }
}
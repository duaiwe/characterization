<?php
include('config.master.php');
include('functions.utilities.php');

/**
 * Load & Initialize the Doctrine ORM and it's DB connection.
 */
require('Doctrine/lib/Doctrine.php');
spl_autoload_register(array('Doctrine', 'autoload'));
$manager = Doctrine_Manager::getInstance();
$manager->setAttribute(Doctrine::ATTR_MODEL_LOADING, 
  Doctrine::MODEL_LOADING_CONSERVATIVE);
$manager->setAttribute(Doctrine::ATTR_VALIDATE, Doctrine::VALIDATE_ALL);
$manager->setAttribute(Doctrine::ATTR_EXPORT, Doctrine::EXPORT_ALL);
$manager->setAttribute(Doctrine::ATTR_AUTOLOAD_TABLE_CLASSES, true);
$manager->setAttribute(Doctrine::ATTR_AUTO_ACCESSOR_OVERRIDE, true);
Doctrine::loadModels(dirname(__FILE__).'/models');
$dsn = "{$config['db']['engine']}://".
  "{$config['db']['username']}:{$config['db']['password']}@".
  "{$config['db']['host']}/{$config['db']['database']}";
$conn = Doctrine_Manager::connection($dsn);

/**
 * Set ATTR_COLL_KEY attributes on tables as needed here.
 */
#ex:
#Doctrine::getTable('Address')->setAttribute(Doctrine::ATTR_COLL_KEY,'id');


/**
 * Setup autoloading for non-Doctrine classes.
 */
spl_autoload_register('autoLoad');
?>

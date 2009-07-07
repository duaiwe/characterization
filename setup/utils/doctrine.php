<?php
$dir = dirname(__FILE__).'/../';

// Include your Doctrine configuration/setup here, your connections, models, etc.
$no_db_access = true;
require($dir.'/../htdocs/includes/inc/master.php');

// Configure Doctrine Cli
// Normally these are arguments to the cli tasks but if they are set here the arguments will be auto-filled and are not required for you to enter them.

$config = array('data_fixtures_path'  =>  $dir.'sql/fixtures',
                'models_path'         =>  $dir.'../htdocs/includes/inc/models',
                'migrations_path'     =>  $dir.'sql/migrations',
                'sql_path'            =>  $dir.'sql/fixtures',
                'yaml_schema_path'    =>  $dir.'sql/schema.yml');
$cli = new Doctrine_Cli($config);
$cli->run($_SERVER['argv']);

?>

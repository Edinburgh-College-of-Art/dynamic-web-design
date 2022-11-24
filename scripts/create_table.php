<?php
// Make table for FFF-SimpleExample
$home = '/home/'.get_current_user();
$f3 = require($home.'/AboveWebRoot/fatfree-master/lib/base.php');
$f3->set('AUTOLOAD','autoload/;'.$home.'/AboveWebRoot/autoload/');
$db = DatabaseConnection::connect();
$db->exec("CREATE TABLE IF NOT EXISTS simpleModel (id int NOT NULL AUTO_INCREMENT, name varchar(128),  colour varchar(128), PRIMARY KEY (id))");

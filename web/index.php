<?php
require_once 'config/MysqlDb.php';
/*$conection=new MysqlDb();
$conection->test();*/

spl_autoload_register(function ($class) {
	if (strpos($class, "Controller")) {
		require_once 'controllers/' . $class . '.php';
	}
	if (strpos($class, "Model")) {
		require_once 'models/' . $class . '.php';
	};
});

require 'vendor/autoload.php';

$index = new IndexController;
$index->run();



?>
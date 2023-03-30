<?php
// Require Composer's autoloader.
require '../vendor/autoload.php';
 
// Using Medoo namespace.
use Medoo\Medoo;
 
$bd = new Medoo([
	// [required]
	'type' => 'mysql',
	'host' => 'localhost',
	'database' => 'medoo',
	'username' => 'root',
	'password' => ''
]);
?>
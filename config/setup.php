<?php 

include "database.php";

//echo $DB_DSN . '/' . $DB_USER . '/' . $DB_PASSWORD . PHP_EOL;
try
{
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
	

	$sql = "DROP DATABASE IF EXISTS `" . $DB_NAME . "`;"; 
	$db->exec($sql);
	echo "Removing any pre-existing 'camagru' database\n";

	
	$sql = "CREATE DATABASE IF NOT EXISTS `" . $DB_NAME . "`;"; 
	$db->exec($sql);
	echo "Fresh database 'camagru' successfully created\n";
	
	$db->exec('use ' . $DB_NAME . ';');
	echo "Switching to " . $DB_NAME . "\n";
	
	$sql = file_get_contents('camagru-rendu.sql');
	$db->exec($sql);
	echo "Database schema imported\n";
	echo "OK -> Ready to roll !\n";
}
catch (PDOException $e)
{
	echo 'Error: ' . $e->getMessage() . '\n';
	die();
}

?>

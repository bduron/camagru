<?php 

include "database.php";

echo $DB_DSN . '/' . $DB_USER . '/' . $DB_PASSWORD;
try
{
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
	$sql = "CREATE DATABASE IF NOT EXISTS camagru";
	$db->exec($sql);
	echo "Database 'camagru' successfully created\n";
	
	$sql = file_get_contents('camagru_pma.sql');
	$db->exec($sql);
	echo "Database features extended\n";

	$sql = file_get_contents('camagru.sql');
	$db->exec($sql);
	echo "Database schema imported\n";
	echo "OK\n";
}
catch (PDOException $e)
{
	echo 'Error: ' . $e->getMessage() . '\n';
	die();
}

?>

<?php

namespace app\models;

use pdo;

class post extends \core\model
{

	public static function getall()
	{

		try 
		{
			$db = static::getdb();		

			$stmt = $db->query('select id, title, content from posts order by created_at');
			$results = $stmt->fetchall(pdo::fetch_assoc);
			
			return $results;
		}
		catch (pdoexception $e)
		{
			echo $e->getmessage();
		}
	}



}


?>

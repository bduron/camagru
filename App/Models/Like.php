<?php

namespace App\Models;

use PDO;
use \App\Models\User;

class Like extends \Core\Model
{

	public function __construct($data = [])
	{
		foreach ($data as $key => $value)
			$this->$key = $value;
	}

	
	public static function isLiked($imageId)
	{
		$sql = "SELECT * FROM likes WHERE user_id = :user_id AND image_id = :image_id;"

		$db = static::getDB();
		$stmt = $db->prepare($sql);

		$stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
		$stmt->bindValue(':image_id', $imageId, PDO::PARAM_INT);

		$stmt->execute();

		return (!empty($stmt->fetch()));
	}

	public static function add($imageId)
	{
		$sql = "INSERT INTO likes (user_id, image_id)
				VALUES (:user_id, :image_id)";

		if ($this::isLiked($imageId))
			return false;

		$db = static::getDB();
		$stmt = $db->prepare($sql);

		$stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
		$stmt->bindValue(':image_id', $imageId, PDO::PARAM_INT);

		return $stmt->execute();
	}

	public function remove($imageId)
	{
		$sql = "DELETE FROM likes WHERE image_id = :image_id AND user_id = :user_id;";

		$db = static::getDB();
		$stmt = $db->prepare($sql);

		$stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
		$stmt->bindValue(':image_id', $image_id, PDO::PARAM_STR);
		return $stmt->execute();
	}

	public static function getAllLikes()
	{
		$sql = "SELECT * FROM likes";
		$likes = [];
		
		$db = static::getDB();
		$stmt = $db->prepare($sql);
		$stmt->execute();
		$likes_raw = $stmt->fetchAll(); 

		/* Count likes for each image */
		forEach ($likes_raw as $like) 
		{
			if (!ISSET($likes[$like['image_id']]))
				$likes[$like['image_id']] = 1; 		
			else 
				$likes[$like['image_id']] += 1; 		
		}

		return $likes;	

	}
	
	public static function getUserLikes()
	{
		$user_id = $_SESSION['user_id'];
		$sql = "SELECT * FROM likes WHERE ";
		$likes = [];
		
		$db = static::getDB();
		$stmt = $db->prepare($sql);
		$stmt->execute();
		$likes_raw = $stmt->fetchAll(); 

		/* Count likes for each image */
		forEach ($likes_raw as $like) 
		{
			if (!ISSET($likes[$like['image_id']]))
				$likes[$like['image_id']] = 1; 		
			else 
				$likes[$like['image_id']] += 1; 		
		}

		return $likes;	
	}
}
?>

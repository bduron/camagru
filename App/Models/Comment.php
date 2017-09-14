<?php

namespace App\Models;

use PDO;
use \App\Mail;

class Comment extends \Core\Model
{


	public function __construct($data = [])
	{
		foreach ($data as $key => $value)
			$this->$key = $value;
	}

	public function save()
	{
		print_r($this);

		$sql = "INSERT INTO comments (user_id, img_id, created_at, comment)
				VALUES (:user_id, :img_id, :created_at, :comment)";

		$db = static::getDB();
		$stmt = $db->prepare($sql);

		$stmt->bindValue(':user_id', $this->user_id, PDO::PARAM_INT);
		$stmt->bindValue(':img_id', $this->image_id, PDO::PARAM_INT);
		$stmt->bindValue(':created_at', date('Y-m-d H:i:s', time()), PDO::PARAM_STR);
		$stmt->bindValue(':comment', $this->comment, PDO::PARAM_STR);

		return $stmt->execute();
	}

	public function getComments($image_id)
	{
		$sql = "SELECT comment FROM comments WHERE img_id = :image_id"; 

		$db = static::getDB();
		$stmt = $db->prepare($sql);

		$stmt->bindValue(':image_id', $image_id, PDO::PARAM_STR);
		$stmt->execute();

		return $stmt->fetchAll();
	}
}
?>

<?php

namespace App\Models;

use PDO;
use \App\Mail;
use \App\Models\Image;
use \App\Models\User;

class Comment extends \Core\Model
{


	public function __construct($data = [])
	{
		foreach ($data as $key => $value)
			$this->$key = $value;
	}

	public function save()
	{
		$sql = "INSERT INTO comments (user_id, img_id, created_at, comment)
				VALUES (:user_id, :img_id, :created_at, :comment)";

		$db = static::getDB();
		$stmt = $db->prepare($sql);

		$stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
		$stmt->bindValue(':img_id', $this->image_id, PDO::PARAM_INT);
		$stmt->bindValue(':created_at', date('Y-m-d H:i:s', time()), PDO::PARAM_STR);
		$stmt->bindValue(':comment', $this->comment, PDO::PARAM_STR);

		return $stmt->execute();
	}

	public function getComments($image_id)
	{
		$sql = "SELECT comments.comment, users.name, comments.created_at
				FROM comments INNER JOIN users ON comments.user_id = users.id 
				WHERE img_id = :image_id 
				ORDER BY comments.created_at ASC"; 

		$db = static::getDB();
		$stmt = $db->prepare($sql);

		$stmt->bindValue(':image_id', $image_id, PDO::PARAM_STR);
		$stmt->execute();

		return $stmt->fetchAll();
	}

	public function sendNotificationEmail()
	{	
		$imageOwnerId = Image::getOwnerId($this->image_id)[0];
		$owner = User::findById($imageOwnerId);
		$sender = User::findById($_SESSION['user_id']);
		
		$url = 'http://' . $_SERVER['HTTP_HOST'] . '/login';
		$html = "Congratulation you just received a new comment on your photo! <br> <br>
				 <b>" . $this->comment . "</b> - " . $sender->name . " <br> <br>
				 Please <a href=\"$url\">login</a> to respond.";
	
		if ($imageOwnerId != $sender->id)
			Mail::send($owner->email, 'Camagru - New comment on your photo', $html);
	}
}
?>

<?php  

namespace App\Controllers;

use \App\Models\Comment;
use \App\Models\Image;
use \App\Models\User;
use \App\Auth;

class Comments extends Authenticated
{

	public function addAction()
	{
		$comment = new Comment($_POST);
		if ($comment->save())
			$this->notify($comment);
	}

	private function notify(Comment $comment) 
	{
		$imageOwnerId = Image::getOwnerId($_POST['image_id'])[0];
		$owner = User::findById($imageOwnerId);
		
		echo 'Notif preference status :' . $owner->notifications;

		if ($owner->notifications)
			$comment->sendNotificationEmail();
	}

}
?>

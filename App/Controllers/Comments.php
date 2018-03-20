<?php  

namespace App\Controllers;

use \App\Models\Comment;

class Comments extends Authenticated
{

	public function addAction()
	{
		$comment = new Comment($_POST);
		if ($comment->save())
			$comment->sendNotificationEmail();
	}

}
?>

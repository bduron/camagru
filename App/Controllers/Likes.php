<?php  

namespace App\Controllers;

use \App\Models\Like;

class Likes extends Authenticated
{

	public function addAction()
	{
		Like::add($_POST['image_id']);
	}

	public function removeAction()
	{
		Like::remove($_POST['image_id']);
	}

}
?>

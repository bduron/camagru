<?php

namespace App\Controllers;

use \Core\View;
use \App\Auth;
use \App\Models\User;
use \App\Models\Image;
use \App\Models\Comment;

class Home extends \Core\Controller
{
	
	public function indexAction()
	{
		View::render('Home/index.php', ['user' => Auth::getUser(), 
										'photos' => Image::getAllPhotos(),
										'comments' => new Comment() ]);

	}

	public function saveAction()
	{
		$comment = new Comment($_POST);
		$comment->save();
	}


	protected function before()
	{
		return true;
	}

	protected function after()
	{
		return true;
	}

}


?>

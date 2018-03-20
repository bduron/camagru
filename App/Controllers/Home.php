<?php

namespace App\Controllers;

use \Core\View;
use \App\Auth;
use \App\Models\User;
use \App\Models\Image;
use \App\Models\Comment;
use \App\Models\Like;

class Home extends \Core\Controller
{
	
	public function indexAction()
	{
		Like::getAllLikes();
		View::render('Home/index.php', ['user' => Auth::getUser(), 
										'photos' => Image::getAllPhotos(),
										'comments' => new Comment() ]);
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

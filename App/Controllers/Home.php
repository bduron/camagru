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
		echo '<pre>';
		print_r(Like::getAllLikes());
		echo '</pre>';
		View::render('Home/index.php', [
			'user' => Auth::getUser(), 
			'photos' => Image::getAllPhotos(),
			'comments' => new Comment() ,
			'allLikes' => Like::getAllLikes(),
			'userLikes' => Like::getUserLikes() 
		]);
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

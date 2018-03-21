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
		View::render('Home/index.php', [
			'user' => Auth::getUser(), 
			'photos' => Image::getAllPhotos(),
			'comments' => new Comment() ,
			'allLikes' => Like::getAllLikes(),
			'userLikes' => Auth::isLoggedIn() ? Like::getUserLikes() : [] 
		]);
	}


	public function getPhotosAction()
	{
		View::render('Partials/photo.php', [
			'user' => Auth::getUser(), 
			'photos' => Image::getFivePhotos($_GET['last_id']),
			'comments' => new Comment() ,
			'allLikes' => Like::getAllLikes(),
			'userLikes' => Auth::isLoggedIn() ? Like::getUserLikes() : [] 
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

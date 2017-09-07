<?php  

namespace App\Controllers;

use \Core\View;
use \App\Models\Image;

class Montage extends Authenticated
{

	public function indexAction()
	{
		//$posts = Post::getAll();
		// get all users pictures 
		// get all filters 
		//
		$curdir = getcwd() . '/public/img/';	
		$filters = glob($curdir . "*.png");
		View::render('Montage/montage.php', ['filters' => $filters]);
	}

	public function uploadAction()
	{
		echo "<p>File uploaded on server</p>";
		var_dump($_FILES);
		var_dump($_POST);

		Image::savePhoto();
	}


}
?>

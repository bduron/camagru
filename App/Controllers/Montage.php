<?php  

namespace App\Controllers;

use \Core\View;
use \App\Models\Image;
use \App\Auth;

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
		View::render('Montage/montage.php', ['filters' => $filters, 'gallery_photos' => Image::getUserPhotos()]);
	}

	public function uploadAction()
	{
		//echo "<p>File uploaded on server</p>";
		//var_dump($_FILES);
		//var_dump($_POST);

		Image::savePhoto();
		echo 'uploads/' . basename($_FILES['photo']['tmp_name']);
	}

	public function deleteAction()
	{
		var_dump($_POST);

		echo $_POST['src'];
		$id = Image::getIdFromName($_POST['src']);
		print_r($id);
			
		if (Image::isUserPhoto($id['id']))
		{
			Image::deletePhoto($id['id']);
			unlink(getcwd() . '/uploads/' . $_POST['src']);
		}
	}


}
?>

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
		$id = Image::getIdFromName(basename($_POST['src']));
		echo $id;
			
		if (Image::isUserPhoto($id))
		{
			Image::deletePhoto($id);
			unlink(getcwd() . $_POST['src']);
		}
	}


}
?>

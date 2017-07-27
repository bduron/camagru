<?php  

namespace App\Controllers;

use \Core\View;
//use \App\Models\User;

class Montage extends Authenticated
{
	
	public function indexAction()
	{
		//$posts = Post::getAll();
		// get all users pictures 
		// get all filters 
		//
		View::render('Montage/montage.php');
	}



}


?>

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
		$curdir = getcwd() . '/public/img/';	
		$filters = glob($curdir . "*.png");
		View::render('Montage/montage.php', ['filters' => $filters]);
	}

	public function uploadAction()
	{
		echo "<p>File uploaded on server</p>";
		var_dump($_FILES);
		var_dump($_POST);

		$this->saveRawPhoto();
	}

	private function saveRawPhoto()
	{
		define("UPLOAD_DIR", getcwd() . "/uploads/");

		if (!empty($_FILES["photo"]))
		{
			$photo = $_FILES["photo"];

			if ($photo["error"] !== UPLOAD_ERR_OK)
			{
				echo "<p>An error occurred.</p>";
				exit;
			}

			// ensure a safe filename
			$name = preg_replace("/[^A-Z0-9._-]/i", "_", $photo["name"]);

			// don't overwrite an existing file
			$i = 0;
			$parts = pathinfo($name);
			while (file_exists(UPLOAD_DIR . $name))
			{
				$i++;
				$name = $parts["filename"] . "-" . $i . "." . $parts["extension"];
			}

			// preserve file from temporary directory
			$success = move_uploaded_file($photo["tmp_name"], UPLOAD_DIR . $name);
			if (!$success) 
			{ 
				echo "<p>Unable to save file.</p>";
				exit;
			}

			// set proper permissions on the new file
			chmod(UPLOAD_DIR . $name, 0644);
		}
	}

}
?>

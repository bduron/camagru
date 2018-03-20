<?php  

namespace App\Models;

use \App\Auth;
use PDO;

class Image extends \Core\Model
{
	public static function savePhoto()
	{
		self::saveRawPhoto();
		self::addFilter();

		$user = Auth::getUser();	
		
		//Save in BDD 

		$sql = "INSERT INTO images (src, user_id, created_at)
				VALUES (:src, :user_id, :created_at)";

		$db = static::getDB();
		$stmt = $db->prepare($sql);

		$stmt->bindValue(':src', basename($_FILES['photo']['tmp_name']), PDO::PARAM_STR);
		$stmt->bindValue(':user_id', $user->id, PDO::PARAM_INT);
		$stmt->bindValue(':created_at', date('Y-m-d H:i:s', time()), PDO::PARAM_STR);

		return $stmt->execute();
		

		//Instanciate the object to get access to montage_src property 
		//use the constructor 	
	}

	private static function saveRawPhoto()
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
			$parts = pathinfo($name);
			while (file_exists(UPLOAD_DIR . $name))
			{
				$name = $parts["filename"] . "-" . uniqid() . "." . $parts["extension"];
			}
			$_FILES['photo']['tmp_name'] = UPLOAD_DIR . $name;

			// preserve file from temporary directory
			$success = move_uploaded_file($photo["tmp_name"], UPLOAD_DIR . $name);
			if (!$success) 
			{ 
				echo "<p>Unable to save file.</p>";
				exit;
			}

			// set proper permissions on the new file
			chmod(UPLOAD_DIR . $name, 0644);

			// Save new photo Path
			$_FILES['photo']['tmp_name'] = UPLOAD_DIR . $name;

		}
	}

	private static function addFilter()
	{
		define("FILTER_DIR", getcwd() . "/public/img/");

		// Load the filter and the photo to apply the watermark to
		$filter = imagecreatefrompng(FILTER_DIR . $_POST['filter_id']);
		$im = imagecreatefrompng($_FILES['photo']['tmp_name']);

		$filter = imagescale($filter, 140);	
		imagealphablending($filter, false);
		imagesavealpha($filter, true);
		$filter = imagerotate($filter, -15, imageColorAllocateAlpha($filter, 0, 0, 0, 127));
		imagealphablending($filter, false);
		imagesavealpha($filter, true);
		imageflip($im, IMG_FLIP_HORIZONTAL);

		// Set the margins for the filter and get the height/width of the filter image
		$marge_right = 100;
		$marge_bottom = 85;
		$sx = imagesx($filter);
		$sy = imagesy($filter);

		// Copy the filter image onto our photo using the margin offsets and the photo 
		// width to calculate positioning of the filter. 
		imagecopy($im, $filter, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($filter), imagesy($filter));

		// Output and free memory
		//header('Content-type: image/png');
		imagepng($im, $_FILES['photo']['tmp_name']);
		//imagedestroy($im);	
			
	}
			
	public static function getUserPhotos()
	{
		$user = Auth::getUser();
	
		$sql = "SELECT src, id FROM images WHERE user_id= :user_id ORDER BY created_at ASC;";
		$db = static::getDB();

		$stmt = $db->prepare($sql);
		$stmt->bindvalue(':user_id', $user->id, PDO::PARAM_INT);
		$stmt->execute();	

		return $stmt->fetchAll();	
	}

	public static function getAllPhotos()
	{
		$sql = "SELECT images.*, users.name FROM images INNER JOIN users ON images.user_id = users.id ORDER BY created_at DESC;";
		$db = static::getDB();

		$stmt = $db->prepare($sql);
		$stmt->execute();	

		return $stmt->fetchAll();	
	}
	
	public static function getIdFromName($name)
	{
		$sql = "SELECT id FROM images WHERE src = :name;";
		$db = static::getDB();

		$stmt = $db->prepare($sql);
		$stmt->bindvalue(':name', $name, PDO::PARAM_STR); 
		$stmt->execute();	

		return $stmt->fetch();	
	}

	public static function isUserPhoto($id)
	{
		$user = Auth::getUser();

		$sql = "SELECT * FROM images WHERE user_id = :user_id AND id = :id;";
		$db = static::getDB();

		$stmt = $db->prepare($sql);
		$stmt->bindvalue(':user_id', $user->id, PDO::PARAM_INT);
		$stmt->bindvalue(':id', $id, PDO::PARAM_INT);
		$stmt->execute();	

		return (!empty($stmt->fetch()));
	}

	public static function deletePhoto($id)
	{
		$sql = "DELETE from images WHERE id = :id;";
		$db = static::getDB();

		$stmt = $db->prepare($sql);
		$stmt->bindvalue(':id', $id, PDO::PARAM_INT);
		$stmt->execute();	
	}

	public static function getOwnerId($imageId)
	{
		$sql = "SELECT user_id FROM images WHERE id = :image_id;";
		$db = static::getDB();

		$stmt = $db->prepare($sql);
		$stmt->bindvalue(':image_id', $imageId, PDO::PARAM_STR); 
		$stmt->execute();	

		return $stmt->fetch();	
	}

}


?>

<?php  

namespace App\Models;

use PDO;

class Image extends \Core\Model
{
	public static function savePhoto()
	{
		self::saveRawPhoto();
		self::addFilter();
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
			$i = 0;
			$parts = pathinfo($name);
			while (file_exists(UPLOAD_DIR . $name))
			{
				$i++;
				$name = $parts["filename"] . "-" . $i . "." . $parts["extension"];
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
		imagepng($im, getcwd() . "/uploads/montage.png");
		//imagedestroy($im);	
			
	}
			


}


?>

<?php  

namespace App;


class Mail
{
	public static function send($to, $subject, $html)
	{
		$headers = 'From: bduron@student.42.fr' . "\r\n";
		$headers .= 'Reply-To: bduron@student.42.fr' . "\r\n";
		$headers .= 'X-Mailer: PHP/' . phpversion() . "\r\n";
 		$headers .= 'MIME-Version: 1.0' . "\r\n";
     	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		mail($to, $subject, $html, $headers);
	}

}


?>

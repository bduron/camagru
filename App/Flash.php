<?php  

namespace App;

class Flash
{
	const SUCCESS = 'success';	
	const INFO = 'info';	
	const WARNING = 'warning';	

	public static function addMessage($message, $type = 'success') 
	{
		if (!isset($_SESSION['flash_notifications']))
			$_SESSION['flash_notifications'] = []; 
	
		$_SESSION['flash_notifications'][] = ['message' => $message, 'type' => $type];
	}
	
	public static function getMessage()
	{
		if (isset($_SESSION['flash_notifications']))
		{		
			$messages = $_SESSION['flash_notifications']; 
			unset($_SESSION['flash_notifications']);
			return $messages;
		}
	}


}


?>

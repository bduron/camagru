<?php  

namespace App\Controllers;

use \Core\View;
use \App\Models\User;

class Password extends \Core\Controller  
{

	public function forgotAction()
	{
		View::render('Password/forgot.php');
	}

	public function requestResetAction()
	{
		User::sendPasswordReset($_POST['email']);
		echo 'Mail sent !';
		View::render('Password/password_requested.php');
	}


}


?>

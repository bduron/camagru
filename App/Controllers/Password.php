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

	protected function getUserOrExit($token)
	{
		$user = User::findByPasswordReset($token);

		if ($user)
			return $user;
		else 
		{
			View::render('Password/token_expired.php');
			exit();
		}
	}	

	public function resetAction()
	{
		$token = $this->route_params['token'];	
		$user = $this->getUserOrExit($token);		
		View::render('Password/reset.php', ['token' => $token]);
	}

	public function resetPasswordAction()
	{
		$token = $_POST['token'];
		$user = $this->getUserOrExit($token);		
		if ($user->resetPassword($_POST['password'], $_POST['password_confirm']))
			View::render('Password/reset_success.php');
		else 
			View::render('Password/reset.php', ['token' => $token, 'user' => $user]);
	}

}


?>

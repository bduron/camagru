<?php  

namespace App\Controllers;

use \Core\View;
use \App\Auth;
use \App\Flash;
use \App\Models\User;

class Profile extends Authenticated
{

	public function indexAction()
	{
		View::render('Profile/index.php', ['user' => Auth::getUser()]);
	}

	public function updateNotificationsAction()
	{
		$user = Auth::getUser();

		if ($user->updateNotifications($_POST['notifications']))
		{
			Flash::addMessage('Notifications preferences updated successfully');	
			$this->redirect('/profile');
		}
		else 
		{
			foreach ($user->errors as $error)
				Flash::addMessage($error, 'warning');	
			View::render('Profile/index.php', ['user' => $user]);
		}
	}

	public function updateProfileAction()
	{
		$user = Auth::getUser();

		if ($user->updateProfile($_POST))
		{
			Flash::addMessage('Profile update successful');	
			$this->redirect('/profile');
		}
		else 
		{
			foreach ($user->errors as $error)
				Flash::addMessage($error, 'warning');	
			View::render('Profile/index.php', ['user' => $user]);
		}
	}

	public function updatePassword()
	{
		$user = Auth::getUser();

		if ($user->updatePassword($_POST))
		{
			Flash::addMessage('Password update successful');	
			$this->redirect('/profile');
		}
		else 
		{
			foreach ($user->errors as $error)
				Flash::addMessage($error, 'warning');	
			View::render('Profile/index.php', ['user' => $user]);
		}
	}
}
?>

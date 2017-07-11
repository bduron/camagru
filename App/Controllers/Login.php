<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;
use \App\Auth;

class Login extends \Core\Controller
{
	
	public function newAction()
	{
		View::render('Login/new.php');
	}

	public function createAction()
	{
		$user = User::authenticate($_POST['name'], $_POST['password']);

		if ($user)
		{		
			Auth::login($user);
			$this->redirect(Auth::getReturnToPage());
		}
		else 
			View::render('Login/new.php', ['name' => $_POST['name']]);
	}

	public function destroyAction()
	{
		Auth::logout();
		$this->redirect('/');
	}

	protected function before()
	{
		return true;
	}

	protected function after()
	{
		return true;
	}

}


?>

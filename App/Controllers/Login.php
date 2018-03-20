<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;
use \App\Auth;
use \App\Flash;

class Login extends \Core\Controller
{
	
	public function newAction()
	{
		View::render('Login/new.php');
	}

	public function createAction()
	{
		
		$user = User::authenticate($_POST['name'], $_POST['password']);
		$remember_me = (isset($_POST['remember_me'])) ? "checked=\"checked\"" : "";
		
		if ($user)
		{		
			Auth::login($user, $remember_me);
			Flash::addMessage('Login successful');	
		echo 'ok';
			$this->redirect(Auth::getReturnToPage());
		}
		else 
		{
			Flash::addMessage('Your username or password is invalid', Flash::WARNING);	
			View::render('Login/new.php', 
				['name' => $_POST['name'], 'remember_me' => $remember_me]);
		}
	}

	public function destroyAction()
	{
		Auth::logout();
		$this->redirect('/login/show-loggout-message');
	}

	public function showLoggoutMessageAction()
	{
		Flash::addMessage('You\'re now logged out', Flash::INFO);	
		$this->redirect('/');
	}

//	public function sendmailAction()
//	{	
//	   	$to      = 'news.benjamin@gmail.com';
//		$subject = 'le sujet';
//		$message = '<h1>Bonjour !</h1><p>Un paragraphe</p>';
//		\App\Mail::send($to, $subject, $message);
//		echo 'Mail sent';
//	}


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

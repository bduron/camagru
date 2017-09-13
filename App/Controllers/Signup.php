<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;

class Signup extends \Core\Controller
{
	
	public function newAction()
	{
		View::render('Signup/new.php');
	}

	public function createAction()
	{
		$user = new User($_POST);
		if ($user->save())
		{
			// echo "<script>alert(". print_r($user) .");</script>";
			$user->sendActivationEmail();
			$this->redirect('/signup/success');
		}
		else 
			View::render('Signup/new.php', ['user' => $user]);
	}

	public function successAction()
	{
		View::render('Signup/success.php');
	}

	public function activateAction()
	{
		User::activate($this->route_params['token']);
		$this->redirect('/signup/activated');
	}

	public function activatedAction()
	{
		View::render('Signup/activated.php');
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

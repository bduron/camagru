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

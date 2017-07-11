<?php

namespace App\Controllers;

use \Core\View;
use \App\Auth;
use \App\Models\User;

class Home extends \Core\Controller
{
	
	public function indexAction()
	{
		View::render('Home/index.php', ['user' => Auth::getUser()]);
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

<?php

namespace App\Controllers;

use \Core\View;
use \App\Auth;

class Home extends \Core\Controller
{
	
	public function indexAction()
	{
		View::render('Home/index.php');
	}

	public function testAction()
	{
		if (!Auth::isLoggedIn()) 	
		{
			Auth::rememberRequestedPage();
			$this->redirect('/login');
		}

		echo '<p>Restricted area</p>';
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

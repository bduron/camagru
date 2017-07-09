<?php

namespace App\Controllers;

use \Core\View;

class Home extends \Core\Controller
{
	
	public function indexAction()
	{
		View::render('Home/index.php', ['name' => 'Ben', 'colours' => ['red', 'green', 'blue']]);
	}

	protected function before()
	{
		echo '(before) ';
		return true;
	}

	protected function after()
	{
		echo ' (after)';
		return true;
	}

}


?>

<?php

namespace App\Controllers;

class Home extends \Core\Controller
{
	
	public function indexAction()
	{
		echo 'Hello from the index function in the Home Class <br>';
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

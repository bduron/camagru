<?php

namespace App\Controllers;

class Posts extends \Core\Controller
{
	
	public function addNewAction()
	{
		echo 'Hello from the addNew function in the Posts Class <br>';
	}
	
	public function indexAction()
	{
		echo 'Hello from the index function in the Posts Class <br>';
	}

	public function editAction()
	{
		echo 'Hello from the edit action in the Post Controller';
		echo '<p>Route parameters <pre>' . 
			htmlspecialchars(print_r($this->route_params, true)) . '</pre></p>';
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

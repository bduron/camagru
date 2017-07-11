<?php

namespace App\Controllers\Admin;

class Users extends \Core\Controller
{
	public function indexAction()
	{
		echo 'User Admin index';
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

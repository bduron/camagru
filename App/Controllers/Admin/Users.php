<?php

namespace App\Controllers\Admin;

class Users extends \Core\Controller
{
	protected function before()
	{
		return true;
	}

	protected function after()
	{}

	public function indexAction()
	{
		echo 'User Admin index';
	}


}	


?>

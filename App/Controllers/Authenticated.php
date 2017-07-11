<?php 

namespace App\Controllers;

use Core\View;

abstract class Authenticated extends \Core\Controller
{
	protected function before()
	{
		$this->requireLogin();		
	}	
}


?>

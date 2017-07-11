<?php

namespace App\Controllers;

use \Core\View;

class Test extends Authenticated
{

	public function indexAction()
	{
		print_r($_SERVER);
	}
}

?>

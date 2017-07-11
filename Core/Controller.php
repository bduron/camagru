<?php

namespace Core;

use \App\Auth;

abstract class Controller
{
	protected $route_params = [];

	public function __construct($route_params)
	{
		$this->route_params = $route_params;
	}

	public function __call($name, $args)
	{
		$method = $name . 'Action';
		if (method_exists($this, $method))
		{
			if ($this->before())
			{
				call_user_func_array([$this, $method], $args);
				$this->after();
			} 			
		}
		else 
			throw new \Exception('Method ' . $method . ' not found in controller ' . get_class($this));
			
	}

	public function redirect($url)
	{
		header('Location : http://' . $_SERVER['HTTP_HOST'] . $url, true, 303);
		exit();	
	}		

	protected function before()
	{
	}

	protected function after()
	{
	}

	
}


?>

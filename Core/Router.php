<?php

namespace Core;

class Router
{
	protected $routes = [];
	protected $params = [];


 	public function add($route, $params = [])
    {
        $route = preg_replace('/\//', '\\/', $route);
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);
		$route = preg_replace('/\{([a-z]+)\:([^\}]+)\}/', '(?P<\1>\2)', $route);
        $route = '/^' . $route . '$/i';
        $this->routes[$route] = $params;
    }	

	public function match($url)
	{
		foreach ($this->routes as $route => $params)		
		{
			if (preg_match($route, $url, $matches))
			{		
				foreach ($matches as $key => $match)
					if (is_string($key))
						$params[$key] = $match;
				$this->params = $params;
				return true;
			}
		}
		return false;
	}

	public function dispatch($url)
	{
		$url = $this->removeQueryStringVars($url);

		if ($this->match($url))
		{
			$controller = $this->params['controller'];
			$controller = $this->toStudlyCaps($controller);			
			$controller = "App\Controllers\\$controller";

			if (class_exists($controller))
			{
				$action = $this->params['action'];
				$action = $this->toCamelCase($action);					
				$controller_obj = new $controller($this->params);
				
				if (is_callable([$controller_obj, $action]))
					$controller_obj->$action(); 
				else
					echo 'No ' . $action . ' method found in ' . $controller . '<br>';
			}
			else 
				echo 'No ' . $controller . ' class found<br>';
		}
		else 
			echo 'No route found for ' . $url . '<br>';
	}
	
	protected function removeQueryStringVars($url)
	{
		if ($url != '')
		{
			$parts = explode('&', $url, 2);
			if (strpos($parts[0], '=') === false)
				$url = $parts[0];
			else
				$url = '';	
		} 
		return $url;
	}
	
	public function toStudlyCaps($str)
	{
		return str_replace('-', '', ucwords($str, "-"));
	}	

	public function toCamelCase($str)
	{
		return lcfirst($this->toStudlyCaps($str));
	}	

	public function getRoutes()
	{
		return $this->routes;
	}

	public function getParams()
	{
		return $this->params;
	}
}


?>

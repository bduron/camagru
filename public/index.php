<?php

/* ERROR LOG */
error_reporting(E_ALL);
ini_set('display_errors', 1);

/**
 *
 * Front controller
 *
 */

//require '../App/Controllers/Posts.php';
//require '../Core/Router.php';

/* Autoloader */
spl_autoload_register(function ($class) 
{
	$root = dirname(__DIR__);
	$file = $root . '/' . str_replace('\\', '/', $class) . '.php';
	if (is_readable($file))
		require $file;
});



$router = new Core\Router();

$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('posts', ['controller' => 'Posts', 'action' => 'index']);
//$router->add('posts/new', ['controller' => 'Posts', 'action' => 'new']);
$router->add('{controller}/{action}');
$router->add('{controller}/{id:\d+}/{action}');
$router->add('admin/{controller}/{action}');


/* DISPLAY ROUTES */
echo '<pre>';
echo htmlspecialchars(print_r($router->getRoutes(), true));
echo '</pre>';


// Match the requested route
$url = $_SERVER['QUERY_STRING'];
$router->dispatch($url);

?>

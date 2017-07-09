<?php

/**
 *
 * Front controller
 *
 */

/* Debbug flags - Error logs */
ini_set('display_errors', 1);

require '../Core/utils.php';

/* Autoloader */
spl_autoload_register(function ($class) 
{
	$root = dirname(__DIR__);
	$file = $root . '/' . str_replace('\\', '/', $class) . '.php';
	if (is_readable($file))
		require $file;
});

/* Error handling */
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');


$router = new Core\Router();

$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('{controller}/{action}');
$router->add('{controller}/{id:\d+}/{action}');
$router->add('admin/{controller}/{action}', ['namespace' => 'Admin']);


/* DISPLAY ROUTES */
//echo '<pre>';
//echo htmlspecialchars(print_r($router->getRoutes(), true));
//echo '</pre>';


/* Match the requested route */
$url = $_SERVER['QUERY_STRING'];
$router->dispatch($url);

?>

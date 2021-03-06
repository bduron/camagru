<?php

/**
 *
 * Front controller
 *
 */

/* Debbug flags - Error logs */
ini_set('display_errors', 1);

require 'Core/utils.php';

/* Autoloader */
spl_autoload_register(function ($class) 
{
	$root = __DIR__;
	$file = $root . '/' . str_replace('\\', '/', $class) . '.php';
	if (is_readable($file))
		require $file;
});

/* Error handling */
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

/* Sessions */
session_start();
date_default_timezone_set('Europe/Paris');

$router = new Core\Router();

$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('{controller}/{action}');
$router->add('profile', ['controller' => 'Profile', 'action' => 'index']);
$router->add('login', ['controller' => 'Login', 'action' => 'new']);
$router->add('logout', ['controller' => 'Login', 'action' => 'destroy']);
$router->add('password/reset/{token:[a-f0-9]+}', ['controller' => 'Password', 'action' => 'reset']);
$router->add('signup/activate/{token:[a-f0-9]+}', ['controller' => 'Signup', 'action' => 'activate']);
$router->add('montage', ['controller' => 'Montage', 'action' => 'index']);

//$router->add('admin/{controller}/{action}', ['namespace' => 'Admin']);


/* Match the requested route */
$url = $_SERVER['QUERY_STRING'];
$router->dispatch($url);

?>

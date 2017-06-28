<?php

/**
 *
 * Front controller
 *
 */

require '../Core/Router.php';

$router = new Router();

echo 'Requested URL : "' .$_SERVER['PATH_INFO'] . '"' . PHP_EOL;

echo get_class($router) . PHP_EOL;

?>

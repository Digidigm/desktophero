<?php
date_default_timezone_set('America/New_York');
/**
 * Step 2: Instantiate a Slim application
 *
 * This example instantiates a Slim application using
 * its default settings. However, you will usually configure
 * your Slim application now by passing an associative array
 * of setting names and values into the application constructor.
 */
define('BASE_PATH',dirname(__FILE__) . '/');
//get the application config
$config = new \Softpath\Config(BASE_PATH . "../config/environments.json");
//create a database connection

$db_conx= new \Softpath\DatabaseConnection($config->database);
$pdo = $db_conx->getPDO();

$app = new \Slim\Slim(
    array(
        'templates.path' => BASE_PATH . "/views"
    )
);


$session_settings = array(
    'expires' => $config->session_expires,
    'secret'  => $config->salt,
    'name'    => 'CHANGE ME'
);
$session = \Softpath\Session::getInstance($pdo,$session_settings);
$app->add($session);

require 'hooks/before.php';
require 'hooks/before.dispatch.php';
require 'routes/web.php';
require 'routes/api.php';
/**
 * Step 4: Run the Slim application
 *
 * This method should be called last. This executes the Slim application
 * and returns the HTTP response to the HTTP client.
**/
$app->run();

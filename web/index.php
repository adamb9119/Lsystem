<?php

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
//error_reporting(E_ALL);

require_once __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/Application.php';

$app = new Application(array('config' => __DIR__ . '/../app/configs/application.php'));

// enable debug mode
$app['debug'] = true;

$app->run();
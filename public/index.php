<?php
ini_set('display_errors','on');
error_reporting(E_ALL);
$t = microtime(true);
define('APP_GENERAL_DIRNAME', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'core');
define('JUNGLE_DIRNAME', APP_GENERAL_DIRNAME . DIRECTORY_SEPARATOR . 'Jungle'.DIRECTORY_SEPARATOR . 'Jungle');
define('APP_DIRNAME', APP_GENERAL_DIRNAME . DIRECTORY_SEPARATOR . 'App');

/**
 * Include loader file
 */
include JUNGLE_DIRNAME . DIRECTORY_SEPARATOR . 'Loader.php';

/**
 * Loader registers
 */
$loader = \Jungle\Loader::getDefault();
$loader->registerNamespaces([
	'Jungle' => JUNGLE_DIRNAME,
	'App' => APP_DIRNAME
]);
$loader->register();



/**
 * Application instantiate
 */
$app = new \App\Application($loader);
$response = $app->handle(\Jungle\Http\Request::getInstance());
$response->send();
exit();

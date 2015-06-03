<?php

date_default_timezone_set('America/New_York');
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once __DIR__.'/vendor/autoload.php';

$app = new Silex\Application();
$app['debug'] = true;

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver'   => 'pdo_pgsql',
        'dbname'   => 'postgres',
        'user'     => 'postgres',
        'password' => '',
    ),
));

$app->get('/client', function () use ($app) {
	$sql = "SELECT * FROM clients ORDER BY name";
	$clients = $app['db']->fetchAll($sql);
	
	if(!$clients) $clients = array();
	if(!isset($clients[0])) $clients = array($clients);
	
	header("Access-Control-Allow-Methods: GET, POST, DELETE, PUT, PATCH, OPTIONS");
	header("Access-Control-Allow-Origin: *");
	return $app->json($clients, 200);
});

$app->get('/client/{id}', function ($id) use ($app) {
	$sql = "SELECT * FROM clients WHERE id = ?";
	$client = $app['db']->fetchAssoc($sql, array((int) $id));

	header("Access-Control-Allow-Methods: GET, POST, DELETE, PUT, PATCH, OPTIONS");
	header("Access-Control-Allow-Origin: *");
	return $app->json($client, 200);
});

$app->run();
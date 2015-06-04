<?php

date_default_timezone_set('America/New_York');
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once __DIR__.'/vendor/autoload.php';

$app = new Silex\Application();
$app['debug'] = true;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ParameterBag;

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver'   => 'pdo_pgsql',
        'dbname'   => 'postgres',
        'user'     => 'master',
        'password' => 'mysecretpassword',
        'host'     => 'db'
    ),
));

$app->before(function (Request $request) {
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }
});

$app->match("{url}", function($url) use ($app) {
	header('Access-Control-Allow-Origin: *');
	header("Access-Control-Allow-Credentials: true");
	header('Access-Control-Allow-Headers: X-Requested-With');
	header('Access-Control-Allow-Headers: Content-Type');
	header("Access-Control-Allow-Methods: GET, POST, DELETE, PUT, PATCH, OPTIONS");
	header("Access-Control-Allow-Origin: *");
	return "OK";
})->assert('url', '.*')->method("OPTIONS");

$app->get('/client', function () use ($app) {
	$sql = "SELECT * FROM clients ORDER BY name";
	$clients = $app['db']->fetchAll($sql);
	if(!is_array($clients)) $clients = array();

	header('Access-Control-Allow-Origin: *');
	header("Access-Control-Allow-Credentials: true");
	header('Access-Control-Allow-Headers: X-Requested-With');
	header('Access-Control-Allow-Headers: Content-Type');
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

$app->post('/client',  function (Request $request) use ($app) {
	$name = json_decode($request->getContent())->name;
	if($name) {
		$sql = "INSERT INTO clients (name) VALUES ('".$name."')";
		$app['db']->fetchAssoc($sql);
	}
	header('Access-Control-Allow-Origin: *');
	header("Access-Control-Allow-Credentials: true");
	header('Access-Control-Allow-Headers: X-Requested-With');
	header('Access-Control-Allow-Headers: Content-Type');
	header("Access-Control-Allow-Methods: GET, POST, DELETE, PUT, PATCH, OPTIONS");
	header("Access-Control-Allow-Origin: *");
	return $app->json(null, 200);
});

$app->put('/client/{id}',  function (Request $request, $id) use ($app) {
	$name = json_decode($request->getContent())->name;
	if($name) {
		$sql = "UPDATE clients set name='".$name."' where id=$id";
		$app['db']->fetchAssoc($sql);
	}
	header('Access-Control-Allow-Origin: *');
	header("Access-Control-Allow-Credentials: true");
	header('Access-Control-Allow-Headers: X-Requested-With');
	header('Access-Control-Allow-Headers: Content-Type');
	header("Access-Control-Allow-Methods: GET, POST, DELETE, PUT, PATCH, OPTIONS");
	header("Access-Control-Allow-Origin: *");
	return $app->json(null, 200);
});

$app->delete('/client/{id}', function ($id) use ($app) {
	$sql = "DELETE FROM clients WHERE id = ?";
	$app['db']->fetchAssoc($sql, array((int) $id));

	header("Access-Control-Allow-Methods: GET, POST, DELETE, PUT, PATCH, OPTIONS");
	header("Access-Control-Allow-Origin: *");
	return $app->json(null, 200);
});

$app->run();
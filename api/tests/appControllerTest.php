<?php

require_once __DIR__.'/../vendor/autoload.php';

use Guzzle\Http\Client;

class appControllerTest extends \PHPUnit_Framework_TestCase {

	public function testClientEndpoint() {
		$testName = 'PHPUnittest';
		$testNameChange = 'PHPUnittestUpdated';
		$client = new Client('http://127.0.0.1:80');

		// client add
	 	$request = $client->post('/client', null, json_encode(array('name' => $testName)));
	 	$response = $request->send();
		$this->assertEquals(200, $response->getStatusCode());

		// client list
	    $request = $client->get('/client');
	    $response = $request->send();
	    $this->assertEquals(200, $response->getStatusCode());
	    
	    $data = $response->json();
	    $this->assertInternalType('array', $data);
	    $this->assertGreaterThanOrEqual(1, count($data));

	    $foundClient = false;
	    $clientId = null;
	    foreach($data as $v) {
	    	if($v['name'] == $testName) {
	    		$foundClient = true;
	    		$clientId = $v['id'];
	    	}
	    }
	    $this->assertTrue($foundClient);

	    // client get
	    $request = $client->get('/client/'.$clientId);
	    $response = $request->send();
	    $this->assertEquals(200, $response->getStatusCode());
	    
	    $data = $response->json();
	    $this->assertInternalType('array', $data);
	    $this->assertEquals($testName, $data['name']);

	    // client update
	    $request = $client->put('/client/'.$clientId, null, json_encode(array('name' => $testNameChange)));
	 	$response = $request->send();
		$this->assertEquals(200, $response->getStatusCode());

		// client get updated value
	    $request = $client->get('/client/'.$clientId);
	    $response = $request->send();
	    $this->assertEquals(200, $response->getStatusCode());
	    
	    $data = $response->json();
	    $this->assertInternalType('array', $data);
	    $this->assertEquals($testNameChange, $data['name']);

	    // client delete
	    $request = $client->delete('/client/'.$clientId, null);
	 	$response = $request->send();
		$this->assertEquals(200, $response->getStatusCode());
	}
}
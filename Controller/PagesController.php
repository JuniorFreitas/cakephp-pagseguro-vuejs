<?php

App::uses('AppController', 'Controller');
App::uses('HttpSocket', 'Network/Http');
App::uses('Xml', 'Utility');

class PagesController extends AppController {

	public $pagEmail = '';
	public $pagToken = '';
	public $api = array(
		'sessions' => 'https://ws.sandbox.pagseguro.uol.com.br/v2/sessions',
	);

	public function index()
	{


	}

	public function getSessionId()
	{
		$this->autoRender = false;
		$HttpSocket = new HttpSocket();

		$data = array(
			'email' => $this->pagEmail,
			'token' => $this->pagToken
		);

		$sessionId = $HttpSocket->post(
			$this->api['sessions'],
			$data
		);

		$sessionResponse = Xml::toArray(Xml::build($sessionId->body));
		$id = $sessionResponse['session']['id'];
		return $id;
	}
	public function transaction()
	{
		$this->autoRender = false;
		if ($this->request->is('post')) {


		}
	}


}

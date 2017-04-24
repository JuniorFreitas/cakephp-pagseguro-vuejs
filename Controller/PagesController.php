<?php

App::uses('AppController', 'Controller');
App::uses('HttpSocket', 'Network/Http');
App::uses('Xml', 'Utility');

class PagesController extends AppController {

	public $pagEmail = 'naanzitos@gmail.com';
	public $pagToken = 'E1A2326A3D194E3B9F0510CB19579104';
	public $api = array(
		// 'sessions' => 'https://ws.sandbox.pagseguro.uol.com.br/v2/sessions',
		// 'transaction' => 'https://ws.sandbox.pagseguro.uol.com.br/v2/transactions'
		'sessions' => 'http://localhost/solupago/pagseguro/session.json',
		'transaction' => 'http://localhost/solupago/pagseguro/checkout.json',
	);

	public $postParams = array();

	public function index()
	{


	}

	public function getSessionId()
	{
		$this->autoRender = false;
		$HttpSocket = new HttpSocket();

		$data = array(
			'key' => 'dde9d881320ed6877933ed08aa20bc81',
			'email' => $this->pagEmail,
			'token' => $this->pagToken,
			'environment' => 'sandbox'
		);

		$sessionId = $HttpSocket->post(
			$this->api['sessions'],
			$data
		);
		$sessionId = json_decode($sessionId, true);
		return $sessionId['session'];
	}
	public function transaction()
	{
		$this->autoRender = false;
		if ($this->request->is('post')) {
			$HttpSocket = new HttpSocket();
			$data = $this->request->data;

			$this->postParams = array(
				'key' => 'dde9d881320ed6877933ed08aa20bc81',
				'email' => $this->pagEmail,
				'token' => $this->pagToken,
				'environment' => 'sandbox',
				'currency' => 'BRL',
				'paymentMethod' => 'creditCard',
				'paymentMode' => 'default',
				'senderHash' => $data['userHash'], // ID do vendedor, fingerprint gerado pelo JS do pag

				'itemId1' => $data['product'][0]['id'], // [Livre, com limite de 100 caracteres.]
				'itemName1' => $data['product'][0]['name'], // [Livre, com limite de 100 caracteres.]
				'itemUnitValue1' => 50.00, //$data['product'][0]['pricePerUnity'], // [Preço unitário] decimal + 2 casas decimais por ponto
				'itemQuantity1' => 2, // quant DE ITENS SENDO COMPRADOS 1~~999
				//'extraAmount' => $data[''], //valor extra a ser cobrado
				'senderEmail' => $data['email'], //email do comprador
				'senderName' => $data['userName'], // Nome completo do comprador (minimo de 2 sequencias de caracteres, limite de 50)
				'senderCPF' => $data['cpf'], // Cpf do comprador
				'senderAreaCode' => '14', // DDD do comprador
				'senderPhone' => $data['phone'], //TElefone do comprador
				//'shippingType' => '1', // Tipo de envio (1 PAC, 2SEDEX, 3 DESCONHECIDO)
				//'shippingCost' => '25.00', // Preço do frete
				'shippingCountry' => 'BRA', // País do endereço de envio
				'shippingState' => $data['state'], //Estado do endereço de envio
				'shippingCity' => $data['city'], // Cidade do endereço de envio
				'shippingCep' => $data['cep'], // CEP do endereço de envio do produto
				'shippingDistrict' => $data['district'], //Bairro do endereço de envio
				'shippingAddress' => $data['address'], // Nome da rua do endereço de envio
				'shippingNumber' => $data['addressNumber'], // Numero do endereço de envio
				'shippingComplement' => $data['complement'],// Complemento do endereço de envio

				'creditCardToken' => $data['crdToken'], // Token de cartão de credito
				'installmentQuantity' => 1, //Qtd de parcelas escolhidas 1-18
				'installmentValue' => 197.50, //valor das parcelas 2 casas decimais por potno

				'cardHolderName' => $data['crdName'], //Nome impresso no cartão 1-50 carac
				'cardHolderBirthdate' => '13/06/1996', // Data de nascimento do dono do cartão
				'cardHolderCPF' => $data['cpf'], //CPF do dono do cartão
				'cardHolderAreaCode' => '14', //DDD do dono do cartão
				'cardHolderPhone' => $data['phone'], // Telefone do dono do cartão

				'billingCep' => $data['cep'], // Cep do endereço de cobrança
				'billingAddress' => $data['address'], //Nome da rua de cobrança
				'billingNumber' => $data['addressNumber'], //numero do endereço de cobrança
				'billingComplement' => $data['complement'], //Complemento do endereço de cobrança
				'billingDistrict' => $data['district'], // Bairro do endereço de cobrança
				'billingCity' => $data['city'], //Cidade de cobrança
				'billingState' => $data['state'], // estado de cobrança
				'billingCountry' => 'BRA', // país de cobrança (BRA)

				'extraAmount' => 97.50 // país de cobrança (BRA)
			);

			$paymentResponse = $HttpSocket->post(
				$this->api['transaction'],
				$this->postParams
			);
			// $paymentStatus = Xml::toArray(Xml::build($paymentResponse));
			// debug($paymentStatus);
			debug($paymentResponse);
		}
	}


}

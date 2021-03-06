<?php

App::uses('AppController', 'Controller');
App::uses('HttpSocket', 'Network/Http');
App::uses('Xml', 'Utility');

class PagesController extends AppController {

	public $pagEmail = 'ti@solutudo.com.br';
	public $pagToken = '5B7A5552D5C0460D875A64AD41E059DB';
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
				'items' => [
					1 => [
						'itemId' => $data['product'][0]['id'], // [Livre, com limite de 100 caracteres.]
						'itemName' => $data['product'][0]['name'], // [Livre, com limite de 100 caracteres.]
						'itemUnitaryValue' => 50.00, //$data['product'][0]['pricePerUnity'], // [Preço unitário] decimal + 2 casas decimais por ponto
						'itemCount' => 2, // quant DE ITENS SENDO COMPRADOS 1~~99
					],
					2 => [
						'itemId' => '231', // [Livre, com limite de 100 caracteres.]
						'itemName' => 'teste', // [Livre, com limite de 100 caracteres.]
						'itemUnitaryValue' => 50.00, //$data['product'][0]['pricePerUnity'], // [Preço unitário] decimal + 2 casas decimais por ponto
						'itemCount' => 4, // quant DE ITJENS SENDO COMPRADOS 1~~99
					],
				],
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
				'installmentCount' => 1, //Qtd de parcelas escolhidas 1-18
				'installmentValue' => '397.50', //valor das parcelas 2 casas decimais por potno

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

				// Optional parameters
				'description' => 'hueheuheue',
				'extraAmount' => 97.50, // país de cobrança (BRA
				'buyerUserId' => '132',
				'sellerUserId' => '133',
				'sellerAdvId' => '109',
				'orderId' => '1258',
				'orderType' => 'ShpProduct',
				'reference' => 'STDSHDPRODUCT',
				'sipphingAddressComment' => 'Entregar pelas portas dos fundos',
				'billingAddressReference' => 'Perto do mercado',
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

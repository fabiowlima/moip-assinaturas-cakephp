<?php
/**
 * Moip Assinaturas CakePHP - Customer API - See http://moiplabs.github.io/assinaturas-docs/api.html#clientes
 * Created by Fábio Lima - Bendit - fabio@bendit.com.br on 2015-01-01.
 * http://www.bendit.com.br
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice
 * @version 	  1.0.0
 * @copyright     Fábio Lima on 2015-01-01.
 * @link          www.bendit.com.br
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
class CustomersComponent extends MoipComponent {

/**
 * Constructor/Startup the Component
 * 
 *
 * @author Fábio Lima
 * @param $controller
 * @return void
 **/
	public function startup(\Controller $controller) {
		parent::startup($controller);
	}

/**
 * Create
 * Create New Customer - See http://moiplabs.github.io/assinaturas-docs/api.html#criar_cliente
 *
 * @author Fábio Lima
 * @param Bool for $new, if you can create user with CC data. String for $data in json format
 * @return array
 **/
	public function create($new, $data) {
		$new_vault = ($new) ? 'true' : 'false';
		$response = $this->HttpSocket->post($this->baseUri . 'customers?new_vault=' . $new_vault, $data, $this->request);
		$body = json_decode($response->body, true);

		switch ($response->code) {
			case 201:
				return array('success' => true, 'message' => 'Cliente criado com sucesso');
			case 400:
				return array('success' => false, 'message' => $body['message'], 'errors' => $body['errors']);
			case 404:
				return array('success' => false, 'message' => 'Not found');
			default:
				return array('success' => false, 'message' => 'Ocorreu um erro ao cadastrar o cliente');
		}
	}

/**
 * Update
 * Update Customer - See http://moiplabs.github.io/assinaturas-docs/api.html#alterar_cliente
 *
 * @author Fábio Lima
 * @param String/Int for Customer $code. String for $data in json format
 * @return array
 **/
	public function update($code, $data) {
		$response = $this->HttpSocket->put($this->baseUri . 'customers/' . $code, $data, $this->request);
		$body = json_decode($response->body, true);

		switch ($response->code) {
			case 200:
				return array('success' => true, 'message' => 'Cliente atualizado com sucesso');
			case 201:
				return array('success' => true, 'message' => 'Cliente atualizado com sucesso');
			case 400:
				return array('success' => false, 'message' => $body['message'], 'errors' => $body['errors']);
			case 404:
				return array('success' => false, 'message' => 'Not found');
			default:
				return array('success' => false, 'message' => 'Ocorreu um erro ao atualizar o cliente');
		}
	}

/**
 * Update
 * Update Customer - See http://moiplabs.github.io/assinaturas-docs/api.html#atualizar_cartao
 *
 * @author Fábio Lima
 * @param String/Int for customer $code. String for $data in json format
 * @return array
 **/
	public function updateBillingInfos($code, $data) {
		$response = $this->HttpSocket->put($this->baseUri . 'customers/' . $code . '/billing_infos', $data, $this->request);
		$body = json_decode($response->body, true);

		switch ($response->code) {
			case 200:
				return array('success' => true, 'message' => 'Dados do cliente atualizado com sucesso');
			case 201:
				return array('success' => true, 'message' => 'Dados do cliente atualizado com sucesso');
			case 400:
				return array('success' => false, 'message' => $body['message'], 'errors' => $body['errors']);
			case 404:
				return array('success' => false, 'message' => 'Not found');
			default:
				return array('success' => false, 'message' => 'Ocorreu um erro ao atualizar os dados cliente');
		}
	}

/**
 * ListAll
 * List All Customer - See http://moiplabs.github.io/assinaturas-docs/api.html#listar_clientes
 *
 * @author Fábio Lima
 * @return array
 **/
	public function listAll() {
		$response = $this->HttpSocket->get($this->baseUri . 'customers');
		$body = json_decode($response->body, true);

		switch ($response->code) {
			case 200:
				return array('success' => true, 'customers' => $body['customers']);
			case 400:
				return array('success' => false, 'message' => $body['message'], 'errors' => $body['errors']);
			case 404:
				return array('success' => false, 'message' => 'Not found');
			default:
				return array('success' => false, 'message' => 'Ocorreu um erro ao listar os clientes');
		}
	}

/**
 * Details
 * List Customer Details - See http://moiplabs.github.io/assinaturas-docs/api.html#consultar_cliente
 *
 * @author Fábio Lima
 * @param String/Int for customer $code
 * @return array
 **/
	public function details($code) {
		$response = $this->HttpSocket->get($this->baseUri . 'customers/' . $code);
		$body = json_decode($response->body, true);

		switch ($response->code) {
			case 200:
				return array('success' => true, 'customer' => $body);
			case 400:
				return array('success' => false, 'message' => $body['message'], 'errors' => $body['errors']);
			case 404:
				return array('success' => false, 'message' => 'Not found');
			default:
				return array('success' => false, 'message' => 'Ocorreu um erro ao listar os detalhes do cliente');
		}
	}
}
?>
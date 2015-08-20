<?php
/**
 * Moip Assinaturas CakePHP - Subscriptions API - See http://moiplabs.github.io/assinaturas-docs/api.html#clientes
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
class SubscriptionsComponent extends MoipComponent {

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
 * Create New Customer - See http://moiplabs.github.io/assinaturas-docs/api.html#criar_assinatura
 *
 * @author Fábio Lima
 * @param Bool for $new, if you can create new customer together. String for $data in json format
 * @return array
 **/
	public function create($new, $data) {
		$new_client = ($new) ? 'true' : 'false';
		$response = $this->HttpSocket->post($this->baseUri . 'subscriptions?new_customer=' . $new_client, $data, $this->request);
		$body = json_decode($response->body, true);

		switch ($response->code) {
			case 201:
				return array('success' => true, 'message' => 'Assinatura criada com sucesso');
			case 400:
				return array('success' => false, 'message' => $body['message'], 'errors' => $body['errors']);
			case 404:
				return array('success' => false, 'message' => 'Not found');
			default:
				return array('success' => false, 'message' => 'Ocorreu um erro ao cadastrar a assinatura');
		}
	}

/**
 * Update
 * Update Subscription - See http://moiplabs.github.io/assinaturas-docs/api.html#alterar_assinatura
 *
 * @author Fábio Lima
 * @param String/Int for Subscription $code. String for $data in json format
 * @return array
 **/
	public function update($code, $data) {
		$response = $this->HttpSocket->put($this->baseUri . 'subscriptions/' . $code, $data, $this->request);
		$body = json_decode($response->body, true);

		switch ($response->code) {
			case 200:
				return array('success' => true, 'message' => 'Assinatura atualizada com sucesso');
			case 201:
				return array('success' => true, 'message' => 'Assinatura atualizada com sucesso');
			case 400:
				return array('success' => false, 'message' => $body['message'], 'errors' => $body['errors']);
			case 404:
				return array('success' => false, 'message' => 'Not found');
			default:
				return array('success' => false, 'message' => 'Ocorreu um erro ao atualizar a assinatura');
		}
	}

/**
 * ListAll
 * List All Subscriptions - See http://moiplabs.github.io/assinaturas-docs/api.html#listar_assinaturas
 *
 * @author Fábio Lima
 * @return array
 **/
	public function listAll() {
		$response = $this->HttpSocket->get($this->baseUri . 'subscriptions');
		$body = json_decode($response->body, true);

		switch ($response->code) {
			case 200:
				return array('success' => true, 'subscriptions' => $body['subscriptions']);
			case 400:
				return array('success' => false, 'message' => $body['message'], 'errors' => $body['errors']);
			case 404:
				return array('success' => false, 'message' => 'Not found');
			default:
				return array('success' => false, 'message' => 'Ocorreu um erro ao listar as assinaturas');
		}
	}

/**
 * Details
 * List Subscription Details - See http://moiplabs.github.io/assinaturas-docs/api.html#consultar_assinatura
 *
 * @author Fábio Lima
 * @param String/Int for customer $code
 * @return array
 **/
	public function details($code) {
		$response = $this->HttpSocket->get($this->baseUri . 'subscriptions/' . $code);
		$body = json_decode($response->body, true);

		switch ($response->code) {
			case 200:
				return array('success' => true, 'subscription' => $body);
			case 400:
				return array('success' => false, 'message' => $body['message'], 'errors' => $body['errors']);
			case 404:
				return array('success' => false, 'message' => 'Not found');
			default:
				return array('success' => false, 'message' => 'Ocorreu um erro ao listar os detalhes da assinatura');
		}
	}

/**
 * Suspend
 * Suspend Subscription - See http://moiplabs.github.io/assinaturas-docs/api.html#suspender_reativar_assinatura
 *
 * @author Fábio Lima
 * @param String/Int for subscription $code
 * @return array
 **/
	public function suspend($code) {
		$response = $this->HttpSocket->put($this->baseUri . 'subscriptions/' . $code . '/suspend');
		$body = json_decode($response->body, true);

		switch ($response->code) {
			case 200:
				return array('success' => true, 'message' => 'Assinatura suspensa com sucesso');
			case 400:
				return array('success' => false, 'message' => $body['message'], 'errors' => $body['errors']);
			case 404:
				return array('success' => false, 'message' => 'Not found');
			default:
				return array('success' => false, 'message' => 'Ocorreu um erro ao suspender a assinatura');
		}
	}

/**
 * Activate
 * Activate Subscription - See http://moiplabs.github.io/assinaturas-docs/api.html#suspender_reativar_assinatura
 *
 * @author Fábio Lima
 * @param String/Int for subscription $code
 * @return array
 **/
	public function activate($code) {
		$response = $this->HttpSocket->put($this->baseUri . 'subscriptions/' . $code . '/activate');
		$body = json_decode($response->body, true);

		switch ($response->code) {
			case 200:
				return array('success' => true, 'message' => 'Assinatura ativada com sucesso');
			case 400:
				return array('success' => false, 'message' => $body['message'], 'errors' => $body['errors']);
			case 404:
				return array('success' => false, 'message' => 'Not found');
			default:
				return array('success' => false, 'message' => 'Ocorreu um erro ao suspender a assinatura');
		}
	}

/**
 * Cancel
 * Cancel Subscription - See http://moiplabs.github.io/assinaturas-docs/api.html#suspender_reativar_assinatura
 *
 * @author Fábio Lima
 * @param String/Int for subscription $code
 * @return array
 **/
	public function cancel($code) {
		$response = $this->HttpSocket->put($this->baseUri . 'subscriptions/' . $code . '/cancel');
		$body = json_decode($response->body, true);

		switch ($response->code) {
			case 200:
				return array('success' => true, 'message' => 'Assinatura cancelada com sucesso');
			case 400:
				return array('success' => false, 'message' => $body['message'], 'errors' => $body['errors']);
			case 404:
				return array('success' => false, 'message' => 'Not found');
			default:
				return array('success' => false, 'message' => 'Ocorreu um erro ao suspender a assinatura');
		}
	}
}
?>
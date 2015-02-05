<?php
/**
 * Moip Assinaturas CakePHP - Plans API - See http://moiplabs.github.io/assinaturas-docs/api.html#planos
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
class PlansComponent extends MoipComponent {

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
 * Create New Plan - See http://moiplabs.github.io/assinaturas-docs/api.html#criar_plano
 *
 * @author Fábio Lima
 * @param String for $data in json format
 * @return array
 **/
	public function create($data) {
		$response = $this->HttpSocket->post($this->baseUri . 'plans', $data, $this->request);
		$body = json_decode($response->body, true);

		switch ($response->code) {
			case 201:
				return array('success' => true, 'message' => 'Plano criado com sucesso');
			case 400:
				return array('success' => true, 'message' => $body['message'], 'errors' => $body['errors']);
			case 404:
				return array('success' => true, 'message' => 'Not found');
			default:
				return array('success' => true, 'message' => 'Ocorreu um erro ao cadastrar o plano');
		}
	}

/**
 * Update
 * Update Plan - See http://moiplabs.github.io/assinaturas-docs/api.html#alterar_plano
 *
 * @author Fábio Lima
 * @param String/Int for Plan $code. String for $data in json format
 * @return array
 **/
	public function update($code, $data) {
		$response = $this->HttpSocket->put($this->baseUri . 'plans/' . $code, $data, $this->request);
		$body = json_decode($response->body, true);

		switch ($response->code) {
			case 200:
				return array('success' => true, 'message' => 'Plano atualizado com sucesso');
			case 400:
				return array('success' => true, 'message' => $body['message'], 'errors' => $body['errors']);
			case 404:
				return array('success' => true, 'message' => 'Not found');
			default:
				return array('success' => true, 'message' => 'Ocorreu um erro ao atualizar o plano');
		}
	}

/**
 * ListAll
 * List All Plans - See http://moiplabs.github.io/assinaturas-docs/api.html#listar_plano
 *
 * @author Fábio Lima
 * @return array
 **/
	public function listAll() {
		$response = $this->HttpSocket->get($this->baseUri . 'plans');
		$body = json_decode($response->body, true);

		switch ($response->code) {
			case 200:
				return array('success' => true, 'plans' => $body['plans']);
			case 400:
				return array('success' => true, 'message' => $body['message'], 'errors' => $body['errors']);
			case 404:
				return array('success' => true, 'message' => 'Not found');
			default:
				return array('success' => true, 'message' => 'Ocorreu um erro ao listar os planos');
		}
	}

/**
 * Details
 * List Plan Details - See http://moiplabs.github.io/assinaturas-docs/api.html#consultar_plano
 *
 * @author Fábio Lima
 * @param String/Int for plan $code
 * @return array
 **/
	public function details($code) {
		$response = $this->HttpSocket->get($this->baseUri . 'plans/' . $code);
		$body = json_decode($response->body, true);

		switch ($response->code) {
			case 200:
				return array('success' => true, 'plan' => $body);
			case 400:
				return array('success' => true, 'message' => $body['message'], 'errors' => $body['errors']);
			case 404:
				return array('success' => true, 'message' => 'Not found');
			default:
				return array('success' => true, 'message' => 'Ocorreu um erro ao listar os detalhes do plano');
		}
	}

/**
 * Activate
 * Activate Plan - See http://moiplabs.github.io/assinaturas-docs/api.html#ativar_desativar_plano
 *
 * @author Fábio Lima
 * @param String/Int for plan $code
 * @return array
 **/
	public function activate($code) {
		$response = $this->HttpSocket->put($this->baseUri . 'plans/' . $code . '/activate');
		$body = json_decode($response->body, true);

		switch ($response->code) {
			case 200:
				return array('success' => true, 'message' => 'Plano ativado com sucesso');
			case 400:
				return array('success' => true, 'message' => $body['message'], 'errors' => $body['errors']);
			case 404:
				return array('success' => true, 'message' => 'Not found');
			default:
				return array('success' => true, 'message' => 'Ocorreu um erro ao ativar o plano');
		}
	}

/**
 * Inactivate
 * Inactivate Plan - See http://moiplabs.github.io/assinaturas-docs/api.html#ativar_desativar_plano
 *
 * @author Fábio Lima
 * @param String/Int for plan $code
 * @return array
 **/
	public function inactivate($code) {
		$response = $this->HttpSocket->put($this->baseUri . 'plans/' . $code . '/inactivate');
		$body = json_decode($response->body, true);

		switch ($response->code) {
			case 200:
				return array('success' => true, 'message' => 'Plano desativado com sucesso');
			case 400:
				return array('success' => true, 'message' => $body['message'], 'errors' => $body['errors']);
			case 404:
				return array('success' => true, 'message' => 'Not found');
			default:
				return array('success' => true, 'message' => 'Ocorreu um erro ao desativar o plano');
		}
	}
}
?>
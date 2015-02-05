<?php
/**
 * Moip Assinaturas CakePHP - Retries API - See http://moiplabs.github.io/assinaturas-docs/api.html#retentativas
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
class RetriesComponent extends MoipComponent {

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
 * Retry
 * Retry Billing to Invoice - See http://moiplabs.github.io/assinaturas-docs/api.html#retentar_pagamento
 *
 * @author Fábio Lima
 * @param String/Int for Invoice $code
 * @return array
 **/
	public function retry($id) {
		$response = $this->HttpSocket->get($this->baseUri . 'invoices/' . $id . '/retry');
		$body = json_decode($response->body, true);

		switch ($response->code) {
			case 200:
				return array('success' => true, 'message' => 'Retentativa executada com sucesso');
			case 400:
				return array('success' => true, 'message' => $body['message'], 'errors' => $body['errors']);
			case 404:
				return array('success' => true, 'message' => 'Not found');
			default:
				return array('success' => true, 'message' => 'Ocorreu um erro ao executar a retentativa');
		}
	}

/**
 * Rules
 * Update Rules for Retries - See http://moiplabs.github.io/assinaturas-docs/api.html#retentativa_automatica
 *
 * @author Fábio Lima
 * @param String for $data in json format
 * @return array
 **/
	public function rules($data) {
		$response = $this->HttpSocket->post($this->baseUri . 'users/preferences/retry', $data, $this->request);
		$body = json_decode($response->body, true);

		switch ($response->code) {
			case 200:
				return array('success' => true, 'message' => 'Regras de retentativa atualizadas com sucesso');
			case 201:
				return array('success' => true, 'message' => 'Regras de retentativa atualizadas com sucesso');
			case 400:
				return array('success' => true, 'message' => $body['message'], 'errors' => $body['errors']);
			case 404:
				return array('success' => true, 'message' => 'Not found');
			default:
				return array('success' => true, 'message' => 'Ocorreu um erro ao atualizar as regras de retentativa');
		}
	}
}
?>
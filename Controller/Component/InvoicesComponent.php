<?php
/**
 * Moip Assinaturas CakePHP - Invoices API - See http://moiplabs.github.io/assinaturas-docs/api.html#faturas
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
class InvoicesComponent extends MoipComponent {

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
 * ListAll
 * List All Invoices for Subscription - See http://moiplabs.github.io/assinaturas-docs/api.html#listar_faturas
 *
 * @author Fábio Lima
 * @param String/Int for Subscription $code
 * @return array
 **/
	public function listAll($code) {
		$response = $this->HttpSocket->get($this->baseUri . 'subscriptions/' . $code . '/invoices');
		$body = json_decode($response->body, true);

		switch ($response->code) {
			case 200:
				return array('success' => true, 'invoices' => $body['invoices']);
			case 400:
				return array('success' => false, 'message' => $body['message'], 'errors' => $body['errors']);
			case 404:
				return array('success' => false, 'message' => 'Not found');
			default:
				return array('success' => false, 'message' => 'Ocorreu um erro ao listar as faturas');
		}
	}

/**
 * Details
 * List Invoice Details - See http://moiplabs.github.io/assinaturas-docs/api.html#consultar_fatura
 *
 * @author Fábio Lima
 * @param String/Int for Invoice $id
 * @return array
 **/
	public function details($id) {
		$response = $this->HttpSocket->get($this->baseUri . 'invoices/' . $id);
		$body = json_decode($response->body, true);

		switch ($response->code) {
			case 200:
				return array('success' => true, 'subscription' => $body);
			case 400:
				return array('success' => false, 'message' => $body['message'], 'errors' => $body['errors']);
			case 404:
				return array('success' => false, 'message' => 'Not found');
			default:
				return array('success' => false, 'message' => 'Ocorreu um erro ao listar os detalhes da fatura');
		}
	}
}
?>
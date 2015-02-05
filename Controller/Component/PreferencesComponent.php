<?php
/**
 * Moip Assinaturas CakePHP - Preferences API - See http://moiplabs.github.io/assinaturas-docs/api.html#preferencias
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
class PreferencesComponent extends MoipComponent {

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
 * Set
 * Update Preferences - See http://moiplabs.github.io/assinaturas-docs/api.html#preferencias_notificar
 *
 * @author Fábio Lima
 * @param String for $data in json format
 * @return array
 **/
	public function set($data) {
		$response = $this->HttpSocket->post($this->baseUri . 'users/preferences', $data, $this->request);
		$body = json_decode($response->body, true);

		switch ($response->code) {
			case 200:
				return array('success' => true, 'message' => 'Preferências atualizadas com sucesso');
			case 201:
				return array('success' => true, 'message' => 'Preferências atualizadas com sucesso');
			case 400:
				return array('success' => true, 'message' => $body['message'], 'errors' => $body['errors']);
			case 404:
				return array('success' => true, 'message' => 'Not found');
			default:
				return array('success' => true, 'message' => 'Ocorreu um erro ao atualizar as Preferências');
		}
	}
}
?>
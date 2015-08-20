<?php
/**
 * Moip Assinaturas CakePHP
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
App::uses('NaspController', 'Controller');
class WebhooksController extends MoipAssinaturasAppController {

/**
 * Constructor
 * In this method. Check if webhook is enable, if tokenNasp is available and if match with NASP
 *
 * @author Fábio Lima
 * @param $controller
 * @return void
 **/
	public function beforeFilter() {
		parent::beforeFilter();

		$header = apache_request_headers();
		$config = Configure::read('MoipAssinaturas');

		if (!$config['activeWebhook'])
			throw new Exception("Webhook desativado no plugin");

		if (empty($config['tokenNasp']))
			throw new Exception("Configure o token (Authorization) do NASP");
			
		if ($header['Authorization'] != $config['tokenNasp'])
			throw new Exception("Token NASP não confere");
			
	}

/**
 * Index
 * Receive NASP. Check if NaspController::process is available and send data to then for custom proccessing
 *
 * @author Fábio Lima
 * @return array
 **/
	public function index() {
				
		$body = json_decode(@file_get_contents('php://input'), true);

		$methods = get_class_methods('NaspController');
		if ($methods) {
			if (in_array('process', $methods)) {
				$nasp = new NaspController();
				$nasp->process($body);
			} else {
				throw new Exception("Método process não encontrado em NaspController");
			}
		} else {
			throw new Exception("Classe NaspController ou método process não encontrado");
		}
	}
}
?>
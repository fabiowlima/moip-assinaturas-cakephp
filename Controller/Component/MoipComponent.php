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
App::uses('Component', 'Controller');
App::uses('HttpSocket', 'Network/Http');
class MoipComponent extends Component {

	public $baseUri;
	public $HttpSocket;
	public $request = array('header' => array('Accept' => 'application/json', 'Content-Type' => 'application/json'));

/**
 * Constructor/Startup the Main Component
 * In this method. Check if plugin is configured. If env is prod/sandbox and initialize HttpSocket with credentials
 *
 * @author Fábio Lima
 * @param $controller
 * @return void
 **/
	public function startup(\Controller $controller) {
		
		$config = Configure::read('MoipAssinaturas');

		if (empty($config))
			throw new Exception("Por favor configure o plugin");

		if (empty($config['token']))
			throw new Exception("Por favor informe o token");

		if (empty($config['key']))
			throw new Exception("Por favor informe a key");

		if ($config['isProd'] && true === $config['isProd']) {
			$this->baseUri = 'https://api.moip.com.br/assinaturas/v1/';
		} else {
			$this->baseUri = 'https://sandbox.moip.com.br/assinaturas/v1/';
		}

		if(!$this->HttpSocket) {
			$this->HttpSocket = new HttpSocket();
			$this->HttpSocket->configAuth('Basic', $config['token'], $config['key']);
		}
	}
}
?>
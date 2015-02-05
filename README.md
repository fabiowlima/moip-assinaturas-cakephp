# Plugin do Moip Assinaturas para CakePHP

Moip Assinaturas  | CakePHP | Descrição do Plugin |
------------- | ------------- | ------------ |
[![Moip Assinaturas](http://moiplabs.github.com/assinaturas-docs/img/palheta_assinaturas.png)](http://site.moip.com.br/assinaturas)  | [![CakePHP](http://cakephp.org/img/cake-logo.png)](http://www.cakephp.org)  | Este plugin permite utilizar todos os recursos do Moip Assinaturas para Aplicações desenvolvidas com CakePHP. O Moip Assinaturas permite que você faça cobranças de forma automática, no valor e intervalo que escolher por meio da criação de planos. |

## Instalação Manual
Faça download da última versão do plugin, descompacte e adiciona ao diretório app/Plugin/MoipAssinaturas/

## Instalação com Submodule
No diretório raiz do projeto
 ```
 git submodule add https://github.com/Bendit/moip-assinaturas-cakephp.git app/Plugin/MoipAssinaturas/
 ```

## Configuração
No arquivo app/Config/bootstrap.php adicione o suporte ao plugin: `CakePlugin::load('MoipAssinaturas');` ou `CakePlugin::loadAll();`

Você precisa ter uma conta no Moip criada e ter em mãos seu token e chave de acesso, com isso em mãos adicione as 
seguintes configurações ainda no arquivo bootstrap.php

```
Configure::write('MoipAssinaturas', array(
        'token' => 'Insira-seu-token-aqui',
        'key' => 'Insira-sua-chave-de-acesso-aqui',
        'isProd' => false,
        'tokenNasp' => null,
        'activeWebhook' => false,
    ));
```
**Explicação rápida**

**Token:** É o token de acesso fornecido pelo Moip

**Key:** É a chave de acesso fornecida pelo Moip

**isProd:** Se vai usar o plugin em ambiente de produção use (true), se é no Sandbox (false)

**tokenNasp:** Esse token é diferente do primeiro. Esse é utilizado quando o Moip enviar uma notificação através do Webhook, com ele o plugin autentica a origem da requisição para garantir a integridade e segurança dos dados. Essa informações está disponível no link configurações no painel do Moip Assinaturas.

**activeWebhook:** (true or false) Se você quer ou não utilizar os recursos do Webhook. [Saiba mais sobre Webhook](http://moiplabs.github.io/assinaturas-docs/webhooks.html).

## Introdução

Nesse plugin você terá as seguintes APIs do Moip Assinaturas, através dos respectivos Components.

| API | Component |
| --- | ---------- |
| Planos | MoipAssinaturas.Plans |
| Clientes | MoipAssinaturas.Customers |
| Assinaturas | MoipAssinaturas.Subscriptions |
| Faturas | MoipAssinaturas.Invoices |
| Pagamentos | MoipAssinaturas.Payments |
| Retentativas | MoipAssinaturas.Retries |
| Preferências | MoipAssinaturas.Preferences |

A seguir os métodos disponíveis para cada Component:

### Planos - MoipAssinaturas.Plans

Criar novo plano 

`Plans::create(plan_attributes)`

Atualizar plano 

`Plans::update(plan_code, plan_attributes)`

Listas todos os planos 

`Plans::listAll()`

Detalhes de um plano específico 

`Plans::details(plan_code)`

Ativar um plano 

`Plans::activate(plan_code)`

Desativar um plano 

`Plans::inactivate(plan_code)`

### Clientes - MoipAssinaturas.Customers

Criar novo cliente. Notar o parametro `new_vault`, que deve ser `true | false`, isso serve para criar um cliente com dados de cartão de crédito ou não. Se esse parâmentro for true, deverá fornecer os dados de cartão obrigatóriamente.

`Customers::create(new_vault, customer_attributes)`

Atualizar cliente 

`Customers::update(customer_code, customer_attributes)`

Listas todos os clientes 

`Customers::listAll()`

Detalhes de um cliente específico 

`Customers::details(customer_code)`

Atualizar dados do cartão do cliente 

`Customers::updateBillingInfos(customer_code, customer_attributes)`

### Assinaturas - MoipAssinaturas.Subscriptions

Criar nova assinatura, atentar para o parametro `new_customer`, as opções que devem ser fornecidas são `true | false`, passando true você pode criar uma assinatura junto com o cliente de uma vez só.

`Subscriptions::create(new_customer, subscription_attributes)`

Atualizar assinatura 

`Subscriptions::update(subscription_code, subscription_attributes)`

Listas todas as assinaturas 

`Subscriptions::listAll()`

Detalhes de uma assinatura específica 

`Subscriptions::details(subscription_code)`

Suspender uma assinatura 

`Subscriptions::suspend(subscription_code)`

Ativar uma assinatura 

`Subscriptions::activate(subscription_code)`

Cancelar uma assinatura 

`Subscriptions::cancel(subscription_code)`

### Faturas - MoipAssinaturas.Invoices

Listas todas faturas de uma assinatura 

`Invoices::listAll(subscription_code)`

Detalhes de uma fatura específica 

`Plans::details(invoice_id)`

### Pagamentos - MoipAssinaturas.Payments

Listas todos pagamentos de uma fatura 

`Payments::listAll(invoice_id)`

Detalhes de um pagamento específico 

`Payments::details(payment_id)`

### Retentativas - MoipAssinaturas.Retries

Retenta a cobrança de uma fatura 

`Payments::retry(invoice_id)`

Atualiza regras de retentativas 

`Payments::rules(rules_attributes)`

### Preferências - MoipAssinaturas.Preferences

Atualiza preferências 

`Preferences::set(preferences_attributes)`

## Como usar

**Nota Importante**: No Controller onde você deseja utilizar o plugin carregue o componente conforme sua necessidade, o componente `MoipAssinaturas.Moip` é obrigatório sempre.

Exemplo carregando plugin e componente de planos

```
public $components = array('MoipAssinaturas.Moip', 'MoipAssinaturas.Plans');
```

### Exemplo de utilização planos - [Documentação planos](http://moiplabs.github.io/assinaturas-docs/api.html#planos)

Primeiro carregue o componente

```
public $components = array('MoipAssinaturas.Moip', 'MoipAssinaturas.Plans');
```

Métodos de Exemplo utilizados no teste do plugin, para testar crie um controller e adicione esses métodos, depois acesse via browser.

```
	public function createPlan() {
		$this->autoRender = false;
		$data = '{
				    "code": "plano02",
				    "name": "Plano Especial",
				    "description": "Descrição do Plano Especial",
				    "amount": 990,
				    "setup_fee": 500,
				    "max_qty": 1,
				    "status": "ACTIVE",
				    "interval": {
				        "length": 1,
				        "unit": "MONTH"
				    },
				    "billing_cycles": 12,
				    "trial": {
				        "days": 30,
				        "enabled": true,
				        "hold_setup_fee": true
				    }
				}';

		$result = $this->Plans->create($data);
		pr($result);
	}

	public function updatePlan($code) {
		$this->autoRender = false;
		$data = '{
				    "code": "plano02",
				    "name": "Plano Especial Alterado",
				    "description": "Descrição do Plano Especial",
				    "amount": 990,
				    "setup_fee": 500,
				    "max_qty": 1,
				    "status": "ACTIVE",
				    "interval": {
				        "length": 1,
				        "unit": "MONTH"
				    },
				    "billing_cycles": 12,
				    "trial": {
				        "days": 30,
				        "enabled": true,
				        "hold_setup_fee": true
				    }
				}';

		$result = $this->Plans->update($code, $data);
		pr($result);
	}

	public function listPlans() {
		$this->autoRender = false;		
		
		$result = $this->Plans->listAll();
		pr($result);
	}

	public function detailsPlan($code = 0) {
		$this->autoRender = false;		
		
		$result = $this->Plans->details($code);
		pr($result);
	}

	public function activatePlan($code) {
		$this->autoRender = false;		
		
		$result = $this->Plans->activate($code);
		pr($result);
	}

	public function inactivatePlan($code) {
		$this->autoRender = false;		
		
		$result = $this->Plans->inactivate($code);
		pr($result);
	}
```

### Exemplo de utilização clientes - [Documentação clientes](http://moiplabs.github.io/assinaturas-docs/api.html#clientes)

Primeiro carregue o componente

```
public $components = array('MoipAssinaturas.Moip', 'MoipAssinaturas.Customers');
```

Métodos de Exemplo utilizados no teste do plugin, para testar crie um controller e adicione esses métodos, depois acesse via browser.

```
	public function createCustomer() {
		$this->autoRender = false;
		$data = '{
				    "code": "cliente05",
				    "email": "nome@exemplo.com.br",
				    "fullname": "Nome Sobrenome",
				    "cpf": "22222222222",
				    "phone_area_code": "11",
				    "phone_number": "934343434",
				    "birthdate_day": "26",
				    "birthdate_month": "04",
				    "birthdate_year": "1980",
				    "address": {
				        "street": "Rua Nome da Rua",
				        "number": "100",
				        "complement": "Casa",
				        "district": "Nome do Bairro",
				        "city": "São Paulo",
				        "state": "SP",
				        "country": "BRA",
				        "zipcode": "05015010"
				    },
				    "billing_info": {
				        "credit_card": {
				            "holder_name": "Nome Completo",
				            "number": "4111111111111111",
				            "expiration_month": "04",
				            "expiration_year": "15"
				        }
				    }
				}';

		$new_vault = true;
		$result = $this->Customers->create($new_vault, $data);
		pr($result);
	}

	public function updateCustomer($code) {
		$this->autoRender = false;
		$data = '{
				    "code": "cliente05",
				    "email": "nome@exemplo.com.br",
				    "fullname": "Nome Sobrenome Alterado",
				    "cpf": "22222222222",
				    "phone_number": "934343434",
				    "phone_area_code": "11",
				    "birthdate_day": "26",
				    "birthdate_month": "04",
				    "birthdate_year": "1986",
				    "address": {
				        "street": "Rua nome da Rua",
				        "number": "170",
				        "complement": "Casa",
				        "district": "Bairro",
				        "city": "São Paulo",
				        "state": "SP",
				        "country": "BRA",
				        "zipcode": "00000-000"
				    }
				}';

		$result = $this->Customers->update($code, $data);
		pr($result);
	}

	public function updateBillingInfos($code) {
		$this->autoRender = false;
		$data = '{
			        "credit_card": {
			            "holder_name": "Novo nome",
			            "number": "5555666677778884",
			            "expiration_month": "04",
			            "expiration_year": "15"
			        }
			 }';

		$result = $this->Customers->updateBillingInfos($code, $data);
		pr($result);
	}

	public function listCustomers() {
		$this->autoRender = false;		
		
		$result = $this->Customers->listAll();
		pr($result);
	}

	public function detailsCustomer($code = 0) {
		$this->autoRender = false;		
		
		$result = $this->Customers->details($code);
		pr($result);
	}
```

### Exemplo de utilização assinaturas - [Documentação assinaturas](http://moiplabs.github.io/assinaturas-docs/api.html#assinaturas)

Primeiro carregue o componente

```
public $components = array('MoipAssinaturas.Moip', 'MoipAssinaturas.Subscriptions');
```

Métodos de Exemplo utilizados no teste do plugin, para testar crie um controller e adicione esses métodos, depois acesse via browser.

```
	public function createSubscription() {
		$this->autoRender = false;
		$data = '{
				    "code": "assinatura05",
				    "amount": "9990",
				    "plan" : {
				        "code" : "PlanoGuitarpediaAnual"
				    },
				    "customer" : {
				    "code" : "cliente05"
				    }
				}';

		$new_client = false;
		$result = $this->Subscriptions->create($new_client, $data);
		pr($result);
	}

	public function createSubscriptionNewUser() {
		$this->autoRender = false;
		$data = '{
				    "code": "assinatura06",
				    "amount": "9990",
				    "plan": {
				        "code": "PlanoGuitarpediaAnual"
				    },
				    "customer": {
				        "code": "cliente04",
				        "email": "nome@exemplo.com.br",
				        "fullname": "Nome Sobrenome",
				        "cpf": "22222222222",
				        "phone_number": "934343434",
				        "phone_area_code": "11",
				        "birthdate_day": "26",
				        "birthdate_month": "04",
				        "birthdate_year": "1986",
				        "address": {
				            "street": "Rua nome da Rua",
				            "number": "170",
				            "complement": "Casa",
				            "district": "Bairro",
				            "city": "São Paulo",
				            "state": "SP",
				            "country": "BRA",
				            "zipcode": "00000000"
				        },
				        "billing_info": {
				            "credit_card": {
				                "holder_name": "Nome Completo",
				                "number": "4111111111111111",
				                "expiration_month": "04",
				                "expiration_year": "15"
				            }
				        }
				    }
				}';

		$new_client = true;
		$result = $this->Subscriptions->create($new_client, $data);
		pr($result);
	}

	public function updateSubscription($code) {
		$this->autoRender = false;
		$data = '{
				    "plan": {
				        "code": "mensal"
				    },
				    "amount": "9990",
				    "next_invoice_date": {
				        "day": "06",
				        "month": "02",
				        "year": "2015"
				    }
				}';

		$result = $this->Subscriptions->update($code, $data);
		pr($result);
	}

	public function listSubscriptions() {
		$this->autoRender = false;		
		
		$result = $this->Subscriptions->listAll();
		pr($result);
	}

	public function detailsSubscriptions($code = 0) {
		$this->autoRender = false;		
		
		$result = $this->Subscriptions->details($code);
		pr($result);
	}

	public function suspendSubscriptions($code = 0) {
		$this->autoRender = false;		
		
		$result = $this->Subscriptions->suspend($code);
		pr($result);
	}

	public function activateSubscriptions($code = 0) {
		$this->autoRender = false;		
		
		$result = $this->Subscriptions->activate($code);
		pr($result);
	}

	public function cancelSubscriptions($code = 0) {
		$this->autoRender = false;		
		
		$result = $this->Subscriptions->cancel($code);
		pr($result);
	}
```

### Exemplo de utilização faturas - [Documentação faturas](http://moiplabs.github.io/assinaturas-docs/api.html#faturas)

Primeiro carregue o componente

```
public $components = array('MoipAssinaturas.Moip', 'MoipAssinaturas.Invoices');
```

Métodos de Exemplo utilizados no teste do plugin, para testar crie um controller e adicione esses métodos, depois acesse via browser.

```
	public function listInvoices($code = 0) {
		$this->autoRender = false;		
		
		$result = $this->Invoices->listAll($code);
		pr($result);
	}

	public function detailsInvoice($id = 0) {
		$this->autoRender = false;		
		
		$result = $this->Invoices->details($id);
		pr($result);
	}
```

### Exemplo de utilização pagamentos - [Documentação pagamentos](http://moiplabs.github.io/assinaturas-docs/api.html#pagamentos)

Primeiro carregue o componente

```
public $components = array('MoipAssinaturas.Moip', 'MoipAssinaturas.Payments');
```

Métodos de Exemplo utilizados no teste do plugin, para testar crie um controller e adicione esses métodos, depois acesse via browser.

```
	public function listPayments($code = 0) {
		$this->autoRender = false;		
		
		$result = $this->Payments->listAll($code);
		pr($result);
	}

	public function detailsPayment($id = 0) {
		$this->autoRender = false;		
		
		$result = $this->Payments->details($id);
		pr($result);
	}
```

### Exemplo de utilização retentativas - [Documentação retentativas](http://moiplabs.github.io/assinaturas-docs/api.html#retentativas)

Primeiro carregue o componente

```
public $components = array('MoipAssinaturas.Moip', 'MoipAssinaturas.Retries');
```

Métodos de Exemplo utilizados no teste do plugin, para testar crie um controller e adicione esses métodos, depois acesse via browser.

```
	public function retry($id = 0) {
		$this->autoRender = false;		
		
		$result = $this->Retries->retry($id);
		pr($result);
	}

	public function setRules() {
		$this->autoRender = false;

		$data = '{
				    "first_try": 1,
				    "second_try": 3,
				    "third_try": 5,
				    "finally": "cancel"
				}';
		
		$result = $this->Retries->rules($data);
		pr($result);
	}
```

### Exemplo de utilização preferências - [Documentação preferências](http://moiplabs.github.io/assinaturas-docs/api.html#preferencias)

Primeiro carregue o componente

```
public $components = array('MoipAssinaturas.Moip', 'MoipAssinaturas.Preferences');
```

Métodos de Exemplo utilizados no teste do plugin, para testar crie um controller e adicione esses métodos, depois acesse via browser.

```
	public function preferences() {
		$this->autoRender = false;

		$data = '{
				    "notification": {
				        "webhook": {
				            "url": "http://exemploldeurl.com.br/assinaturas"
				        },
				        "email": {
				            "merchant": {
				                "enabled": true
				            },
				            "customer": {
				                "enabled": true
				            }
				        }
				    }
				}';
		
		$result = $this->Preferences->set($data);
		pr($result);
	}
```

## Webhooks - [Documentação do Webhooks](http://moiplabs.github.io/assinaturas-docs/webhooks.html)

Conforme descrição do Moip: *O Moip Assinaturas utiliza webhooks para notificar a sua aplicação em tempo real sobre os eventos que afetam os recursos da sua conta, como clientes, assinaturas, faturas e pagamentos.*

Com esse plugin, ele torna sua vida mais fácil para receber as notificações do Moip (NASP).

A primeira coisa a fazer é configurar o `tokenNasp` e o `activeWebhook` para habilitar seu funcionamento.

Exemplo:

```
Configure::write('MoipAssinaturas', array(
        'token' => 'Insira-seu-token-aqui',
        'key' => 'Insira-sua-chave-de-acesso-aqui',
        'isProd' => false,
        'tokenNasp' => 'Seu-token-aqui',
        'activeWebhook' => true,
    ));
```

Você também precisa configurar a URL de notificação para receber os webhooks no painel do Moip ou através do componente MoipAssinaturas::Preferences, a URL que deve ser informada é

```
http://seu-dominio/diretorio-seu-projeto/moip_assinaturas/webhooks
```

Todas as notificações que chegarem nesse endereço passarão por 3 verificações

1. Se o Webhook está ativado nas configurações
2. Se o Token do Nasp foi Configurado
3. Se o Token da Configurações é o mesmo do Header da Notificação

Se algum desse falhar vai gerar uma **Exception**.

Para utilizar os dados será necessário criar um Controller onde você poderá customizar ou tomar ações baseados nessas notificações, como por exemplo disparar um e-mail para o cliente ou gravar os dados no banco, baseado nos tipos das notificações. [Veja aqui os tipos](http://moiplabs.github.io/assinaturas-docs/webhooks.html)

**Nota Importante**: O controller você deverá criar no diretório app/Controller da sua aplicação e deverá ter o nome `NaspController` e possuir pelo menos um método que deverá se chamar `process`

Exemplo para NaspController onde o método process grava as informações recebidas no banco de dados.

```
<?php

App::uses('AppController', 'Controller');

class NaspController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array('Log');

/**
 * This controller has component
 *
 * @var array
 */
	public $components = array();

	public function process($data){
		$this->request->data['Log']['log'] = json_encode($data);
		
		if ($this->Log->save($this->request->data)) {
			echo 'Dados salvos com sucesso';
		} else {
			echo 'Ocorreu um erro ao salvar os dados';
		}
	}
}

```

## Bugs
Abra uma issue https://github.com/Bendit/moip-assinaturas-cakephp/issues/new

## Como contribuir

Contribuições são bem vindas

1. Fork it
2. Crie um novo branch (`git checkout -b my-new-feature`)
3. Commit suas features (`git commit -am 'Add some feature'`)
4. Push (`git push origin my-new-feature`)
5. Crie um novo Pull Request

## License

MIT License. See http://www.opensource.org/licenses/mit-license.php

Fábio Lima - Bendit - [fabio@bendit.com.br](mailto:fabio@bendit.com.br)

[Bendit - Web & Mobile](http://www.bendit.com.br)


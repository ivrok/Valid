# Valid
Simple field validator


```
$validator = new \Valid\Validator();

//add checking fields and rules
$validator->addFieldRules('idLembrete')->int();
$validator->addFieldRules('idNatDoc')->int();
$validator->addFieldRules('idTipo')->int();
$validator->addFieldRules('idEmissor')->int()->requred()->errMessage('Falta informar dados. Verifique!');
$validator->addFieldRules('detalhe')->string();
$validator->addFieldRules('dtCadastro')->date()->requred()->errMessage('Data de Cadastro deve ser!');
$validator->addFieldRules('dtVencimento')->date()->requred()->errMessage('Data de Vencimento deve ser!');
$validator->addFieldRules('valor')->float()->requred()->errMessage('Informe um Valor!');
$validator->addFieldRules('obs')->string();

//check array and get validated fields
$validPost = $validator->validArray($post);

//check if we got errors
$this->errorFields = $validator->getErrors();
```

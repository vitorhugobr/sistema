
<?php 
/*
 *	Função de busca de Endereço pelo CEP
 *	-	Desenvolvido Felipe Olivaes para ajaxbox.com.br
 *	-	Utilizando WebService de CEP da republicavirtual.com.br
 */
function busca_cep($cep){
	$resultado = @file_get_contents('http://republicavirtual.com.br/web_cep.php?cep='.urlencode($cep).'&formato=query_string');
	if(!$resultado){
		$resultado = "&resultado=0&resultado_txt=erro+ao+buscar+cep";
	}
	parse_str($resultado, $retorno); 
	return $retorno;
}
//Vamos buscar o CEP 
?>
  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br">
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
</head>
<body>
<?php
	$resultado_busca = busca_cep('95997000');

echo "<pre> Array Retornada:
 ".print_r($resultado_busca, true)."</pre>";

switch($resultado_busca['resultado']){
	case '2':
		$texto = "
	Cidade com logradouro único
	<b>Cidade: </b> ".$resultado_busca['cidade']."
	<b>UF: </b> ".$resultado_busca['uf']."
		";	
	break;
	
	case '1':
		$texto = "É 
	Cidade com logradouro completo
	<b>Tipo de Logradouro: </b> ".$resultado_busca['tipo_logradouro']."
	<b>Logradouro: </b> ".$resultado_busca['logradouro']."
	<b>Bairro: </b> ".$resultado_busca['bairro']."
	<b>Cidade: </b> ".$resultado_busca['cidade']."
	<b>UF: </b> ".$resultado_busca['uf']."
		";
	break;
	
	default:
		$texto = "Falha ao buscar cep: ".$resultado_busca['resultado'];
	break;
}

echo $texto;

	?>
</body>
</html>


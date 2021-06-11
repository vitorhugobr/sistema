<?php
// Inclui o arquivo com o sistema de segurança
require_once("seguranca.php");

// Verifica se um formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Salva duas variáveis com o que foi digitado no formulário
  // Detalhe: faz uma verificação com isset() pra saber se o campo foi preenchido
  $usuario = (isset($_POST['txt_usuario'])) ? $_POST['txt_usuario'] : '';
  $senha = (isset($_POST['txt_senha'])) ? $_POST['txt_senha'] : '';
  $usuario = mysqli_real_escape_string($_con, $usuario);
  $senha = mysqli_real_escape_string($_con, $senha);
  // Utiliza uma função criada no seguranca.php pra validar os dados digitados
  if (validaUsuario($usuario, $senha) == true) {
    // O usuário e a senha digitados foram validados, manda pra página interna
	gravar("users","L", $usuario,"Login Sistema");
	  
    header("Location: index2.php");
  } else {
    // O usuário e/ou a senha são inválidos, manda de volta pro form de login
    // Para alterar o endereço da página de login, verifique o arquivo seguranca.php
	$_SESSION['loginErro'] = "Usuário/Senha Inválidos!";
    expulsaVisitante();
  }
}
function gravar($tabela, $operacao, $usuario, $conteudo) {
	
	date_default_timezone_set('America/Sao_Paulo');
	
//	$data = date("d/m/Y", mktime(gmdate("d"), gmdate("m"), gmdate("Y")));
	$data = date('Y-m-d H:i:s');	
	$hora = date("H:i:s", mktime(gmdate("H")-3, gmdate("i"), gmdate("s")));	 

	// operacao
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($operacao) : $operacao;
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$operacao = $theValue;
	// conteudo
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($conteudo) : $conteudo;
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$conteudo = $theValue;
	// tabela
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($tabela) : $tabela;
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$tabela = $theValue;
	// usuario
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($usuario) : $usuario;
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$usuario = $theValue;
	// data
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($data) : $data;
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$data = $theValue;
	// hora
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($hora) : $hora;
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$hora = $theValue;
	
  // grava na tabela 'operacoes' transação realizada
	$strsqlo = 'INSERT into operacoes VALUES(NULL';
	$strsqlo .= ",".$data;
	$strsqlo .= ",".$hora;
	$strsqlo .= ",".$tabela;
	$strsqlo .= ",".$operacao;
	$strsqlo .= ",".$usuario;
	$strsqlo .= ",".$conteudo;
	$strsqlo .= ')';
	
	// Faz conexão com banco de dados
	$pdosqlo = new PDO("mysql:host=".$_SESSION['servidor'].";dbname=".$_SESSION['banco'].";",$_SESSION['usuario'], $_SESSION['senha']);
	$pdosqlo->exec("set names utf8");
	$pdosqlo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	array(PDO::ATTR_PERSISTENT => true);
	//echo $msgok;
	try{
		$statementSql = $pdosqlo->prepare($strsqlo);
		$statementSql->execute();
		return $statementSql->rowCount();;
	}catch(PDOException $e){
	  // Caso ocorra algum erro exibe a mensagem
		//die;
		return false;
	}
	$pdosqlo= null;
}

?>
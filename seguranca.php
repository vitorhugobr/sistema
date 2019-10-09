<?php
 
//  Configurações do Script
// ==============================
$_SG['conectaServidor'] = true;    // Abre uma conexão com o servidor MySQL?
$_SG['abreSessao'] = true;         // Inicia a sessão com um session_start()?
$_SG['caseSensitive'] = false;     // Usar case-sensitive? Onde 'thiago' é diferente de 'THIAGO'
$_SG['validaSempre'] = true;       // Deseja validar o usuário e a senha a cada carregamento de página?
// Evita que, ao mudar os dados do usuário no banco de dado o mesmo contiue logado.
//$_SG['servidor'] = 'localhost';    // Servidor MySQL
//$_SG['usuario'] = 'root';          // Usuário MySQL
//$_SG['senha'] = '';                // Senha MySQL
//$_SG['banco'] = 'sigre';            // Banco de dados MySQL
$_SG['paginaLogin'] = 'index.php'; // Página de login
$_SG['tabela'] = 'users';       // Nome da tabela onde os usuários são salvos
// Verifica se precisa iniciar a sessão
if ($_SG['abreSessao'] == true) {
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
}

// ==============================
include_once('connections/banco.php');
// Data no passado
// ======================================
//   ~ Não edite a partir deste ponto ~
// ======================================
// Verifica se precisa fazer a conexão com o MySQL
if ($_SG['conectaServidor'] == true) {
	$_SG['link'] = new mysqli($_SG['servidor'],$_SG['usuario'],$_SG['senha'],$_SG['banco']);	
if(!$_SG['link']) {  
	echo "Não foi possivel conectar ao MySQL. Erro " .
			mysqli_connect_errno() . " : " . mysql_connect_error();
	exit;
}

}
/**
* Função que valida um usuário e senha
*
* @param string $usuario - O usuário a ser validado
* @param string $senha - A senha a ser validada
*
* @return bool - Se o usuário foi validado ou não (true/false)
*/
function validaUsuario($usuario, $senha) {
  global $_SG;
  $cS = ($_SG['caseSensitive']) ? 'BINARY' : '';
  // Usa a função addslashes para escapar as aspas
  $nusuario = addslashes($usuario);
  $nsenha = addslashes($senha);
  $_SESSION['usuarioSenha'] = md5($nsenha);
  // Monta uma consulta SQL (query) para procurar um usuário
  $sql = "SELECT * FROM `".$_SG['tabela']."` WHERE ".$cS." `usuario` = '".$nusuario."' AND ".$cS." `senha` = '".md5($nsenha)."' LIMIT 1";
	try{
		// Faz conexão com banco de daddos
		$pdo = new PDO("mysql:host=".HOST.";dbname=".DB.";",USER, PASS);
		$pdo->exec("set names utf8");
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		array(PDO::ATTR_PERSISTENT => true);
	}catch(PDOException $e){
		// Caso ocorra algum erro na conexão com o banco, exibe a mensagem
		echo 'Função validaUsuario - Falha ao conectar no banco de dados: '.$e->getMessage();
		session_unset();
		session_destroy();
		session_start();

		die;
	}
	//echo $sql;
	$sql = $pdo->prepare($sql);
	$sql->execute();
	$total = $sql->rowCount();
	if($total==0){
    // Nenhum registro foi encontrado => o usuário é inválido
    	return false;
	}else{
		// Definimos a mensagem de erro
		while($dados = $sql->fetch()) {	
			$_SESSION['usuarioCodigo'] = $dados['codigo']; // Pega o valor da coluna 'id do registro encontrado no MySQL	
			$_SESSION['usuarioUser'] = $dados['usuario']; // Pega o valor da coluna 'nome' do registro encontrado no MySQL	
			$_SESSION['usuarioNivel'] = $dados['nivel']; // Pega o valor da coluna 'nivel' do registro encontrado no MySQL	
			$_SESSION['usuarioNome'] = $dados['nome']; // Pega o valor da coluna 'nome' do registro encontrado no MySQL
			$_SESSION['foto'] = $dados['foto']; // Pega o o nome do arquivo da foto
			$_SESSION['agenda'] = $dados['host_pol']; // Pega o o nome do arquivo da foto
			$nome = $_SESSION['usuarioNome'];
			$pieces = explode(" ", $nome);
			$primnome =  $pieces[0]; 
			$_SESSION['primnome'] = $primnome;
			$_SESSION['nometela'] = '<span class="badge">Usuário: '.$primnome.'</span>';

			//$_SESSION['codCadastro'] = $dados['codcadastro']; // Pega o valor da coluna 'codcadastro' do registro encontrado no MySQL		
		}
		return true;
	}
	// Verifica a opção se sempre validar o login
	if ($_SG['validaSempre'] == true) {
	// Definimos dois valores na sessão com os dados do login
		$_SESSION['usuarioLogin'] = $usuario;
		$_SESSION['usuarioSenha'] = md5($senha);
	}	
	$nivel = $_SESSION['usuarioNivel'];
	$nome = $_SESSION['usuarioNome'];
	$pieces = explode(" ", $nome);
	$primnome =  $pieces[0]; 
	$_SESSION['primnome'] = $primnome;
	$_SESSION['nometela'] = '<span class="badge">Usuário: '.$primnome.'</span>';
	return true;
}
/**
* Função que protege uma página
*/
function protegePagina() {
  global $_SG;
  if (!isset($_SESSION['usuarioCodigo']) OR !isset($_SESSION['usuarioNome'])) {
    // Não há usuário logado, manda pra página de login
    expulsaVisitante();
  } else if (!isset($_SESSION['usuarioCodigo']) OR !isset($_SESSION['usuarioNome'])) {
    // Há usuário logado, verifica se precisa validar o login novamente
    if ($_SG['validaSempre'] == true) {
      // Verifica se os dados salvos na sessão batem com os dados do banco de dados
      if (!validaUsuario($_SESSION['usuarioLogin'], $_SESSION['usuarioSenha'])) {
        // Os dados não batem, manda pra tela de login
        expulsaVisitante();
      }
    }
  }
}
/**
* Função para expulsar um visitante
*/
function expulsaVisitante() {
  global $_SG;
  // Remove as variáveis da sessão (caso elas existam)
  unset($_SESSION['usuarioCodigo'], $_SESSION['usuarioNome'], $_SESSION['usuarioLogin'], $_SESSION['usuarioSenha']);
  // Manda pra tela de login
//  header("Location: ".$_SG['paginaLogin']);
  header("Location: index.php");
}
/**
* Função para expulsar um visitante
*/
function expulsaVisitante2() {
  global $_SG;
  // Remove as variáveis da sessão (caso elas existam)
  unset($_SESSION['usuarioCodigo'], $_SESSION['usuarioNome'], $_SESSION['usuarioLogin'], $_SESSION['usuarioSenha']);
  $_SESSION['loginErro'] = "Usário não logado OU sem liberação para esta função!";
  // Manda pra tela de login
  header("Location: ../index.php");
}
function expulsaVisitante3() {
  global $_SG;
  // Remove as variáveis da sessão (caso elas existam)
  unset($_SESSION['usuarioCodigo'], $_SESSION['usuarioNome'], $_SESSION['usuarioLogin'], $_SESSION['usuarioSenha']);
  $_SESSION['loginErro'] = "Usário não logado OU sem liberação para esta função!";
  // Manda pra tela de login
  header("Location: ajax.php");
}


<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página

$_con  = new mysqli(HOST,USER,PASS,DB);

if(!$_con) {  
	echo "Não foi possivel conectar ao MySQL. Erro " .
			mysqli_connect_errno() . " : " . mysql_connect_error();
	exit;
}
	
$subj= 'Nada';
$theValue = (!get_magic_quotes_gpc()) ? addslashes($subj) : $subj;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$subj = $theValue;

$mensagem	 ='mensagem';
$theValue = (!get_magic_quotes_gpc()) ? addslashes($mensagem) : $mensagem;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$mensagem = $theValue;
	
$_sql = 'UPDATE controle_envio SET ';
$_sql .= 'lote_aberto = 0';
$_sql .= ', ultimo_registro = 0';
$_sql .= ', subject_email = '.$subj;
$_sql .= ', mensagem_email = '.$mensagem;
$_sql .= ' WHERE id=1';

$_res = $_con->query($_sql);

if(!$_res) {  
	echo "ERRO ao inicilizar arquivo lote!";
}else{
	echo "LOTE INICIALIZADO!";
}

$_con->close();

?>


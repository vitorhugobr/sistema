<?php
session_start();
require_once ('../utilitarios/funcoes.php');
$_SG['servidor'] = "www.vitor.poa.br";
$_SG['banco'] = "vitorpoa_teste";
$_SG['usuario'] = "vitorpoa_user";
$_SG['senha'] = "vhmo@2017";
$_con  = new mysqli($_SG['servidor'],$_SG['usuario'],$_SG['senha'],$_SG['banco']);	
if(!$_con) {  
	echo "Não foi possivel conectar ao MySQL. Erro " .
			mysqli_connect_errno() . " : " . mysql_connect_error();
	exit;
}
mysqli_set_charset($_con,"utf8");
mysqli_query($_con, "SET NAMES 'utf8'");
mysqli_query($_con, 'SET character_set_connection=utf8');
mysqli_query($_con, 'SET character_set_client=utf8');
mysqli_query($_con, 'SET character_set_results=utf8');
$arqconfig = "../".md5("mapa").".txt";
if (!file_exists($arqconfig)) {
	echo 'IMPOSSÍVEL ACESSAR O SISTEMA.<br>Arquivo de configuração excluído ou danificado! ';
	die;
} 	
$linhas = explode("\n", file_get_contents($arqconfig));
$id = $linhas[0]; // usuario =A(100,80);
$versao= $linhas[1];
$_sql = "SELECT * from config where id = ".$id;
$_res = $_con->query($_sql);
if($_res->num_rows==0) {
	echo "ERRO";
} else {
	$_row = $_res->fetch_assoc();	
	$indice = 1;
	foreach ($_row as $campo => $valor) {
		$_valor    = $valor;
		$_campo    = $campo;
		switch($indice) {
			case 1:
				$id_pol= $_valor;
				break;
			case 2:
				$politico= $_valor;
				break;
			case 3:	
				$end_pol= $_valor;
				break;
			case 4:
				$email_pol= $_valor;
				break;
			case 5:
				$cidade_pol= $_valor;
				break;
			case 6:
				$estado_pol= $_valor;
				break;
			case 7:
				$cep_pol= $_valor;
				break;
			case 8:
				$url_pol= $_valor;
				break;
			case 9:
				$endfoto= $_valor;
				break;
			case 10:
				$ativo= $_valor;
				break;
			case 11:
				$host_pol= $_valor;
				break;
			case 12:
				$email_retorno = $_valor;
				break;
			case 13:
				$login = $_valor;
				break;
			case 14:
				$password = $_valor;
				break;
			case 15:
				$fones = $_valor;
				break;
			case 16:
				$versao = $_valor;
				break;
			case 17:
				$partido = $_valor;
				break;
			case 18:
				$email2 = $_valor;
				break;
			case 19:
				$nome2 = $_valor;
				break;
			case 20:
				$email3 = $_valor;
				break;
			case 21:
				$nome3 = $_valor;
				break;
			case 22:
				$email4 = $_valor;
				break;
			case 23:
				$nome4 = $_valor;
				break;
			default:			
		}
		$indice++;
	}
}
//
include_once('../connections/banco.php');
//

$query = "select * from cdd";
$mysql_query = $_con->query($query);
$tot=0;
$atualizados="";
$strsql="";
while ($dados_s = $mysql_query->fetch_assoc()) {
	$cepi = $dados_s["inicial"];
	$cepf = $dados_s["final"];
	$reg = $dados_s["reg"];
	$strsql = 'UPDATE cep SET ';
	$strsql .= "REG =".$reg;
	$strsql .= " WHERE CEP BETWEEN $cepi AND $cepf;";
	echo $strsql."<br>";
}
$regsl = executa_sql($strsql,"","",false,false);
require_once("../phpmailer/class.phpmailer.php");
require_once("../phpmailer/class.smtp.php");
# Inicia a classe PHPMailer
$mail = new PHPMailer();
# Define os dados do servidor e tipo de conexão
$mail->IsSMTP(); // Define que a mensagem será SMTP
$mail->Host = "empregosnainternet.com.br"; # Endereço do servidor SMTP
$mail->Port = 587; // Porta TCP para a conexão
$mail->SMTPAuth = true; # Usar autenticação SMTP - Sim
$mail->Username = 'folder'; # Usuário de e-mail
$mail->Password = 'cfcd378b6'; // # Senha do usuário de e-mail
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->CharSet = "UTF-8";
$mail->smtpConnect(
	array(
		"ssl" => array(
		"verify_peer" => false,
		"verify_peer_name" => false,
		"allow_self_signed" => true
		)
	)
);
$mail->From = 'sigre@vitor.poa.br'; # e-mail remetente
$mail->FromName = 'Sistema SIGRE'; // nome remetente
$mail->IsHTML(true); # Define que o e-mail será enviado como HTML
$mail->AddAddress("vhmoliveira@gmail.com", "Vitor H M Oliveira"); # Os campos podem ser substituidos por variáveis
$mail->Subject = "Atualização CEPs - $politico"; # Assunto da mensagem
$mail->setFrom('sigre@vitor.poa.br', 'Sistema SIGRE');		
$mail->Body    = stripslashes($atualizados);
$mail->AltBody = stripslashes($atualizados);
$enviado = $mail->Send();
if ($enviado) {
	echo "Atualização de CEPs com sucesso!";
} else {
	echo "Não foi possível enviar atualização de CEPs.";
	echo "<b>Informações do erro:</b> " . $mail->ErrorInfo;
}
echo "TOTAL GERAL -> ".$tot;
?>
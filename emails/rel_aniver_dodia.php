<?php 

session_start();

include_once("../utilitarios/funcoes.php");

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
$_SESSION['id'] = $id;

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

echo 'id '.$id_pol.'<br>';
echo 'politico '.$politico.'<br>';
echo 'end_pol '.$end_pol.'<br>';
echo 'email_pol '.$email_pol.'<br>';

// conectar ao banco do usuário

include_once('../connections/banco.php');

//$datatoday  = date('d/m/Y', strtotime("+1 days"));	AUMENTA X DIAS NA DATA DE HOJE

$hoje  = date('d/m/Y');	

$datatoday = getdate();

$dia = $datatoday["mday"];

$mes = $datatoday["mon"];

$ano = $datatoday["year"];

//	echo $hoje;

$_sql='SELECT * from aniversarios where MES = '.$mes.' AND DIA = '.$dia.' ORDER BY NOME';

$_res = $_con->query($_sql);

$qtd_emails= 0;

$iniciohtml = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Relação de Aniversariantes do Dia</title>

</head>

<body>';

$pessoas='<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <caption><strong><font face="Verdana, Geneva, sans-serif" color="#000066" size="3"> 

    Aniversariantes do Dia</font></strong>

  </caption>

  <tr valign="top">

    <th width="7%" align="left" scope="col"><font face="Verdana, Geneva, sans-serif" size="2" color="#990000"><strong>C&oacute;digo</strong></font></th>

    <th width="55%" align="left" scope="col"><strong><font face="Verdana, Geneva, sans-serif" size="2" color="#990000">Nome<br />

Endere&ccedil;o<br />

E-mail<br />

Fones</font></strong></th>

  </tr>

  <tr>

    <td colspan="5"><hr /></td>

  </tr>';

$cor = 0;

$person = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Aniversariantes do Dia ".$hoje.":<br>";

if($_res->num_rows>0){

//		echo 'ENTROU Regs '.$_res->num_rows;

	while($_row = $_res->fetch_assoc()) {
		$qtd_emails= $qtd_emails + 1;
		$codigo = $_row["CODIGO"];
		$nome = $_row["NOME"];
		$person .= $nome.'<br>';			
		$foneres = $_row["FONE_RES"];
		$fonecel = $_row["FONE_CEL"];
		$fonecom = $_row["FONE_COM"];
		$email = $_row["EMAIL"];
		$dtnasc  = $_row["DTNASC"];
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($dtnasc) : $dtnasc;
		$theValue = ($theValue != "") ? " " . FormatDateTime($theValue,7) . "" : "___/___/____";
		$dtnasc = $theValue;
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($email) : $email;
		$theValue = ($theValue != "") ? " " . $theValue . " " : "<font color='#FF0004' style='ont-family: Verdana; font-style: italic; font-size: 12px;'><strong>*** SEM E-MAIL CADASTRADO ***</strong></font>";
		$email = $theValue;
		if ($_row["rua"]==""){
			$ender = "<font color='#FF0004' style='ont-family: Verdana; font-style: italic; font-size: 12px;'><strong>** SEM ENDEREÇO CADASTRADO **</strong></font>";
		}else{		
			$ender = $_row["tipolog"].' '.$_row["rua"].', '.$_row["numero"].' '.$_row["complemento"].' - '.$_row["bairro"].' - '.$_row["cidade"].' - '.substr($_row["cep"],0,5).'-'.substr($_row["cep"],5,3);
		}
		$pessoas .= '<tr align="left" valign="top">
    <td nowrap="nowrap"><strong>'.$codigo.'</strong></td>
    <td><strong>'.$nome.'</strong><br />
      '.$ender.'<br />
      <strong>'.$email.'</strong><br />
      '.$foneres.'&nbsp;&nbsp;'.$fonecel.'&nbsp;&nbsp;'.$fonecom.'</td></tr>';
	}

}

$pessoas .= '<tr><td colspan="2"><hr /></td></tr></table>';

$final = '<br><br><br><font color="#FF0004" style="font-family: Verdana; font-style: italic; font-size: 9px;">Este &eacute; um e-mail autom&aacute;tico disparado pelo sistema. Favor n&atilde;o respond&ecirc;-lo, pois esta conta n&atilde;o &eacute; monitorada. </font>';

if ($qtd_emails== 0){
	echo 'Não exitem aniversariantes em '.$hoje;
}else{
	if ($qtd_emails== 1){
		$mens_qtde = $iniciohtml.'01 aniversariante em '.$hoje.' conforme abaixo:<br><br>'.$pessoas.$final.'</body></html>';
	}else{
		$mens_qtde = $iniciohtml.'Existem '.$qtd_emails.' aniversariantes em '.$hoje.' conforme abaixo:<br><br>'.$pessoas.$final.'</body></html>';
	}
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
	$mail->AddAddress($email_pol, $politico); # Os campos podem ser substituidos por variáveis
	if (!empty($email2)){
		$mail->AddAddress($email2, $nome2); # Os campos podem ser substituidos por variáveis
	}
	if (!empty($email3)){
		$mail->AddAddress($email3, $nome3); # Os campos podem ser substituidos por variáveis
	}
	if (!empty($email4)){
		$mail->AddAddress($email4, $nome4); # Os campos podem ser substituidos por variáveis
	}
	$mail->Subject = 'Aniversariantes em ' .$hoje.' - '.$politico; # Assunto da mensagem
	$mail->setFrom('sigre@vitor.poa.br', 'Sistema SIGRE');		
	$mail->Body    = stripslashes($mens_qtde);
	$mail->AltBody = stripslashes($mens_qtde);
	$enviado = $mail->Send();
	if ($enviado) {
		echo "Relação de aniversariantes enviada com sucesso!";
	} else {
		echo "Não foi possível enviar a relação de aniversariantes.";
		echo "<b>Informações do erro:</b> " . $mail->ErrorInfo;
	}
}

?>
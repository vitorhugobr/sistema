<?php 
// TAREFA CRON NO SITE VITOR.POA
include_once("../utilitarios/funcoes.php");
$prg = $_SERVER['SCRIPT_NAME'];
$id = 1; // usuario =A(100,80);
$versao= '202011062100';

$id_pol= 1;
$politico= 'Dep. Dr Thiago Duarte';
#$email_pol= 'dr.thiago@al.rs.gov.br';
$email_pol = 'duharte@terra.com.br';

echo 'iniciando... '.$id_pol.'<br>';

// conectar ao banco do usuário

// conectar ao banco do usuário
$_SG['servidor'] = "191.252.101.58";
$_SG['banco'] = "drthiago_sigre";
$_SG['usuario'] = "sigre";
$_SG['senha'] = "sigre2018";

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
    <th width="7%" align="right" scope="col"><font face="Verdana, Geneva, sans-serif" size="2" color="#990000"><strong>C&oacute;digo&nbsp;</strong></font></th>
    <th width="93%" align="left" scope="col"><strong><font face="Verdana, Geneva, sans-serif" size="2" color="#990000">Nome<br />
Endere&ccedil;o<br />
E-mail<br />
Fones</font></strong></th>
  </tr>
  <tr>
    <td colspan="2"><hr /></td>
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
    <td width="7%" align="right"><strong>'.$codigo.'&nbsp;</strong></td>
    <td width="93%"><strong>'.$nome.'</strong><br />
      '.$ender.'<br />
      '.$email.'<br />
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
		$mens_qtde = $iniciohtml.$qtd_emails.' aniversariantes em '.$hoje.' conforme abaixo:<br><br>'.$pessoas.$final.'</body></html>';
	}
	$headers  = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=utf-8\r\n";
	$headers .= "From: Sistema Sigre<sigre@vitor.poa.br>\r\n";
	$subject = "E-mails para Aniversariantes - Dr Thiago"; # Assunto da mensagem
	$message = $mens_qtde;
	$to = $email_pol;
	#$to .= ', vhmoliveira@gmail.com';
	$enviado = mail($to, $subject, $message, $headers);
	if ($enviado) {
		echo "E-mail enviado";
	} else {
		$headers  = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=utf-8\r\n";
		$headers .= "From: Sistema Sigre<sigre@vitor.poa.br>\r\n";
		$subject = "Erro Rel Aniver Dia - Dr Thiago"; # Assunto da mensagem
		$message = 'Erro ao enviar e-mail com resumo de aniversariantes.<br>'.stripslashes($mens_qtde).'<br>'.$pessoas.'<br>'.$prg;//Pretty error messages from PHPMailer
		$to = 'Vitor H M Oliveira<vhmoliveira@gmail.com>';
		mail($to, $subject, $message, $headers);
		echo "Não foi possível enviar o e-mail - ".$prg;
	}	
}
?>
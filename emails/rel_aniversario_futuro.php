<?php 
// somente utilizado pelo Pujol = id=2
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

$_sql = "SELECT * from config where id = 2;";
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
			case 2:
				$politico= $_valor;
			case 3:	
				$end_pol= $_valor;
			case 4:
				$email_pol= $_valor;
			case 5:
				$cidade_pol= $_valor;
			case 6:
				$estado_pol= $_valor;
			case 7:
				$cep_pol= $_valor;
			case 8:
				$url_pol= $_valor;
			case 9:
				$endfoto= $_valor;
			case 10:
				$ativo= $_valor;
			case 11:
				$host_pol= $_valor;
			case 12:
				$email_retorno = $_valor;
			default:			
		}
		$indice++;
	}
}


// conectar ao banco do usuário

$_SG['servidor'] = "www.rpujol.com.br";
$_SG['banco'] = "rpujolco_pujol";
$_SG['usuario'] = "rpujolco_pujol";
$_SG['senha'] = "vhm@2019";

$_con  = new mysqli($_SG['servidor'],$_SG['usuario'],$_SG['senha'],$_SG['banco']);	

//$datatoday  = date('d/m/Y', strtotime("+1 days"));	AUMENTA X DIAS NA DATA DE HOJE
$hoje  = date('d/m/Y');	
$hoje  = date('d/m/Y', strtotime("+3 days"));	//AUMENTA X DIAS NA DATA DE HOJE

$datatoday = $hoje;

$dia = substr($hoje,0,2);

$mes = substr($hoje,3,2);

$ano = substr($hoje,6,4);

//echo "Hoje: ".$hoje."<br>Dia= ".$dia."<br>Mes= ".$mes."<br>Ano= ".$ano."<br>";

$_sql='SELECT * from aniversarios where MES = '.$mes.' AND DIA = '.$dia.' ORDER BY NOME';

//echo "Comando: ".$_sql."<br>";

$_res = $_con->query($_sql);

$qtd_emails= 0;

$iniciohtml = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Relação de Aniversariantes do Dia '.$hoje.'</title>
</head>
<body>';

$pessoas='<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <caption><strong><font face="Verdana, Geneva, sans-serif" color="#000066" size="3"> 
    Aniversariantes do Dia '.$hoje.'</font></strong>
  </caption>
  <tr valign="top">
    <th width="7%" align="left" scope="col"><font face="Verdana, Geneva, sans-serif" size="2" color="#990000"><strong>C&oacute;digo</strong></font></th>
    <th width="55%" align="left" scope="col"><strong><font face="Verdana, Geneva, sans-serif" size="2" color="#990000">Nome<br />
Endere&ccedil;o<br />
E-mail<br />
Data Nascimento<br>
Fones</font></strong></th>
  </tr>
  <tr>
    <td colspan="5"><hr /></td>
  </tr>';

$cor = 0;

if($_res->num_rows>0){
//		echo 'ENTROU Regs '.$_res->num_rows;
	while($_row = $_res->fetch_assoc()) {

		$qtd_emails= $qtd_emails + 1;

		$codigo = $_row["CODIGO"];

		$nome = $_row["NOME"];

		$foneres = $_row["FONE_RES"];

		$fonecel = $_row["FONE_CEL"];

		$fonecom = $_row["FONE_COM"];

		$email = $_row["EMAIL"];

		$dtnasc  = $_row["DTNASC"];

		$theValue = (!get_magic_quotes_gpc()) ? addslashes($dtnasc) : $dtnasc;
		$theValue = ($theValue != "") ? " " . FormatDateTime($theValue,7) . "" : "___/___/____";
		$dtnasc = $theValue;
		
		if ($email==""){
			$email= '<font color="#FF0004" style="font-family: Verdana; font-style: italic; font-size: 12px;"><strong>*** SEM E-MAIL CADASTRADO ***</strong></font>';			
		}
		$ender = $_row["tipolog"].' '.$_row["rua"].' '.$_row["numero"].' '.$_row["complemento"].' '.$_row["bairro"].' '.$_row["cidade"].' '.substr($_row["cep"],0,5).' '.substr($_row["cep"],5,3).'<br />';		
		$pessoas .= '<tr align="left" valign="top">
    <td nowrap="nowrap"><strong>'.$codigo.'</strong></td>
    <td><strong>'.$nome.'</strong><br />';
		if ($_row["rua"]>""){	
			$pessoas .= $ender;
		}else{
			$pessoas .= '<font color="#FF0004" style="font-family: Verdana; font-style: italic; font-size: 12px;"><strong>** SEM ENDEREÇO CADASTRADO **</strong></font><br />';			
		}
		$pessoas .= '<strong>'.$email.'</strong><br />'.$foneres.'&nbsp;'.$fonecel.'&nbsp;'.$fonecom.'</td>
  </tr>';
		//$pessoas .= $codigo.' - '.$nome.' -> fone(s)- '.$foneres.' - '.$fonecel.' - '.$fonecel.'<br>';
	}

}

$pessoas .= '  <tr>
    <td colspan="2"><hr /></td>
  </tr>
</table>';
$final = '<br><br><br><font color="#FF0004" style="font-family: Verdana; font-style: italic; font-size: 9px;">Este é um e-mail automático disparado pelo sistema. Favor não respondê-lo, pois esta conta não é monitorada. </font>';

if ($qtd_emails> 0){
	$pessoas = $iniciohtml.'<br>'.$pessoas.$final.'</body></html>';
	$subject = 'Relação Aniversariantes em ' .$hoje.' - Sistema SIGRE';

	$headers  = "MIME-Version: 1.0\r\n";

	$headers .= "Content-type: text/html; charset=utf-8\r\n";

	/* headers adicionais */
	
	#$to = "Vitor H M Oliveira <vhmoliveira@gmail.com>";

	$headers .= "From: Sistema SIGRE<sigre@vitor.poa.br>";
	$headers .= "To: Jorge Fraga<adm.jorgefraga@gmail.com>";

//	echo $pessoas;
//	echo '<br>'.$headers;
	
	if (mail($to, $subject, $pessoas, $headers)){
		//echo "Enviado";
	}else{
		echo "NÃO ENVIADO";
	}
}
echo $pessoas;
?>


<?php 
// somente utilizado pelo Pujol = id=2 --  CRON NO SITE PUJOL
include_once("../utilitarios/funcoes.php");

$versao= "4.0.3";

$id_pol= 1;
$politico= 'Emerson Correa';
$email_pol= 'veremerson@gmail.com';

// conectar ao banco do usuário
$_SESSION['servidor'] = "www.serverwebdb.com.br";
$_SESSION['banco'] = "chaplinb_chaplin";
$_SESSION['usuario'] = "chaplinb_chaplin";
$_SESSION['senha'] = "HpcOKYN7b2E-";

$_con  = new mysqli($_SESSION['servidor'],$_SESSION['usuario'],$_SESSION['senha'],$_SESSION['banco']);	
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

$datatoday = getdate();
$dia = $datatoday["mday"];
$mes = $datatoday["mon"];

require_once("../phpmailer/class.phpmailer.php");
require_once("../phpmailer/class.smtp.php");


$_con  = new mysqli($_SESSION['servidor'],$_SESSION['usuario'],$_SESSION['senha'],$_SESSION['banco']);	

//$datatoday  = date('d/m/Y', strtotime("+1 days"));	AUMENTA X DIAS NA DATA DE HOJE
$hoje  = date('d/m/Y');	
$hoje  = date('d/m/Y', strtotime("+3 days"));	//AUMENTA X DIAS NA DATA DE HOJE

$datatoday = $hoje;

$dia = substr($hoje,0,2);

$mes = substr($hoje,3,2);

$ano = substr($hoje,6,4);

echo "Hoje: ".$hoje."<br>Dia= ".$dia."<br>Mes= ".$mes."<br>Ano= ".$ano."<br>";

//$_sql = 'select * from aniversarios_email  where ((MES= '.$mes.') AND (DIA = '.$dia.') and (`RECEBEMAIL` = 1) and (`EMAIL` > "A") and (`CONDICAO` = 1))';
$_sql = 'select * from aniversarios_email where ((`CODIGO` = 11650))';

echo "Comando: ".$_sql."<br>";

$_res = $_con->query($_sql);

$qtd_emails= 0;

$cor = 0;
$iniciohtml = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Relação de Aniversariantes do Dia</title>
</head>
<body>';

if($_res->num_rows>0){
	echo 'ENTROU Regs '.$_res->num_rows;
	while($_row = $_res->fetch_assoc()) {
		$qtd_emails= $qtd_emails + 1;
		$codigo = $_row["CODIGO"];
		$apelido = $_row["APELIDO"];
		$nome = $_row["NOME"];
		$pieces = explode(" ", $nome);
		if ($apelido > "A"){
			$primnome = $apelido;
		}else{
			$primnome =  $pieces[0]; 
		}
		$sexo = $_row["SEXO"];
		$email = $_row["EMAIL"];
		if ($sexo=="M"){
			$genero="o";
		}else{
			$genero="a";
		}
		$mensagem = '<html>
				<head>
				<title>Parabéns</title>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
				</head>
				<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
				<!-- Save for Web Slices (niver1.psd) -->
				<table id="Tabela_01" width="750" height="540" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td align="center" colspan="6" background="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_01.jpg" width="750" height="90" alt="">
										<font face="Tahoma, Geneva, sans-serif" size="+10" color="#07FA17" 
										style="marquee-speed:normal"><strong>'.$primnome.'</strong></font>
						<td >
					</tr>
					<tr>
						<td>
							<img style="display:block" border="0" src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_02.gif" width="125" height="90" alt=""></td>
						<td>
							<img style="display:block" border="0" src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_03.gif" width="125" height="90" alt=""></td>
						<td>
							<img style="display:block" border="0" src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_04.gif" width="125" height="90" alt=""></td>
						<td>
							<img style="display:block" border="0" src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_05.gif" width="125" height="90" alt=""></td>
						<td>
							<img style="display:block" border="0" src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_06.gif" width="125" height="90" alt=""></td>
						<td>
							<img style="display:block" border="0" src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_07.gif" width="125" height="90" alt=""></td>
					</tr>
					<tr>
						<td>
							<img style="display:block" border="0" src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_08.gif" width="125" height="90" alt=""></td>
						<td>
							<img style="display:block" border="0" src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_09.gif" width="125" height="90" alt=""></td>
						<td>
							<img style="display:block" border="0" src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_10.gif" width="125" height="90" alt=""></td>
						<td>
							<img style="display:block" border="0" src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_11.gif" width="125" height="90" alt=""></td>
						<td>
							<img style="display:block" border="0" src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_12.gif" width="125" height="90" alt=""></td>
						<td>
							<img style="display:block" border="0" src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_13.gif" width="125" height="90" alt=""></td>
					</tr>
					<tr>
						<td>
							<img style="display:block" border="0" src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_14.gif" width="125" height="89" alt=""></td>
						<td>
							<img style="display:block" border="0" src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_15.gif" width="125" height="89" alt=""></td>
						<td>
							<img style="display:block" border="0" src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_16.gif" width="125" height="89" alt=""></td>
						<td>
							<img style="display:block" border="0" src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_17.gif" width="125" height="89" alt=""></td>
						<td>
							<img style="display:block" border="0" src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_18.gif" width="125" height="89" alt=""></td>
						<td>
							<img style="display:block" border="0" src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_19.gif" width="125" height="89" alt=""></td>
					</tr>
					<tr>
						<td>
							<img style="display:block" border="0" src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_20.gif" width="125" height="90" alt=""></td>
						<td>
							<img style="display:block" border="0" src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_21.gif" width="125" height="90" alt=""></td>
						<td>
							<img style="display:block" border="0" src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_22.gif" width="125" height="90" alt=""></td>
						<td>
							<img style="display:block" border="0" src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_23.gif" width="125" height="90" alt=""></td>
						<td>
							<img style="display:block" border="0" src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_24.gif" width="125" height="90" alt=""></td>
						<td>
							<img style="display:block" border="0" src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_25.gif" width="125" height="90" alt=""></td>
					</tr>
					<tr>
						<td>
							<img style="display:block" border="0" src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_26.gif" width="125" height="90" alt=""></td>
						<td>
							<img style="display:block" border="0" src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_27.gif" width="125" height="90" alt=""></td>
						<td>
							<img style="display:block" border="0" src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_28.gif" width="125" height="90" alt=""></td>
						<td>
							<img style="display:block" border="0" src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_29.gif" width="125" height="90" alt=""></td>
						<td>
							<img style="display:block" border="0" src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_30.gif" width="125" height="90" alt=""></td>
						<td>
							<img style="display:block" border="0" src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_31.gif" width="125" height="90" alt=""></td>
					</tr>
				</table>
				<!-- End Save for Web Slices -->
				<table width="100%" border="0" align="center">  <tr>    <td width="100%"><hr />      
					<p><font face="Verdana, Arial" size=1><font color=#808080>
					<b>OBS:</b> Voc&ecirc; est&aacute; recebendo este e-mail porque est&aacute; cadastrado para tal. Caso voc&ecirc; n&atilde;o deseje mais receber nenhum tipo de contato nosso, 
					</font><a title=mailto:'.$email_pol.'?subject=REMOVER href="mailto:'.$email_pol.'?subject=REMOVER">
					<font title=mailto:'.$email_pol.'?subject=REMOVER color=#0000ff>clique aqui</font></a>
					<font color=#808080>, ou  envie um e-mail para <b>
					<a title=mailto:'.$email_pol.' href="mailto:'.$email_pol.'?subject=REMOVER">'.$email_pol.'</a>
					</b> com o assunto REMOVER.<br>  Para garantir o recebimento de nossas mensagens, inclua nosso e-mail em seus contatos.</font>
					</font></p></td></tr>
				</table>

				</body>
				</html>';	
		$pessoas 'Email para '.$nome.' '.$email.'<br>';

		$subject = 'Parabéns '.$primnome;

		$headers  = "MIME-Version: 1.0\r\n";

		$headers .= "Content-type: text/html; charset=utf-8\r\n";

		/* headers adicionais */
	
		$to = $email;

		$headers .= "From: Emerson Correa <veremerson@gmail.com>";
	
		if (mail($to, $subject, $mensagem, $headers)){
			//echo "Enviado";
		}else{
			echo "NÃO ENVIADO";
		}

	}
}

$final = '<br><br><br><font color="#FF0004" style="font-family: Verdana; font-style: italic; font-size: 9px;">Este &eacute; um e-mail autom&aacute;tico disparado pelo sistema. Favor n&atilde;o respond&ecirc;-lo, pois esta conta n&atilde;o &eacute; monitorada. </font>';

if ($qtd_emails> 0){
	$pessoas = $iniciohtml.'<br>'.$pessoas.''.$final.' </body></html>';
	$subject = 'Aniversariantes em ' .$hoje.' - Sistema SIGRE';

	$headers  = "MIME-Version: 1.0\r\n";

	$headers .= "Content-type: text/html; charset=utf-8\r\n";

	/* headers adicionais */
	
	$to = "Vitor H M Oliveira <vhmoliveira@gmail.com>";

	$headers .= "From: Emerson Correa <veremerson@gmail.com>";

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
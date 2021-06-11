<?php 
session_start();

include('../connections/banco.php');

$politico = 'Reginaldo Pujol';
$email_pol ='vereadorpujol@gmail.com';
$datatoday = getdate();
$dia = $datatoday["mday"];
$mes = $datatoday["mon"];
// ARQUIVO DE CONTROLE DE ENVIO
$_sql = "SELECT * from controle_envio WHERE id=1 and lote_aberto = 0;";
$_res = $_con->query($_sql);
if($_res->num_rows==0) {
	echo "Lote fechado ou ERRO";
} else {
	$_row = $_res->fetch_assoc();	
	$indice = 1;
	foreach ($_row as $campo => $valor) {
		$_valor    = $valor;
		$_campo    = $campo;
		switch($indice) {
			case 1:
				$id = $_valor;
			case 2:	
				$lote_aberto= $_valor;
			case 3:
				$ultimo_registro = $_valor;
			case 4:
				$subj = $_valor;
			case 5:
				$mensagem = $_valor;
			default:			
		}
		$indice++;
	}
	echo $lote_aberto.'<br>';
	echo 'registros ...'.$_res->num_rows.'<br>';

	$_sql = 'SELECT * FROM cadastro_email limit '.$ultimo_registro.', 25';
	// INIBIR LINHA ABAIXO QDO EM PRODUTO
	//$_sql = 'SELECT * FROM cadastro_email WHERE codigo=11650';
	$_res = $_con->query($_sql);
	$qtd_emails= 0;
	$pessoas="";
	if($_res->num_rows>0){
		while($_row = $_res->fetch_assoc()) {
			$qtd_emails= $qtd_emails + 1;
			$codigo = $_row["codigo"];
			$nome = $_row["nome"];
			$pieces = explode(" ", $nome);
			$primnome =  $pieces[0]; 
			$email = $_row["email"];
			$to = $email;
			/* assunto */
			//$subject = $subj." ".$primnome;
			$subject = 'Posse Presidente Câmara Municipal de Porto Alegre';
			/* mensagem */
			$message = '<html>
			<head>
			<title>Convite Posse Pujol</title>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			</head>
			<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
			<!-- Save for Web Slices (convite_pujol.jpg) -->
			<table id="Tabela_01" width="785" height="555" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<img style="display:block" border="0" src="https://www.rpujol.com.br/sigre/emails/images/convite_pujol_01.jpg" width="263" height="111" alt=""></td>
					<td>
						<img style="display:block" border="0" src="https://www.rpujol.com.br/sigre/emails/images/convite_pujol_02.jpg" width="263" height="111" alt=""></td>
					<td>
						<img style="display:block" border="0" src="https://www.rpujol.com.br/sigre/emails/images/convite_pujol_03.jpg" width="263" height="111" alt=""></td>
				</tr>
				<tr>
					<td>
						<img style="display:block" border="0" src="https://www.rpujol.com.br/sigre/emails/images/convite_pujol_04.jpg" width="263" height="111" alt=""></td>
					<td>
						<img style="display:block" border="0" src="https://www.rpujol.com.br/sigre/emails/images/convite_pujol_05.jpg" width="263" height="111" alt=""></td>
					<td>
						<img style="display:block" border="0" src="https://www.rpujol.com.br/sigre/emails/images/convite_pujol_06.jpg" width="263" height="111" alt=""></td>
				</tr>
				<tr>
					<td>
						<img style="display:block" border="0" src="https://www.rpujol.com.br/sigre/emails/images/convite_pujol_07.jpg" width="263" height="111" alt=""></td>
					<td>
						<img style="display:block" border="0" src="https://www.rpujol.com.br/sigre/emails/images/convite_pujol_08.jpg" width="263" height="111" alt=""></td>
					<td>
						<img style="display:block" border="0" src="https://www.rpujol.com.br/sigre/emails/images/convite_pujol_09.jpg" width="263" height="111" alt=""></td>
				</tr>
				<tr>
					<td>
						<img style="display:block" border="0" src="https://www.rpujol.com.br/sigre/emails/images/convite_pujol_10.jpg" width="263" height="111" alt=""></td>
					<td>
						<img style="display:block" border="0" src="https://www.rpujol.com.br/sigre/emails/images/convite_pujol_11.jpg" width="263" height="111" alt=""></td>
					<td>
						<img style="display:block" border="0" src="https://www.rpujol.com.br/sigre/emails/images/convite_pujol_12.jpg" width="263" height="111" alt=""></td>
				</tr>
				<tr>
					<td>
						<img style="display:block" border="0" src="https://www.rpujol.com.br/sigre/emails/images/convite_pujol_13.jpg" width="263" height="111" alt=""></td>
					<td>
						<img style="display:block" border="0" src="https://www.rpujol.com.br/sigre/emails/images/convite_pujol_14.jpg" width="263" height="111" alt=""></td>
					<td>
						<img style="display:block" border="0" src="https://www.rpujol.com.br/sigre/emails/images/convite_pujol_15.jpg" width="263" height="111" alt=""></td>
				</tr>
			</table>
			<!-- End Save for Web Slices -->
			</body>
			</html>';
			/* Para enviar email HTML, voc precisa definir o header Content-type. */
			$headers  = "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html; charset=utf-8\r\n";
			/* headers adicionais */
			$headers .= "From: ".$politico." <".$email_pol.">\r\n";
			/* Enviar o email */
			if (mail($to, $subject, $message, $headers)) {
				$pessoas .= $codigo." - ".$nome.' - '.$email.' OK<br>';
			}else{
				$pessoas .= "E R R O  --> ".$codigo." - ".$email."<br>";
			}
			echo 'Disparou email para: '.$nome.'<br>';
			// incluir na tabela de visitas como contato feito						

		}
		$ult_enviado = $ultimo_registro + 25;		//ALTERA O ARQUIVO controle_envio
		$strsql6 = 'UPDATE controle_envio SET ultimo_registro = '.$ult_enviado.' where id=1';
		$_res5 = $_con->query($strsql6);
		if (!$_res5){
			$mens_qtde = 'ERRO UPADTE ARQUIVO '. mysql_error($_con).'<br>';  
			echo 'ERRO UPADTE ARQUIVO '. mysql_error($_con).'<br>';  
		}else{
			$mens_qtde='';
		}
		if ($qtd_emails== 0){
			$mens_qtde .= 'Nenhuma mensagem enviada em '.date("d/m/Y");
		}else{
			if ($qtd_emails== 1){
				$mens_qtde .= 'Foi enviada 01 mensagem de lote em '.date("d/m/Y").' com o assunto: '.$subject.', conforme abaixo:<br>'.$pessoas;
			}else{
				$mens_qtde .= 'Foram enviadas '.$qtd_emails.' mensagens de lote em '.date("d/m/Y").' com o assunto: '.$subject.', conforme abaixo:<br>'.$pessoas;
			}
		}
		echo $mens_qtde;
		$headers  = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=utf-8\r\n";
		/* headers adicionais */
		$to = "Vitor H M Oliveira <vhmoliveira@gmail.com>";
		//$headers .= "To: Vitor H M Oliveira <vhmoliveira@gmail.com>\r\n";
		$headers .= "From: ".$politico." <".$email_pol.">\r\n";
		$subject = "Resumo e-mails enviados - LOTE - Ult. Enviado : ".$ult_enviado;
//		echo $mens_qtde;
		if (mail($to, $subject, $mens_qtde, $headers)){
			echo 'enviado e-mail pra mim<br>';
		}
		$_con->close();	
	}else{
		//echo "Lote ENCERRADO";
		//ALTERA O ARQUIVO controle_envio
		$strsql6 = "UPDATE controle_envio SET lote_aberto = 1 where id=1";
		$_res5 = $_con->query($strsql6);
	}
}	
?>
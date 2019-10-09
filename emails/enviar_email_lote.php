<?php 
include('../connections/banco.php');
include ("../utilitarios/phpmkrfn.php");
$_con  = new mysqli(HOST,USER,PASS,DB);
if(!$_con) {  
	echo "Não foi possivel conectar ao MySQL. Erro " .
			mysqli_connect_errno() . " : " . mysql_connect_error();
	exit;
}
$_sql = "SELECT * from config WHERE id = 1;";
$_res = $_con->query($_sql);
if($_res->num_rows==0) {
	echo "ERRO";
} else {
	$_row = $_res->fetch_assoc();	
	/* os campos da tabela TABLE `config` (
  `politico` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `end_pol` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_pol` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `cidade_pol` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `estado_pol` char(2) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `cep_pol` varchar(8) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `id` int(4) NOT NULL DEFAULT '0',
  `endurl` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `endfoto` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `ativo` int(1) NOT NULL,
  `host` varchar(20) DEFAULT NULL,
  `email_retorno` varchar(20) DEFAULT NULL,
  `login` varchar(20) DEFAULT NULL,
  `passw` varchar(20) DEFAULT NULL,
  `telefones` varchar(35) DEFAULT NULL,
  PRIMARY KEY (`id`) */
	$indice = 1;
	foreach ($_row as $campo => $valor) {
		$_valor    = $valor;
		$_campo    = $campo;
		switch($indice) {
			case 1:
				$politico= $_valor;
			case 2:	
				$end_pol= $_valor;
			case 3:
				$email_pol= $_valor;
			case 4:
				$cidade_pol= $_valor;
			case 5:
				$estado_pol= $_valor;
			case 6:
				$cep_pol= $_valor;
			default:			
		}
		$indice++;
	}
}
echo $politico.'<br>';
echo $email_pol.'<br>';
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
			$subject = $subj;
			/* mensagem */
			$message = '<font size="4"><strong>'.$primnome.'</strong></font>'.$mensagem;
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
		//ALTERA O ARQUIVO controle_envio
		$ult_enviado = $ultimo_registro + 25;
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




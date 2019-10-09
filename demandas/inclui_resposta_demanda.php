<?php 
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
require_once ('../utilitarios/funcoes.php');

$id = "NULL";
$numero = $_GET['numero'];
$retorno = $_GET['retorno'];
$enviar_email = $_GET['enviar_email'];
$ccemail = $_GET['ccemail'];
$num_tarefa = $_GET['num_tarefa'];	
$data_demanda = $_GET['data_demanda'];	
//
$theValue = (!get_magic_quotes_gpc()) ? addslashes($retorno) : $retorno;
$theValue = ($theValue != '') ? ' "' . $theValue . '"' : "NULL";
$retorno = strtoupper($theValue);

//$resposta = htmlspecialchars($resposta);
$usuarioresp = $_SESSION["usuarioUser"];
$resto="";
// atualiza o encaminhamento como respondido
$_sql = "Update encaminhamentos set situacao = 1 where numero = ".$numero;
executa_sql($_sql,"","",false,false); 

date_default_timezone_set('America/Sao_Paulo');
if ($num_tarefa>0){
	//Vê se tarefa já foi iniciada
	$strbusca = "SELECT * FROM `historico_tarefas` where cod_tarefa = ".$num_tarefa;
	$qtdregbusca = executa_sql($strbusca,"","",false,false);
	if ($qtdregbusca==0){
		$retornofirst = '* INICIADA *';
		$strsqltarefai = "INSERT INTO `historico_tarefas` VALUES (NULL,";
		$strsqltarefai .= $num_tarefa.",'".date("Y-m-d H:i:s")."','".$retornofirst."'";
		$strsqltarefai .= ")";
		//echo "Busca hist tarefa = ".$strsqltarefai."<br>";
		$retornotarefai = executa_sql($strsqltarefai,"","",false,false);
		//echo $retornotarefai."<br>";
		$strsql = 'UPDATE tarefas SET ';
		$strsql .= "data_inicio ='".date("Y-m-d H:i:s")."'";
		$strsql .= ' WHERE id='.$num_tarefa;
		//echo $strsql."<br>";
		$ret = executa_sql($strsql,"","",false,false);
		//echo $ret."<br>";
	}
	// insere no banco
	$strsqltarefa = "INSERT INTO `historico_tarefas` VALUES (NULL,";
	$strsqltarefa .= $num_tarefa.",'".date("Y-m-d H:i:s")."',".$retorno;
	$strsqltarefa .= ")";
	$retornotarefa = executa_sql($strsqltarefa,"Histórico da Tarefa incluída com sucesso","Histórico da Tarefa NÃO incluída",false,false); 
}
//=========================================================================================
$strsql = "INSERT INTO `historico_encaminhamentos` VALUES (NULL,";
$strsql .= $numero.",'".date("Y-m-d H:i:s")."',".$retorno.",'".$usuarioresp."'";
$strsql .= ")";
$retorno = executa_sql($strsql,"Resposta da Demanda incluída com sucesso","Resposta NÃO incluída",true,true); 
if (($enviar_email=="true") OR ($ccemail<>"")){
	$email="";
	$primnome =  "Atenção"; 
	if ($enviar_email=="true"){
		$_sql = 'SELECT cadastro.NOME, cadastro.CODIGO, cadastro.EMAIL, encaminhamentos.data, encaminhamentos.numero FROM cadastro INNER JOIN encaminhamentos ON cadastro.CODIGO = encaminhamentos.codigo ';
		$_sql .= 'where encaminhamentos.numero = '.$numero;
		$_res = $_con->query($_sql);	
		if($_res->num_rows>0){
			while($_row = $_res->fetch_assoc()) {
				$nome = $_row["NOME"];
				$pieces = explode(" ", $nome);
				$primnome =  $pieces[0]; 
				$email = $_row["EMAIL"];
				$data = FormatDateTime($_row["data"],7);
			}
		}
	}

	/* assunto */
	$subject = "Sua demanda nro ".$numero." do dia ".$data_demanda." - RESPOSTA";

	/* mensagem */
	$message = '<html xmlns="http://www.w3.org/1999/xhtml"><head>	 <title>Resposta de Demanda</title>	 <style type="text/css">	
	<!--	.style54 {	color: #000000;	font-weight: bold;	font-size: 18;	font-family: Arial, Helvetica, sans-serif;}.style65 {font-size: 18px}.style69 {font-size: 18px; color: #000000; }.style75 {	font-size: 16px;	font-family: Arial, Helvetica, sans-serif;	font-weight: bold;	color: #F00;}.style76 {	font-size: 36px;	font-style: italic;	font-weight: bold;	color: #FF0000;	font-family: Verdana, Arial, Helvetica, sans-serif;}.style75 strong {	color: #3F0;}.style75 strong em {	color: #00F;}body,td,th {	color: #000;}-->	 	
	</style>	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>	<body><p align="center" class="style76">'.$_SESSION['politico'].'</p><p><span class="style54"><span class="style65">'.$primnome.'</span>, </span>	  <span class="style69">sua solicita&ccedil;&atilde;o cujo encaminhamento recebeu o  n&uacute;mero  '.$numero.' inclu&iacute;da no dia '.$data_demanda.', teve como resposta parcial/final o seguinte:</span><br>    <span class="style75"><strong><em>'.$retorno.'</em></strong><em></em></span></p>
	<p class="style69">Qualquer d&uacute;vida, entre em contato pelos fones '.$_SESSION['fones_pol'].' ou pelo e-mail '.$_SESSION['email_pol'].'</p><p class="style69">Obrigado,</p><p align="center" class="style69"><span class="style75">'.$_SESSION['politico'].'</span></p></body>		</html>';		
			/* Para enviar email HTML, voc� precisa definir o header Content-type. */
//---------------------------enviando e-mail pelo PHPMailer -----------------------------------------

		require_once("../phpmailer/class.phpmailer.php");
		require_once("../phpmailer/class.smtp.php");
		$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
		try {
			//Server settings
			$mail->SMTPDebug = 0;                                 // Enable verbose debug output
			$mail->isSMTP();                                      // Set mailer to use SMTP
			$mail->Host = 'empregosnainternet.com.br';			  // Specify main and backup SMTP servers
			$mail->SMTPAuth = true;                               // Enable SMTP authentication
			$mail->Username = 'folder';			                 // SMTP username
			$mail->Password = 'cfcd378b6';                       // SMTP password
			$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
			$mail->Port = 587;                                    // TCP port to connect to
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
			$mail->Subject =$primnome." ".$subject;
			$mail->From= $_SESSION['email_pol'];//email do remetente
			$mail->FromName=$_SESSION['politico'];//nome do remetente
			//$mail->AddCC("vhmoliveira@gmail.com", "Vitor Gmail");//email do desenvolvedor
			if ($enviar_email=="true"){
				$mail->AddAddress($email, $nomeusuario);//email do destinatario
			}
			if ($ccemail<>""){
				$mail->AddAddress($ccemail, "");//email do destinatario
			}
			//Recipients
			$mail->setFrom($_SESSION['email_pol'], $_SESSION['politico']);

			//Attachments
		//    $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
		//    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

			//Content
			$mail->isHTML(true);                                  // Set email format to HTML
			$mail->Body    = stripslashes($mensagem);
			$mail->AltBody = stripslashes($mensagem);

			$mail->send();
			$_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Resposta de Demanda incluída com sucesso e e-mail enviado para ".$nomeusuario."<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";		
		} catch (Exception $e) {
			$_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Resposta de Demanda foi incluída mas NÃO foi possível enviar e-mail. Motivo: ".$mail->ErrorInfo."<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";		
		}
//--------------------------------------------------------------------	
}
//echo "<br><br><br><br>".$strsql;

?>
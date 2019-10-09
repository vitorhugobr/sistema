<?php 
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
require_once ('../utilitarios/funcoes.php');
$usuario = $_GET['usuario'];
$priority = $_GET['priority'];
$assunto = $_GET['assunto'];
$tarefa = $_GET['tarefa'];
$tarefa_email= $tarefa;
$email = $_GET['email'];
$chkemail = $_GET['chkemail'];
$dttarefa = new DateTime();
$dttarefa = $dttarefa->format( "d/m/Y H:i" );

// id
$id = "NULL";

$nomeusuario = busca_user($usuario);
$pieces = explode(" ", $nomeusuario);
$primnome =  $pieces[0]; 

// usuario
$theValue = (!get_magic_quotes_gpc()) ? addslashes($usuario) : $usuario;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$usuario = $theValue;

// DTCAD
$theValue = (!get_magic_quotes_gpc()) ? addslashes($dttarefa) : $dttarefa;
$theValue = ($theValue != "") ? " '" . ConvertDateToMysqlFormat($theValue) . "'" : "NULL";
$dttarefa = $theValue;

// assunto
$theValue = (!get_magic_quotes_gpc()) ? addslashes($assunto) : $assunto;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$assunto = $theValue;

// tarefa
$theValue = (!get_magic_quotes_gpc()) ? addslashes($tarefa) : $tarefa;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$tarefa = $theValue;

// datainicio
$dtinicio = "NULL";

// datafim
$dtfim = "NULL";

// status
$status = 0;
$theValue = (!get_magic_quotes_gpc()) ? addslashes($status) : $status;
$theValue = ($theValue != "") ? intval($theValue) : "NULL";
$status = $theValue;

// prioridade
$theValue = (!get_magic_quotes_gpc()) ? addslashes($priority) : $priority;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$priority = $theValue;

$_sql = "Insert into tarefas values(".$id.",".$dttarefa.",".$usuario.",".$assunto.",".$tarefa.",".$dtinicio.",".$dtfim.",".$status.",".$priority.", NULL)";
$ret = executa_sql($_sql,"Tarefa incluída com sucesso!","Tarefa NÃO incluída",true,true);

$_SESSION['mudoutarefa'] = true;

if ($ret>0){
	if ($chkemail) {
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
			$mensagem='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br">
			<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<meta http-equiv="X-UA-Compatible" content="IE=edge">
				<meta name="viewport" content="width=device-width, initial-scale=1">
				<meta name="author" content="Vitor H M Oliveira">
				<title>Tarefas</title>
				</head>
			<body>
			<h4><strong style="color: #0422D1;">'.$nomeusuario.'</strong></h4>
			<p style="font-size: 14px; font-family: "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "DejaVu Sans", Verdana, sans-serif;">Uma nova tarefa foi designada para você pelo Gabinete.</p>
			<p style="font-size: 16px; color: teal; font-style: italic; font-weight: bold;">'.$tarefa_email.'</p>
			<p style="font-size: 14px; font-family: "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "DejaVu Sans", Verdana, sans-serif;">Acesse o sistema para maiores informações. <br />
			Qualquer dúvida, entrar em contato.</p>
			<p  style="font-size: 14px; font-family: "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "DejaVu Sans", Verdana, sans-serif;">'.$_SESSION['politico'].'</p>
			</body>
			</html>';
			$mail->Subject =$primnome." - Nova Tarefa do Gabinete";
			$mail->From= $_SESSION['email_pol'];//email do remetente
			$mail->FromName=$_SESSION['politico'];//nome do remetente
			//$mail->AddCC("vhmoliveira@gmail.com", "Vitor Gmail");//email do desenvolvedor
			$mail->AddAddress($email, $nomeusuario);//email do destinatario
			//Recipients
			$mail->setFrom($_SESSION['email_pol'], $_SESSION['politico']);
			$mail->isHTML(true);                                  // Set email format to HTML
			$mail->Body    = stripslashes($mensagem);
			$mail->AltBody = stripslashes($mensagem);
			$mail->send();
			$_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Tarefa incluída com sucesso e e-mail enviado para ".$nomeusuario."<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";		
		} catch (Exception $e) {
			$_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Tarefa foi incluída mas NÃO foi possível enviar e-mail. Motivo: ".$mail->ErrorInfo."<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";		
		}
//--------------------------------------------------------------------	
	}
}

?>
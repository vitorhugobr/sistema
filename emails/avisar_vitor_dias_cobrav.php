<?php
# formato da imagem a enviar: (9 colunas por 5 linhas no photoshop)
use PHPMailer \ PHPMailer \ PHPMailer;
include('../utilitarios/funcoes.php');
date_default_timezone_set('America/Sao_Paulo');
$data1 = "18/05/2019";
$data2 = date('Y-m-d H:m:s');
// converte as datas para o formato timestamp
$d1 = strtotime($data1); 
$d2 = strtotime($data2);
// verifica a diferença em segundos entre as duas datas e divide pelo número de segundos que um dia possui
#$dataFinal = EntreDuasDatas($data1,$data2);
// caso a data 2 seja menor que a data 1

$date  = new DateTime('2019-05-18 09:00:00');
$date2 = new DateTime($data2);

$intervalo = $date->diff($date2);
//echo 'Anos '.$intervalo->y;
//echo '<br>meses '.$intervalo->m;
//echo '<br>dias no mês '.$intervalo->d;
//echo '<br>horas '.$intervalo->h;
//echo '<br>minutos '.$intervalo->i;
//echo '<br>segundos '.$intervalo->s;
//echo '<br>dias '.$intervalo->days.'<br>';
//
$mens_qtde = "Já se passaram $intervalo->y anos, $intervalo->m meses, $intervalo->d dias, $intervalo->h horas desde minha demissão da COBRAV. Totalizando $intervalo->days dias";

require_once("../phpmailer/PHPMailer.php");
require_once("../phpmailer/SMTP.php");
require_once('../phpmailer/Exception.php');
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
// For most clients expecting the Priority header:
// 1 = High, 2 = Medium, 3 = Low
$mail->Priority = 1;

# Define os dados técnicos da Mensagem
$mail->IsHTML(true); # Define que o e-mail será enviado como HTML
$mail->setLanguage('br');
$mail->SMTPDebug = true;
$mail->AddAddress('vitorhugo@protonmail.com', 'Vitor H M Oliveira'); # Os campos podem ser substituidos por variáveis
$mail->Subject = "Cobrav"; # Assunto da mensagem
$mail->setFrom('redcard@vitor.poa.br', 'Sistema RedCard');
$mail->Body    = stripslashes($mens_qtde);
$mail->AltBody = stripslashes($mens_qtde);
//$enviado = $mail->Send();
// envia a mensagem, verifica se há erros
if (! $mail->send ()) {
    echo  'Erro na correspondência:' . $mail->ErrorInfo ;
} else {
    echo 'Mensagem enviada!' ;
}

# Exibe uma mensagem de resultado (opcional)
	
?>
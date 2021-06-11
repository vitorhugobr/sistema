<?php

ini_set('display_errors', 1);

error_reporting(E_ALL);

$from = "sigre@vitor.poa.br";

$to = "vhmoliveira@gmail.com";

$subject = "Verificando o correio do PHP";

$message = "O correio do PHP funciona bem";
$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=utf-8\r\n";
$headers .= "From: Sistema Sigre<sigre@vitor.poa.br>\r\n";

mail($to, $subject, $message, $headers);

echo "A mensagem de e-mail foi enviada.";

?>
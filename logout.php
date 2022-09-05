<?php
session_start();
include_once("utilitarios/funcoes.php");
gravaoperacoes("users","S", $_SESSION["usuarioUser"],"Saída Sistema");
$_SESSION = array();
session_unset();
session_destroy();


$_SESSION['loginSaida']="Saída do Sistema com sucesso!";
exit('<script>location.href = "index.php"</script>');

?>

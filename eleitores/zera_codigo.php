<?php 
include_once("../seguranca.php");
protegePagina();
$_SESSION['ult_eleitor_pesquisado']=0;
unset($_SESSION['tab']);
unset($_SESSION['msg']);
echo '<script>location.reload();</script>';
?>
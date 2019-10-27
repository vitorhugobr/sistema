<?php 
include_once("../seguranca.php");
protegePagina();
$_SESSION['ult_eleitor_pesquisado']=0;
unset($_SESSION['msg']);
unset($_SESSION['msgativo']);
echo '<script>location.reload();</script>';
?>
<?php 
include_once("../seguranca.php");
protegePagina();
unset($_SESSION['ult_eleitor_pesquisado']);
unset($_SESSION['msg']);
unset($_SESSION['msgativo']);
<script>
var param = 'cadastro.php?codigo=0';
	//alert(param);
	//ajax5('cadastro.php?codigo='+cod_cadastro, 'carregando');
	open(param,"_self");	
</script>
//echo '<script>location.reload();</script>';
?>
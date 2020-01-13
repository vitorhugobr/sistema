<?php 

include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina();
include("../utilitarios/funcoes.php");

$codigo = $_GET["P0"];
$_SESSION['ult_eleitor_pesquisado']=0;

$strsql3 = "DELETE FROM visitas where visitas.Visitante =". $codigo;
$strsql4 = "DELETE FROM encaminhamentos where encaminhamentos.codigo =". $codigo;
$strsql5 = "DELETE FROM enderecos where enderecos.codigo = ".$codigo;
executa_sql($strsql3,"visitas excluído com sucesso","visitas NÃO excluído!",false,false);
executa_sql($strsql4,"encaminhamentos excluído com sucesso","encaminhamentos NÃO excluído!",false,false);
executa_sql($strsql5,"enderecos excluído com sucesso","endererecos NÃO excluído!",false,false);
gravaoperacoes("cadastro","E", $_SESSION["usuarioUser"],"Excluído cadastro #: ".$codigo);

$strsql2 = "DELETE from cadastro where cadastro.CODIGO = ".$codigo;

executa_sql($strsql2,"Cadastro excluído com sucesso","Cadastro NÃO excluído!",true,true);
//	

?>
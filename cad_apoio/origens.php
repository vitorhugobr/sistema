<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
require_once("../utilitarios/funcoes.php");

if (liberado(5800==0)){
	expulsaVisitante2();
}else{
	$_SESSION['funcao']="Origens";

?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Cadastro de Origens">
	<meta name="author" content="Vitor H M Oliveira">
	<title>Cadastro Origens</title>
	<link rel="icon" href="../imagens/favicon.ico">
	<link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">
	<link href="../css/sticky-footer-navbar.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../css/ajax.css"/>
	<link rel="stylesheet" type="text/css" href="../css/autocomplete.css"/>
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
	<link href="../css/formata_textos.css" rel="stylesheet">
  	<link href="../css/all.css" rel="stylesheet">
  	<link href="../css/botoes.css" rel="stylesheet">


	<script>
    var retorno = carga_origens(1);
  </script>
	<script language="javascript" src="../js/origens.js"></script>
  <script type="text/javascript" src="../js/ajax.js"></script>
	<script type="text/javascript" src="../js/carrega_ajax.js"></script>
	<script src="../js/ie-emulation-modes-warning.js"></script>
	<script src="../js/jquery.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
  <script src="../js/ie10-viewport-bug-workaround.js"></script>
	<script type="text/javascript" src="../js/autocomplete.js"></script>
	</head>
  <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="carga_origens(1)">
<?php include("../utilitarios/cabecalho.php"); ?>	  

<form name="form1" method="post" action="">
    <nav class="navbar navbar-expand-sm navbar-light shadow-sm">
        <div class="container">
            <span class="navbar-brand"></span>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
      					<button type="button" class="btn btn-sm btn-incluir" onclick="javascript:inclui_Origem();"> 
                        <i class="fas fa-plus" aria-hidden="true"></i> Incluir 
                        </button>
                    </li>
                    <li class="nav-item">
      					&nbsp;<button type="button" class="btn btn-sm btn-consultar" onclick="javascript:carga_origens(1);"> 
                        <i class="fas fa-sitemap "></i> Mostrar Todos 
                        </button>
                    </li>
                    <li class="nav-item">
                        &nbsp;<a href="apoio.php" class="btn btn-voltar btn-sm" role="button">
                            <i class="fas fa-arrow-left" aria-hidden="true"></i>  Voltar
                        </a>
                    </li>
                    <li class="nav-item">
                        &nbsp;<a href="../index2.php" class="btn btn-menu btn-sm" role="button">
                            <i class="fas fa-list-ul" aria-hidden="true"></i>  Menu
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
  <?php
if(isset($_SESSION['msg'])){
	echo $_SESSION['msg'];
	unset($_SESSION['msg']);
}
?>

  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
    <tr>
      <td valign="top">
      	<div style="width:100%; overflow: auto;">
					<div class="dados" id="dados"></div>
        </div>
        </td>
      <td width="40%" valign="top">
      	<div class="edicao" id="edicao"></div>
      </td>
    </tr>
  </table>
  </form>  
<?php
include("../utilitarios/rodape-fixo.php");
}
?>

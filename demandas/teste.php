<?php
require_once("../utilitarios/funcoes.php");

$pathToSave = $_SERVER["DOCUMENT_ROOT"]."/sigre/imagens/";
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sem título</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Upload de arquivos com PHP</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Cadastro de Eleitores">
	<meta name="author" content="Vitor H M Oliveira">
	<link rel="icon" href="../imagens/favicon.ico">
  <!--- Component CSS -->
	<link href="../css/formata_textos.css" rel="stylesheet">
	<link href="../css/all.css" rel="stylesheet">
	<link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">
	<link href="../css/sticky-footer-navbar.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../css/ajax.css"/>
	<link rel="stylesheet" type="text/css" href="../css/autocomplete.css"/>
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>

	
	<script type="text/javascript" src="../js/eleitor.js"></script>
	<script type="text/javascript" src="../js/exames.js"></script>
	<script src="../js/jquery-3.3.1.min"></script>
	<script src="../js/bootstrap.min.js"></script>
	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<script src="../js/ie10-viewport-bug-workaround.js"></script>
	<script src="../js/carrega_ajax.js" type="text/javascript"></script>
	<script src="../js/ajax.js" type="text/javascript"></script>
	<script src="../js/ie-emulation-modes-warning.js"></script>
	<script type="text/javascript" src="../js/autocomplete.js"></script>


 
    <!-- CDN Bootstrap CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    
    </head>
    <body>
<div class="row">
	<div class="col-2"></div>
	<div class="col-6"></div>
	<div class="col-2">
		<a href="#" onclick="javascript:ver_exame_solicitado(1,2,3,4)" class="btn btn-sm btn-warning" />
			<i class="fas fa-x-ray" aria-hidden="true"></i> Ver Exame 
		</a>
	</div>
	<div class="col-2">
		<a href="#" title="Excluir o exame '.$dados_exames["descricao"].'" onclick="javascript:exclui_exame_solicitado('.$dados_exames["id"].')" class="btn btn-sm btn-danger" /><i class="fas fa-trash" aria-hidden="true"></i> Excluir o Exame</a>
	</div>
</div>
eeeeeee		
<div class="row">
	<div class="col-2 text-primary"><strong>99/99/9999</strong></div>
	<div class="col-6 text-secondary"> # dados_exames</div>
	<div class="col-2">
		<a href="#" title="Excluir TODOS Exames Solitados" onclick="javascript:exclui_exame('.$dados_exames["id"].')" class="btn btn-sm btn-warning" />
		<i class="fas fa-notes-medical" aria-hidden="true"></i> Excluir Solicitação</a>
	</div>
	<div class="col-2">
		<a href="#" title="Imprimir Solicitação do exame" onclick="javascript:imprime_exames('.$dados_exames["cod_cadastro"].','.$dados_exames["id"].')" class="btn btn-sm btn-info" /><i class="fas fa-print" aria-hidden="true"></i> Imprimir</a>
	</div>
</div>
------------------------------------------------------------
<div class="row">
	<div class="col-2"><strong>Exame:&nbsp;</strong></div>
	<div class="col-6">descricao</div>
	<div class="col-2">
	 <a href="#" onclick="javascript:ver_exame_solicitado(2,2,2,2)" class="btn btn-sm btn-warning" /><i class="fas fa-x-ray" aria-hidden="true"></i> Ver Exame</a>
	</div>
	<div class="col-2">
		<a href="#" title="Excluir o exame '.$dados_exames["descricao"].'" onclick="javascript:excluir_item_solicitado('.$dados_exames["cod_exame"].','.$dados_exames["id"].')" class="btn btn-sm btn-danger" />
			<i class="fas fa-trash" aria-hidden="true"></i> Excluir Item</a>
	</div>
</div>
				


	</body>
</html>
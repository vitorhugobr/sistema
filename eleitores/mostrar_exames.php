<?php
include_once("../seguranca.php");
protegePagina();
include_once("../utilitarios/funcoes.php");

date_default_timezone_set('America/Sao_Paulo');
$cod_cadastro = $_GET['cod_cadastro'];
$data = $_GET['data'];
$cod_exame = $_GET['cod_exame'];
$_SESSION['tab']= 7;

$i = 1;
$first = 0;
$view_exames ="";

$_SESSION['funcao']="Visualização de Exames";
?>
	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Receituarios">
<meta name="author" content="Vitor H M Oliveira">
<title>Visualização de Exames</title>
<link rel="icon" href="../imagens/favicon.ico">
<link href="../css/formata_textos.css" rel="stylesheet">
<link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">
<link href="../css/sticky-footer-navbar.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../css/ajax.css"/>
<link rel="stylesheet" type="text/css" href="../css/autocomplete.css"/>
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
<link href="../css/botoes.css" rel="stylesheet">
<link href="../css/all.css" rel="stylesheet">
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" role="document">
<?php include_once("../utilitarios/cabecalho.php");?>
<!-- --------------------------------------------------------------------------------------- -->
<!-- --- paramêtro 1 passado a seguir significa que será incluído - insert  -->
<!-- --------------------------------------------------------------------------------------- -->

<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
  <div class="carousel-inner">
	  <?php
	 while ($i <= 999) {
		$arquivo = "../imagens/exames/E".str_pad($cod_cadastro,6,"0",STR_PAD_LEFT).$data.str_pad($cod_exame,3,"0",STR_PAD_LEFT).str_pad($i,3,"0",STR_PAD_LEFT).".jpg";
		if (file_exists($arquivo)) {
			if ($first==0){
				$first = 1;?>
				<div class="carousel-item active">
		 <?php
			}else{?>
				<div class="carousel-item">
		 <?php
			}
		}?> 
		<img class="d-block w-75" src="<?php echo $arquivo;?>" alt="">
		</div>
        <?php
        	$i++;  /* the printed value would be*/
	}?>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Anterior</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Próximo</span>
  </a>
</div>


<script type="text/javascript" src="../js/eleitor.js"></script>
<script src="../js/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/docs.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="../js/ie10-viewport-bug-workaround.js"></script>
<script src="../js/carrega_ajax.js" type="text/javascript"></script>
<script src="../js/ajax.js" type="text/javascript"></script>
<script src="../js/ie-emulation-modes-warning.js"></script>
<script type="text/javascript" src="../js/autocomplete.js"></script>
<?php include_once("../utilitarios/rodape.php");?>
</body>
</html>

<?php
include_once("../seguranca.php");
protegePagina();
include_once("../utilitarios/funcoes.php");

$demanda = filter_input(INPUT_GET, 'demanda',FILTER_DEFAULT);
$_SESSION['funcao']="Excluir Imagens";
?>
  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br">
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Cadastro de árbitros">
  <meta name="author" content="Vitor H M Oliveira">
  <link rel="stylesheet" type="text/css" href="../css/ajax.css"/>
  <link rel="SHORTCUT ICON" href="../imagens/vhmo.png" />
  <link rel="stylesheet" type="text/css" href="../css/formata_textos.css"/> 
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link href="../css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="../css/sticky-footer-navbar.css"/>
  <script type="text/javascript" src="../js/bootstrap.js"></script>
  <script type="text/javascript" src="../js/ajax.js"></script>
  <script type="text/javascript" src="../js/carrega_ajax.js"></script>
  <script src="../js/ie-emulation-modes-warning.js"></script>
  <script src="../js/jquery.min.js"></script>
  <script src="../js/ie10-viewport-bug-workaround.js"></script>
  <title>Excluir Imagens</title>
  </head>
  <body>
  <?php include_once("../utilitarios/cabecalho.php"); ?>
   <?php

	if(isset($_SESSION['msg'])){
		echo $_SESSION['msg'];
		unset($_SESSION['msg']);
	}
	?>

  <div class="container">
  <form action="" method="post" enctype="multipart/form-data" name="form1" ><br />
	<input type="hidden" name="txtdemanda" value="<?php echo $demanda; ?>">
	<h4 class="alert-danger">Clique na imagem para excluir</h4>
	<?php 
		$qtdefotos=0;
		for ($i=0; $i < 1000; $i++) {
			$arqbusca =  "D".str_pad($demanda, 7, '0', STR_PAD_LEFT).str_pad($i, 3, '0', STR_PAD_LEFT);
			$arquivo = "../imagens/demandas/".$arqbusca.".jpg";
			$imagens ='';
			if (file_exists($arquivo)) {
				//echo $arquivo.'<br>';
				$qtdefotos++;
				if (($qtdefotos==1) or ($qtdefotos==5)){
					echo '<div class="row">';
				}
				$formataimg = '<img src="'.$arquivo.'" class="img-thumbnail" onclick="javascript:excluir_imagem_demanda(';
				$formataimg .= "'".$arquivo."'";
				$formataimg .= ')">';
				echo $formataimg;
				if (($qtdefotos==4) or ($qtdefotos==8)){
					echo '</div>';
				}
				//$imagens .= '<img class="img-fluid" src="'.$arquivo.'" alt="Foto da demanda">';
			} 	
		}	
	  ?>
  </form>
  <div class="col-12">
<button type="button" class="btn btn-lg btn-dark" onClick="self.window.close();"><i class="fas fa-window-close" aria-hidden="true"></i>  Cancelar
</button>
</div>
</div>
 <?php include_once("../utilitarios/rodape-fixo.php")
  ?>
    <script>
 function excluir_imagem_demanda(arq){
 	if (confirm("Confirma a Exclusão da imagem da demanda?")){
		AjaxRequest();
		if(!Ajax) {
			alert('não foi  possível iniciar o AJAX');
			return;
		}
		var parametro = 'exclui_imagem.php?arq='+arq+'&demanda='+<?php echo $demanda; ?>
		//alert (parametro);
		ajax2(parametro, 'carregando');
	}

	 }
  </script>

 </body>
</html>
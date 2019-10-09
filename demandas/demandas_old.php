<?php
#*****************************************************************
#             CÓDIGOS DE SITUAÇÃO DAS DEMANDAS:                  *
# 0	-	ABERTA													 *
# 1	-	RESPONDIDA												 *
# 2	-	ENCERRADA												 *
# 5	-	ARQUIVADA												 *
#*****************************************************************

include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
include_once("../utilitarios/funcoes.php");
$_SESSION['funcao']="Demandas";
if (liberado(2000)==0){
	expulsaVisitante2();
}else{

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $_SESSION['sistemaabrev']?> - Demandas</title>
<link rel="stylesheet" type="text/css" href="../css/sticky-footer-navbar.css"/>
<link rel="stylesheet" type="text/css" href="../css/ajax.css"/>
<link rel="stylesheet" type="text/css" href="../css/autocomplete.css" />
<link rel="SHORTCUT ICON" href="../imagens/favicon.ico" />
<link rel="stylesheet" type="text/css" href="../css/formata_textos.css"/>
<link rel="stylesheet" href="../css/bootstrap.min.css">
<link href="../css/all.css" rel="stylesheet">
	<script type="text/javascript" language="javascript" src="../js/datatables.js"></script>
	<script type="text/javascript" language="javascript" class="init">	
	$(document).ready(function() {
		$('#mostraE').dataTable({
                        "aaSorting": [[ 3, "asc" ]],
			"bPaginate": true,
			"bFilter": true,
			"sType": "brazilian", 
			"aoColumns": [
			{ "sType": 'numeric' },
			{ "sType": 'text' },
			{ "sType": 'text' },
			{ "sType": 'text' },
			{ "sType": 'numeric' },
			{ "sType": 'numeric' },
			{ "sType": 'numeric' },
			{ "sType": 'text' },
			{ "sType": 'text' },
			null
			]			
		});
		
	} );
	</script>
</head>
<body onload="javascript:mostrarDemandas(3);" onblur="javascript:mostrarDemandas(3);" >
<?php include_once("../utilitarios/cabecalho.php"); ?>
<form name="form1" method="post" action="">
  <nav class="navbar navbar-expand-sm navbar-light shadow-sm">
  	<div class="container">
    	<span class="navbar-brand">
        </span>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        	<ul class="navbar-nav mr-auto">
			  <?php 
              if (liberado(2001)>0){   
                echo '<li class="nav-item"><button id="btnincdem" name="btnincdem" type="button" class="btn btn-sm btn-primary" onClick="javascript:demandaI('.$_SESSION["usuarioNivel"].','.$_SESSION["usuarioCodigo"].')">
                      <i class="fas fa-plus"></i> Incluir Demanda
                      </button>&nbsp;</li>';
              }
              if (liberado(2005)>0){
                echo '<li class="nav-item">
						<button id="btnincdem" name="btnincdem" type="button" class="btn btn-sm btn-info" onClick="javascript:mostrarDemandas(9)"><i class="fas fa-search"></i> Todas  
						</button>
                		<button id="btnincdem" name="btnincdem" type="button" class="btn btn-sm btn-warning" onClick="javascript:mostrarDemandas(0)"><i class="fas fa-search"></i> Não Respondidas 
						</button></li>&nbsp;
						<li class="nav-item">
						<button id="btncondem" name="btncondem" type="button" class="btn btn-sm btn-success" onClick="javascript:mostrarDemandas(2)"><i class="fas fa-search"></i> Encerradas 
						</button>
              			</li>&nbsp;<li class="nav-item">
			  			<button id="btncondem" name="btncondem" type="button" class="btn btn-sm btn-secondary" onClick="javascript:mostrarDemandas(1)"><i class="fas fa-search"></i> Abertas 
						</button>
					  </li>&nbsp;<li class="nav-item">
			  			<button id="btncondem" name="btncondem" type="button" class="btn btn-sm btn-danger" onClick="javascript:mostrarDemandas(5)"><i class="fas fa-file-archive"></i> Arquivadas 
						</button>
					  </li>';
              } 
              ?>
              
              <li class="nav-item">
                  &nbsp;<a href="../index2.php" class="btn btn-dark btn-sm" role="button">
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

<table class="table table-sm table-striped table-borderless">
  <tr>
    <td rowspan="2" valign="top" width="60%">
        <div id="mostraE"></div>
    </td>
    </td>
  </tr>
</table>

</form>
<?php
	include_once("../utilitarios/rodape-fixo.php");
	?>
<script language="javascript" src="../js/demandas.js"></script>
<script src="../js/carrega_ajax.js" type="text/javascript"></script>
<script src="../js/ajax.js" type="text/javascript"></script>
<script src="../js/ie-emulation-modes-warning.js"></script>
<script src="../js/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script type="text/javascript" src="../js/autocomplete.js"></script>
<script src="../js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>
<?php } ?>

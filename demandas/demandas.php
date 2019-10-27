<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
include_once("../utilitarios/funcoes.php");
$_SESSION['funcao']="Demandas";

$result_demandas = "select * from demandas_view";
#$resultado_demandas = mysqli_query($conn, $result_demandas);
$mysql_query = $_con->query($result_demandas);
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></meta>
	<meta http-equiv="X-UA-Compatible" content="IE=edge"></meta>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"></meta>
	<meta name="description" content="Cadastro de demandas"></meta>
	<meta name="author" content="Vitor H M Oliveira"></meta>		
	<script type="text/javascript" language="javascript" src="scripts/jquery.js"></script>
	<script type="text/javascript" language="javascript" src="scripts/jquery.dataTables.js"></script>
	<link rel="stylesheet" href="../css/datatables.min.css"></link>
	<link href="../css/font-awesome.min.css" rel="stylesheet">
	<link href="../css/formata_textos.css" rel="stylesheet">
	<link href="../css/all.css" rel="stylesheet">
	<link href="../css/botoes.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../css/sticky-footer-navbar.css"></link>
	<link rel="stylesheet" href="../css/bootstrap.css"></link>
	<link rel="stylesheet" href="../css/dataTables.bootstrap4.min.css"></link>
	<link rel="icon" href="../imagens/vhmo.png" type="image/png"></link>
	<link rel="shortcut icon" href="../imagens/vhmo.ico"></link>
	<title>SIGRE - Demandas</title>
	<script src="../js/carrega_ajax.js" type="text/javascript"></script>
	<script src="../js/ajax.js" type="text/javascript"></script>
	<script src="../js/ie-emulation-modes-warning.js"></script>
	<script src="../js/demandas.js" language="javascript"></script>
	<script src="../js/jquery-3.3.1.min.js"></script>
	<script src="../js/jquery.dataTables.min.js"></script>
	<script src="../js/dataTables.bootstrap4.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../js/autocomplete.js"></script>
	<script src="../js/ie10-viewport-bug-workaround.js"></script>
	<script type="text/javascript" charset="utf-8">
		$(document).ready(function() {
            $('#demandas').dataTable({	
				"language": {
					"lengthMenu": "Mostrar _MENU_ Demandas por página - clique na coluna do cabeçalho para classificar",
					"zeroRecords": "Nenhum registro",
					"info": "Visualizando pág _PAGE_ de _PAGES_",
					"sInfoFiltered": "(filtro aplicado sobre _MAX_ demandas)",
					"infoEmpty": "Sem registros",
					"sSearch": "Pesquisar",
					"sProcessing" :"Processando...",
					"sLoadingRecords": "Carregando...",
					"sEmptyTable" :"Sem dados na tabela",
					"oPaginate":{
					"sFirst":"Primeiro","sLast":"Último","sNext":"Próximo","sPrevious":"Anterior"}
				},
				"processing": true
			});
		} );
	</script>
</head>
<body>
<?php include_once("../utilitarios/cabecalho.php"); ?>
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
                echo '<li class="nav-item"><button id="btnincdem" name="btnincdem" type="button" class="btn btn-sm btn-incluir" onClick="javascript:demandaI('.$_SESSION["usuarioNivel"].','.$_SESSION["usuarioCodigo"].')">
                      <i class="fas fa-plus"></i> Nova Demanda
                      </button>&nbsp;</li>';
              }
              ?>
              
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

	<table id="demandas" class="table table-striped table-sm">
	<thead class="thead-dark">
		<tr>
		  <th width="3%">
			  <div align="center"><i class="fas fa-hashtag"></i>
			  </div>
		  </th>
		  <th width="26%">
			  <div align="left"><i class="fas fa-user"></i> Nome
			  </div>
		  </th>
		  <th width="10%">
			  <div align="center"><i class="fas fa-calendar-alt"></i> Data
			  </div>
		  </th>
		  <th width="15%">
			  <div align="left"><i class="fas fa-text-width"></i> Secretaria
			  </div>		      
		  </th>
		  <th width="10%">
			  <div align="left"><i class="fas fa-tag"></i> Protocolo
			  </div>		      
		  </th>
		  <th width="10%">
			  <div align="left"><i class="fas fa-info"></i> Situação
			  </div>		      
		  </th>
		  <th width="2%">
			  <div align="left">Respostas
			  </div>		      
		  </th>
		  <th width="10%">
			  <div align="left">Responsável
			  </div>		      
		  </th>
		  <th width="24%">
			  <div align="left">Endereço
			  </div>		      
		  </th>
		</tr>
	</thead><tbody>
		<?php
		if ($mysql_query->num_rows>0){
			while ($row_demandas = $mysql_query->fetch_assoc()) {
				$datademanda = FormatDateTime($row_demandas['data'],7);
				$situacao = ve_situacao($row_demandas['situacao']);
				echo "<tr>";
				echo "<td>".$row_demandas['numero']."</td>";
				
				echo '<td><div align="left">
						<a href="javascript:traz_demanda('.$row_demandas['numero'].')" ><i class="fas fa-eye"></i> '.$row_demandas['nome'].'</a>
							</div></td>';
				echo "<td>".$datademanda."</td>";
				echo "<td>".$row_demandas['secretaria']."</td>";
				echo "<td>".$row_demandas['protocolo']."</td>";
				echo "<td><strong>".$situacao."</strong></td>";
				echo "<td  align='right'>".busca_qtde_respostas($row_demandas['numero'])."</td>";
				echo "<td>".$row_demandas['operador']."</td>";
				echo "<td>".$row_demandas['endereco']."</td>";
				echo "</tr>";
			}
		}
		?>
	<tbody>	
</table>
<?php include_once("../utilitarios/rodape-fixo.php"); ?>

</body>
</html>
 


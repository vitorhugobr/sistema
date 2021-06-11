<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
include_once("../utilitarios/funcoes.php");
$_SESSION['funcao']="Tarefas";

$result_tarefas = "select * from tarefas_pesquisa";
$mysql_query = $_con->query($result_tarefas);
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></meta>
	<meta http-equiv="X-UA-Compatible" content="IE=edge"></meta>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"></meta>
	<meta name="description" content="Cadastro de Tarefas"></meta>
	<meta name="author" content="Vitor H M Oliveira"></meta>		
	<!-- <link rel="stylesheet" href="../css/bootstrap.css"> -->
	<script type="text/javascript" language="javascript" src="../demandas/scripts/jquery.js"></script>
	<script type="text/javascript" language="javascript" src="../demandas/scripts/jquery.dataTables.js"></script>
	<link rel="stylesheet" href="../css/datatables.min.css"></link>
	<link href="../css/font-awesome.min.css" rel="stylesheet">
	<link href="../css/formata_textos.css" rel="stylesheet">
	<link href="../css/all.css" rel="stylesheet">
	<link href="../css/botoes.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../css/sticky-footer-navbar.css"></link>
	</link>
	<link rel="stylesheet" href="../css/dataTables.bootstrap4.min.css">
	<link href="../css/bootstrap-4.3.1.css" rel="stylesheet" type="text/css">
	</link>
	<link rel="icon" href="../imagens/vhmo.png" type="image/png"></link>
	<link rel="shortcut icon" href="../imagens/vhmo.ico">
</link>
<title>SIGRE - Tarefas</title>
	<script src="../js/carrega_ajax.js" type="text/javascript"></script>
	<script src="../js/ajax.js" type="text/javascript"></script>
	<script src="../js/ie-emulation-modes-warning.js"></script>
	<script src="../js/tarefas.js" language="javascript"></script>
	<script src="../js/jquery-3.3.1.min.js"></script>
	<script src="../js/jquery.dataTables.min.js"></script>
    <script src="../js/dataTables.bootstrap4.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/bootstrap-4.3.1.js" type="text/javascript"></script>
    <script type="text/javascript" src="../js/autocomplete.js"></script>
	<script src="../js/ie10-viewport-bug-workaround.js"></script>
	<script type="text/javascript" charset="utf-8">
		$(document).ready(function() {
            $('#tarefas').dataTable({	
				"language": {
					"lengthMenu": "Mostrar _MENU_ Tarefas por página - clique na coluna do cabeçalho para classificar",
					"zeroRecords": "Nenhum registro",
		            "sSortDesc": "sorting_desc",
		            "sSortable": "sorting", /* Sortable in both directions */
					"info": "Visualizando pág _PAGE_ de _PAGES_",
					"sInfoFiltered": "(filtro aplicado sobre _MAX_ Tarefas)",
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
              if (liberado(4501)>0){   
                echo '<li class="nav-item"><button id="btnincdem" name="btnincdem" type="button" class="btn btn-sm btn-incluir" onClick="javascript:nova_tarefa('.$_SESSION["usuarioNivel"].','.$_SESSION["usuarioCodigo"].')">
                      <i class="fas fa-plus"></i> Nova Tarefa
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
    <table id="tarefas" class="table table-striped table-sm">
	<thead class="thead-dark">
		<tr>
		  <th width="5%">
			  <div align="center"><i class="fas fa-hashtag">Tarefa</i>
			  </div>
		  </th>
		  <th width="10%">
			  <div align="center"><i class="fas fa-calendar-alt">Data</i>
			  </div>
		  </th>
		  <th width="10%">
			  <div align="left"><i class="fas fa-user"></i> Usuário
			  </div>
		  </th>
		  <th width="45%">
			  <div align="center"><i class="fas fa-text-height"></i> Assunto
			  </div>
		  </th>
		  <th width="10%">
			  <div align="left"><i class="fas fa-calendar"></i> Data Início
			  </div>		      
		  </th>
		  <th width="10%">
			  <div align="left"><i class="fas fa-tag"></i> Prioridade
			  </div>		      
		  </th>
		  <th width="10%">
			  <div align="left">Status
			  </div>		      
		  </th>
		  <th width="5%">
			  <div align="left">Opções
			  </div>		      
		  </th>
		</tr>
	</thead><tbody>
		<?php
		if ($mysql_query->num_rows>0){
			while ($row_tarefas = $mysql_query->fetch_assoc()) {
				$datatarefa = FormatDateTime($row_tarefas['data_tarefa'],7);
				$datainicio = FormatDateTime($row_tarefas['data_inicio'],7);
				echo "<tr>";
				echo '<td><div align="left">
						<a href="javascript:mostratarefa('.$row_tarefas['id'].')" >'.$row_tarefas['id'].'</a>
							</div></td>';
				echo "<td>".$datatarefa."</td>";
				
				echo "<td>".$row_tarefas['usuario']."</td>";
				echo "<td>".$row_tarefas['assunto']."</td>";
				echo "<td>".$datainicio."</td>";
				echo "<td><strong>".$row_tarefas['prioridade']."</strong></td>";
				echo "<td>".$row_tarefas['status']."</td>";
				echo "<td>";
                echo '<img src="../imagens/editar.png" alt="Editar" width="18" height="18" onclick="mostratarefa('.$row_tarefas['id'].')">&nbsp';
		        if ($_SESSION["usuarioNivel"]<2 AND $row_tarefas["status"]<> "ENCERRADA") {
                    echo '<img src="../imagens/excluir.jpg" alt="Excluir" width="18" height="18" onclick="excluitarefa('.$row_tarefas['id'].');">';
		        }
                
				echo "</tr>";
			}
		}
		?>
	<tbody>	
</table>
    </button>
    </button>
<?php include_once("../utilitarios/rodape-fixo.php"); ?>
</body>
</html>
 


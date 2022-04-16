<?php 
$_SESSION['servidor'] = "www.serverwebdb.com.br";
$_SESSION['banco'] = "chaplinb_chaplin";
$_SESSION['usuario'] = "chaplinb_chaplin";
$_SESSION['senha'] = "HpcOKYN7b2E-";
require_once ('../utilitarios/funcoes.php');

?>
    <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"></meta>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"></meta>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"></meta>
        <meta name="description" content="Ocorrências"></meta>
        <meta name="author" content="Vitor H M Oliveira"></meta>

    <link rel="stylesheet" type="text/css" href="../css/formata_textos.css"></link>
    <link rel="stylesheet" type="text/css" href="../css/sticky-footer-navbar.css"></link>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css"></link>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css"></link>
    <link rel="icon" href="../imagens/vhmo.png" type="image/png"></link>
    <link rel="shortcut icon" href="../imagens/vhmo.ico"></link>
    <title>SIGRE - Operações</title>
    <script src="../js/ajax.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript">
    $(document).ready(function() {
      $('#listar-usuario').DataTable({	
        "aaSorting": [[1,'asc']],
        "iDisplayLength": 12,
        "bFilter": true,
        "aaSorting": [[1,'asc']], 
	"language": {
        "sEmptyTable": "Nenhum registro encontrado",
        "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
        "sInfoFiltered": "(Filtrados de _MAX_ registros)",
        "sInfoPostFix": "",
        "sInfoThousands": ".",
        "sLengthMenu": "_MENU_ resultados por página ",
        "sLoadingRecords": "Carregando...",
        "sProcessing": "Processando...",
        "sZeroRecords": "Nenhum registro encontrado",
        "sSearch": "Pesquisar",
        "oPaginate": {
            "sNext": "Próximo",
            "sPrevious": "Anterior",
            "sFirst": "Primeiro",
            "sLast": "Último"
            },
            "info": "Visualizando pág _PAGE_ de _PAGES_",
            "infoEmpty": "Sem registros",
        "oAria": {
            "sSortAscending": ": Ordenar colunas de forma ascendente",
            "sSortDescending": ": Ordenar colunas de forma descendente"
            },
	"oPaginate":{
            "sFirst":"Primeiro","sLast":"Último","sNext":"Próximo","sPrevious":"Anterior"}
            },
            "processing": true,
            "serverSide": true,
            
            "ajax": {
                "url": "proc_ocorrencias.php",
		"type": "POST"
            }
	});
    } );
    </script>
    <style type="text/css">
        body{
            margin-bottom: 0;
            margin-left: 0;
            margin-right: 0;
            margin-top: 0;
        }
    </style>
    </head>
    <body>
    <div class="container-fluid">
	<div class='col-1 text-center'>
		<img class="float" src="../imagens/vhmo.png" width="22" height="22"/>
		<span class="mr-1 d-none d-lg-inline text-gray-600 small">SIGRE</span> 
		<span class="rodape">1.0.0</span> 
	</div>
	<div class="col-2 text-center" align="center"> 
	</div>
	<div class='col-3' align="center">
		<span class="politico"><img src="<?php echo $_SESSION['imagem_camp']?>" height="30"> POLÍTICO
		</span>
	</div>
	<div class='col-1 text-center'>
		<div id="carregando"></div>
	</div>
	<div class='col-2 text-center'>
		<span class="mr-1 d-none d-lg-inline text-gray-600 large">Ocorrências</span>
	</div>
	<div class='col-3 text-right'>
        <span class="mr-2 d-none d-lg-inline text-gray-600 small"></span>
    </div>
<!-- </div> -->
<div id="results"><!-- Results are displayed here --></div>
<div id="fade"></div>
      <div class="row">
         <div class="col-sm-12 text-center"><span class="textoAzul"><i class="fa fa-address-card"></i> Ocorrências</span></div>
      </div>
      <table id="listar-usuario" class="table table-striped table-borderless" style="width:100%">
        <thead>
          <tr>
            <th>Data</th>
            <th>Hora</th>
            <th>Tabela</th>
            <th>Operador</th>
            <th>Operação</th>
          </tr>
			<tr>
				<th>Conteúdo</th>
			</tr>
        </thead>
      </table>	

	</body>
</html>

  <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br">
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"></meta>
  <meta http-equiv="X-UA-Compatible" content="IE=edge"></meta>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"></meta>
  <meta name="description" content="Cadastro de árbitros"></meta>
  <meta name="author" content="Vitor H M Oliveira"></meta>


  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"></link>
  <link rel="stylesheet" type="text/css" href="../css/formata_textos.css"></link>
  <link rel="stylesheet" type="text/css" href="../css/sticky-footer-navbar.css"></link>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css"></link>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css"></link>
  <link rel="icon" href="../imagens/vhmo.png" type="image/png"></link>
  <link rel="shortcut icon" href="../imagens/vhmo.ico"></link>
  <title>SIGRE - Operações</title>
  <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
  <script type="text/javascript" language="javascript">
	$(document).ready(function() {
            $('#listar-usuario').DataTable({	
            "language": {
            "lengthMenu": "Mostrar _MENU_ Registros por página",
            "zeroRecords": "Nenhum registro",
            "info": "Visualizando pág _PAGE_ de _PAGES_",
            "infoEmpty": "Sem registros",
            "infoFiltered": "(filtrado de _MAX_ total registros)",
						"sSearch": "Busca",
						"sProcessing" :"Processando...",
						"sLoadingRecords": "Carregando...",
						"sEmptyTable" :"Sem dados na tabela",
						"oPaginate":{
							"sFirst":"Primeiro","sLast":"Último","sNext":"Próximo","sPrevious":"Anterior"}
				},
				"processing": true,
				"serverSide": true,
				"ajax": {
					"url": "proc_pesq_user.php",
					"type": "POST"
				}
			});
		} );
		</script>
	</head>
	<body>
  <div class="row">
    <div class="col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2" align="left"><img src="../imagens/vhmo.png"></div>
    <div class="col-12 col-sm-12 col-md-8 col-lg-8 col-xl-8"" align="center">
    	<span class="sigla_sistema">SIGRE </div>
    <div class="col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2"" align="right"><span class="badge badge-info">Vitor</span></div>
  </div>
		<h4 align="center">Operações dos Usuários</h4>
		<table id="listar-usuario" class="table table-striped" style="width:100%">
			<thead class="thead-light">
				<tr>
					<th>Data</th>
					<th>Hora</th>
					<th>Tabela</th>
					<th>Operação</th>
					<th>Operador</th>
					<th>Conteúdo</th>
				</tr>
			</thead>
		</table>		
  <footer class="footer">
    <div class="card">
      <div class="card-text text-muted rodape">
        Vitor H M Oliveira - 
        <span class="rodapeSigla">
          SIGRE - 
        </span>
        <span class="card-text text-muted rodape">
          Desenvolvedor
        </span>
      </div>
    </div>
  </footer>
	</body>
</html>

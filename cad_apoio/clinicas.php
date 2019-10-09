<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
require_once("../utilitarios/funcoes.php");

if (liberado(5650)==0){
	expulsaVisitante2();
}else{
	$_SESSION['funcao']="Clínicas";
	$result_clinicas = "SELECT * FROM clinicas order by clinica";
	$resultado_clinicas = mysqli_query($_con, $result_clinicas);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br">
  	<head>
  	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<meta name="description" content="Cadastro de Grupos">
  	<meta name="author" content="Vitor H M Oliveira">
  	<title>Cadastro</title>
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
    var retorno = carga_clinicas(1);
  	</script>
  	<script language="javascript" src="../js/clinicas.js"></script>
  	<script type="text/javascript" src="../js/ajax.js"></script>
  	<script type="text/javascript" src="../js/carrega_ajax.js"></script>
  	<script src="../js/ie-emulation-modes-warning.js"></script>
  	<script src="../js/jquery.min.js"></script>
  	<script src="../js/bootstrap.min.js"></script>
  	<script src="../js/ie10-viewport-bug-workaround.js"></script>
  	<script type="text/javascript" src="../js/autocomplete.js"></script>
  	<script src="../js/jquery-3.2.1.slim.min.js"></script>
  	</head>
  	<body>
	<?php include("../utilitarios/cabecalho.php"); ?>
    <nav class="navbar navbar-expand-sm navbar-light shadow-sm">
        <div class="container">
            <span class="navbar-brand"></span>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
          				<button type="button" class="btn btn-sm btn-incluir" data-toggle="modal" data-target="#incModal">
                        <i class="fas fa-plus"></i> Incluir
                        </button>
                    </li>
                    <li class="nav-item">
          				<button type="button" class="btn btn-sm btn-consultar" onclick="javascript:carga_clinicas(1);"> 
                        <i class="fas fa-sitemap"></i> Mostrar Todas 
                        </button>
                    </li>
                    <li class="nav-item">
                        <a href="apoio.php" class="btn btn-voltar btn-sm" role="button">
                            <i class="fas fa-arrow-left" aria-hidden="true"></i>  Voltar
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="../index2.php" class="btn btn-menu btn-sm" role="button">
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

<div class="container-fluid theme-showcase" role="main">
	<div class="row">
    <div class="col-md-12">
          <table class="table table-sm table-striped">
        	<thead class="thead-dark">
              <tr>
				<th><i class="fas fa-hashtag"></i></th>
				<th><i class="fas fa-text-width"></i> Nome da Clínica</th>
				<th><i class="fas fa-home"></i> Endereço</th>
				<th><i class="fas fa-phone"></i> Telefone</th>
				<th>Ações</th>
			  </tr>
            </thead>
			<tbody>
              <?php while($rows_clinicas = mysqli_fetch_assoc($resultado_clinicas)){ ?>
              <tr>
				<td><?php echo $rows_clinicas['id']; ?></td>
				<td><?php echo $rows_clinicas['clinica']; ?></td>
				<td><?php echo $rows_clinicas['endereco']; ?></td>
				<td><?php echo $rows_clinicas['telefone']; ?></td>
				<td><button type="button" class="btn btn-sm btn-consultar" data-toggle="modal" data-target="#myModal<?php echo $rows_clinicas['id']; ?>"><i class="fas fa-search"></i> Visualizar</button>
                <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#exampleModal" data-whatever="<?php echo $rows_clinicas['id']; ?>" data-whateverclinica="<?php echo $rows_clinicas['clinica']; ?>" data-whateverendereco="<?php echo $rows_clinicas['endereco']; ?>"data-whatevertelefone="<?php echo $rows_clinicas['telefone']; ?>"><i class="fas fa-edit"></i>Editar</button>
                <button type="button" class="btn btn-sm btn-excluir"><i class="fas fa-trash"></i> Excluir</button></td>
			  </tr>
              
              <!-- Inicio Modal -->
			<div class="modal fade" id="myModal<?php echo $rows_clinicas['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title text-center" id="myModalLabel"><?php echo $rows_clinicas['clinica']; ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
                  </div>
                  <div class="modal-body">
                    <p>
                      <label>Código:&nbsp;</label>
                      <?php echo $rows_clinicas['id']; ?></p>
                    <p>
                      <label>Nome Clínica:&nbsp;</label>
                      <?php echo $rows_clinicas['clinica']; ?></p>
                    <p>
                      <label>Endereço:&nbsp;</label>
                      <?php echo $rows_clinicas['endereco']; ?></p>
                    <p>
                      <label>Telefone:&nbsp;</label>
                      <?php echo $rows_clinicas['telefone']; ?></p>
                  </div>
                </div>
              </div>
            </div>
        <!-- Fim Modal -->
        <?php } ?>
          </tbody>
      </table>
  </div>
    </div>

<!-- modal para inclusão -->
<div class="modal fade" id="incModal" tabindex="-1" role="dialog" aria-labelledby="incModalLabel">
	<div class="modal-dialog" role="document">
    	<div class="modal-content">
          <div class="modal-header">
        	<h4 class="modal-title" id="incModalLabel">Inclusão de Clínica</h4>
        	<button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
          </div>
        <div class="modal-body">
          <form method="POST" action="incluir_clinica.php" enctype="multipart/form-data">
              <div class="form-group">
              <label for="recipient-name" class="control-label">Nome Clínica:</label>
              <input name="clinica" type="text" class="form-control" id="recipient-clinica">
            </div>
            <div class="form-group">
              <label for="message-text" class="control-label">Endereço:</label>
              <textarea name="endereco" class="form-control" id="endereco"></textarea>
            </div>
            <div class="form-group">
              <label for="message-text" class="control-label">Telefone:</label>
              <textarea name="telefone" class="form-control" id="telefone"></textarea>
            </div>
            <input name="id_clinica" type="hidden" class="form-control" id="id_clinica" value="">
            <button type="button" class="btn btn-encerrar" data-dismiss="modal"><i class="fas fa-times"></i> Cancelar</button>
            <button type="submit" class="btn btn-incluir"><i class="fas fa-save"></i> Gravar</button>
          </form>
        </div>
      </div>
  </div>
</div>

  <!-- modal para alteração -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
      <div class="modal-dialog" role="document">
    <div class="modal-content">
          <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Clínica</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
      </div>
          <div class="modal-body">
        <form method="POST" action="processa_clinica.php" enctype="multipart/form-data">
              <div class="form-group">
            <label for="recipient-name" class="control-label">Nome Clínica:</label>
            <input name="clinica" type="text" class="form-control" id="recipient-clinica">
          </div>
              <div class="form-group">
            <label for="message-text" class="control-label">Endereço:</label>
            <textarea name="endereco" class="form-control" id="endereco"></textarea>
          </div>
              <div class="form-group">
            <label for="message-text" class="control-label">Telefone:</label>
            <textarea name="telefone" class="form-control" id="telefone"></textarea>
          </div>
              <input name="id_clinica" type="hidden" class="form-control" id="id_clinica" value="">
              <button type="button" class="btn btn-cancelar" data-dismiss="modal"><i class="fas fa-times"></i> Cancelar</button>
              <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Alterar</button>
            </form>
      </div>
        </div>
  </div>
    </div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> 
<!-- Include all compiled plugins (below), or include individual files as needed --> 
<script src="../js/bootstrap.min.js"></script> 
<script type="text/javascript">
		$('#exampleModal').on('show.bs.modal', function (event) {
		  var button = $(event.relatedTarget) // Button that triggered the modal
		  var recipient = button.data('whatever') // Extract info from data-* attributes
		  var recipientclinica = button.data('whateverclinica')
		  var recipientendereco = button.data('whateverendereco')
		  var recipienttelefone = button.data('whatevertelefone')
		  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
		  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
		  var modal = $(this)
		  modal.find('.modal-title').text('Clínica # ' + recipient)
		  modal.find('#id_clinica').val(recipient)
		  modal.find('#clinica').val(recipient)
		  modal.find('#recipient-clinica').val(recipientclinica)
		  modal.find('#endereco').val(recipientendereco)
		  modal.find('#telefone').val(recipienttelefone)
		  
		})
	</script>
</body>

  	<!--		<div class="container">
			<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Edição - Clínica</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body" id="edicao">
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-cancelar" data-dismiss="modal">Fechar</button>
						</div>	
					</div>
				</div>
			</div>
			
		</div>
	
  <form name="form1" method="post" action="">
  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
    <tr>
      <td valign="top">
      	<div style="width:100%; height: 570px; overflow: auto;">
					<div class="dados" id="dados"></div>
        </div>
        </td>
    </tr>
    <tr>
      <td valign="top">
      <button type="button" class="btn btn-sm btn-incluir" onclick="javascript:inclui_clinica();"> <i class="fas fa-refresh"></i> Incluir </button>
      <button type="button" class="btn btn-sm btn-consultar" onclick="javascript:carga_clinicas(1);"> <i class="fas fa-refresh"></i> Mostrar Todas </button>
      	<a href="apoio.php" class="btn btn-menu btn-sm" role="button">
          <i class="fas fa-menu-hamburger"></i>  Menu
        </a>
      <td valign="top">&nbsp;</td>
    </tr>
  </table>
  </form>  
-->
  	<?php
include("../utilitarios/rodape-fixo.php");
}
?>

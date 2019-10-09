<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
require_once('../utilitarios/funcoes.php');
if (liberado(7100)==0){
  expulsaVisitante2();
}else{
  $_SESSION['funcao']="Lista de Espera";
  $cod_clinica = $_GET['clinica'];
  $data_consulta = $_GET['data'];
  $sql = "select * from clinicas where id=".$cod_clinica;
  $mysql_query = $_con->query($sql);
  if ($mysql_query->num_rows>0) {
    while ($_row = $mysql_query->fetch_assoc()) {
	  $nome_clinica = $_row['clinica']; 
    }
  }
//  echo "<br><br><br>";
  $dia_agenda = substr($data_consulta,8,2);
//  echo $dia_agenda.'<br>';
  $mes_agenda = substr($data_consulta,5,2);
//  echo $mes_agenda.'<br>';
  $ano_agenda = substr($data_consulta,0,4);
//  echo $ano_agenda.'<br>';
  $data_tela = $dia_agenda."/".$mes_agenda."/".$ano_agenda;
//  $data_tela = FormatDateTime($data_consulta,7); 
 // echo $data_tela;
  $query = "SELECT  
    `espera`.`id` AS `id`,
    `espera`.`clinica` AS `clinica`,
    `espera`.`data_inclusao` AS `data_inclusao`,
    `espera`.`data_consulta` AS `data_consulta`,
    `espera`.`cod_cadastro` AS `cod_cadastro`,
    `espera`.`fones` AS `fones`,
    `espera`.`observacoes` AS `observacoes`,
    `espera`.`status` AS `status`,
    `cadastro`.`NOME` AS `nome`,
    `cadastro`.`DTNASC` AS `dtnasc`,
    `cadastro`.`SEXO` AS `sexo` 
  from 
    (`espera` join `cadastro` on((`espera`.`cod_cadastro` = `cadastro`.`CODIGO`))) WHERE clinica = ".$cod_clinica." and data_consulta='".$data_consulta."' and status = 0 order by nome";
  $mysql_query = $_con->query($query);
  $qtderegs = $mysql_query->num_rows;
  $tabela = '<table class="table table-borderless table-striped table-sm">
	<thead class="thead-dark">
	  <th width="2%" class="text-right"><i class="fas fa-hashtag"></i></th>
	  <th width="7%" class="text-right"><i class="fas fa-key"></i> Cadastro</th>
	  <th width="9%" class="text-right"><i class="fas fa-calendar-alt"></i> Data Inc.</th>
	  <th width="9%" class="text-right"><i class="fas fa-calendar-alt"></i> Últ. Consulta</th>
	  <th width="5%" class="text-right"><i class="fas fa-user-alt-slash"></i> Faltas</th>
	  <th width="20%"><i class="fas fa-sort-alpha-down"></i> Nome</th>
	  <th width="20%"><i class="fas fa-phone"></i> Fones</th>
	  <th width="20%"><i class="fas fa-text-width"></i> Observações</th>
	  <th width="10%">Opções</th>
	</thead>
	<tbody>';
  if ($qtderegs==0) {
	   $tabela .= '<tr><td colspan="8"><strong>SEM LISTA DE ESPERA</strong></td></tr>';
  }else{
	$linha = 1;
	while ($dado = $mysql_query->fetch_assoc()) {
		if ($linha == 1) {
			$classe = 'class="bg-light"';
			$linha =2;
		}else {
			$classe = 'class="bg-transparent"';
			$linha =1;
		}
		$id = $dado['id'];
		$cod_cadastro = $dado['cod_cadastro']; 
		$data_inclusao = FormatDateTime($dado['data_inclusao'],7); 
		$fones = $dado['fones']; 
		$nome = $dado['nome']; 
		$observacoes = $dado['observacoes']; 
		$botaoalt = '<button type="button" class="btn btn-sm btn-success" title="Altera Lista Espera de '.$nome.'" data-toggle="modal" data-target="#exampleModal" data-whatever="'.$id.'" data-whateverfones="'.$fones.'" data-whateverobs="'.$observacoes.'"><i class="fas fa-edit"></i>Editar</button>&nbsp;';
		$botaoexc="";
		$botaoexc .= '<button type="button" class="btn btn-sm btn-excluir" title="Exclui '.$nome.' da Lista de Espera" onclick="javascript:excluir_espera('.$id.');"><i class="fas fa-trash "></i> Excluir 
					  </button>';
		$tabela .= '<tr class="'.$classe.'">
				  <td align="right">'.$id.'</td>
				  <td align="right">'.$cod_cadastro.'</td>
				  <td align="right">'.$data_inclusao.'</td>
				  <td align="right"><span class="alert-warning"><strong>'.buscar_ultima_consulta($cod_cadastro).'</strong></span></td>
				  <td align="center"><span class="text-danger"><strong>'.busca_qtde_faltas($cod_cadastro).'</strong></span></td>
				  <td><strong><a href="javascript:abrir_cadastro('.$cod_cadastro.')" class="alert-link">'.$nome.'</a></strong></td>
				  <td>'.$fones.'</td>
				  <td>'.$observacoes.'</td>
				  <td align="center">'.$botaoexc.'</td>';
	}		
  }
  $tabela .='  </tbody></table>';
  //echo $tabela;
  //echo $query;
  ?>
  <!DOCTYPE html>
  <html lang="pt-br">
  <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $_SESSION['sistemaabrev']?> - Lista Espera</title>
  <link rel="stylesheet" type="text/css" href="../css/sticky-footer-navbar.css"/>
  <link rel="stylesheet" type="text/css" href="../css/ajax.css"/>
  <link rel="stylesheet" type="text/css" href="../css/autocomplete.css" />
  <link rel="ICON" href="../imagens/favicon.ico" />
  <link rel="stylesheet" type="text/css" href="../css/formata_textos.css"/>
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link href="../css/all.css" rel="stylesheet">
  <link href="../css/botoes.css" rel="stylesheet">

  </head>
  <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
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
				  <li class="nav-item" active>
					  &nbsp;<a href="index.php" class="btn btn-indigo btn-sm" role="button"><i class="fas fa-stethoscope">
						  </i> Agenda Clínica
					  </a>
				  </li>
				  <li class="nav-item">
					  &nbsp;<a href="imprime_espera.php?query=<?php echo $query; ?>&clinica=<?php echo $nome_clinica; ?>&data=<?php echo $data_tela; ?>" target="_blank" class="btn btn-imprimir btn-sm" role="button">
						  <i class="fas fa-print" aria-hidden="true"></i> Imprimir
					  </a>
				  </li>
				  <li class="nav-item">
					  &nbsp;<a href="espera.php" class="btn btn-voltar btn-sm" role="button">
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

   <div class="container-fluid">
	<div class="row">
	  <div class="col-sm-12" align="center"><span class="textoAzul"><i class="fas fa-clipboard"></i> Lista de Espera
          <?php
           echo $nome_clinica; 
            ?>
	   do dia <?php echo $data_tela ?></span>
     	</div>
      </div>
	<div class="row">
      <form class="form-inline" id="form1" name="form1" action="" method="post">
        <div class="form-group col-12 col-sm-12 col-md-6 col-xl-4">
			<input name="cod_clinica" id="cod_clinica" type="hidden" value="<?php echo $cod_clinica?>">
			<input name="data_consulta" id="data_consulta" type="hidden" value="<?php echo $data_consulta?>">
			<label>Paciente:</label>
              <input name="txtNome" type="text" class="form-control" id="txtNome" autofocus placeholder="Digite nome do Paciente para buscar informações"/>
              <input name="txtCodigo" type="hidden" id="txtCodigo">
		</div>
        <div class="form-group col-12 col-sm-12 col-md-6 col-xl-4">
              <label>Fones:</label>
              <input name="txtFones" type="text" class="form-control" id="txtFones" />
		  </div>
        <div class="form-group col-12 col-sm-12 col-md-6 col-xl-3">
              <label>Observações:</label>
              <input name="txtObs" type="text" class="form-control" id="txtObs" />
		  </div>
         <div class="form-group col-12 col-sm-12 col-md-6 col-xl-1">
             <a href="javascript:inclui_espera();" class="btn btn-incluir btn-sm" role="button" >
                <i class="fas fa-plus"></i> Incluir
              </a>
		  </div>         
        <div class="container-fluid theme-showcase" role="main">
          <div class="row">
			<?php echo $tabela;?>
          </div>
        </div>
      </form>
	   </div>
	  </div>
<!-- modal para alteração -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel">Espera</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
        	<form method="post" id="form2" name="form2" action="processa_espera.php" enctype="multipart/form-data">
                <div class="form-group">
              	<label for="message-text" class="control-label">Telefones:</label>
              	<textarea name="telefone" class="form-control" id="telefone"></textarea>
            	</div>
                <div class="form-group">
              	<label for="message-text" class="control-label">Observações:</label>
              	<textarea name="observacoes" class="form-control" id="observacoes"></textarea>
            	</div>
                <input name="id_espera" type="text" class="form-control" id="id_espera">
                <button type="button" class="btn btn-cancelar" data-dismiss="modal"><i class="fas fa-times"></i> Cancelar</button>
                <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Alterar</button>
        	</form>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
	$('#exampleModal').on('show.bs.modal', function (event) {
	  var button = $(event.relatedTarget) // Button that triggered the modal
	  var recipient = button.data('whatever') // Extract info from data-* attributes
	  var recipientfones = button.data('whateverfones')
	  var recipientobs = button.data('whateverobs')
	  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
	  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
	  var modal = $(this)
	  modal.find('.modal-title').text('Espera # ' + recipient)
	  modal.find('#id_espera').val(recipient)
	  modal.find('#telefone').val(recipientfones)
	  modal.find('#observacoes').val(recipientobs)
	  
	})
  </script>

  <script language="javascript" src="../js/espera.js"></script> 
  <script type="application/javascript" src="../js/ajax.js"></script> 
  <script language="javascript" src="../js/carrega_ajax.js"></script> 
  <script type="text/javascript" src="../js/autocomplete.js"></script> 
  <script src="../js/jquery.min.js"></script> 
  <script src="../js/bootstrap.min.js"></script> 
  <script type="text/javascript">
	new Autocomplete("txtNome", function() { return "autocomplete_espera.php?typing=" + this.text.value ;});
	new Autocomplete("txtFones", function() { return "autocomplete_fones.php?typing=" + this.text.value ;});
</script>
<?php include_once("../utilitarios/rodape-fixo.php");
}
?>
</body>
</html>



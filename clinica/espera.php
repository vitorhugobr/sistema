<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
require_once("../utilitarios/funcoes.php");

if (liberado(7100)==0){
	expulsaVisitante2();
}else{
	$_SESSION['funcao']="Lista de Espera";

?>
<!DOCTYPE>

  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Cadastro de Espera">
  <meta name="author" content="Vitor H M Oliveira">
  <title>Lista de Espera</title>
  <link rel="icon" href="../imagens/favicon.ico">
  <link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">
  <link href="../css/sticky-footer-navbar.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="../css/ajax.css"/>
  <link rel="stylesheet" type="text/css" href="../css/autocomplete.css"/>
  <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
  <link href="../css/formata_textos.css" rel="stylesheet">
  <link href="../css/all.css" rel="stylesheet">
  <link href="../css/botoes.css" rel="stylesheet">
  <script language="javascript" src="../js/espera.js"></script>
  <script type="text/javascript" src="../js/ajax.js"></script>
  <script type="text/javascript" src="../js/carrega_ajax.js"></script>
  <script src="../js/ie-emulation-modes-warning.js"></script>
  <script src="../js/jquery.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/ie10-viewport-bug-workaround.js"></script>
  <script type="text/javascript" src="../js/autocomplete.js"></script>
  </head>
  <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

	<?php include("../utilitarios/cabecalho.php"); ?>	
     
    <form class="form-inline" id="form1" name="form1" method="post" action="">
      <div class="form-group col-12 col-sm-12 col-md-6 col-xl-5">
        <label>Clínica&nbsp;</label>
            <select class="form-control" name="clinica">
              <option>Selecione</option>
              <?php
                $sql = "select * from clinicas order by clinica";
                $mysql_query = $_con->query($sql);
                if ($mysql_query->num_rows>0) {
                  while ($_row = $mysql_query->fetch_assoc()) {?>
                    <option value="<?php echo $_row['id']; ?>"><?php echo $_row['clinica']; ?></option>
                <?php
                  }
                }?>
            </select>
      </div>
     <?php
		if(isset($_SESSION['msg'])){
			echo $_SESSION['msg'];
			unset($_SESSION['msg']);
		}
		?>

      <div class="form-group col-12 col-sm-12 col-md-6 col-xl-4">
        <label>Data da Lista de Espera&nbsp;</label>
        <input type="date" class="form-control" id="data_pesquisa" name="data_pesquisa">
      </div>
      <button type="button" class="btn btn-consultar btn-sm" onclick="javascript:busca_espera();">
      <i class="fas fa-search" aria-hidden="true"></i> Pesquisar</button>
      &nbsp;<a href="index.php" class="btn btn-voltar btn-sm" role="button">
      <i class="fas fa-arrow-left" aria-hidden="true"></i>  Voltar
      </a>
      &nbsp;<a href="../index2.php" class="btn btn-menu btn-sm" role="button">
      <i class="fas fa-list-ul" aria-hidden="true"></i>  Menu
      </a>
    </form>
  <table width="100%" border="1" align="center" cellpadding="2" cellspacing="0">
    <tr>
      <td valign="top">
      	<div style="width:100%; height: 600px; overflow: auto;">
                <?php
				echo '
				<table class="table table-borderless table-striped table-sm">
				<thead class="thead-dark">
				<tr>
					<th><i class="fas fa-hashtag"></i></th>
					<th><i class="fas fa-hospital"></i> Clínica</th>
					<th><i class="fas fa-calendar-alt"></i> Data da Consulta</th>
					<th><i class="fas fa-users"></i> Pacientes</th>
					<th>Opções</th>
				</tr>
				<tbody>
					';
                $sql = "select * from consultas_dia_clinica order by data_consulta DESC";
                $mysql_query = $_con->query($sql);
                if ($mysql_query->num_rows==0) {
			         echo '<tr><td colspan="8" class="alert-danger text-center"><strong>SEM LISTAS DE ESPERA</strong></td></tr>';
				}else{
                  while ($_row = $mysql_query->fetch_assoc()) {
					$id = $_row['id'];
					$clinica = $_row['cod_clinica'];
					$data_cons = FormatDateTime($_row['data_consulta'],5);
					// DATA CONSULTA
					$theValue = (!get_magic_quotes_gpc()) ? addslashes($data_cons) : $data_cons;
					$theValue = ($theValue != "") ? " '" . ConvertDateToMysqlFormat($theValue) . "'" : "NULL";
					$data_consulta = $theValue;

					echo '
					  <tr>
					  <td>'.$_row['id'].'</td>
					  <td>'.$_row['nome_clinica'].'</td>
					  <td>'.FormatDateTime($_row['data_consulta'],7).'</td>
					  <td>'.$_row['pacientes'].'</td>
					  <td width="20%"><a href="mostra_espera.php?clinica='.$clinica.'&data='.$data_cons.'" class="btn btn-consultar btn-sm" role="button">
						  <i class="fas fa-list-ul" aria-hidden="true"></i> Visualizar
						  </a>';
  
					  if (liberado(7200)>0){
						  echo '&nbsp;<a href="mostra_gerar_consulta.php?clinica='.$clinica.'&data='.$data_cons.'" class="btn btn-cancelar btn-sm" role="button">
						  <i class="fas fa-medkit" aria-hidden="true"></i> Gerar Consultas
						  </a>';
					  }
					echo '</td>
						  </tr>';
                  }
                }
				echo '</tbody></table>';
				?>
        </div>
        </td>
    </tr>
  </table>
<?php
include("../utilitarios/rodape-fixo.php");
}
?>
</body>
</html>
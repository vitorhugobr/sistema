<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
require_once('../utilitarios/funcoes.php');

if (liberado(7200)==0){
  expulsaVisitante2();
}else{
  $cod_clinica = $_GET['clinica'];
  $data_consulta = $_GET['data'];
//  echo "<br><br><br>";
  $dia_agenda = substr($data_consulta,8,2);
//  echo $dia_agenda.'<br>';
  $mes_agenda = substr($data_consulta,5,2);
//  echo $mes_agenda.'<br>';
  $ano_agenda = substr($data_consulta,0,4);
//  echo $ano_agenda.'<br>';
  $data_tela = $dia_agenda."/".$mes_agenda."/".$ano_agenda;
  
$titulo = '<span class="textoAzul"><i class="fas fa-clipboard"></i> Gerar Consultas ';
		$sql = "select * from clinicas where id=".$cod_clinica;
		$mysql_query = $_con->query($sql);
		if ($mysql_query->num_rows>0) {
		  while ($_row = $mysql_query->fetch_assoc()) {
			$titulo .= $_row['clinica']; 
		  }
		}
$titulo .=' para o dia '.$data_tela.'</span>';
  
$_SESSION['funcao'] = "Gerar Consultas";
  
//  $data_tela = FormatDateTime($data_consulta,7); 
$query = "SELECT * from espera_view WHERE clinica = ".$cod_clinica." and data_consulta='".$data_consulta."' and status = 0 order by nome";
//  echo "<br><br><br>".$query."<br>";
$mysql_query = $_con->query($query);
$qtderegs = $mysql_query->num_rows;
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

  <link href="../css/bootstrap-datetimepicker.css" rel="stylesheet">
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
                          <a href="index.php" class="btn btn-indigo btn-sm" role="button" title="Volta para o menu Agenda Clínica"><i class="fas fa-stethoscope">
                              </i> Agenda Clínica
                          </a>
                      </li>
                      <li class="nav-item">
                          <a href="espera.php" class="btn btn-voltar btn-sm" role="button" title="Volta para tela do Cadastro de Espera">
                              <i class="fas fa-arrow-left" aria-hidden="true"></i>  Voltar
                          </a>
                      </li>
                      <li class="nav-item">
                          <a href="../index2.php" class="btn btn-menu btn-sm" role="button" title="Retorna ao Menu Principal">
                              <i class="fas fa-list-ul" aria-hidden="true"></i>  Menu
                          </a>
                      </li>
                      <li class="nav-item">
                          <button type="button" class="btn btn-sm btn-orange" onclick="javascript:gravar_consultas(<?php echo $cod_clinica?>,<?php echo $qtderegs?>)" title="Clique neste botão para gerar a consulta do dia">
                              <i class="fas fa-medkit" aria-hidden="true"></i>  Gerar Consultas 
                          </button>
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

  <div class="row col-12">
      <div class="alert alert-warning">
        <strong>Atenção!</strong> Selecione os pacientes para o dia da consulta. Altere a data de consulta para os demais.
      </div>
      <div class="alert alert-light">
        <?php echo $titulo; ?>
      </div>
   </div>
  <div class="container-fluid">
    <input name="cod_clinica" id="cod_clinica" type="hidden" value="<?php echo $cod_clinica?>">
    <input name="data_consulta" id="data_consulta" type="hidden" value="<?php echo $data_consulta?>">
    <table class="table table-sm table-borderless table-striped">
      <tr>
          <td width="33%">      
          </td>
          <td width="2%">
              <input name="marcall" type="checkbox" class="form-control" value="marcall" onclick="selecionar_todos()"/>
          </td>
          <td width="15%" align="left">
              <label class="col-sm col-form-label">Marcar Todos <?php echo $qtderegs?> Pacientes</label>
          </td>
  
          <td width="2%">
              <input name="marcall2" type="checkbox" class="form-control" value="marcall2" onclick="deselecionar_todos()"/>
          </td>
          <td width="15%" align="left">
              <label class="col-sm col-form-label">Desmarcar Todos</label>
          </td>
          <td width="33%">      
          </td>
      </tr>
    </table>
    <div class="container-fluid theme-showcase" role="main">
      <div class="row">
        <table class="table table-borderless table-striped table-sm">
          <thead class="thead-dark">
            <th width="2%"><i class="fas fa-check"></i></th>
            <th width="3%" class="text-right"><i class="fas fa-hashtag"></i></th>
            <th width="7%" class="text-right"><i class="fas fa-key"></i> Cód. Cad.</th>
            <th width="10%" class="text-center"><i class="fas fa-calendar-alt"></i> Data Inc.</th>
            <th width="10%" class="text-center"><i class="fas fa-calendar-alt"></i> Data Consulta</th>
            <th width="23%"><i class="fas fa-user"></i> Nome</th>
            <th width="23%"><i class="fas fa-phone"></i> Fones</th>
            <th width="22%"><i class="fas fa-text-width"></i> Observações</th>
          </thead>
          <tbody>
    <?php        
    if ($qtderegs==0) {?>
         <tr><td colspan="8" class="alert-danger text-center"><strong>SEM PACIENTES PARA GERAR CONSULTAS</strong></td></tr>
    <?php }else{
      $linha = 1;
      $indice = 0;
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
          $data_inclusao = $dado['data_inclusao']; 
          $data_consulta =$dado['data_consulta']; 
  //		echo $data_consulta.'<br>';
          $fones = $dado['fones']; 
          $nome = $dado['nome']; 
          $observacoes = $dado['observacoes']; 
		  ?>
          <tr>
				  <td>
				  	<input type="checkbox" class="form-control" name="checkconsulta" id="checkconsulta"/>
				  </td>
				  <td>
				  	<input type="number" readonly class="form-control-plaintext text-right" id="id" name="id" value="<?php echo $id?>">
				  </td>
				  <td>
				  	<input type="number" readonly class="form-control-plaintext text-right" id="cod_cadastro" name="cod_cadastro" value="<?php echo $cod_cadastro?>" >
				  </td>
				  <td class="text-right">
				  	<input type="date" readonly class="form-control-plaintext text-right" id="data_inclusao" name="data_inclusao" value="<?php echo $data_inclusao?>">
				  </td>
				  <td>
				  	<input type="date" class="form-control" name="data_consulta" id="data_consulta" value="<?php echo $data_consulta?>" onChange="javascript:mudou(this.value,<?php echo $indice?>)">
				  	<input type="hidden" class="form-control-plaintext" name="data_consulta_a" id="data_consulta_a" value="<?php echo $data_consulta?>">
                  </td>
				  <td>
				  	<input type="text" readonly class="form-control-plaintext text-left" id="nome" name="nome" value="<?php echo $nome?>">
				  </td>
				  <td>
				  	<input type="text" readonly class="form-control-plaintext text-left" id="fones" name="fones" value="<?php echo $fones?>">
				  </td>
				  <td>
				  	<input type="text" readonly class="form-control-plaintext text-left" id="observacoes" name="observacoes" value="<?php echo $observacoes?>">
				  </td> 
				  </tr>
                  <?php 
		$indice++;
	}		
  }
  ?> 
  	</tbody></table>
      </div>
    </div>
  </div>	
  </form>
<div id="comandos"></div>
  <script language="javascript" src="../js/espera.js"></script> 
  <script type="application/javascript" src="../js/ajax.js"></script> 
  <script language="javascript" src="../js/carrega_ajax.js"></script> 
  <script type="text/javascript" src="../js/autocomplete.js"></script> 
  <script src="../js/jquery.min.js"></script> 
  <script src="../js/bootstrap.min.js"></script> 
  <script type="text/javascript">
		new Autocomplete("txtNome", function() { return "autocomplete_espera.php?typing=" + this.text.value ;});
	</script>
<?php include_once("../utilitarios/rodape-fixo.php");
}
?>
</body>
</html>



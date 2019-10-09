<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
require_once('../utilitarios/funcoes.php');

if (liberado(7600)==0){
  expulsaVisitante2();
}else{
  $_SESSION['funcao']="Painel Consultas";
  $cod_clinica = $_GET['clinica'];
  $data_agenda = $_GET['data'];
  //echo '<br><br><br>'.$data_agenda.'<br>';
  $dia_agenda = substr($data_agenda,0,2);
  //echo $dia_agenda.'<br>';
  $mes_agenda = substr($data_agenda,3,2);
  //echo $mes_agenda.'<br>';
  $ano_agenda = substr($data_agenda,6,4);
  //echo $ano_agenda.'<br>';
  $data_agenda = $ano_agenda."-".$mes_agenda."-".$dia_agenda;

  $query = "SELECT * from agenda_dia_clinica WHERE clinica = ".$cod_clinica." and data_agenda='".$data_agenda."'  and status = 0 and situacao=3 order by prioridade desc";
  //echo $query;
  $mysql_query = $_con->query($query);
  $qtderegs = $mysql_query->num_rows;
  $tabela = '<table class="table table-sm table-striped">
	<thead class="table-dark">
	  <th class="text-center"><i class="fas fa-sort-numeric-down"></i></th>
	  <th><i class="fas fa-user"></i> Nome</th>
	</thead>
	<tbody>';
  if ($qtderegs==0) {
	 $tabela .= '<tr><td colspan="5"><strong>SEM CONSULTAS</strong></td></tr>';
  }else{
    $indice = 0;
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
  		$fones = $dado['fones']; 
  		$nome = $dado['nome']; 
  		$situacao = $dado['situacao']; 
  		$prioridade = $dado['prioridade']; 
//		echo $situacao."<br>";

  		$tabela .= '<tr class="'.$classe.'">
				  <td align="center" width="10%"><img src="../imagens/ajax-loading2.gif" width="100" ></td>
				  <td><strong>'.$nome.'</strong></td>';
		
    }
  }
  $tabela .='  </tbody></table>';
  ?>
  <!DOCTYPE html>
  <html lang="pt-br">
  <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="refresh" content="30">
  <title><?php echo $_SESSION['sistemaabrev']?> - Painel Consultas</title>
  <link rel="stylesheet" type="text/css" href="../css/sticky-footer-navbar.css"/>
  <link rel="stylesheet" type="text/css" href="../css/ajax.css"/>
  <link rel="stylesheet" type="text/css" href="../css/autocomplete.css" />
  <link rel="icon" href="../imagens/favicon.ico" />
  <link rel="stylesheet" type="text/css" href="../css/formata_textos.css"/>
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link href="../css/all.css" rel="stylesheet">
  </head>
  <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

  <?php include("../utilitarios/cabecalho.php"); ?>	  

  <div class="container-fluid">
	<div class="row">
	  <div class="col-sm-12" align="center"><span class="textoAzul"><i class="fas fa-clipboard"></i> Consultas 
          <?php
            $sql = "select * from clinicas where id=".$cod_clinica;
            $mysql_query = $_con->query($sql);
            if ($mysql_query->num_rows>0) {
              while ($_row = $mysql_query->fetch_assoc()) {?>
                <?php echo $_row['clinica']; 
              }
            }?>
	   do dia <?php echo FormatDateTime($data_agenda,7) ?></span></div>
      </div>
        <div class="container-fluid theme-showcase" role="main">
          <div class="row">
			<?php echo $tabela;?>
          </div>
        </div>
    </div>
  <script language="javascript" src="../js/agenda_consultas.js"></script> 
  <script type="application/javascript" src="../js/ajax.js"></script> 
  <script language="javascript" src="../js/carrega_ajax.js"></script> 
  <script type="text/javascript" src="../js/autocomplete.js"></script> 
  <script src="../js/jquery.min.js"></script> 
  <script src="../js/bootstrap.min.js"></script> 
<?php include_once("../utilitarios/rodape-fixo.php");
}
?>
</body>
</html>
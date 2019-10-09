<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
require_once('../utilitarios/funcoes.php');

if (liberado(7500)==0){
  expulsaVisitante2();
}else{
  $_SESSION['funcao']="Agenda Consultas";
  $cod_clinica = $_GET['clinica'];
  $data_agenda = $_GET['data'];
//  echo '<br><br><br>';
  $dia_agenda = substr($data_agenda,2,2);
  //echo $dia_agenda.'<br>';
  $mes_agenda = substr($data_agenda,5,2);
  //echo $mes_agenda.'<br>';
  $ano_agenda = substr($data_agenda,8,4);
  //echo $ano_agenda.'<br>';
  $data_agenda = $ano_agenda."-".$mes_agenda."-".$dia_agenda;

  $query = "SELECT * from agenda_dia_clinica WHERE clinica = ".$cod_clinica." and data_agenda='".$data_agenda."' and status=0 and situacao = 3 order by prioridade desc";
  //echo $query;
  $mysql_query = $_con->query($query);
  $qtderegs = $mysql_query->num_rows;
  $tabela = '<table class="table table-sm">
	<thead class="table-dark">
	  <th width="2%" class="text-right"><i class="fas fa-hashtag"></i></th>
	  <th width="8%" class="text-right"><i class="fas fa-key"></i> Cadastro</th>
	  <th width="30%">Nome</th>
	  <th width="30%"><i class="fas fa-phone"></i> Fones</th>
	  <th width="10%"><i class="fas fa-sort-numeric-up"></i> Prioridade</th>
	  <th width="10%">Situação</th>
	  <th width="10%">Opções</th>
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
		switch ($prioridade) {
			case 0:  //pendente
				$fontecor = "#000000"; //preto
				$txtprioridade = "Normal";
				break;
			case 1:  //faltou
				$fontecor = "#000099"; //azul
				$txtprioridade = "Alta";
				break;
			case 2:  //chegou
				$fontecor = "#FF0000"; //vermelho
				$txtprioridade = "Altíssima";
				break;
			default:					
				$txtprioridade = "";
				break;
		}
//		echo $situacao."<br>";
		switch ($situacao) {
			case 1:  //pendente
				$txtsituacao = "Pendente";
				break;
			case 2:  //faltou
				$txtsituacao = "Faltou";
				break;
			case 3:  //chegou
				$txtsituacao = "Chegou";
				break;
			case 4:  //atendido
				$txtsituacao = "Atendido";
				break;
			default:					
				$txtsituacao = "";
				break;
		}
		$tabela .= '<tr class="'.$classe.'">
				  <td width="2%" align="right">'.$id.'</td>
				  <td width="8%" align="right">'.$cod_cadastro.'</td>
				  <td><font color='.$fontecor.'><strong>'.$nome.'</strong></font></td>
				  <td>'.$fones.'</td>
				  <td><font color='.$fontecor.'><strong>'.$txtprioridade.'</strong></font></td>
				  <td>'.$txtsituacao.'</td>				  	
				  <td>
					<button type="button" class="btn btn-sm btn-teal" title="Iniciar consulta de '.$nome.'" onclick="iniciar_consulta('.$cod_cadastro.','.$id.')">
					<i class="fas fa-medkit"></i> Prontuário
					</button>
				  </td>';
		$indice++;
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
  <title><?php echo $_SESSION['sistemaabrev']?> - Agenda Consultas</title>
  <link rel="stylesheet" type="text/css" href="../css/sticky-footer-navbar.css"/>
  <link rel="stylesheet" type="text/css" href="../css/ajax.css"/>
  <link rel="stylesheet" type="text/css" href="../css/autocomplete.css" />
  <link rel="icon" href="../imagens/favicon.ico" />
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
					  &nbsp;<a href="consultas.php" class="btn btn-voltar btn-sm" role="button">
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
      <form class="form-inline" id="form1" name="form1" action="" method="post">
      	<input name="cod_clinica" id="cod_clinica" type="hidden" value="<?php echo $cod_clinica?>">
        <input name="data_consulta" id="data_consulta" type="hidden" value="<?php echo $data_agenda?>">
        <div class="container-fluid theme-showcase" role="main">
          <div class="row">
			<?php echo $tabela;?>
          </div>
        </div>
      </form>
    </div>
  <script language="javascript" src="../js/agenda_consultas.js"></script> 
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



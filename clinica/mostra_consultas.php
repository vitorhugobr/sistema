<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
require_once('../utilitarios/funcoes.php');

if (liberado(7300)==0){
  expulsaVisitante2();
}else{
  $_SESSION['funcao']="Agenda Consultas";
  $cod_clinica = $_GET['clinica'];
  $data_agenda = $_GET['data'];
  $sql = "select * from clinicas where id=".$cod_clinica;
  $mysql_query = $_con->query($sql);
  if ($mysql_query->num_rows>0) {
    while ($_row = $mysql_query->fetch_assoc()) {
	  $nome_clinica = $_row['clinica']; 
    }
  }

  //echo '<br><br><br>'.$data_agenda;
  $dia_agenda = substr($data_agenda,2,2);
  //echo $dia_agenda.'<br>';
  $mes_agenda = substr($data_agenda,5,2);
  //echo $mes_agenda.'<br>';
  $ano_agenda = substr($data_agenda,8,4);
  //echo $ano_agenda.'<br>';
  $data_agenda = $ano_agenda."-".$mes_agenda."-".$dia_agenda;
  $data_tela = $dia_agenda."/".$mes_agenda."/".$ano_agenda;

  $query = "SELECT cadastro.NOME AS nome, agenda_clinica.id, agenda_clinica.data_agenda, agenda_clinica.clinica, agenda_clinica.cod_cadastro, agenda_clinica.situacao, agenda_clinica.prioridade, agenda_clinica.data_inc_esp, agenda_clinica.observacoes, agenda_clinica.fones, agenda_clinica.status, cadastro.DTNASC AS dtnasc, cadastro.SEXO AS sexo FROM agenda_clinica LEFT OUTER JOIN cadastro ON (agenda_clinica.cod_cadastro = cadastro.CODIGO) WHERE clinica = ".$cod_clinica." and data_agenda='".$data_agenda."' order by situacao, prioridade desc";
  #$query = "SELECT * from agenda_dia_clinica WHERE clinica = ".$cod_clinica." and data_agenda='".$data_agenda."' order by situacao, prioridade desc";
  //echo $query;
  $mysql_query = $_con->query($query);
  $qtderegs = $mysql_query->num_rows;
  $tabela = '<table class="table table-sm">
	<thead class="table-dark">
	  <th width="2%" class="text-right"><i class="fas fa-hashtag"></i></th>
	  <th width="6%" class="text-right"><i class="fas fa-key"></i> Cadastro</th>
	  <th width="22%"><i class="fas fa-user"></i> Nome</th>
	  <th width="20%"><i class="fas fa-phone"></i> Fones</th>
	  <th width="20%"><i class="fas fa-text-width"></i> Observações</th>
	  <th width="10%"><i class="fas fa-sort-numeric-up"></i> Prioridade</th>
	  <th width="10%"><i class="fas fa-calendar-check"></i> Situação</th>
	  <th width="13%">Opções</th>
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
		$observacoes = $dado['observacoes']; 
		$status = $dado['status']; 
//		echo $situacao."<br>";
		switch ($situacao) {
			case 1:  //pendente
				$fontecor = "#000000"; //preto
				break;
			case 2:  //faltou
				$fontecor = "#FF0000"; //vermelho
				break;
			case 3:  //chegou
				$fontecor = "#009900"; //verde
				break;
			case 4:  //atendido
				$fontecor = "#000099"; //azul
				break;
			default:					
				break;
		}
		$tabela .= '<tr class="'.$classe.'">
				  <td><input name="id" type="text" class="form-control-plaintext text-right" id="id" value="'.$id.'"></td>
				  <td><input name="cod_cadastro" type="text" class="form-control-plaintext text-right" id="cod_cadastro" value="'.$cod_cadastro.'"></td>
				  <td><font color='.$fontecor.'><strong><input name="nome" type="text" class="form-control-plaintext" id="nome" value="'.$nome.'"></strong></font></td>';
		if ($status==0){		
			$tabela .='<td><input name="fones" type="text" class="form-control" id="fones" value="'.$fones.'"></td>
				<td><input name="observacoes" type="text" class="form-control" id="observacoes" value="'.$observacoes.'"></td>
				<td>
				<select class="form-control" name="prioridade" id="prioridade">
          	  	<option value="0" ';
			if ($prioridade==0) 
				$tabela .= 'selected="selected" ';
			$tabela .= '>Normal</option>';
			$tabela .= '<option value="1"';
			if ($prioridade==1) 
				$tabela .= 'selected="selected"';
			$tabela .= '>Alta';
			$tabela .= '</option>
						<option value="2"';
			if ($prioridade==2) 
				$tabela .= 'selected="selected"';
			$tabela .= '>Altíssima</option>
						</select>
					  </td>
					  <td>				  	
						<select class="form-control" name="situacao" id="situacao">
						<option value="1"';
			if ($situacao==1) 
				$tabela .= 'selected="selected"';
			$tabela .= '>Pendente</option>';
			$tabela .= '<option value="2"';
			if ($situacao==2) 
				$tabela .= 'selected="selected"';
			$tabela .= '>Faltou';
			$tabela .= '</option>
						<option value="3"';
			if ($situacao==3) 
				$tabela .= 'selected="selected"';
			$tabela .= '>Chegou';
			$tabela .= '</option>
						<option value="4"';
			if ($situacao==4) 
				$tabela .= 'selected="selected"';
			$tabela .= '>Atendido';
			$tabela .= '</option>
						</select>
					  </td>
					  <td nowrap>
						<button type="button" class="btn btn-sm btn-success" title="Altera dados da consulta de '.$nome.'" onclick="altera_consulta('.$id.', '.$indice.')">
						<i class="fas fa-save "></i> Alterar 
						</button>
					  </td>';
		}else {
			$tabela .='<td><input name="fones" type="text" class="form-control-plaintext" id="fones" value="'.$fones.'"></td>
				<td><input name="observacoes" type="text" class="form-control-plaintext" id="observacoes" value="'.$observacoes.'"></td> 
				<td>
				<select class="form-control-plaintext" name="prioridade" id="prioridade" disabled>
          	  	<option value="0" ';
			if ($prioridade==0) 
				$tabela .= 'selected="selected" ';
			$tabela .= '>Normal</option>';
			$tabela .= '<option value="1"';
			if ($prioridade==1) 
				$tabela .= 'selected="selected"';
			$tabela .= '>Alta';
			$tabela .= '</option>
						<option value="2"';
			if ($prioridade==2) 
				$tabela .= 'selected="selected"';
			$tabela .= '>Altíssima</option>
						</select>
					  </td>
					  <td>				  	
						<select class="form-control-plaintext" name="situacao" id="situacao" disabled>
						<option value="1"';
			if ($situacao==1) 
				$tabela .= 'selected="selected"';
			$tabela .= '>Pendente</option>';
			$tabela .= '<option value="2"';
			if ($situacao==2) 
				$tabela .= 'selected="selected"';
			$tabela .= '>Faltou';
			$tabela .= '</option>
						<option value="3"';
			if ($situacao==3) 
				$tabela .= 'selected="selected"';
			$tabela .= '>Chegou';
			$tabela .= '</option>
						<option value="4"';
			if ($situacao==4) 
				$tabela .= 'selected="selected"';
			$tabela .= '>Atendido';
			$tabela .= '</option>
						</select>
					  </td>
					  <td>
					  </td>';
		}
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
  <link rel="SHORTCUT ICON" href="../imagens/favicon.ico" />
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
					  <a href="index.php" class="btn btn-indigo btn-sm" role="button"><i class="fas fa-stethoscope">
						  </i> Agenda Clínica
					  </a>
				  </li>
				  <li class="nav-item">
					  <a href="imprime_consultas.php?query=<?php echo $query; ?>&clinica=<?php echo $nome_clinica; ?>&data=<?php echo $data_tela; ?>" target="_blank" class="btn btn-imprimir btn-sm" role="button">
						  <i class="fas fa-print" aria-hidden="true"></i> Imprimir
					  </a>
				  </li>
				  <li class="nav-item">
					  <a href="agenda_consultas.php" class="btn btn-voltar btn-sm" role="button">
						  <i class="fas fa-arrow-left" aria-hidden="true"></i> Voltar
					  </a>
				  </li>
				  <li class="nav-item">
					  <a href="../index2.php" class="btn btn-menu btn-sm" role="button">
						  <i class="fas fa-list-ul" aria-hidden="true"></i> Menu
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
            echo $nome_clinica; 
            ?>
	   do dia <?php echo $data_tela ?></span>
     	</div>
      </div>
	<div class="row">
      <form class="form-inline" id="form1" name="form1" action="" method="post">
        <div class="form-group col-4">
			<input name="cod_clinica" id="cod_clinica" type="hidden" value="<?php echo $cod_clinica?>">
			<input name="data_consulta" id="data_consulta" type="hidden" value="<?php echo $data_agenda?>">
			<label>Paciente:</label>
              <input name="txtNome" type="text" class="form-control" id="txtNome" autofocus placeholder="Digite nome do Paciente para buscar informações"/>
              <input name="txtCodigo" type="hidden" id="txtCodigo">
		</div>
        <div class="form-group col-3">
              <label>Fones:</label>
              <input name="txtFones" type="text" class="form-control" id="txtFones" />
		  </div>
        <div class="form-group col-3">
              <label>Observações:</label>
              <input name="txtObs" type="text" class="form-control" id="txtObs" />
		  </div>
         <div class="form-group col-2">
             <a href="javascript:inclui_consulta();" class="btn btn-incluir btn-sm" role="button" >
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



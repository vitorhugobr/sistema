<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
require_once ('../utilitarios/funcoes.php');
$_SESSION['mudoutarefa'] = false;
$id_tarefa = $_GET['tarefa'];
$_SESSION['funcao']="Consulta Tarefa";
$sql = "SELECT id, data_tarefa, (SELECT users.usuario FROM users WHERE users.codigo= tarefas.usuario) AS usuario, assunto, tarefa, data_inicio, data_fim, CASE WHEN status = 0 THEN 'ABERTA' ELSE 'ENCERRADA' END AS status, CASE WHEN prioridade = 1 THEN 'BAIXA' WHEN prioridade = 2 THEN 'MÉDIA' ELSE 'ALTA' END as prioridade, demanda from tarefas where id=".$id_tarefa;

$mysql_query = $_con->query($sql);
if ($mysql_query->num_rows<1) {
	echo '<script>alert("Tarefa não cadastrada!");</script>';					
}else{
	while ($dados_s = $mysql_query->fetch_assoc()) {
		$codigo = $dados_s["id"];
		$datat = FormatDateTime($dados_s['data_inicio'],7);
		$datatarefa = FormatDateTime($dados_s['data_tarefa'],7);
		$usuario = $dados_s["usuario"];
		$assunto = $dados_s["assunto"];
		$tarefa = $dados_s["tarefa"];
		$datainicio = FormatDateTime($dados_s['data_inicio'],7);
		$datafim = FormatDateTime($dados_s['data_fim'],7);
		$dataf = FormatDateTime($dados_s['data_fim'],7);
		$status = $dados_s["status"];
		$prioridade = $dados_s["prioridade"];
		$demanda = $dados_s["demanda"];
	}
}		
//cho '- Sem formatação: '.$datat.'<br> Com formatação: '.$datainicio;
$sql2 = "SELECT * from historico_tarefas where cod_tarefa =".$id_tarefa.' order by data_historico desc';
//echo $sql2;
$mysql_query2 = $_con->query($sql2);
$hist = '';
if ($mysql_query2->num_rows<1) {
	$numhist = 0;
}else{	
	$numhist = $mysql_query2->num_rows;
	while ($dado = $mysql_query2->fetch_assoc()) {
		$idhistorico = $dado["id_historico"];
		$idtarefa = $dado["cod_tarefa"];
		$datahistorico = FormatDateTime($dado['data_historico'],7);
		$descricao = $dado["descricao"];
		$hist .= $datahistorico.' - '.$descricao.'&#13;&#10;'; // códigos '&#13;&#10;' servem para quebrar linha dentro do txtarea
	}
}		

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Cadastro de Eleitores">
<meta name="author" content="Vitor H M Oliveira">
<title>Tarefas</title>
<link rel="icon" href="../imagens/favicon.ico">
<link href="../css/formata_textos.css" rel="stylesheet">
<link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">
<link href="../css/sticky-footer-navbar.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../css/ajax.css"/>
<link rel="stylesheet" type="text/css" href="../css/autocomplete.css"/>
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="../css/all.min.css"/>
<link href="../css/botoes.css" rel="stylesheet">
<script language="javascript" src="../js/tarefas.js"></script>
<script src="../js/carrega_ajax.js" type="text/javascript"></script>
<script src="../js/ajax.js" type="text/javascript"></script>
<script src="../js/ie-emulation-modes-warning.js"></script>
<script src="../js/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script type="text/javascript" src="../js/autocomplete.js"></script>
<script src="../js/ie10-viewport-bug-workaround.js"></script>
</head>
<body onLoad="atualiza_info_tarefa(<?php echo $id_tarefa;?>)" onBlur="atualiza_info_tarefa(<?php echo $id_tarefa;?>)" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"> 
 
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
                    <?php
					if ($datat==""){
						echo '<li class="nav-item"><button type="button" class="btn btn-sm btn-orange" onclick="javascript:iniciatarefa('.$codigo.');">
							<i class="fas fa-plus" aria-hidden="true"></i> Iniciar Tarefa
							</button></li>';
					}else{
						if ($status=='ABERTA'){
							echo '<li class="nav-item">
								&nbsp;<button type="button" class="btn btn-sm btn-primary" onclick="javascript:inserehistorico('.$codigo.');">
								<i class="fas fa-plus" aria-hidden="true"></i> Incluir Histórico
								</button></li>';
						}
					}
					if ($dataf==""){
						echo '<li class="nav-item">
							&nbsp;<button type="button" class="btn btn-sm btn-encerrar" onclick="javascript:encerratarefa('.$codigo.');">
							<i class="fas fa-folder-minus"></i> Encerrar Tarefa
							</button></li> ';
					}
					?>
                    <li class="nav-item">
	      					&nbsp;<button type="button" class="btn btn-sm btn-voltar" onclick="javascript:voltaPag('tarefas.php');">
							<i class="fas fa-arrow-left"></i> Voltar
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

<form name="form1" method="post" action="">
  <table class="table table-sm table-borderless">
    <tr>
      <td width="11%" nowrap="nowrap" align="right"><label># Tarefa:</label>
      </td>
      <td width="38%">
      	<div class="col col-sm-6">
        	<strong><?php echo $codigo; 
						if ($demanda>0){
							echo "</strong>&nbsp;&nbsp;Demanda de Origem: <strong>".$demanda."</strong>";
						}
				?>
        </div>
        </td>
      <td width="12%" nowrap="nowrap" align="right"><label>Data Tarefa:</label>
      </td>
      <td width="39%">
      	<div class="col col-sm-4">
        	<strong><?php echo $datatarefa ?></strong>
        </div>
      </td>
    </tr>
    <tr>
      <td align="right"><label>Data Início:</label>
      </td>
      <td>
       	<div class="col col-sm-4">
			<strong><?php echo $datainicio ?></strong>
        </div>
      </td>
      <td align="right"><label>Data Fim:</label>
      </td>
      <td>
      	<div class="col col-sm-4">
        	<strong><?php echo $datafim ?></strong>
        </div>
        </td>
    </tr>
    <tr>
      <td align="right"><label>Usuário:</label>
      </td>
      <td>
	     <div class="col col-sm-4">
			<strong><?php echo $usuario ?></strong>
        </div>
        </td>
      <td align="right"><label>Prioridade:</label></td>
      <td >
       	<div class="col col-sm-4">
			<strong><?php echo $prioridade ?></strong>
        </div>
        </td>
    </tr>
    <tr>
      <td align="right"><label>Status:</label>
      </td>
      <td>
      	<div class="col col-sm-4">
			<strong><?php echo $status ?></strong>
      	</div>  
      </td>
      <td align="right"><label>Assunto:</label>
      </td>
      <td>
	     <div class="col col-sm-12">
		 	<strong><?php echo $assunto ?></strong>
        </div>
        </td>
    </tr>
  </table>
  <table width="100%" border="1" cellspacing="0" cellpadding="0">
    <tr>
      <td width="50%" nowrap="nowrap" align="center"><font color="#003399" size="+1" face="Tahoma, Geneva, sans-serif"><strong><i class="fas fa-tasks"></i> Tarefa</strong></font></td>
      <td width="50%" nowrap="nowrap" align="center"><font color="#003399" size="+1" face="Tahoma, Geneva, sans-serif"><strong><i class="fas fa-history"></i> Histórico</strong></font></td>
    </tr>
    <tr>
      <td nowrap="nowrap">
        <textarea name="txttarefa" cols="80" rows="15" readonly="readonly" class="form-control" id="txttarefa"><?php echo $tarefa ?></textarea>
       </td>
      <td valign="top" nowrap="nowrap"><?php 
	if ($numhist == 0){
      echo '<textarea name="txthist" cols="80" rows="15" readonly="readonly" class="form-control" id="txthist">Tarefa NÃO INICIADA ou sem Histórico</textarea>';
	}else{
      echo '<textarea name="txthist" cols="80" rows="15" readonly="readonly" class="form-control" id="txthist">'.$hist .'</textarea>';		
	}?>
    </tr>
  </table>
</form>
<?php
include("../utilitarios/rodape-fixo.php");
?>
</body>
</html>
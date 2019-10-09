<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
require_once ('../utilitarios/funcoes.php');
if (liberado(2001)==0){
	expulsaVisitante2();
}else{

	$codigo = $_GET['codigo'];
	$nivel = $_GET['nivel'];
?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Inclusão de Demandas">
	<meta name="author" content="Vitor H M Oliveira">
	<title>Nova Demanda</title>
	<link rel="icon" href="../imagens/favicon.ico">
	<link href="../css/formata_textos.css" rel="stylesheet">
  	<link href="../css/all.css" rel="stylesheet">  	
  	<link href="../css/botoes.css" rel="stylesheet">

	<link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">
	<link href="../css/sticky-footer-navbar.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../css/ajax.css"/>
	<link rel="stylesheet" type="text/css" href="../css/autocomplete.css"/>
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
	<script language="javascript" src="../js/ajax.js"></script>
 	<script src="../js/ie-emulation-modes-warning.js"></script>
	<script src="../js/jquery.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../js/autocomplete.js"></script>
	<script type="text/javascript" src="../js/demandas.js"></script>
  	<script src="../js/ie10-viewport-bug-workaround.js"></script>
  	<script language="javascript">
  	function incluir(){
		if (document.form1.txtcodigo.value===""){
			alert("Pesquise o nome do Eleitor para incluir demanda.");
			document.form1.txtnome.focus();
			return false;
		}
		var dados  = 'inclui_demanda.php?codigo='+document.form1.txtcodigo.value;
		dados += '&assunto='+document.form1.txtassunto.value;
		dados += '&protocolo='+document.form1.txtprotocolo.value;
		dados += '&descricao='+document.form1.txtdescricao.value;
		dados += '&prioridade='+document.form1.txtprioridade.value;
		dados += '&responsavel='+document.form1.txtresponsavel.value;
		dados += '&nome='+document.form1.txtnome.value;
		//alert(dados);
		if (confirm("Confirma a Inclusão da demanda?")){
			ajax2(dados, 'carregando');
			fechaJanela();
		}
  	}
  
  	function fechaJanela(){
    	self.close();
  	}

</script>
</head>

<body>
<?php include("../utilitarios/cabecalho.php"); ?>	  

<form class="form-inline" name="form1" method="post" action="">
  <nav class="navbar navbar-expand-sm navbar-light shadow-sm">
  	<div class="container">
    	<span class="navbar-brand">
        </span>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        	<ul class="navbar-nav mr-auto">
            	<li class="nav-item">
                	<button type="button" class="btn btn-sm btn-incluir" onclick="javascript:incluir();">
        			<i class="fas fa-save" aria-hidden="true"></i> Incluir
      				</button>
                </li>
                  &nbsp;<a href="demandas.php" class="btn btn-voltar btn-sm" role="button">
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


<table width="100%"  border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
    <td width="13%" align="right"><label>Eleitor</span>:</label></td>
    <td class="textoAzul">
	<?php 		
		if ($_SESSION["usuarioNivel"]==9){
			echo '<div class="col-sm-2">';
			echo '<input type="hidden" name="txtcodigo" value='.$codigo.'>';
			echo $codigo;
			echo '</div>';
		}else{
			echo '<div class="col-sm-8">';
			echo '<input class="form-control" name="txtnome" type="text" size="50" maxlength="50" placeholder="Pesquise o nome do Eleitor para busca no cadastro" autofocus required>';
			echo '<input type="hidden" name="txtcodigo" id="txtcodigo" >';
			echo '</div>';
		}
	?>
	</td>
  </tr>
  <tr>
    <td><div align="right"><label>Secretaria:</label></div></td>
    <td >
		<div class="col-sm-4">
        <select name="txtassunto" class="form-control">
				<?php
				$sql = "select * from secretarias order by descricao";
				$mysql_query = $_con->query($sql);
				if ($mysql_query->num_rows>0) {
					while ($_row = $mysql_query->fetch_assoc()) {?>
						<option value="<?php echo $_row['codigo']; ?>"><?php echo $_row['descricao']; ?></option>
				<?php			
					}
				}?>
      	</select>
        </div>
    </td>
  </tr>
  <tr>
    <td valign="top" align="right" nowrap="nowrap"><label>Endereço:</label>
    </td>
    <td>
		<div class="col-sm-6">
    		<input type="text" class="form-control" size="80" maxlength="100" name="txtendereco" id="txtendereco" placeholder="Endereço da Demanda, se necessário">
  		</div>
     </td>
  </tr>
  <tr>
    <td valign="top" align="right" nowrap="nowrap"><label>Protocolo:</label>
    </td>
    <td>
		<div class="col-sm-3">
    		<input type="text" class="form-control" name="txtprotocolo" id="txtprotocolo">
  		</div>
     </td>
  </tr>
  <tr>
    <td valign="top" align="right" nowrap="nowrap"><label>Descreva a Demanda:</label>
    </td>
    <td>
		<div class="col-sm-12">
    		<textarea class="form-control" name="txtdescricao" cols="80" rows="10" id="txtdescricao"></textarea>
  		</div>
     </td>
  </tr>
  <tr>
    <td valign="top" align="right" nowrap="nowrap"><label>Responsável:</label>
    </td>
    <td>	
		<div class="form-group col-auto">
		<select class="form-control" name="txtresponsavel" id="txtresponsavel" aria-describedby="txtrespHelpInline">
			<option value="0">Opcional</option>
			<?php
			$sql = "select * from users order by nome";
				$mysql_query = $_con->query($sql);
				if ($mysql_query->num_rows>0) {
					while ($_row = $mysql_query->fetch_assoc()) {?>
						<option value="<?php echo $_row['codigo']; ?>"><?php echo $_row['nome']; ?></option>
				<?php
					}
				}?>
		</select>
		<small id="txtrespHelpInline" class="text-muted">&nbsp;Vai gerar TAREFA, se informado</small>		
		</div>
	</tr>
   	<tr>
    <td valign="top" align="right" nowrap="nowrap"><label>Prioridade:</label>
    </td>
    <td>
    	<div class="form-group col-auto"> 
			<select name="txtprioridade" class="form-control" id="txtprioridade">
			<option value="0">Opcional</option>
			<option value="1">Baixa</option>
			<option value="2">Média</option>
			<option value="3">Alta</option>
			</select>
		<small id="txtrespHelpInline" class="text-muted">&nbsp;Informar a prioridade da TAREFA, caso responsável informado</small>		
		</div>

     </td>
  </tr>
  <tr>
     <td valign="top" align="right" nowrap="nowrap"></td>
 	<td>
		<div class="col-sm-4">
		<input type="hidden" class="form-control" name="txtoperador" id="txtoperador" value="<?php echo $_SESSION['usuarioUser'] ?>">
		</div>
  	</td>
  </tr>
</table>
</form>
 <?php
	include_once("../utilitarios/rodape-fixo.php");
	?>

  <script type="text/javascript">
		new Autocomplete("txtnome", function() { return "autocomplete_demanda.php?typing=" + this.text.value ;});
	</script>

</body>
</html>
<?php } ?>
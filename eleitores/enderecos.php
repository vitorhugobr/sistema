<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
require_once ('../utilitarios/funcoes.php');
$id = $_GET['id'];			//ID
$tpoper = $_GET['otipo'];			//TIPO
$_SESSION['funcao']="Endereço";
		
if ($tpoper=="A"){
	$litoper='Altera&ccedil;&atilde;o de Endere&ccedil;o';
	$_sql = "SELECT * FROM enderecos WHERE id = $id";
	$_res = $_con->query($_sql);
	if($_res->num_rows==0) {
		echo "ERRO";
	} else {
		$_row = $_res->fetch_assoc();	
		// os campos da tabela são: id,codigo,cep,tipolog,rua,bairro,cidade,uf,numero,compl,padrao,tipo,reg
		$indice = 1;
		foreach ($_row as $campo => $valor) {
			$_valor    = $valor;
			$_campo    = $campo;
			//echo 'valor '.$valor.'<br>';			
			switch($indice) {				
				case 1:
					$id = $_valor;
				case 2:	
					$codigo= $_valor;
				case 3:
					$cep= $_valor;
				case 4:
					$tipolog= $_valor;
				case 5:
					$rua= $_valor;
				case 6:
					$bairro= $_valor;
				case 7:
					$cidade = $_valor;
				case 8:
					$uf= $_valor;
				case 9:
					$numero= $_valor;
				case 10:
					$compl= $_valor;
				case 11:
					$padrao= $_valor;
				case 12:
					$tipo= $_valor;
				case 13:
					$reg= $_valor;
				default:			
			}
			$indice++;
		}
	}
}else{ 
	$_valor="";
	$litoper='Inclus&atilde;o de Endere&ccedil;o';
	$codigo= $id;
	$padrao='S';
	$tipo='RESIDENCIAL';
	$cidade = 'PORTO ALEGRE';
	$rua =$_valor;
	$cep=$_valor;
	$tipolog=$_valor;	
	$bairro= $_valor;
	$uf= $_valor;
	$numero= $_valor;
	$compl= $_valor;
	$reg= $_valor;
	
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Cadastro de árbitros">
<meta name="author" content="Vitor H M Oliveira">
<script language="javascript" src="../js/grava_end.js"></script>
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/bootstrap.min.js"></script>
<script language="javascript" src="../js/ajax.js"></script>
<script language="javascript" src="../js/carrega_ajax.js"></script>
<script type="text/javascript" src="../js/autocomplete.js"></script>
<link rel="icon" href="../imagens/favicon.ico">
<link rel="SHORTCUT ICON" href="../imagens/favicon.ico" />
<link rel="stylesheet" href="../css/ajax.css" type="text/css">
<link rel="stylesheet" type="text/css" href="../css/autocomplete.css" />
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="../css/ie10-viewport-bug-workaround.css"/>
<link rel="stylesheet" type="text/css" href="../css/formata_textos.css"/>
<link rel="stylesheet" type="text/css" href="../css/sticky-footer-navbar.css"/>
<link rel="stylesheet" type="text/css" href="../css/all.css">
<link href="../css/botoes.css" rel="stylesheet">
<title>Endereços</title>

</head>

<body>
<?php include_once("../utilitarios/cabecalho.php");  ?>
<?php
if(isset($_SESSION['msg'])){
	echo $_SESSION['msg'];
	unset($_SESSION['msg']);
}
$_SESSION['tab']=2;
?>

<form action="" method="post" name="alteracadastro" id="alteracadastro">

<div class="container-fluid">
	<div class="row">
		<div class="col-2 text-right">
			<label>Logradouro: </label>
		</div>
		<div class="col-4">
	  	  	<input class="form form-control" name="rua" type="text" id="rua" value="<?php echo $rua; ?>" size="45" maxlength="50">			
		</div>
		<div class="col-2 text-right">
			<label>CEP: </label>
		</div>
		<div class="col-2">
			<input type="text" id="cep" name="cep" class="form-control" size="8" maxlength="8"  placeholder="CEP"  value="<?php echo $cep; ?>">
		</div>
		<div class="col-2">
			<button class="btn btn-consultar btn-sm" onclick="javascript:buscacep(this.value);" type="button"><i class="fas fa-search"></i> Consultar</button>		
		</div>
	</div>	
	
	<div class="row">
		<div class="col-2 text-right">
			<label>Tipologia: </label>
		</div>
		<div class="col-4">
	    	<input class="form-control" name="tipolog" type="text" id="tipolog" size="5" maxlength="5" value="<?php echo $tipolog;?>">
	 	</div>
		<div class="col-2 text-right">
			<label>Bairro: </label>
		</div>
		<div class="col-2">
    		<input class="form-control" name="bairro" type="text" id="bairro" size="20" maxlength="20" value="<?php echo $bairro;?>" onChange="javascript:this.value=this.value.toUpperCase();"/>
		</div>
	</div>	
	
	<div class="row">
		<div class="col-2 text-right">
			<label>Cidade: </label>
		</div>
		<div class="col-4">
	  	  	<input class="form-control" name="cidade" type="text" id="cidade" size="30" maxlength="30" value="<?php echo $cidade; ?>" onChange="javascript:this.value=this.value.toUpperCase();"/>
	 	</div>
		<div class="col-2 text-right">
			<label>Estado: </label>
		</div>
		<div class="col-2">
    		<input class="form-control" name="uf" type="text" id="uf" size="2" maxlength="2" value="<?php echo $uf; ?>" onChange="javascript:this.value=this.value.toUpperCase();"/>
		</div>
	</div>	

	<div class="row">
		<div class="col-2 text-right">
			<label>Número: </label>
		</div>
		<div class="col-4">
			<input class="form-control" name="numero" type="text" id="numero" size="6" maxlength="6" value="<?php echo $numero; ?>">
	 	</div>
		<div class="col-2 text-right">
			<label>Complemento: </label>
		</div>
		<div class="col-2">
    		<input class="form-control" name="complemento" type="text" id="complemento" size="40" maxlength="40" value="<?php echo $compl; ?>" onChange="javascript:this.value=this.value.toUpperCase();"/>
		</div>
	</div>	
	
	<div class="row">
		<div class="col-2 text-right">
			<label>Tipo Endereço: </label>
		</div>
		<div class="col-4">
    		<input class="form-control" name="tipo" type="text" id="tipo" size="15" maxlength="15" value="<?php echo $tipo; ?>" onChange="javascript:this.value=this.value.toUpperCase();"/>
	 	</div>
		<div class="col-2 text-right">
			<label>Endereço Padrão? </label>
		</div>
		<div class="col-2">
    		<input name="padrao" type="text" id="padrao" size="1" maxlength="1" value="<?php echo $padrao; ?>" onChange="javascript:this.value=this.value.toUpperCase();"/>
    		<input name="id" type="hidden" id="id" value="<?php echo $id;?>">
	       	<input name="codigo" type="hidden" id="codigo" value="<?php echo $codigo; ?>">
    		<input name="reg" type="hidden"  id="reg" value="<?php echo $reg; ?>" size="3" maxlength="3" >
		</div>
	</div>	
	

		
</div>
<p align="center">
<?php
if ($tpoper=="A"){?>
  <button type="button" class="btn btn-sm btn-success" onclick="javascript:atual_ender('A',<?php echo $id;?>);">
    <i class="fas fa-save" aria-hidden="true"></i> Alterar
  </button>
	<?php 
}else{?>
  <button type="button" class="btn btn-sm btn-incluir" onclick="javascript:atual_ender('I',<?php echo $codigo;?>);">
    <i class="fas fa-plus" aria-hidden="true"></i> Incluir
  </button>
	<?php 
}?>
<button type="button" class="btn btn-sm btn-cancelar" onClick="window.close();"><i class="fas fa-window-close" aria-hidden="true"></i> Fechar
</button>
</form>  
<script type="text/javascript">
  new Autocomplete("rua", function() { return "autocompleterua.php?typing=" + this.text.value+"&city="+document.alteracadastro.cidade.value;});

</script>
<?php include_once("../utilitarios/rodape-fixo.php");  ?>
</body>
</html>
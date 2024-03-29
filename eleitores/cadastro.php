<?php
include_once("../seguranca.php");
protegePagina();
include_once("../utilitarios/funcoes.php");
date_default_timezone_set('America/Sao_Paulo');

if (liberado(1000)==0){
	expulsaVisitante2();
	return;
}
$_SESSION['funcao']="Cadastro";
$codigo = $_GET["codigo"];	

if ($codigo==0) {
	$codigo=$_SESSION['ult_eleitor_pesquisado'];
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Cadastro de Eleitores">
<meta name="author" content="Vitor H M Oliveira">
<title>Cadastro</title>
<link rel="icon" href="../imagens/favicon.ico">
<!--- Component CSS -->


<link href="../css/all.css" rel="stylesheet">
<link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">
<link href="../css/sticky-footer-navbar.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../css/ajax.css"/>
<link rel="stylesheet" type="text/css" href="../css/autocomplete.css"/>
<link rel="stylesheet" type="text/css" href="../css/bootstrap.css"/>
<link href="../css/botoes.css" rel="stylesheet">
<link href="../css/formata_textos.css" rel="stylesheet">
<link href="../css/all.css" rel="stylesheet">
<script type="text/javascript" src="../js/eleitor.js"></script>
<script type="text/javascript" src="../js/exames.js"></script>
<script src="../js/jquery.min.js"></script>
<script src="../js/bootstrap.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="../js/ie10-viewport-bug-workaround.js"></script>
<script src="../js/carrega_ajax.js" type="text/javascript"></script>
<script src="../js/ajax.js" type="text/javascript"></script>
<script src="../js/ie-emulation-modes-warning.js"></script>
<script type="text/javascript" src="../js/autocomplete.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
function enableFields(verdade){
	var totalFields = document.form1.elements.length;
	for (i = 2; i < totalFields; i++) 	{
		document.form1.elements[i].disabled = verdade;
		if (verdade) {
			document.form1.elements[i].style.backgroundColor = '#DDDDDD';
		} else {
			document.form1.elements[i].style.backgroundColor = '#FFFFFF';
		}
	}

	document.getElementById("txtpesqendereco").disabled = false;
	document.getElementById("txtpesqendereco").style.backgroundColor = '#FFFFFF';
	//document.getElementById("txtcpf").disabled = false;
	//document.getElementById("txtcpf").style.backgroundColor = '#FFFFFF';
	document.getElementById("txtemail").disabled = false;
	document.getElementById("txtemail").style.backgroundColor = '#FFFFFF';
	document.getElementById("txtcelular").disabled = false;
	document.getElementById("txtcelular").style.backgroundColor = '#FFFFFF';
	
}
function inclui_novo(){
	//document.getElementById('btnNovo').style.visibility = 'hidden';
	document.getElementById("btnNovo").disabled = true;
	//document.getElementById("btnCancel").disabled = false;
	document.getElementById("btnExcCad").disabled = false;
	document.getElementById("btnAltCad").disabled = false;		
	//document.getElementById("btn_endereco").disabled = false;
	document.getElementById("btnincvis").disabled = false;
	enableFields(false);
	document.form1.txtcodigo.disabled = true;
	document.getElementById("chkcondicao").checked = true;
	ajax2("incluir_novo.php",'modal');	
}

function cancela_novo() {
	var cod = document.form1.txtcodigo.value;
	if ((cod==0) || (cod=="")) {
		return false;
	}
	ajax('exclui_novo.php?cod='+cod, 'modal');
}			

	</script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="javascript:enableFields(true);PesquisaEleitor(<?php echo $codigo?>)">
<div class="nav fixed-top container-fluid shadow mt-0 mb-0 bg-white rounded sticky-top">
<?php 
	include("../utilitarios/cabecalho.php"); ?>	 
<nav class="nav stick-top navbar-expand-sm shadow-sm navbar-light">
	<div class="container-fluid" style="align-items: center; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, 'Noto Sans', sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji';">
		<span class="navbar-brand"></span>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="true" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
		</button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <?php
				if (liberado(1001)>0){ 
						echo '<li class="nav-item active">
						<button type="button" id="btnNovo" name="btnNovo" class="btn btn-sm btn-incluir" onclick="javascript:inclui_novo();">
						<i class="fas fa-user-plus" aria-hidden="true text-muted" aria-hidden="true"></i> Novo
						</button>
					</li>';
				}
//				if (liberado(1001)>0){ 
//						echo '<li class="nav-item">
//						<button type="button" disabled id="btnCancel" name="btnCancel" class="btn btn-sm btn-deep-cancelar" onclick="javascript:cancela_novo();">
//						<i class="fas fa-user-times" aria-hidden="true text-muted" aria-hidden="true"></i> Cancelar
//						</button>
//					</li>';
//				}
				if (liberado(1002)>0){  
						//echo 'entrou';
						echo '<li class="nav-item">
						<button type="button" id="btnAltCad" class="btn btn-sm btn-success" disabled onclick="javascript:validaA();">
						<i class="fas fa-save" aria-hidden="true text-muted" aria-hidden="true"></i> Gravar
						</button>
					</li>';
				}
				if (liberado(1003)>0){  
						echo '<li class="nav-item">
						<button type="button" id="btnExcCad" class="btn btn-sm btn-excluir" disabled onclick="javascript:validaE();">
						<i class="fas fa-user-times" aria-hidden="true text-muted" aria-hidden="true"></i> Excluir
						</button>
					</li>';
				}
//				if (liberado(7500)>0){
//						echo '<li class="nav-item">
//							  <a href="../clinica/consultas.php" class="btn btn-lime btn-sm" role="button">
//							  <i class="fas fa-calendar-check" aria-hidden="true text-muted" aria-hidden="true"></i> Agendar Consultas
//							  </a>
//						</li>';
//				}
				if ((liberado(1006)>0) and ($_SESSION['id']<2)){  
						echo '<li class="nav-item">
						<a href="cadastro_to_excel.php" title="Exportar Cadastro para Excel" class="btn btn-imprimir btn-sm" role="button">
						<i class="fas fa-copy" aria-hidden="true text-muted" aria-hidden="true"></i> Exportar Cad. Excel
						</a>
					</li>';
				} 
				if ($_SESSION['usuarioNivel']<2) { 
					echo '<li class="nav-item"> <a href="../relatorios/cadastro_duplos.php" class="btn btn-yellow btn-sm" role="button"> <i class="fas fa-list"></i> Cadastros Duplos </a> </li>';
					echo '<li class="nav-item"> <a href="../relatorios/emails_invalidos.php" class="btn btn-cyan btn-sm" role="button"> <i class="fas fa-envelope"></i> E-mails Inválidos </a> </li>';
				}
				?>
			<li class="nav-item">
            	<button type="button" class="btn btn-sm btn-limpatela" onclick="javascript:reload_cadastro();"> <i class="fas fa-eraser" aria-hidden="true text-muted"></i> Limpar Tela </button>
 			</li>
			<li class="nav-item">
				<button type="button" class="btn btn-sm btn-voltar" onclick="javascript:window.history.back();"> <i class="fas fa-backward" aria-hidden="true text-muted"></i> Voltar Tela Anterior </button>
			</li>    
            <li class="nav-item"> <a href="../index2.php" class="btn btn-menu btn-sm" role="button"> <i class="fas fa-list-ul" aria-hidden="true text-muted"></i> Menu </a> </li>
          </ul>
        </div>
	</div>
</nav>
</div>
 <?php

if(isset($_SESSION['msg'])){
	echo $_SESSION['msg'];
	unset($_SESSION['msg']);
}
?>

<form name="form1" method="post" action="">
<div class="container-fluid">
	<div class="btn-toolbar mb-3" role="toolbar" aria-label="Informações">
 	  <div id="mensagem_sistema" class="col-sm-12 badge badge-warning">Campos em VERMELHO - preenchimento obrigatório></div>
	  <div class="btn-group btn-group-sm" role="group" aria-label="Principal" id="home">
		<a href="#" class="btn btn-cancelar btn-sm">Dados Gerais</a>
		<a href="#tela_enderecos" class="btn btn-cancelar btn-sm">Endereços</a>
		<a href="#tela_contatos" class="btn btn-cancelar btn-sm">Contatos</a>
		<a href="#tela_demandas" class="btn btn-cancelar btn-sm">Demandas</a>
		<?php 
			if (liberado(1010)>0)  ?>
				<a href="#tela_prontuarios" class="btn btn-cancelar btn-sm">Prontuários</a>
		<?php  
			if (liberado(1011)>0)  ?>
				<a href="#tela_receituarios" class="btn btn-cancelar btn-sm">Receituários</a>
		<?php  
			if (liberado(1009)>0)  ?>
				<a href="#tela_exames" class="btn btn-cancelar btn-sm">Exames</a>	  
      </div>
	  <div class="input-group">&nbsp;&nbsp;
	  </div>
	</div>
 
  <div class="form-row col-form-label-sm">
    <div class="col-sm-6">
      <label for="txtnome" class="textoVermelho">Nome Completo </label>
      <input type="text" autocomplete="off" class="form-control" id="txtnome" name="txtnome" placeholder="Nome do Eleitor" required>
    </div>
    <div class="col-sm-2">
      <label for="txtcodigo" class="textoAzul">Código </label>
      <input type="text" class="form-control" id="txtcodigo" name="txtcodigo">
    </div>
    <div class="col-sm-2">
      <label for="txtdtnasc" class="textoAzul">Data de Nascimento </label>
        <input type="date" class="form-control" id="txtdtnasc" name=txtdtnasc>
      </div>
  </div>

 <!--  nova linha -->
  
  <div class="form-row col-form-label-sm">
    <div class="col-sm-2">
      <label for="txtsexo" class="textoVermelho">Sexo </label>
		<select class="form-control" name="txtsexo" id="txtsexo">
			<option value="F">Feminino</option>
			<option value="M">Masculino</option>
		</select>
    </div>
    <div class="col-sm-4">
      <label for="txtgrupo"  class="textoVermelho">Grupo </label>
		<select class="form-control" name="txtgrupo">
			<option value="0">Selecione</option>
			<?php
			$sql = "select * from grupos order by NOMEGRP";
			$mysql_query = $_con->query($sql);
			if ($mysql_query->num_rows>0) {
				while ($_row = $mysql_query->fetch_assoc()) {?>
					<option value="<?php echo $_row['GRUPO']; ?>"><?php echo $_row['NOMEGRP']; ?></option>
			<?php
				}
			}?>
		</select>
    </div>
    <div class="col-sm-4">
      <label for="txtorigem" class="textoVermelho">Origem </label>
		<select class="form-control" name="txtorigem">
			<option value="0">Selecione</option>
			<?php
			$sql = "select * from origem order by Descricao";
			$mysql_query = $_con->query($sql);
			if ($mysql_query->num_rows>0) {
				while ($_row = $mysql_query->fetch_assoc()) {?>
					<option value="<?php echo $_row['Origem']; ?>"><?php echo $_row['Descricao']; ?></option>
			<?php
				}
			}?>
		</select>
    </div>
  </div>
  
<!--  nova linha -->
 
  <div class="form-row col-form-label-sm">
    <div class="col-sm-6">
      <label for="txtemail" class="textoAzul">Email </label>
      <input type="email" class="form-control" name="txtemail" id="txtemail" placeholder="E-mail válido"> 
    </div>
    <div class="col-sm-2">
      <label for="txtcpf" class="textoAzul">CPF </label>
      <input type="text" class="form-control" id="txtcpf" name="txtcpf" placeholder="CPF somente números">      
    </div>
    <div class="col-sm-2">
      <label for="txtestadocivil" class="textoAzul">Estado Civil </label>
		<select name="txtestadocivil" class="form-control" id="txtestadocivil" name="txtestadocivil">
			<option value="0">Solteiro(a)</option>
			<option value="1">Casado(a)</option>
			<option value="2">Viúvo(a)</option>
			<option value="3">Separado(a)</option>
			<option value="4">Divorciado(a)</option>
			<option value="5">Desquitado(a)</option>
			<option value="6">Companheiro(a)</option>
		</select>
    </div>
  </div>
	
	<table  cellspacing="2" width="100%" border="1">
  <tbody bgcolor="#E7E7E7">
    <tr>
      <td>
	
  <!-- endereços-->
  
  <!--	  <div class="form-row col-form-label-sm">
        <div class="col-sm-12" align="left">
		  
			<div class="custom-control custom-switch">
				<input type="checkbox" class="custom-control-input" id="chkmudaend" name="chkmudaend">
				<label class="custom-control-label textoAzul" for="chkmudaend">Alterar endereço?</label>
   			</div>
		 </div>
	  </div>
-->	  
  <div class="form-row col-form-label-sm">
        <div class="col-sm-1" align="right">
		  <label class="textoAzul" for="txtpesqendereco">Endereço</label>							
		</div>
        <div class="col-6">
		  <input type="text" id="txtpesqendereco" name="txtpesqendereco" maxlength="80" size="'60" placeholder="Informe o endereço para pesquisar eleitor pelo endereço">
	    </div>	
          <div class="col-sm-5 textoVermelho" align="left"><i class="fas fa-arrow-circle-left" aria-hidden="true text-muted"></i> Usar este campo APENAS para consulta!</div>
	  </div>
	<div class="form-row col-form-label-sm">
		<div class="col-sm-6">
      		<label for="rua" class="textoAzul">Logradouro</label>
      		<input type="text" class="form-control" id="rua" name="rua"  size="50" maxlength="50" onChange="javascript:this.value=this.value.toUpperCase();"> 
    	</div>

		<div class="col-sm-2" align="left">
		  <label for="cep" class="textoAzul">CEP</label>
			<input type="text" id="cep" name="cep" class="form form-control" size="8" maxlength="8" >
		</div>
		<div class="col-sm-4">
			<button name="btnUpdEnd" id="btnUpdEnd" class="btn btn-consultar btn-lg" onclick="javascript:buscacep(document.form1.cep.value);" type="button"><i class="fas fa-search"></i> Consultar por CEP</button>		
		</div>
   	 </div>
	<div class="form-row col-form-label-sm">
		
		<div class="col-3" align="left">
			<label class="textoAzul">Tipologia</label>
			<input class="form form-control" name="tipolog" type="text" id="tipolog" size="10" maxlength="10" onChange="javascript:this.value=this.value.toUpperCase();">
		</div>
		<div class="col-3" align="left">
			<label class="textoAzul">Bairro</label>
			<input class="form form-control" name="bairro" type="text" id="bairro" size="20" maxlength="20" onChange="javascript:this.value=this.value.toUpperCase();"/>
		</div>
		<div class="col-4" align="left">
			<label class="textoAzul">Cidade</label>
			<input class="from form-control" name="cidade" type="text" id="cidade" size="30" maxlength="30" onChange="javascript:this.value=this.value.toUpperCase();"/>
		</div>
		<div class="col-1" align="left">
			<label class="textoAzul">UF</label>
			<input class="form form-control" name="uf" type="text" id="uf" size="2" maxlength="2" onChange="javascript:this.value=this.value.toUpperCase();"/>
		</div>
	</div>	
	<div class="form-row col-form-label-sm">
		<div class="col-1" align="left">
			<label class="textoAzul">Numero</label>
			<input class="form form-control" name="numero" type="number" id="numero" size="6" maxlength="6">
		</div>
		<div class="col-2">
			<label class="textoAzul">Complemento</label>
			<input class="form form-control" name="complemento" type="text" id="complemento" size="20" maxlength="20" onChange="javascript:this.value=this.value.toUpperCase();"/>
			<input name="tipo" type="hidden" id="tipo" value="RESIDENCIAL">
			<input name="padrao" type="hidden" id="padrao" value="S">
			<input name="id_endereco" type="hidden" id="id_endereco">
			<input name="reg" type="hidden" id="reg">
		</div>
	</div>
<!--	<div class="form-row col-form-label-sm">
		<div class="col-12 text-center">
			  <button id="btn_endereco" name="btn_endereco" class="btn btn-alterar btn-sm" onclick='javascript:atual_ender();'>
				<i class="fas fa-save" aria-hidden="true"></i> Gravar Endereço
			  </button>
		</div>
	</div>
-->  
</td>
    </tr>
  </tbody>
</table>		  
    
<!--  nova linha -->  
 
  <div class="form-row col-form-label-sm">
    <div class="col-sm-3">
      <label for="txtcelular" class="textoAzul">Telefone Celular </label>
      <input type="tel" class="form-control" id="txtcelular" name="txtcelular"> 
    </div>
    <div class="col-sm-3">
      <label for="txtresidencial" class="textoAzul">Telefone Residencial </label>
      <input type="tel" class="form-control" id="txtresidencial" name="txtresidencial">      
    </div>
    <div class="col-sm-3">
      <label for="txtcomercial" class="textoAzul">Telefone Comercial </label>
      <input type="tel" class="form-control" id="txtcomercial" name="txtcomercial">      
    </div>
  </div>
  
  <!--  nova linha -->

  <div class="form-row col-form-label-sm">
    <div class="col-sm-3">
      <label for="txtprofissao" class="textoAzul">Profissão </label>
		<select class="form-control" id="txtprofissao" name="txtprofissao">
			<option value="0">Selecione</option>
			<?php
			$sql = "select * from profissao order by Descricao2";
			$mysql_query = $_concomum->query($sql);
			if ($mysql_query->num_rows>0) {
				while ($_row = $mysql_query->fetch_assoc()) {?>
					<option value="<?php echo $_row['Profissao']; ?>"><?php echo $_row['Descricao2']; ?></option>
			<?php
				}
			}?>
		</select>
    </div>
    <div class="col-sm-3">
      <label for="txtramo" class="textoAzul">Ramo de Atividade </label>
		<select class="form-control" id="txtramo" name="txtramo">
			<option value="0">Selecione</option>
			<?php
			$sql = "select * from ramo order by DESCRICAO";
			$mysql_query = $_concomum->query($sql);
			if ($mysql_query->num_rows>0) {
				while ($_row = $mysql_query->fetch_assoc()) {?>
					<option value="<?php echo $_row['CODIGO']; ?>"><?php echo $_row['DESCRICAO']; ?></option>
			<?php
				}
			}?>
		</select>
    </div>
    <div class="col-sm-6">
      <label for="txtempresa" class="textoAzul">Empresa </label>
      <input type="text" class="form-control" id="txtempresa" name="txtempresa">      
    </div>
  </div>
  
  <!--  nova linha -->

  <div class="form-row col-form-label-sm">
    <div class="col-sm-3">
      <label for="txtcargo" class="textoAzul">Cargo </label>
       <input type="text" class="form-control" id="txtcargo" name="txtcargo">      
   </div>
    <div class="col-sm-3">
      <label for="txtramo" class="textoAzul">Classificação </label>
		<select name="txtclass" class="form-control" id="txtclass">
			<option value="0">Selecione</option>
			<option value="1">Alto</option>
			<option value="2">Médio</option>
			<option value="3">Baixo</option>
		</select>
    </div>
    <div class="col-sm-3">
      <label for="txtempresa" class="textoAzul">Campanha </label>
		<select class="form-control" name="txtcampanha" id="txtcampanha">
			<option value="0">Selecione</option>
			<?php
			$sql = "select * from campanha order by descricao";
				$mysql_query = $_con->query($sql);
				if ($mysql_query->num_rows>0) {
					while ($_row = $mysql_query->fetch_assoc()) {?>
						<option value="<?php echo $_row['codigo']; ?>"><?php echo $_row['descricao']; ?></option>
				<?php
					}
				}?>
		</select>
    </div>
  </div>
  
  <!--  nova linha -->

  <div class="form-row col-form-label-sm">
    <div class="col-sm-3">
      <label for="txtface" class="textoAzul">Facebook </label> <img class="float" src="../imagens/face.png" width="20" height="20"/>
       <input type="text" class="form-control" id="txtface" name="txtface">      
   </div>
    <div class="col-sm-3">
      <label for="txttwitter" class="textoAzul">Instagram </label> <img class="float" src="../imagens/instagram.png" width="20" height="20"/>
      <input type="text" class="form-control" id="txttwitter" name="txttwitter">      
   </div>
    <div class="col-sm-6">
      <label for="txtoutra" class="textoAzul">Outras Redes Sociais </label> <img class="float" src="../imagens/sociais.png" height="20"/>
       <input type="text" class="form-control" id="txtoutra" name="txtoutra" maxlength="220">      
    </div>
  </div>

  <!--  nova linha -->

  <div class="form-row col-form-label-sm">
    <div class="col-sm-3">
      <label for="txtapelido" class="textoAzul">Apelido </label>
       <input type="text" class="form-control" id="txtapelido" name="txtapelido">      
   </div>
    <div class="col-sm-2">
      <label for="txtzona" class="textoAzul">Zona Eleitoral </label>
      <input type="text" class="form-control" id="txtzona" name="txtzona">      
   </div>
    <div class="col-sm-2">
      <label for="txtsecao" class="textoAzul">Seção Eleitoral </label>
       <input type="text" class="form-control" id="txtsecao" name="txtsecao">      
    </div>
    <div class="col-sm-2">
      <label for="txtpaimae" class="textoAzul">Filhos </label>
		<select class="form-control" id="txtpaimae" name="txtpaimae">
			<option value="0">Não</option>
			<option value="1">Sim</option>
		</select>
    </div>
  </div>
  
  <!--  nova linha -->
  
   <div class="form-row col-form-label-sm">
    <div class="col-2">
		<div class="custom-control custom-switch">
			<input type="checkbox" class="custom-control-input" id="chkcondicao" name="chkcondicao">
			<label class="custom-control-label textoAzul" for="chkcondicao">Cadastro ATIVO</label>
		</div>
   	</div>
    <div class="col-3">
		<div class="custom-control custom-switch">
			<input type="checkbox" class="custom-control-input" id="chkemail" name="chkemail">
			<label class="custom-control-label textoAzul" for="chkemail">Recebe E-mail</label>
		</div>
   	</div>
<hr />

    <div class="col-sm-3">
		<div class="custom-control custom-switch">
			<input type="checkbox" class="custom-control-input" id="chkimpresso" name="chkimpresso">
			<label class="custom-control-label textoAzul" for="chkimpresso">Recebe WhatsApp/Impressos</label>
		</div>
  </div>
    <div class="col-sm-2">
		<div class="custom-control custom-switch">
			<input type="checkbox" class="custom-control-input" id="chkfiliado" name="chkfiliado">
			<label class="custom-control-label textoAzul" for="chkfiliado">É Filiado</label>
		</div>
    </div>
    <div class="col-sm-2">
		<div class="custom-control custom-switch">
			<input type="checkbox" class="custom-control-input" id="chkvotou" name="chkvotou">
			<label class="custom-control-label textoAzul" for="chkvotou">Votou</label>
		</div>
    </div>
  </div>

   <!--  nova linha -->

  <!-- Observações -->
  <div class="form-row col-form-label-sm">
    <div class="col-sm-12">
      <label for="txtzona" class="textoAzul">Observações </label>
		<textarea name="txtobs" cols="300" rows="5" class="form-control form-control-sm" id="txtobs" placeholder="Observações relevantes do Eleitor">
		</textarea>
   </div>
  </div>
  <hr />
   
  
  <!-- contatos -->
  <div class="jumbotron jumbotron-fluid" id="tela_contatos">
	  <div class="form-row col-form-label-sm">
		  
	  	<div class="h6 align-content-center" id="contatos"><a href="#"><img src="../imagens/toppage.png"></a>&nbsp;
			<?php 
			if ($_SESSION['partido'] = "psc") { 
				echo 'Histórico'; 
			} else {
				echo 'Contato';
			}?>
		  </div><br>
	   	<div class="col">
		   <button id="btnincvis" name="btnincvis" type="button" class="btn btn-sm btn-incluir" onClick="javascript:OpenVisita();" disabled="disabled"><i class="fas fa-plus" aria-hidden="true text-muted" aria-hidden="true"></i>
			<?php 
			if ($_SESSION['partido'] = "psc") { 
				echo 'Novo Histórico'; 
			} else {
				echo 'Novo Contato';
			}?>	   
			</button>
	   	</div>	  
		  
	  </div>
	  <div class="form-row col-form-label-sm">
		<div class="col-sm-12">
		  <input type="hidden" name="txtvisitas" id ="txtvisitas">
		  <div id="visit">
			<?php 
			if ($_SESSION['partido'] = "psc") { 
				echo 'Sem Histórico'; 
			} else {
				echo 'Sem Contatos';
			}?>	   
		</div>
	   </div>
  </div>
  
  <!-- demandas -->
  <div class="jumbotron jumbotron-fluid" id="tela_demandas">
  <div class="form-row col-form-label-sm">
	  <div class="h6 align-content-center" id="demandas"><a href="#"><img src="../imagens/toppage.png"></a>&nbsp;Demandas</div>
  </div>
  <div class="form-row col-form-label-sm">
    <div class="col-sm-12">
	  	<input type="hidden" name="txtdemandas" id ="txtdemandas">
	  	<div id="solution">Sem Demandas</div>
	</div>
   </div>
  </div>
   <hr />
   
	  <!-- prontuários só se id =1 -->
	<?php
	if (liberado(1010)>0){ ?>
    <div class="jumbotron jumbotron-fluid" id="tela_prontuarios">
	  <div class="form-row col-form-label-sm">
		  <div class="h6 align-content-center" id="prontuarios"><a href="#"><img src="../imagens/toppage.png"></a>&nbsp;
Prontuários</div>
	  </div>
	  <div class="form-row col-form-label-sm">
		<div class="col-sm-12">
			<input type="hidden" name="txtprontuarios" id ="txtprontuarios">
			<div id="dados_prontuario">Sem Prontuários</div>
		</div>
	   </div>
	</div>
<?php } 
	if (liberado(1011)>0){ ?>
    <div class="jumbotron jumbotron-fluid" id="tela_receituarios">
	  <div class="form-row col-form-label-sm">
		  <div class="h6 align-content-center" id="receituarios"><a href="#"><img src="../imagens/toppage.png"></a>&nbsp;
Receituários</div>
	  </div>
	  <div class="form-row col-form-label-sm">
		<div class="col-sm-12">
			<input type="hidden" name="txtreceituario" id ="txtreceituario">
			<div id="dados_receituario">Sem Receituários</div>
		</div>
	   </div>
	</div>
	   <hr />
<?php } 
	if (liberado(1009)>0){ ?>
    <div class="jumbotron jumbotron-fluid" id="tela_exames">
	  <div class="form-row col-form-label-sm">
		  <div class="h6 align-content-center" id="exame"><a href="#"><img src="../imagens/toppage.png"></a>&nbsp;
Exames</div>
	  </div>
	  <div class="form-row col-form-label-sm">
		<div class="col-sm-12">
			<input type="hidden" name="txtexames" id ="txtexames">
			<div id="dados_exames">Sem Exames</div>
		</div>
	   </div>
	</div> 
	<hr />
<?php } ?>

     <div class="form-row">
			<div class="col-sm-3">
  				<span>Data Cadastro:</span>
   				<div id="lbldtcad" class="text text-danger"></div>
			</div>
			<div class="col-sm-3">
  				<span>Última Alteração:</span>
          			<div id="lbldtultalt" class="text text-danger"></div>
			</div>
			<div class="col-sm-3">
  				<span>Responsável Cadastro:</span>
       			<div id="lblrespcad" class="text text-danger"></div>
			</div>
   	</div>

 <!-- Final das linhas--> 
</div>
</form>
<script language="javascript">
function reload_cadastro() {
	document.form1.txtcodigo.value = "";
	document.form1.txtnome.value = "";
	document.form1.txtsexo.value = "";
	document.getElementById('lbldtcad').innerHTML = "";  // data cadastramento
	document.form1.txtdtnasc.value = "";
	document.form1.txtcargo.value = "";
	document.form1.txtresidencial.value = "";					
	document.form1.txtcelular.value = "";
	document.form1.txtcomercial.value = "";
	document.form1.txtcpf.value = "";
	document.form1.txtobs.value = "";	
	document.form1.txtemail.value = "";
	document.form1.txtgrupo.value = "";	
	document.form1.txtorigem.value = "";
	document.form1.txtprofissao.value = "";
	document.form1.txtzona.value = "";
	document.form1.txtsecao.value = "";
	document.form1.txtpaimae.value = "";				
	document.form1.chkfiliado.checked = false;
	document.form1.txtempresa.value = "";
	document.form1.chkvotou.checked = false;	
	document.form1.txtramo.value = "";
	document.form1.chkemail.checked= false;	
	document.form1.chkimpresso.checked = false;	
	document.form1.txtcampanha.value = "";	
	document.form1.txtface.value = "";	
	document.form1.txttwitter.value = "";	
	document.form1.txtoutra.value = "";	
	document.form1.txtapelido.value = "";	
	document.form1.txtestadocivil.value = "";	
	document.form1.txtclass.value = "";	
    ajax('zera_codigo.php','modal');
}

</script>
<script type="text/javascript">
	new Autocomplete("txtnome", function() { return "autocomplete_nome.php?typing=" + this.text.value;});
	new Autocomplete("txtemail", function() { return "autocomplete_email.php?typing=" + this.text.value;});
	//new Autocomplete("txtcpf", function() { return "autocomplete_cpf.php?typing=" + this.text.value;});
	new Autocomplete("txtcodigo", function() { return "autocomplete_codigo.php?typing=" + this.text.value;});
	new Autocomplete("txtcelular", function() { return "autocomplete_fone.php?campo=FONE_CEL&typing=" + this.text.value;});
	new Autocomplete("txtpesqendereco", function() { return "autocompletecad_endereco.php?typing=" + this.text.value;});	
  new Autocomplete("rua", function() { return "autocompleterua.php?typing=" + this.text.value+"&city="+document.form1.cidade.value;});	
</script>

<?php include_once("../utilitarios/rodape-fixo.php");?>

</body>
</html>
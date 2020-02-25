<?php
include_once("../seguranca.php");
protegePagina();
include_once("../utilitarios/funcoes.php");
date_default_timezone_set('America/Sao_Paulo');
$id = $_SESSION['id'];

$_SESSION['funcao']="Exportar para Excel";
?>
	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Receituarios">
<meta name="author" content="Vitor H M Oliveira">
<title>Exportar Excel</title>
<link rel="icon" href="../imagens/favicon.ico">
<link href="../css/formata_textos.css" rel="stylesheet">
<link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">
<link href="../css/sticky-footer-navbar.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../css/ajax.css"/>
<link rel="stylesheet" type="text/css" href="../css/autocomplete.css"/>
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
<link href="../css/botoes.css" rel="stylesheet">
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" role="document">
<?php include_once("../utilitarios/cabecalho.php");?>
 <?php

if(isset($_SESSION['msg'])){
	echo $_SESSION['msg'];
	unset($_SESSION['msg']);
}
?>

<!-- --------------------------------------------------------------------------------------- -->
<!-- --- paramêtro 0 passado a seguir significa que será alteração - update  -->

<form name="form1" method="post" action="gera_excel.php">
<section id="corpo" class="container-fluid">
<div class="col-12 text-center">
  <button type="button" class="btn btn-sm btn-success" onClick="javascript:geraexcel();">
    <i class="fas fa-save" aria-hidden="true"></i> Gerar Excel
  </button>
  <button type="button" class="btn btn-sm btn-voltar" onclick="javascript:voltaPag('cadastro.php');">
    <i class="fas fa-arrow-left" aria-hidden="true"></i> Voltar Cadastro
  </button>
</div>
   <div class="form-row col-form-label-sm">
    <div class="col-12 text-center textoVermelho">Marque os CAMPOS que deseja exportar</div>
	</div>
   <div class="form-row col-form-label-sm">
    <div class="col-1"></div>
    <div class="col-2">
		<div class="custom-control custom-switch">
			<button type="button" class="btn btn-sm btn-indigo" onclick="javascript:selecionar_all();">
				<i class="fas fa-eraser" aria-hidden="true text-muted" aria-hidden="true"></i> Marcar Todos
			</button>
		</div>
	</div>
    <div class="col-2">
		<div class="custom-control custom-switch">
			<button type="button" class="btn btn-sm btn-encerrar" onclick="javascript:deselecionar_all();">
				<i class="fas fa-eraser" aria-hidden="true text-muted" aria-hidden="true"></i> Desmarcar Todos
			</button>
		</div>
   	</div>
   	<div class="col-7"></div>
  </div>

	<div class="form-row col-form-label-sm">
    <div class="col-1"></div>
    <div class="col-2">
		<div class="custom-control custom-switch">
			<input type="checkbox" class="custom-control-input" id="chkcodigo" name="chkcodigo" >
			<label class="custom-control-label textoVerde" for="chkcodigo">Código</label>
		</div>
   	</div>
    <div class="col-sm-2">
		<div class="custom-control custom-switch">
			<input type="checkbox" class="custom-control-input" id="chknome" name="chknome">
			<label class="custom-control-label textoVerde" for="chknome">Nome</label>
		</div>
  </div>
    <div class="col-sm-2">
		<div class="custom-control custom-switch">
			<input type="checkbox" class="custom-control-input" id="chksexo" name="chksexo">
			<label class="custom-control-label textoVerde" for="chksexo">Sexo</label>
		</div>
    </div>
    <div class="col-sm-2">
		<div class="custom-control custom-switch">
			<input type="checkbox" class="custom-control-input" id="chkdtnasc" name="chkdtnasc">
			<label class="custom-control-label textoVerde" for="chkdtnasc">Data Nascimento</label>
		</div>
    </div>
    <div class="col-sm-2">
		<div class="custom-control custom-switch">
			<input type="checkbox" class="custom-control-input" id="chkcargo" name="chkcargo">
			<label class="custom-control-label textoVerde" for="chkcargo">Cargo</label>
		</div>
    </div>
    <div class="col-1"></div>
  </div>

	<div class="form-row col-form-label-sm">
    <div class="col-1"></div>
    <div class="col-2">
		<div class="custom-control custom-switch">
			<input type="checkbox" class="custom-control-input" id="chkcelular" name="chkcelular" >
			<label class="custom-control-label textoVerde" for="chkcelular">Fone Celular</label>
		</div>
   	</div>
    <div class="col-sm-2">
		<div class="custom-control custom-switch">
			<input type="checkbox" class="custom-control-input" id="chkresidencial" name="chkresidencial">
			<label class="custom-control-label textoVerde" for="chkresidencial">Fone Residencial</label>
		</div>
  </div>
    <div class="col-sm-2">
		<div class="custom-control custom-switch">
			<input type="checkbox" class="custom-control-input" id="chkcomercial" name="chkcomercial">
			<label class="custom-control-label textoVerde" for="chkcomercial">Fone Comercail</label>
		</div>
    </div>
    <div class="col-sm-2">
		<div class="custom-control custom-switch">
			<input type="checkbox" class="custom-control-input" id="chkcpf" name="chkcpf">
			<label class="custom-control-label textoVerde" for="chkcpf">CPF</label>
		</div>
    </div>
    <div class="col-sm-2">
		<div class="custom-control custom-switch">
			<input type="checkbox" class="custom-control-input" id="chkemail" name="chkemail">
			<label class="custom-control-label textoVerde" for="chkemail">Email</label>
		</div>
    </div>
    <div class="col-1"></div>
  </div>

	<div class="form-row col-form-label-sm">
    <div class="col-1"></div>
    <div class="col-2">
		<div class="custom-control custom-switch">
			<input type="checkbox" class="custom-control-input" id="chkgrupo" name="chkgrupo" >
			<label class="custom-control-label textoVerde" for="chkgrupo">Grupo</label>
		</div>
   	</div>
    <div class="col-sm-2">
		<div class="custom-control custom-switch">
			<input type="checkbox" class="custom-control-input" id="chkorigem" name="chkorigem">
			<label class="custom-control-label textoVerde" for="chkorigem">Origem</label>
		</div>
  </div>
    <div class="col-sm-2">
		<div class="custom-control custom-switch">
			<input type="checkbox" class="custom-control-input" id="chkzonal" name="chkzonal">
			<label class="custom-control-label textoVerde" for="chkzonal">Zonal Eleitoral</label>
		</div>
    </div>
    <div class="col-sm-2">
		<div class="custom-control custom-switch">
			<input type="checkbox" class="custom-control-input" id="chksecao" name="chksecao">
			<label class="custom-control-label textoVerde" for="chksecao">Seção Eleitoral</label>
		</div>
    </div>
    <div class="col-sm-2">
		<div class="custom-control custom-switch">
		</div>
    </div>

    <div class="col-1"></div>
  </div>

	<div class="form-row col-form-label-sm">
    <div class="col-1"></div>
    <div class="col-2">
		<div class="custom-control custom-switch">
			<input type="checkbox" class="custom-control-input" id="chkpaimae" name="chkpaimae" >
			<label class="custom-control-label textoVerde" for="chkpaimae">Tem Filhos</label>
		</div>
   	</div>
    <div class="col-sm-2">
		<div class="custom-control custom-switch">
			<input type="checkbox" class="custom-control-input" id="chkfiliado" name="chkfiliado">
			<label class="custom-control-label textoVerde" for="chkfiliado">É Filiado</label>
		</div>
  </div>
    <div class="col-sm-2">
		<div class="custom-control custom-switch">
			<input type="checkbox" class="custom-control-input" id="chkvotou" name="chkvotou">
			<label class="custom-control-label textoVerde" for="chkvotou">Votou</label>
		</div>
    </div>
    <div class="col-sm-2">
		<div class="custom-control custom-switch">
			<input type="checkbox" class="custom-control-input" id="chkrecebemat" name="chkrecebemat">
			<label class="custom-control-label textoVerde" for="chkrecebemat">Recebe Mat/Whats</label>
		</div>
    </div>
    <div class="col-sm-2">
		<div class="custom-control custom-switch">
			<input type="checkbox" class="custom-control-input" id="chkrecebemail" name="chkrecebemail" >
			<label class="custom-control-label textoVerde" for="chkrecebemail">Recebe Email</label>
		</div>
    </div>
    <div class="col-1"></div>
  </div>

	<div class="form-row col-form-label-sm">
    <div class="col-1"></div>
    <div class="col-2">
 		<div class="custom-control custom-switch">
			<input type="checkbox" class="custom-control-input" id="chkrecebeimpresso" name="chkrecebeimpresso">
			<label class="custom-control-label textoVerde" for="chkrecebeimpresso">Recebe Impresso</label>
		</div>
  	</div>
    <div class="col-sm-2">
		<div class="custom-control custom-switch">
			<input type="checkbox" class="custom-control-input" id="chkcampanha" name="chkcampanha">
			<label class="custom-control-label textoVerde" for="chkcampanha">Paticipação Campanha</label>
		</div>
   </div>
    <div class="col-sm-2">
		<div class="custom-control custom-switch">
			<input type="checkbox" class="custom-control-input" id="chkfacebook" name="chkfacebook">
			<label class="custom-control-label textoVerde" for="chkchkfacebookramo">Facebook</label>
		</div>
    </div>
    <div class="col-sm-2">
		<div class="custom-control custom-switch">
			<input type="checkbox" class="custom-control-input" id="chktwitter" name="chktwitter">
			<label class="custom-control-label textoVerde" for="chktwitter">Twitter</label>
		</div>
    </div>
    <div class="col-sm-2">
		<div class="custom-control custom-switch">
			<input type="checkbox" class="custom-control-input" id="chkoutrarede" name="chkoutrarede" >
			<label class="custom-control-label textoVerde" for="chkoutrarede">Outra Rede</label>
		</div>
    </div>
    <div class="col-1"></div>
  </div>

	<div class="form-row col-form-label-sm">
    <div class="col-1"></div>
    <div class="col-2">
		<div class="custom-control custom-switch">
			<input type="checkbox" class="custom-control-input" id="chkapelido" name="chkapelido">
			<label class="custom-control-label textoVerde" for="chkapelido">Apelido</label>
		</div>
   	</div>
    <div class="col-sm-2">
		<div class="custom-control custom-switch">
			<input type="checkbox" class="custom-control-input" id="chkestcivil" name="chkestcivil">
			<label class="custom-control-label textoVerde" for="chkestcivil">Estado Civil</label>
		</div>
    </div>
    <div class="col-sm-2">
		<div class="custom-control custom-switch">
			<input type="checkbox" class="custom-control-input" id="chkclassif" name="chkclassif">
			<label class="custom-control-label textoVerde" for="chkclassif">Classificação</label>
		</div>
    </div>
    <div class="col-sm-2">
		<div class="custom-control custom-switch">
			<input type="checkbox" class="custom-control-input" id="chkobs" name="chkobs">
			<label class="custom-control-label textoVerde" for="chkobs">Observações</label>
		</div>
    </div>
    <div class="col-sm-2">
		<div class="custom-control custom-switch">
			<input type="checkbox" class="custom-control-input" id="chkcep" name="chkcep" >
			<label class="custom-control-label textoVerde" for="chkcep">CEP</label>
		</div>
    </div>
    <div class="col-1"></div>
  </div>

	<div class="form-row col-form-label-sm">
    <div class="col-1"></div>
    <div class="col-2">
		<div class="custom-control custom-switch">
			<input type="checkbox" class="custom-control-input" id="chktipolog" name="chktipolog">
			<label class="custom-control-label textoVerde" for="chktipolog">Tipologia</label>
		</div>
   	</div>
    <div class="col-sm-2">
		<div class="custom-control custom-switch">
			<input type="checkbox" class="custom-control-input" id="chklogradouro" name="chklogradouro">
			<label class="custom-control-label textoVerde" for="chklogradouro">Logradouro</label>
		</div>
    </div>
    <div class="col-sm-2">
		<div class="custom-control custom-switch">
			<input type="checkbox" class="custom-control-input" id="chknumero" name="chknumero">
			<label class="custom-control-label textoVerde" for="chknumero">Número</label>
		</div>
    </div>
    <div class="col-sm-2">
		<div class="custom-control custom-switch">
			<input type="checkbox" class="custom-control-input" id="chkcompl" name="chkcompl">
			<label class="custom-control-label textoVerde" for="chkcompl">Complemento</label>
		</div>
    </div>
    <div class="col-sm-2">
		<div class="custom-control custom-switch">
			<input type="checkbox" class="custom-control-input" id="chkbairro" name="chkbairro" >
			<label class="custom-control-label textoVerde" for="chkbairro">Bairro</label>
		</div>
    </div>
    <div class="col-1"></div>
    </div>

	<div class="form-row col-form-label-sm">
    <div class="col-1"></div>
    <div class="col-2">
		<div class="custom-control custom-switch">
			<input type="checkbox" class="custom-control-input" id="chkcidade" name="chkcidade">
			<label class="custom-control-label textoVerde" for="chkcidade">Cidade</label>
		</div>
   	</div>
    <div class="col-sm-2">
		<div class="custom-control custom-switch">
			<input type="checkbox" class="custom-control-input" id="chkuf" name="chkuf">
			<label class="custom-control-label textoVerde" for="chkuf">UF</label>
		</div>
    </div>
    <div class="col-sm-2">
		<div class="custom-control custom-switch">
			<input type="checkbox" class="custom-control-input" id="chktipo" name="chktipo">
			<label class="custom-control-label textoVerde" for="chktipo">Tipo de Endereço</label>
		</div>
    </div>
    <div class="col-sm-2">
		<div class="custom-control custom-switch">
			<input type="checkbox" class="custom-control-input" id="chkcdd" name="chkcdd">
			<label class="custom-control-label textoVerde" for="chkcdd">CDD Correios</label>
		</div>
    </div>
    <div class="col-sm-2">
    </div>
    <div class="col-1"></div>
  </div>

  <div class="form-row col-form-label-sm">
    <div id="mens" class="col-12"></div>
  </div>


	</section>
</form>
<br><br><br><br><br><br>

<script>
function geraexcel(){
	var select ='';
	var primeiro = true;
	if (document.form1.chkcodigo.checked){
		select = select + 'cadastro.CODIGO';		
		primeiro = false;
	}																

	if (document.form1.chknome.checked){
		if (!primeiro){
			select = select + ',cadastro.NOME';		
		}else{
			select = select + 'cadastro.NOME';	
			primeiro = false;
		}	
	}	
	if (document.form1.chksexo.checked){
		if (!primeiro){
			select = select + ',cadastro.SEXO';		
		}else{
			select = select + 'cadastro.SEXO';	
			primeiro = false;
		}	
	}	
	if (document.form1.chkdtnasc.checked){
		if (!primeiro){
			select = select + ',cadastro.DTNASC';		
		}else{
			select = select + 'cadastro.DTNASC';	
			primeiro = false;
		}	
	}	
	if (document.form1.chkcargo.checked){
		if (!primeiro){
			select = select + ',cadastro.CARGO';		
		}else{
			select = select + 'cadastro.CARGO';	
			primeiro = false;
		}	
	}	
	if (document.form1.chkcelular.checked){
		if (!primeiro){
			select = select + ',cadastro.FONE_CEL';		
		}else{
			select = select + 'cadastro.FONE_CEL';	
			primeiro = false;
		}	
	}	
	if (document.form1.chkresidencial.checked){
		if (!primeiro){
			select = select + ',cadastro.FONE_RES';		
		}else{
			select = select + 'cadastro.FONE_RES';	
			primeiro = false;
		}	
	}	
	if (document.form1.chkcomercial.checked){
		if (!primeiro){
			select = select + ',cadastro.FONE_COM';		
		}else{
			select = select + 'cadastro.FONE_COM';	
			primeiro = false;
		}	
	}	
	if (document.form1.chkcpf.checked){
		if (!primeiro){
			select = select + ',cadastro.CPF';		
		}else{
			select = select + 'cadastro.CPF';	
			primeiro = false;
		}	
	}	
	if (document.form1.chkgrupo.checked){
		if (!primeiro){
			select = select + ',grupos.NOMEGRP';		
		}else{
			select = select + 'grupos.NOMEGRP';	
			primeiro = false;
		}	
	}	
	if (document.form1.chkorigem.checked){
		if (!primeiro){
			select = select + ',origem.Descricao';		
		}else{
			select = select + 'oridem.Descricao';	
			primeiro = false;
		}	
	}	
	if (document.form1.chkzonal.checked){
		if (!primeiro){
			select = select + ',cadastro.ZONAL';		
		}else{
			select = select + 'cadastro.ZONAL';	
			primeiro = false;
		}	
	}	
	if (document.form1.chksecao.checked){
		if (!primeiro){
			select = select + ',cadastro.SECCAO';		
		}else{
			select = select + 'cadastro.SECCAO';	
			primeiro = false;
		}	
	}	
	if (document.form1.chkpaimae.checked){
		if (!primeiro){
			select = select + ',CASE WHEN cadastro.PAI_MAE = 0 THEN "NÃO" ELSE "SIM" END AS PAI_MAE';		
		}else{
			select = select + 'CASE WHEN cadastro.PAI_MAE = 0 THEN "NÃO" ELSE "SIM" END AS PAI_MAE';	
			primeiro = false;
		}	
	}	
	if (document.form1.chkfiliado.checked){
		if (!primeiro){
			select = select + ',CASE WHEN cadastro.FILIADO = 0 THEN "NÃO" ELSE "SIM" END AS FILIADO';		
		}else{
			select = select + 'CASE WHEN cadastro.FILIADO = 0 THEN "NÃO" ELSE "SIM" END AS FILIADO';	
			primeiro = false;
		}	
	}	
	if (document.form1.chkvotou.checked){
		if (!primeiro){
			select = select + ',CASE WHEN cadastro.VOTOU = 0 THEN "NÃO" ELSE "SIM" END AS VOTOU';		
		}else{
			select = select + 'CASE WHEN cadastro.VOTOU = 0 THEN "NÃO" ELSE "SIM" END AS VOTOU';	
			primeiro = false;
		}	
	}	
	if (document.form1.chkrecebemat.checked){
		if (!primeiro){
			select = select + ',CASE WHEN cadastro.RECEBEMAT = 0 THEN "NÃO" ELSE "SIM" END AS RECEBEMAT';		
		}else{
			select = select + 'CASE WHEN cadastro.RECEBEMAT = 0 THEN "NÃO" ELSE "SIM" END AS RECEBEMAT';	
			primeiro = false;
		}	
	}	
	if (document.form1.chkrecebemail.checked){
		if (!primeiro){
			select = select + ',CASE WHEN cadastro.RECEBEMAIL = 0 THEN "NÃO" ELSE "SIM" END AS RECEBEMAIL';		
		}else{
			select = select + 'CASE WHEN cadastro.RECEBEMAIL = 0 THEN "NÃO" ELSE "SIM" END AS RECEBEMAIL';	
			primeiro = false;
		}	
	}	
	if (document.form1.chkrecebeimpresso.checked){
		if (!primeiro){
			select = select + ',CASE WHEN cadastro.IMPRESSO = 0 THEN "NÃO" ELSE "SIM" END AS IMPRESSO';		
		}else{
			select = select + 'CASE WHEN cadastro.IMPRESSO = 0 THEN "NÃO" ELSE "SIM" END AS IMPRESSO';	
			primeiro = false;
		}	
	}	
	if (document.form1.chkcampanha.checked){
		if (!primeiro){
			select = select + ',cadastro.CAMPANHA';		
		}else{
			select = select + 'cadastro.CAMPANHA';	
			primeiro = false;
		}	
	}	
	if (document.form1.chkfacebook.checked){
		if (!primeiro){
			select = select + ',cadastro.FACEBOOK';		
		}else{
			select = select + 'cadastro.FACEBOOK';	
			primeiro = false;
		}	
	}	
	if (document.form1.chktwitter.checked){
		if (!primeiro){
			select = select + ',cadastro.TWITTER';		
		}else{
			select = select + 'cadastro.TWITTER';	
			primeiro = false;
		}	
	}	
	if (document.form1.chkoutrarede.checked){
		if (!primeiro){
			select = select + ',cadastro.OUTRAREDE';		
		}else{
			select = select + 'cadastro.OUTRAREDE';	
			primeiro = false;
		}	
	}	
	if (document.form1.chkapelido.checked){
		if (!primeiro){
			select = select + ',cadastro.APELIDO';		
		}else{
			select = select + 'cadastro.APELIDO';	
			primeiro = false;
		}	
	}	
	if (document.form1.chkestcivil.checked){
		if (!primeiro){
			select = select + ',cadastro.EST_CIVIL';		
		}else{
			select = select + 'cadastro.EST_CIVIL';	
			primeiro = false;
		}	
	}	
	if (document.form1.chkclassif.checked){
		if (!primeiro){
			select = select + ',cadastro.CLASSI';		
		}else{
			select = select + 'cadastro.CLASSI';	
			primeiro = false;
		}	
	}	
	if (document.form1.chkobs.checked){
		if (!primeiro){
			select = select + ',cadastro.OBS';		
		}else{
			select = select + 'cadastro.OBS';	
			primeiro = false;
		}	
	}	
	if (document.form1.chkcep.checked){
		if (!primeiro){
			select = select + ',enderecos.cep';		
		}else{
			select = select + 'enderecos.cep';	
			primeiro = false;
		}	
	}	
	if (document.form1.chktipolog.checked){
		if (!primeiro){
			select = select + ',enderecos.tipolog';		
		}else{
			select = select + 'enderecos.tipolog';	
			primeiro = false;
		}	
	}	
	if (document.form1.chklogradouro.checked){
		if (!primeiro){
			select = select + ',enderecos.rua';		
		}else{
			select = select + 'enderecos.rua';	
			primeiro = false;
		}	
	}	
	if (document.form1.chknumero.checked){
		if (!primeiro){
			select = select + ',enderecos.numero';		
		}else{
			select = select + 'enderecos.numero';	
			primeiro = false;
		}	
	}	
	if (document.form1.chkcompl.checked){
		if (!primeiro){
			select = select + ',enderecos.complemento';		
		}else{
			select = select + 'enderecos.complemento';	
			primeiro = false;
		}	
	}	
	if (document.form1.chkbairro.checked){
		if (!primeiro){
			select = select + ',enderecos.bairro';		
		}else{
			select = select + 'enderecos.bairro';	
			primeiro = false;
		}	
	}	
	if (document.form1.chkcidade.checked){
		if (!primeiro){
			select = select + ',enderecos.cidade';		
		}else{
			select = select + 'enderecos.cidade';	
			primeiro = false;
		}	
	}	
	if (document.form1.chkuf.checked){
		if (!primeiro){
			select = select + ',enderecos.uf';		
		}else{
			select = select + 'enderecos.uf';	
			primeiro = false;
		}	
	}	
	if (document.form1.chktipo.checked){
		if (!primeiro){
			select = select + ',enderecos.tipo';		
		}else{
			select = select + 'enderecos.tipo';	
			primeiro = false;
		}	
	}	
	if (document.form1.chkcdd.checked){
		if (!primeiro){
			select = select + ',enderecos.reg';		
		}else{
			select = select + 'enderecos.reg';	
			primeiro = false;
		}	
	}	

	
	select = select + ' FROM cadastro LEFT OUTER JOIN enderecos ON (cadastro.CODIGO = enderecos.codigo) INNER JOIN grupos ON (cadastro.GRUPO = grupos.GRUPO) INNER JOIN origem ON (cadastro.ORIGEM = origem.Origem)';
	
    document.getElementById('mens').innerHTML = select;	

	ajax('gera_excel.php?string='+select,'carregando');
  
}

	
function selecionar_all() {
	var frm = document.form1;
	for(i = 2; i < frm.length; i++)         {
		if(frm.elements[i].type == "checkbox")	{ 
			frm.elements[i].checked = "checked";                        
		}        
	}
}

function deselecionar_all() {
	var frm = document.form1;
	for(i = 2; i < frm.length; i++)         {
		if(frm.elements[i].type == "checkbox")	{ 
			frm.elements[i].checked = "";                        
		}        
	}
}


	
</script>

<script src="../js/bootstrap.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="../js/ie10-viewport-bug-workaround.js"></script>
<script src="../js/carrega_ajax.js" type="text/javascript"></script>
<script src="../js/ajax.js" type="text/javascript"></script>
<script src="../js/ie-emulation-modes-warning.js"></script>
<script type="text/javascript" src="../js/autocomplete.js"></script>
<?php include_once("../utilitarios/rodape.php");?>
</body>
</html>

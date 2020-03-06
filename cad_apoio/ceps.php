<?php
include_once("../seguranca.php");
protegePagina();
include_once("../utilitarios/funcoes.php");

if (liberado(5600)==0){
	expulsaVisitante2();
}else{
	$_SESSION['funcao']="CEPs";

?>
  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br">
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="CEP's" />
  <meta name="author" content="Vitor H M Oliveira" />
  <title>Cadastro CEPs</title>
  <link rel="icon" href="../imagens/favicon.ico" />
  <link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet" />
  <link href="../css/sticky-footer-navbar.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="../css/ajax.css"/>
  <link rel="stylesheet" type="text/css" href="../css/autocomplete.css"/>
  <link rel="stylesheet" type="text/css" href="../css/bootstrap.css"/>
  <link href="../css/formata_textos.css" rel="stylesheet">
  <link href="../css/all.css" rel="stylesheet">
  <link href="../css/botoes.css" rel="stylesheet">
  <script type="text/javascript" src="../js/ceps.js"></script>
  <script type="text/javascript" src="../js/ajax.js"></script>
  <script type="text/javascript" src="../js/carrega_ajax.js"></script>
  <script src="../js/ie-emulation-modes-warning.js"></script>
  <script src="../js/jquery.min.js"></script>
  <script src="../js/bootstrap.js"></script>
  <script src="../js/ie10-viewport-bug-workaround.js"></script>
  <script type="text/javascript" src="../js/autocomplete.js"></script>
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
                    <li class="nav-item active">
      					<button type="button" class="btn btn-sm btn-incluir" onclick="javascript:inclui_Cep();"> 
                        <i class="fas fa-plus" aria-hidden="true"></i> Incluir 
                        </button>
                    </li>
                    <li class="nav-item">
						&nbsp;<button type="button" class="btn btn-sm btn-success" onclick="javascript:altera_Cep();">
						<i class="fas fa-save" aria-hidden="true"></i> Alterar
						</button>
                    </li>
                    <li class="nav-item">
                        &nbsp;<button type="button" class="btn btn-sm btn-excluir" onclick="javascript:exclui_Cep();">
                        <i class="fas fa-trash" aria-hidden="true"></i> Excluir
                        </button>
                    </li>
                    <li class="nav-item">
                         &nbsp;<button type="button" class="btn btn-sm btn-pink" onclick="javascript:location.reload();">
                        <i class="fas fa-eraser" aria-hidden="true"></i> Limpa Tela
                    </button>
                    </li> 
                    <li class="nav-item">
                        &nbsp;<a href="apoio.php" class="btn btn-voltar btn-sm" role="button">
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
<pre><div class="col-12">
                       <strong>CEP</strong>: <input  type="text"  id="cep" name="cep" maxlength="8" size="8" autofocus/> <button class="btn btn-consultar btn-sm" type="button" onclick="ajax('pesquisa_ajax.php?cep='+document.getElementById('cep').value+'&consulta=cep','carregando');"> <i class="fas fa-search" aria-hidden="true"></i> Pesquisar </button> <a href="http://www.buscacep.correios.com.br/sistemas/buscacep/BuscaCepEndereco.cfm" title="Pesquisa Correios" target="_blank">Buscar no site dos Correios</a></div>
<div class="col-12">                 <strong>Tipologia</strong>: <input  name="tipologia" type="text" id="tipologia" size="10" maxlength="10" placeholder="Rua, Avenida etc"  onChange="javascript:this.value=this.value.toUpperCase();" /></div>
<div class="col-6">                <strong>Logradouro</strong>: <input name="rua" type="text" id="rua"  placeholder="NOME DO LOGRADOURO" maxlength="50" onChange="javascript:this.value=this.value.toUpperCase();" /></div>
<div class="col-12">                 <strong>Numeração</strong>: <input name="numeracao" type="text" id="numeracao"  maxlength="50" onChange="javascript:this.value=this.value.toUpperCase();" /></div>		
<div class="col-12">                 <strong>Bairro</strong>(1): <input name="bairro" type="text" id="bairro" size="30" placeholder="BAIRRO DO LOGRADOURO" maxlength="30" onChange="javascript:this.value=this.value.toUpperCase();" /> </div>       
<div class="col-12">                 <strong>Bairro(2)</strong>: <input  name="bairro2" type="text" id="bairro2" size="30"  maxlength="30" onChange="javascript:this.value=this.value.toUpperCase();" /></div>       
<div class="col-12">                    <strong>Cidade</strong>: <input name="cidade" type="text" id="cidade" size="30" maxlength="30" onChange="javascript:this.value=this.value.toUpperCase();" /> </div>              
<div class="col-12">                        <strong>UF</strong>: <input name="uf" type="text" id="uf" size="2" maxlength="2" onChange="javascript:this.value=this.value.toUpperCase();" /></div>
<div class="col-12">  <strong> Região entrega ECT(CDD)</strong>: <input name="reg" type="text" id="reg" size="3" maxlength="3" onChange="javascript:this.value=this.value.toUpperCase();" /></div>
<div class="col-12">          <strong>Última alteração:</strong> <span id="dtcad"></span> <strong>por</strong> <span id="respcad"></span> </div>

</form>
<script type="text/javascript">
	new Autocomplete("rua", function() { return "../eleitores/autocompleterua2.php?typing=" + this.text.value+'&city='+document.getElementById('cidade').value;});
		</script>
<?php
include("../utilitarios/rodape-fixo.php");
?>
</pre>
</body>
</html>
<?php }?>
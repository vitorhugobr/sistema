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

<table width="100%" border="0" cellspacing="2" cellpadding="2">
    <tr>
      <td align="right" width="15%">
      	<label>CEP:</label>
      </td>
      <td>
        <div class="input-group col-sm-4">
          <input type="text" class="form-control" id="cep" name="cep" maxlength="8" size="8" aria-label="Código CEP" autofocus/>
          <div class="input-group-append">
          <button class="btn btn-consultar btn-sm" type="button" onclick="ajax('pesquisa_ajax.php?cep='+document.getElementById('cep').value+'&consulta=cep','carregando');"><i class="fas fa-search" aria-hidden="true"></i> Pesquisar
          </button>
          </div>
        </div>
      
      </td>
    </tr>
    <tr>
    	<td align="right">
      	<label>Tipologia:</label>
      </td>
      <td>
	  	<div class="col-sm-2">
			<input class="form-control" name="tipologia" type="text" id="tipologia" size="10" maxlength="10" placeholder="Rua, Avenida etc"  onChange="javascript:this.value=this.value.toUpperCase();" />
        </div>
      </td>
    </tr>
    <tr>
    	<td align="right">
      		<label>Logradouro:</label>
      	</td>
      	<td>
		<div class="col-sm-6">
			<input class="form-control" name="rua" type="text" id="rua" size="50" placeholder="NOME DO LOGRADOURO" maxlength="50" onChange="javascript:this.value=this.value.toUpperCase();" />
		</div>
      	</td>
    </tr>
    <tr>
    	<td align="right">
      	<label>Numeração:</label>
      	</td>
      	<td>
	     	<div class="col-sm-4">
				<input class="form-control" name="numeracao" type="text" id="numeracao" size="50" maxlength="50" onChange="javascript:this.value=this.value.toUpperCase();" />		    
        	</div>
      	</td>
    </tr>
    <tr>
    	<td align="right">
      		<label>Bairro(1):</label>
      	</td>
      	<td>
	    	<div class="col-sm-4">
				<input class="form-control" name="bairro" type="text" id="bairro" size="30" placeholder="BAIRRO DO LOGRADOURO" maxlength="30" onChange="javascript:this.value=this.value.toUpperCase();" />        
        	</div>
      	</td>
    </tr>
    <tr>
    	<td align="right">
     	 	<label>Bairro(2):</label>
      	</td>
      	<td>
	    	<div class="col-sm-4">
				<input class="form-control" name="bairro2" type="text" id="bairro2" size="30"  maxlength="30" onChange="javascript:this.value=this.value.toUpperCase();" />        
        	</div>
      	</td>
    </tr>
    <tr>
    	<td align="right">
    	  	<label>Cidade:</label>
      	</td>
      	<td>
	     	<div class="col-sm-4">
				<input class="form-control" name="cidade" type="text" id="cidade" size="30" maxlength="30" onChange="javascript:this.value=this.value.toUpperCase();" />        
        	</div>
      	</td>
    </tr>
    <tr>
    	<td align="right">
      		<label>UF:</label>
      	</td>
      	<td>
	     	<div class="col-sm-1">
				<input class="form-control" name="uf" type="text" id="uf" size="2" maxlength="2" onChange="javascript:this.value=this.value.toUpperCase();" />
        	</div>
      	</td>
    </tr>
    <tr>
    	<td align="right">
    	  	<label>Regi&atilde;o entrega ECT(CDD):</label>
      	</td>
      	<td>
	     	<div class="col-sm-1">
				<input class="form-control" name="reg" type="text" id="reg" size="3" maxlength="3" onChange="javascript:this.value=this.value.toUpperCase();" />
        	</div>
      	</td>
    </tr>
    <tr>
    	<td align="right">
      		<label>Última alteração:</label>
      	</td>
      	<td>
	     	<div class="col-sm-3">
        		<span id="respcad"></span> 
        		<span id="dtcad"></span>
        	</div>
      	</td>
    </tr>
</table>
</form>
<script type="text/javascript">
	new Autocomplete("rua", function() { return "../eleitores/autocompleterua2.php?typing=" + this.text.value+'&city='+document.getElementById('cidade').value;});
		</script>
<?php
include("../utilitarios/rodape-fixo.php");
?>
</body>
</html>
<?php }?>
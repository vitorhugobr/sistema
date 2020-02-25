<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
require_once("../utilitarios/funcoes.php");
$_SESSION['funcao']="Config";
$sqlstr = "SELECT * from config limit 1";
$statement = $pdo->prepare($sqlstr);
$statement->execute();
$total = $statement->rowCount();
if($total==0){
  echo '<script>alert("Cliente não cadastrado");</script>'; 
}else{
  // Definimos a mensagem de erro
  while($dados_s = $statement->fetch()) {
	  $politico = $dados_s['politico'];	  
	  $id = $dados_s['id'];
	  $end_pol = $dados_s['end_pol'];
	  $email_pol = $dados_s['email_pol'];
	  $cidade_pol = $dados_s['cidade_pol'];
	  $estado_pol = $dados_s['estado_pol'];
	  $cep_pol = $dados_s['cep_pol'];
	  $id = $dados_s['id'];
	  $endurl = $dados_s['endurl'];
	  $endfoto = $dados_s['endfoto'];
	  $ativo = $dados_s['ativo'];
	  $host_pol = $dados_s['host_pol'];
	  $email_retorno = $dados_s['email_retorno'];
	  $login_pol = $dados_s['login_pol'];
	  $passw_pol = $dados_s['passw_pol'];
		$fones_pol = $dados_s['fones_pol'];
	  $versao = $dados_s['versao'];
  }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Cadastro de Grupos">
<meta name="author" content="Vitor H M Oliveira">
<title>Configurações</title>
<link rel="icon" href="../imagens/favicon.ico">
<link rel="stylesheet" type="text/css" href="../css/bootstrap.css"/>
<link rel="stylesheet" type="text/css" href="../css/sticky-footer-navbar.css"/>
<link rel="stylesheet" type="text/css" href="../css/formata_textos.css"/>
<link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css"/>
<link rel="stylesheet" type="text/css" href="../css/all.css"/>
</head>

<body>
<?php include_once("../utilitarios/cabecalho.php");?>
<p></p>
<div class="container-fluid">
  <form name="form1" method="POST" action="gravar_config.php" enctype="multipart/form-data">
    <div class="form-group row">
      <label for="politico" class="col-sm-2 col-form-label text-right"><strong>Nome</strong></label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="politico" name="politico" placeholder="Nome do Político" value="<?php echo $politico?>">
        <input type="hidden" id="id_politico" name="id_politico" value="<?php echo $id?>">
      </div>
    </div> 
    <div class="form-group row">
      <label for="endereco" class="col-sm-2 col-form-label text-right">Endereço</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" id="endereco" name="endereco" placeholder="Endereço Completo" value="<?php echo $end_pol?>">
      </div>
    </div>
    <div class="form-group row">
      <label for="cidade" class="col-sm-2 col-form-label text-right">Cidade</label>
      <div class="col-sm-2">
        <input type="text" class="form-control" id="cidade" name="cidade" placeholder="Cidade" value="<?php echo $cidade_pol ?>">
      </div>
      <label for="estado" class="col-sm-1 col-form-label text-right">UF</label>
      <div class="col-sm-2">
        <input type="text" class="form-control" id="estado" name="estado" placeholder="UF" value="<?php echo $estado_pol?>">
      </div>
      <label for="cep" class="col-sm-1 col-form-label text-right">CEP</label>
      <div class="col-sm-1">
        <input type="text" class="form-control" id="cep" name="cep" placeholder="CEP" value="<?php echo $cep_pol?>">
      </div>
    </div>
    <div class="form-group row">
      <label for="email" class="col-sm-2 col-form-label text-right">Email</label>
      <div class="col-sm-6">
        <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $email_pol ?>">
      </div>
    </div>
    <div class="form-group row">
      <label for="endurl" class="col-sm-2 col-form-label text-right">Endereço URL</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" id="endurl" name="endurl" placeholder="Endereço URL" value="<?php echo $endurl?>">
      </div>
    </div>
    <div class="form-group row">
      <label for="endfoto" class="col-sm-2 col-form-label text-right">Endereço Foto</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" id="endfoto" name="endfoto" placeholder="Endereço Foto" value="<?php echo $endfoto?>">
      </div>
    </div>
    <div class="form-group row">
      <div class="col-sm-2 text-right">Sistema Ativo</div>
      <div class="col-sm-3">
        <div class="form-check">
        	<?php if ($ativo==0){ ?>
          	<input class="form-check-input" type="checkbox" id="ativo" name="ativo" checked="checked">
            <?php } else  {?>
          	<input class="form-check-input" type="checkbox" id="ativo" name="ativo" >
						<?php } ?>
          <label class="form-check-label text-right" for="gridCheck1">
            Sistema ativo e liberado para uso
          </label>
        </div>
      </div>
      <label for="versao" class="col-sm-2 col-form-label text-right">Versão</label>
      <div class="col-sm-1">
        <input type="text" class="form-control" id="versao" name="versao" placeholder="Versão" value="<?php echo $versao?>">
      </div>

    </div>
    <div class="form-group row">
      <label for="host_pol" class="col-sm-2 col-form-label text-right">Host</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" id="host_pol" name="host_pol" placeholder="Host" value="<?php echo $host_pol?>">
      </div>
    </div>
    <div class="form-group row">
      <label for="email_retorno" class="col-sm-2 col-form-label text-right">E-mail Retorno</label>
      <div class="col-sm-6">
        <input type="email" class="form-control" id="email_retorno" name="email_retorno" placeholder="E-mail Retorno" value="<?php echo $email_retorno?>">
      </div>
    </div>
    <div class="form-group row">
      <label for="login_pol" class="col-sm-2 col-form-label text-right">Login Cpanel</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" id="login_pol" name="login_pol" placeholder="Usuário Cpanel" value="<?php echo $login_pol?>">
      </div>
    </div>
    <div class="form-group row">
      <label for="passw_pol" class="col-sm-2 col-form-label text-right">Senha Cpanel</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" id="passw_pol" name="passw_pol" placeholder="Senha Cpnael" value="<?php echo $passw_pol?>">
      </div>
    </div>
    <div class="form-group row">
      <label for="fones_pol" class="col-sm-2 col-form-label text-right">Telefones</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" id="fones_pol" name="fones_pol" placeholder="Telefones" value="<?php echo $fones_pol?>">
      </div>
    </div>
    <div class="form-group row">
      <div class="col-sm-12">
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>&nbsp;Salvar</button>
        <a href="../index2.php" class="btn btn-dark"><i class="fas fa-list-ul"></i>&nbsp;Menu</a>
      </div>
    </div>
  </form>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../js/bootstrap.min.js"></script>
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script src="../js/ie-emulation-modes-warning.js"></script>
<script type="text/javascript" src="../js/ie10-viewport-bug-workaround.js"></script>
<?php
include("../utilitarios/rodape.php");
?>
</body>
</html>
<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
require_once("../utilitarios/funcoes.php");
$_SESSION['funcao']="Config";

$sql = "SELECT * from config where id = ".$_SESSION['id'];
try{
	$pdo = new PDO("mysql:host=www.vitor.poa.br;dbname=vitorpoa_teste;","vitorpoa_user", "vhmo@2017");
	$pdo->exec("set names utf8");
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	array(PDO::ATTR_PERSISTENT => true);
}catch(PDOException $e){
	// Caso ocorra algum erro na conexão com o banco, exibe a mensagem
	echo 'Falha ao conectar no banco de dados: '.$e->getMessage();
	die;
}
//echo $sql;
$sql = $pdo->prepare($sql);
$sql->execute();
$total = $sql->rowCount();
if($total==0){
// Nenhum registro foi encontrado => o usuário é inválido
	$msg_erro= "Cliente ".$_SESSION['id']." não cadastrado";
	echo '<script>alert('.$msg_erro.');</script>'; 
}else{
	// Definimos a mensagem de erro
	while($dados_s = $sql->fetch()) {	
	  $id = $dados_s['id'];
	  $politico  = $dados_s['politico'];
	  $end_pol = $dados_s['end_pol'];
	  $email_pol = $dados_s['email_pol'];
	  $cidade_pol= $dados_s['cidade_pol'];
	  $estado_pol = $dados_s['estado_pol'];
	  $cep_pol = $dados_s['cep_pol'];
	  $endurl = $dados_s['endurl'];
	  $endfoto= $dados_s['endfoto'];
	  $ativo= $dados_s['ativo'];
	  $host_pol= $dados_s['host_pol'];
	  $email_retorno = $dados_s['email_retorno'];
	  $user_login= $dados_s['login_pol'];
	  $user_pass = $dados_s['passw_pol'];	  
	  $fones_pol = $dados_s['fones_pol'];
	  $versao = $dados_s['versao'];
	  $partido = $dados_s['partido']; 
	  $imagem = $dados_s['endfoto'];
	  $nome2 = $dados_s['nome2'];
	  $email2 = $dados_s['email2'];
	  $nome3 = $dados_s['nome3'];
	  $email3 = $dados_s['email3'];
	  $nome4 = $dados_s['nome4'];
	  $email4 = $dados_s['email4'];
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
<?php include_once("../utilitarios/cabecalho.php");

if(isset($_SESSION['msg'])){
	echo $_SESSION['msg'];
	unset($_SESSION['msg']);
}
?>
<div class="container-fluid">
  <form name="form1" method="POST" action="gravar_config.php" enctype="multipart/form-data">
    <input type="hidden" id="id_politico" name="id_politico" value="<?php echo $id?>">
    <div class="form-group row">
      <label for="cidade" class="col-sm-2 col-form-label text-right">Nome</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="cidpoliticoade" name="politico" placeholder="Cidade" value="<?php echo $politico ?>">
      </div>
      <label for="estado" class="col-sm-1 col-form-label text-right">Partido</label>
      <div class="col-sm-2">
        <input type="text" class="form-control" id="estado" name="estado" placeholder="UF" value="<?php echo $partido?>">
      </div>
    </div>    <div class="form-group row">
      <label for="endereco" class="col-sm-2 col-form-label text-right">Endereço</label>
      <div class="col-sm-10">
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
      <div class="col-sm-10">
        <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $email_pol ?>">
      </div>
    </div>
    <div class="form-group row">
      <label for="endurl" class="col-sm-2 col-form-label text-right">Endereço Sistema</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" id="endurl" name="endurl" placeholder="www.dominio.com.br/sigre/" value="<?php echo $endurl?>">
      </div>
    </div>
    <div class="form-group row">
      <label for="endfoto" class="col-sm-2 col-form-label text-right">Endereço Foto</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" id="endfoto" name="endfoto" placeholder="Endereço Foto" value="<?php echo $endfoto?>">
      </div>
    </div>
     <div class="form-group row">
      <label for="fones_pol" class="col-sm-2 col-form-label text-right">Telefones</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" id="fones_pol" name="fones_pol" placeholder="Telefones" value="<?php echo $fones_pol?>">
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
      <label for="host_pol" class="col-sm-2 col-form-label text-right">iframe da Agenda</label>
      <div class="col-sm-10">
       <textarea name="host_pol" rows="3" class="form-control" id="host_pol" placeholder="Agenda"><?php echo $host_pol?></textarea>
      </div>
    </div>
    <div class="form-group row">
      <label for="email_retorno" class="col-sm-2 col-form-label text-right">E-mail Retorno</label>
      <div class="col-sm-6">
        <input type="email" class="form-control" id="email_retorno" name="email_retorno" placeholder="E-mail Retorno" value="<?php echo $email_retorno?>">
      </div>
    </div>
    <div class="form-group row">
      <label for="nome2" class="col-sm-2 col-form-label text-right">Nome Email 2</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="nome2" name="nome2" placeholder="Nome #2 para receber e-mails" value="<?php echo $nome2 ?>">
      </div>
      <label for="email2" class="col-sm-1 col-form-label text-right">Email2</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="email2" name="email2" placeholder="Email 2" value="<?php echo $email2?>">
      </div>
    </div>
    <div class="form-group row">
      <label for="nome3" class="col-sm-2 col-form-label text-right">Nome Email 3</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="nome3" name="nome3" placeholder="Nome #3 para receber e-mails" value="<?php echo $nome3 ?>">
      </div>
      <label for="email3" class="col-sm-1 col-form-label text-right">Email 3</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="email3" name="email3" placeholder="Email 3" value="<?php echo $email3?>">
      </div>
    </div>
    <div class="form-group row">
      <label for="nome4" class="col-sm-2 col-form-label text-right">Nome Email4</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="nome4" name="nome4" placeholder="Nome #4 para receber e-mails" value="<?php echo $nome4 ?>">
      </div>
      <label for="email4" class="col-sm-1 col-form-label text-right">Email4</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="email4" name="email4" placeholder="Email 4" value="<?php echo $email4?>">
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
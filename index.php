<?php
//**********************************************************************************************
// chave do api google maps de minha conta                                                     *
//  AIzaSyA45LBB4ik4oOKbSPCyujC7dovt6-I_TsM                                                    *
//**********************************************************************************************
session_start();

date_default_timezone_set('America/Sao_Paulo');
$_SESSION['ult_etapa'] = 0;  // guarda a última etapa consultada na sessão.
$_SESSION['sistema']= "Sistema de Gestão e Relacionamento com Eleitor";
$_SESSION['sistemaabrev']= "SIGRE";
$ano = date('Y');
$_SESSION['autor']= "&copy 2016-$ano Vitor H M Oliveira";

$_SESSION['ult_eleitor_pesquisado'] = 0;
$arqconfig = md5("mapa").".txt";
if (!file_exists($arqconfig)) {
	echo 'IMPOSSÍVEL ACESSAR O SISTEMA.<br>Arquivo de configuração excluído ou danificado! ';
	die;
} 	

$linhas = explode("\n", file_get_contents($arqconfig));
$_SESSION['id'] = $linhas[0]; // usuario =A(100,80);
$_SESSION['versao']= $linhas[1];
#echo $_SESSION['id']."<br>";
include_once("seguranca.php");

require_once("utilitarios/funcoes.php");

$sql = "SELECT * from config where id = ".$_SESSION['id'];
try{
	// Faz conexão com banco de daddos
	if ($_SERVER['DOCUMENT_ROOT']=="D:/wampserver64/www"){
		$area_acesso = "TESTES";
	} else {
		$area_acesso = "Web";
	}
	$pdo = new PDO("mysql:host=www.vitor.poa.br;dbname=vitorpoa_teste;","vitorpoa_user", "vhmo@2017");
	$pdo->exec("set names utf8");
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	array(PDO::ATTR_PERSISTENT => true);
}catch(PDOException $e){
	// Caso ocorra algum erro na conexão com o banco, exibe a mensagem
	echo 'Leitura config - Falha ao conectar no banco de dados: '.$e->getMessage();
	session_unset();
	session_destroy();
	session_start();

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
		  $_SESSION['id'] = $dados_s['id'];
		  $_SESSION['politico'] = $dados_s['politico'];
		  $_SESSION['ativo']= $dados_s['ativo'];
		  $_SESSION['url']= $dados_s['endurl'];
		  $_SESSION['host_pol']= $dados_s['host_pol'];
		  $_SESSION['email_pol']= $dados_s['email_pol'];
		  $_SESSION['fones_pol'] = $dados_s['fones_pol'];
		  $_SESSION['email_pol'] = $dados_s['email_pol'];
		  $_SESSION['partido'] = $dados_s['partido']; 
		  $_SESSION['servidor']= $dados_s['host_pol'];
		  $_SESSION['user_login']= $dados_s['login_pol'];
		  $_SESSION['user_pass']= $dados_s['passw_pol'];	  
	  	  $imagem = $dados_s['endfoto'];
			if ($dados_s['ativo']==1){
				header("Location: manutencao.html");		
			}
		}
	}


$_SESSION['ult_eleitor_pesquisado']=0;


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="Vitor H M Oliveira">
<title><?php echo $_SESSION['sistemaabrev']?> - Área Restrita</title>
<link rel="icon" href="imagens/favicon.ico">
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<link href="css/all.css" rel="stylesheet">
<link href="css/formata_textos.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/sticky-footer-navbar.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet">
<link href="css/signin.css" rel="stylesheet">
<link href="css/botoes.css" rel="stylesheet">
<style type="text/css">
  body {
		background-image: url(<?php echo $imagem?>);
		background-repeat: no-repeat;
		background-size: cover;
	}
  body,td,th {
		color: #FFFFFF;
	}
</style>

<style type="text/css">
	.msgLogin {
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 10px;
	font-weight: bold;
	color: #F00;
	text-align: center;
	}
	</style>
<link href="css/floating-labels.css" rel="stylesheet" type="text/css" />
    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
<script src="js/ie-emulation-modes-warning.js"></script>
</head>
<body>
<form class="form-signin" method="POST" action="valida.php">
  <div class="text-center mb-4">
    <img class="mb-4" src="imagens/vhmo.png" alt="" width="32" height="32"><br>
    <h5 align="center">
<div id="time" class="data_hora_index"></div>
<script >
	function checkTime(i) {
			if (i < 10) {
					i = "0" + i;
			}
			return i;
	}
	function startTime() {
			var today = new Date();
			var h = today.getHours();
			var m = today.getMinutes();
			var s = today.getSeconds();
			// add a zero in front of numbers<10
			m = checkTime(m);
			s = checkTime(s);
			document.getElementById('time').innerHTML = h + ":" + m + ":" + s;
			t = setTimeout(function () {
					startTime()
			}, 500);
	}
	startTime();
</script>
<div id="time" class="data_hora_index">
<?php echo date('d/m/Y')?></div></h5>
	<div class="nome_usuario_index" >
		<?php echo $_SESSION['sistemaabrev']?></div>
	<div class="data_hora_index">
	<?php echo $_SESSION['versao'].'-'.$_SESSION['id'];?></div>
	<div class="nome_usuario_index"><?php echo $_SESSION['politico'] ?>
  	</div>
   <div class="form-signin-heading text-danger">Área Restrita <?php echo $area_acesso; ?>
   </div>

  <div class="form-label-group">
    <input type="text" id="inputEmail" name="txt_usuario" class="form-control" placeholder="Usuário/Email" required autofocus>
    <label for="inputEmail">Usuário/Email</label>
  </div>

  <div class="form-label-group">
    <input type="password" id="inputPassword" name="txt_senha" class="form-control" placeholder="Senha" required>
    <label for="inputPassword">Senha</label>
  </div>

  <button class="btn btn-lg btn-teal btn-block" type="submit"><i class="fas fa-door-open"></i> Entrar</button>
<!--    <div class="row text-center" style="margin-top:20px;">
-->      <a href="senhas/recuperar_senha.php" class="btn btn-yellow btn-lg btn-block" role="button" ><i class="fas fa-exclamation-triangle"></i> Esqueci a Senha!</a>
<!--    </div>
-->    <h5 class="text-center btn-danger">
        <?php if(isset($_SESSION['loginErro'])){
            echo '<i class="fas fa-exclamation">&nbsp;</i>'.$_SESSION['loginErro'];
            unset ($_SESSION['loginErro']);
        }?>
    </h5>
    <h5 class="text-center btn-success">
        <?php if(isset($_SESSION['loginSaida'])){
            echo '<i class="fas fa-check">&nbsp;</i>'.$_SESSION['loginSaida'];
            unset ($_SESSION['loginSaida']);
        }?>
    </h5>

</form>

<?php 
						
include_once("utilitarios/rodape-fixo.php");?>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>

<?php
require_once ("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
require_once ("../utilitarios/funcoes.php");
date_default_timezone_set('America/Sao_Paulo');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!--<![endif]-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Recuperar Senha">
<meta name="author" content="Vitor H M Oliveira">
<title><?php echo $_SESSION['sistemaabrev']?> - Recuperar Senha</title>
<link rel="icon" href="../imagens/favicon.ico">
<link href="../css/formata_textos.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../css/sticky-footer-navbar.css">
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
<link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">
<link href="../css/signin.css" rel="stylesheet">
<link href="../css/botoes.css" rel="stylesheet">
<style type="text/css">
	.msgLogin {
		font-family: Tahoma, Geneva, sans-serif;
		font-size: 18px;
		font-weight: bold;
		color: #F00;
		text-align: center;
	}
</style>
<script src="../js/ie-emulation-modes-warning.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="../js/ie10-viewport-bug-workaround.js"></script>
</head>

<body>
	<h1 align="center"><img src="../imagens/vhmo.png" width="32" height="32"><span class="sigla_sistema"> 
  <?php echo $_SESSION['sistemaabrev']?> -</span> <span class="politico"><?php echo $_SESSION['politico'] ?></span> <img src="../imagens/vhmo.png" alt="" width="32" height="32"></h1>
	<h5 align="center">
	<div id="time" class="rodape"></div>
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
	<div id="time" class="rodape">
		<?php echo date('d/m/Y')?>
  </div></h5>

  <div class="container">
    <form class="form-signin" method="POST" action="adm_proc_edita_rec_senha.php">
    <h2 class="form-signin-heading">Recuperar a Senha<br><br></h2>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>E-mail:</td>
        <td>
          <input style="text-transform:lowercase" type="email" id="inputEmail" name="txt_email" class="form-control"  placeholder="Informe o e-mail" required autofocus>
        </td>
      </tr>
    </table>
    <button class="btn btn-lg btn-orange btn-block" type="submit"><i class="fas fa-send"></i> Enviar</button>
    <div class="row text-center" style="margin-top:20px;">
      <a href="../index.php">Login</a>
    </div>
    <p class="text-center alert-danger">
    <?php 
      if(isset($_SESSION['recuperar_senha'])){
        echo $_SESSION['recuperar_senha'];
        unset ($_SESSION['recuperar_senha']);
      }
    ?>
    </p>
    </form>
  </div> <!-- /container -->
<?php include_once("../utilitarios/rodape-fixo.php");?>    
</body>
</html>

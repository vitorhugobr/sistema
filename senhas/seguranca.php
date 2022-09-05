<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a p&Aacute;gina
require_once ('../utilitarios/funcoes.php');
  $_SESSION['funcao'] = "Segurança";
if (liberado(3000)==0)) {
	expulsaVisitante2();
}else{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br">
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Segurança">
  <meta name="author" content="Vitor H M Oliveira">
  <title>Arbitragem</title>
  <script src="../js/jquery.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="../css/sticky-footer-navbar.css"/>
  <link rel="stylesheet" type="text/css" href="../css/ajax.css"/>
  <link rel="SHORTCUT ICON" href="../imagens/favicon.ico" />
  <link rel="stylesheet" type="text/css" href="../css/formata_textos.css"/>
  <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>  </head>
  <body>

  <?php include_once("../utilitarios/cabecalho.php");?>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="500" valign="middle">
    <div class="container" align="center">
    
    <?php 
    if (liberado(3000)>0){
	  	echo '<a href="senhas.php" class="btn btn-primary btn-lg" role="button"><i class="fas fa-lock"></i> Senhas</a> ';
    }else{
	 		echo '<button type="button" class="btn btn-primary btn-lg disabled"><i class="fas fa-lock"></i> Senhas</button> ';
    }
    if (liberado(4000)>0){
	  	echo '<a usuarios.php" class=" btn btn-success btn-lg" role="button"><i class="fas fa-user"></i> Usuários</a> ';
    }else{
	  	echo '<button type="button" class="btn btn-success btn-lg disabled"><i class="fas fa-user"></i> Usuários</button> ';
    }
    if (liberado(5000)>0){
	  	echo '<a href="origens.php" class="btn btn-warning btn-lg" role="button"><i class="fas fa-log-in"></i> Controle de Acessos ao Sistema</a> ';
    }else{
	 		echo '<button type="button" class="btn btn-warning btn-lg disabled"><i class="fas fa-log-in"></i> Controle de Acessos ao Sistema</button> ';
    }
		?>  
    <a href="../index2.php" class="btn btn-dark btn-lg" role="button"><i class="fas fa-menu-hamburger"></i> Menu</a>
    </div>
  </td>
  </tr>
  </table>
<?php include_once("../utilitarios/rodape-fixo.php");?>
  </body>
</html>
<?php
}
?>
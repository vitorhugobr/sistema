<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a p&Aacute;gina
require_once ('../utilitarios/funcoes.php');
  $_SESSION['funcao'] = "Cadastros de Apoio";
if (liberado(5500)==0) {
	expulsaVisitante2();
}else{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br">
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Cadastro de Apoio">
  <meta name="author" content="Vitor H M Oliveira">
  <title>Cadastros Apoio</title>
  <script src="../js/jquery.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="../css/sticky-footer-navbar.css"/>
  <link rel="stylesheet" type="text/css" href="../css/ajax.css"/>
  <link rel="stylesheet" type="text/css" href="../css/botoes.css"/>
  <link rel="SHORTCUT ICON" href="../imagens/favicon.ico" />
  <link rel="stylesheet" type="text/css" href="../css/formata_textos.css"/>
  <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">
  </head>
  <body>

  <?php include_once("../utilitarios/cabecalho.php");?>
  
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="500" valign="middle">
    <div class="container-fluid" align="center">
    
    <?php 
	  if (liberado(5600)>0){
			echo '<a href="ceps.php" class="btn btn-indigo btn-lg" role="button"><i style="font-size:20px" class="fas fa-street-view" aria-hiden="true"></i> CEPs</a> ';
	  }
	  if (liberado(5550)>0){
			echo '<a href="campanha.php" class="btn btn-blue-grey btn-lg" role="button"><i style="font-size:20px" class="fas fa-flag"></i> Campanha</a> ';
      }
		if (liberado(5650)>0){
			echo '<a href="clinicas.php" class="btn btn-brown btn-lg" role="button"><i style="font-size:20px" class="fas fa-hospital"></i> Clínicas</a> ';
		}
	  if (liberado(5750)>0){
			echo '<a href="exames.php" class=" btn btn-orange btn-lg" role="button"><i style="font-size:20px" class="fas fa-x-ray"></i> Exames</a> ';
		}
	  if (liberado(5700)>0){
			echo '<a href="grupos.php" class=" btn btn-amber btn-lg" role="button"><i style="font-size:20px" class="fas fa-users"></i> Grupos</a> ';
		}
	  if (liberado(5800)>0){
			echo '<a href="origens.php" class="btn btn-yellow btn-lg" role="button"><i style="font-size:20px" class="fas fa-user-circle"></i> Origens</a> ';
		}
	  if (liberado(5900)>0){
			echo '<a href="profissoes.php" class="btn btn-lime btn-lg" role="button"><i style="font-size:20px" class="fas fa-id-badge"></i> Profissões</a> ';
		}
	  if (liberado(6000)>0){
			echo '<a href="ramos.php" class="btn btn-cyan btn-lg" role="button"><i style="font-size:20px" class="fas fa-leaf"></i> Ramos Atividades</a> ';
		}
	  if (liberado(6050)>0){
			echo '<a href="secretarias.php" class="btn btn-teal btn-lg" role="button"><i style="font-size:20px" class="fas fa-building"></i> Secretarias</a> ';
		}
		?>
    <a href="../index2.php" class="btn btn-menu btn-lg" role="button"><span class="fas fa-list-ul"></span> Menu</a>
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
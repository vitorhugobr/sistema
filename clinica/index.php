<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a p&Aacute;gina
require_once ('../utilitarios/funcoes.php');
 $_SESSION['funcao'] = "Agenda Clínica";
if (liberado(5500)==0) {
	expulsaVisitante2();
}else{
?>
<!DOCTYPE >
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Admistra agenda clínica">
  <meta name="author" content="Vitor H M Oliveira">
  <title>Cadastros Apoio</title>
  <script src="../js/jquery.min.js"></script>
  <script type="text/javascript" src="../js/popper.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="../css/sticky-footer-navbar.css"/>
  <link rel="stylesheet" type="text/css" href="../css/ajax.css"/>
  <link rel="SHORTCUT ICON" href="../imagens/favicon.ico" />
  <link rel="stylesheet" type="text/css" href="../css/formata_textos.css"/>
  <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
  <link rel="stylesheet" href="../css/all.css">
  <link href="../css/botoes.css" rel="stylesheet">
 </head>
  <body>
  <?php include_once("../utilitarios/cabecalho.php");?>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="500" valign="middle">
    <div class="container-fluid" align="center">
    
    <?php 
	  if (liberado(7100)>0){
			echo '<a href="espera.php" class="btn btn-deep-orange btn-lg" role="button"><i class="fas fa-list-alt"></i> Administra Lista de Esperas</a>';
	  }
	  if (liberado(7300)>0){
			echo '<a href="agenda_consultas.php" class="btn btn-indigo btn-lg" role="button"><i class="fas fa-calendar-check"></i> Administra Agenda Consultas</a>';
      }
		if (liberado(7500)>0){
			echo '<a href="consultas.php" class="btn btn-brown btn-lg" role="button"><i class="fas fa-user-md"></i> Consultas (opção específica para o Doutor)</a>';
		}
		?>
    <a href="../index2.php" class="btn btn-menu btn-lg" role="button"><i class="fas fa-list-ul"></i> Menu</a>
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
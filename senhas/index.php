<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a p&Aacute;gina
require_once ('../utilitarios/funcoes.php');
$_SESSION['funcao'] = "Segurança";
if (liberado(3000)==0){
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
  <link rel="icon" href="../imagens/favicon.ico">
  <link rel="stylesheet" type="text/css" href="../css/sticky-footer-navbar.css"/>
  <link rel="stylesheet" type="text/css" href="../css/formata_textos.css"/>
  <link rel="stylesheet" type="text/css" href="../css/ajax.css"/>
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/all.css">
  <link rel="stylesheet" type="text/css" href="../css/botoes.css"/>
  <script type="application/javascript" src="../js/ajax.js"></script>
  <script language="javascript" src="../js/arbitragem.js"></script>
  <script language="javascript" src="../js/carrega_ajax.js"></script>
  <script src="../js/jquery.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>	
</head>
<body>
	<?php 
		include_once("../utilitarios/cabecalho.php");
	?>
  <table width="100%" border="0" cellspacing="2" cellpadding="2">
    <tr height="450">
      <td valign="middle">
        <div class="container" align="center">
        <?php 
        if (liberado(5000)>0){
            echo '<a href="autoriza_acessos.php" class="btn btn-deep-orange btn-lg" role="button"><i class="fas fa-user-check"></i> Controle de Acessos</a> ';
        }
        if (liberado(4000)>0){
            echo '<a href="../usuarios/usuarios.php" class="btn btn-blue-grey btn-lg" role="button"><i class="fas fa-user"></i> Usuários</a> ';
        }
        if (liberado(4000)>0){
            echo '<a href="../usuarios/upload_imagem.php" class="btn btn-success btn-lg" role="button"><i class="fas fa-id-badge"></i> Fotos Usuários</a> ';
        }
        ?>
        <a href="senhas.php" class="btn btn-yellow btn-lg" role="button"><i class="fas fa-lock"></i> Senhas</a>
        <a href="../index2.php" class="btn btn-menu btn-lg" role="button"><i class="fas fa-list-ul"></i> Menu</a>
        </div>
      </td>
    </tr>
  </table>
<?php
include_once("../utilitarios/rodape-fixo.php");
}
?>
<?php
include_once("../seguranca.php");
protegePagina();
include_once("../utilitarios/funcoes.php");
date_default_timezone_set('America/Sao_Paulo');


$comando_sql = "SELECT * FROM cadastro WHERE email >'' "; 

$mysql_query = $_con->query($comando_sql);
if ($mysql_query->num_rows<1) {
  echo '<script>alert("NENHUM REGISTRO SELECIONADO");</script>'; 
}else{
	$displayEnc = '<table class="table table-transparent table-striped table-sm">';
	$displayEnc .= '<thead class="thead-dark">
					<tr>
					  <th scope="col">
						  <div  class="col-auto" align="center"><i class="fas fa-hashtag"></i>
						  </div>
					  </th>
					  <th scope="col">
						  <div class="col-auto" align="left"><i class="fas fa-user"></i> Nome
						  </div>
					  </th>
					  <th scope="col">
						  <div class="col-auto" align="center"><i class="fas fa-calendar-alt"></i> Data Nasc
						  </div>
					  </th>
					  <th scope="col">
						  <div class="col-auto" align="left"><i class="fas fa-restroom"></i> Sexo
						  </div>		      
					  </th>
					  <th scope="col">
						  <div class="col-auto" align="left"><i class="fas fa-mail-bulk"></i> E-mail
						  </div>		      
					  </th>
					</tr>
				</thead><tbody>';
	$qtdinv = 0;
	while ($dados_s = $mysql_query->fetch_assoc()) {
		#if (!Verify_Email_Address($dados_s["EMAIL"]) ){
		if (!filter_var($dados_s["EMAIL"], FILTER_VALIDATE_EMAIL)) {
			$displayEnc .=  '<tr><td><div align="center">';
			$displayEnc .= '<strong><a href="javascript:abrir_cadastro_pelo_apoio('.$dados_s["CODIGO"].')" class="alert-link">'.$dados_s["CODIGO"].'</a></strong>';
			$displayEnc .=  '</div></td>';
			$displayEnc .=  '<td><div class="textoAzul" align="left">';
				$displayEnc .=  $dados_s["NOME"];
			$displayEnc .=  '</div></td>';
			$displayEnc .=  '<td><div align="center">';
				$displayEnc .= FormatDateTime($dados_s["DTNASC"],7);
			$displayEnc .=  '</div></td>';
			$displayEnc .=  '<td><div align="center">';
				$displayEnc .= $dados_s["SEXO"];
			$displayEnc .=  '</div></td>';
			$displayEnc .=  '<td><div class="text-danger" align="left">';
				$displayEnc .= $dados_s["EMAIL"];
			$displayEnc .=  '</div></td>';
			$displayEnc .=  "</tr>";
			$qtdinv++;

		}
	}
	$displayEnc .= '</tbody></table>';
	
	if ($qtdinv==0) {
		$_SESSION['msg'] = "<div class='alert alert-success' role='alert'><i class='fas fa-check' aria-hidden='true text-muted' aria-hidden='true'></i> Nenhum E-mail Inválido<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";			
		exit('<script>location.href = "../eleitores/cadastro.php?codigo=0"</script>'); 

	}

}

$_SESSION['funcao']="E-mails inválidos ".$qtdinv;

?>

<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Lista na tela de emails inválidos">
    <meta name="author" content="Vitor H M Oliveira">

    <title>SIGRE - Emails Inválidos</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.3/examples/navbar-fixed/">
	<link rel="icon" href="../imagens/favicon.ico">
  <!--- Component CSS -->
	<link href="../css/font-awesome.min.css" rel="stylesheet">
	<link href="../css/formata_textos.css" rel="stylesheet">
	<link href="../css/all.css" rel="stylesheet">
	<link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">
	<link href="../css/sticky-footer-navbar.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../css/ajax.css"/>
	<link rel="stylesheet" type="text/css" href="../css/botoes.css">
	<script src="../js/carrega_ajax.js" type="text/javascript"></script>
	<script src="../js/eleitor.js" type="text/javascript"></script>
    <!-- Bootstrap core CSS -->
	<link href="../css/bootstrap.min.css" rel="stylesheet">

  </head>
  <body>
  <div id="carregando"></div>
<div id="_VReportHeader"> 
<div class="nav fixed-top container-fluid">	
	<div class='col-2 text-center'>
		<a href="javascript:window.history.back();" class="btn btn-voltar btn-sm" role="button"><i class="fas fa-paper-plane"></i> Voltar</a>
		<img class="float" src="../imagens/vhmo.png" width="20" height="20"/> 
	</div>
	<div class="col-1 text-center" align="center"> 
		<?php 
		$imgpartido = "../imagens/".$_SESSION['partido'].".png";	
		?>
		<img src="<?php echo $imgpartido; ?>" height="20">
	</div>

	<div class='col-4 text-center'>
		<span class="sigla_sistema"><?php echo $_SESSION['sistemaabrev']?> - </span> <span class="politico"><?php echo $_SESSION['politico'] ?>
		</span>
	</div>
	<div class='col-4 text-center'>
		<span class="text-danger"><strong><?php echo $_SESSION['funcao']?></strong></span>
	</div>
	<div class='col-1 text-right'>
		<span class="badge badge-info"><?php echo $_SESSION['nometela']?></span>
	</div>
</div>

</div>
<div id="_VReportContent" style="margin-top: 35px">
  <?php
	echo $displayEnc ;
		?>
</div>
<div id="_VReportFooter" align="center">
<?php echo $_SESSION['sistemaabrev']." - ".$_SESSION['politico'] ?>	
</div>
<script src="../js/ie10-viewport-bug-workaround.js"></script>
<script src="../js/carrega_ajax.js" type="text/javascript"></script>
<script src="../js/ajax.js" type="text/javascript"></script>
<script src="../js/ie-emulation-modes-warning.js"></script>

<script>
function abrir_cadastro_pelo_apoio(cod_cadastro) {
	var param = '../eleitores/cadastro.php?codigo='+cod_cadastro;
	//alert(param);
	//ajax5('../eleitores/cadastro.php?codigo='+cod_cadastro, 'carregando');
	open(param,"_self");	
	
}
	  
</script>
<script src="../js/jquery-3.2.1.slim.min.js"></script>
      <script>window.jQuery || document.write('<script src="/../js/jquery-3.2.1.slim.min.js"><\/script>')</script>
      <script src="../js/bootstrap.bundle.min.js" ></script>
	<?php include_once("../utilitarios/rodape-fixo.php");?>
      </body>
</html>

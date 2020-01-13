<?php
include_once("../seguranca.php");
protegePagina();
include_once("../utilitarios/funcoes.php");
date_default_timezone_set('America/Sao_Paulo');

$comando_sql = "SELECT * FROM cadastro_enderecos_grupo 
WHERE NOME IN ( SELECT B.NOME FROM cadastro_enderecos_grupo B GROUP BY B.NOME HAVING COUNT(*) > 1 ) ";

$comando_sql.= " ORDER BY NOME";

//echo "<br><br>".$comando_sql;
$mysql_query = $_con->query($comando_sql);
if ($mysql_query->num_rows<1) {
	$_SESSION['msg'] = "<div class='alert alert-success' role='alert'><i class='fas fa-check' aria-hidden='true text-muted' aria-hidden='true'></i> Nenhum registro Duplicado<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";			
	exit('<script>location.href = "../eleitores/cadastro.php"</script>'); 
	
}
$_SESSION['funcao']="Cadastro com ".$mysql_query->num_rows." registros com nomes iguais.";

?>

<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Lista na tela o cadastroS DUPLOS por nome">
    <meta name="author" content="Vitor H M Oliveira">

    <title>SIGRE - Cadastros Duplos</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.3/examples/navbar-fixed/">
	<link rel="icon" href="../imagens/favicon.ico">
  <!--- Component CSS -->
	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
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
	<style>
	#_VReportHeader {
		font-family: Tahoma, Geneva, sans-serif;
		font-size: 12px;
		font-weight: bold;
		border-bottom: 0px;
		width: 100%;
		padding: 3px;
		text-align: center;
	}

	#_VReportFooter {
		font-family: Verdana, Geneva, sans-serif;
		font-size: 12px;
		border-top: 0px;
		width: 100%;
		text-align: center;
	}

	#_VReportContent{
		font-family:Tahoma, Geneva, sans-serif;
		font-size: 12px;
	}

	</style>

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
 <?php

if(isset($_SESSION['msg'])){
	echo "<br><br>".$_SESSION['msg'];
	unset($_SESSION['msg']);
}
?>
<div id="_VReportContent" style="margin-top: 35px">
  <?php
#echo $comando_sql."<br>";
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
					  <div class="col-auto" align="left"><i class="fas fa-phone"></i> Fone Cel
					  </div>		      
				  </th>
				  <th scope="col" >
					  <div class="col-auto" align="left"><i class="fas fa-phone"></i> Fone Com
					  </div>		      
				  </th>
				  <th scope="col" >
					  <div class="col-auto" align="left"><i class="fas fa-phone"></i> Fone Res
					  </div>		      
				  </th>
				  <th scope="col">
					  <div class="col-auto" align="left"><i class="fas fa-mail-bulk"></i> E-mail
					  </div>		      
				  </th>
				</tr>
				<tr>
				  <th scope="col">
					  <div class="col-auto" align="center"></div>
				  </th>
				  <th scope="col" colspan="3">
					  <div class="col-auto" align="left"><i class="fas fa-user"></i> Endereço
					  </div>
				  </th>
				  <th scope="col" colspan="3">
					  <div class="col-auto" align="left"><i class="fas fa-users"></i> Grupo
					  </div>
				  </th>
				  <th scope="col">
					  <div class="col-auto" align="left"><i class="fas fa-cut"></i> Opção
					  </div>
				  </th>
				</tr>
			</thead><tbody>';
while ($dados_s = $mysql_query->fetch_assoc()) {
	$displayEnc .=  '<tr>
				<td><div align="center">';
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
		$displayEnc .=  '<td><div align="center">';
			$displayEnc .= $dados_s["FONE_CEL"];
		$displayEnc .=  '</div></td>';
		$displayEnc .=  '<td><div align="center">';
			$displayEnc .= $dados_s["FONE_RES"];
		$displayEnc .=  '</div></td>';
		$displayEnc .=  '<td><div align="center">';
			$displayEnc .= $dados_s["FONE_COM"];
		$displayEnc .=  '</div></td>';
		$displayEnc .=  '<td><div align="left">';
			$displayEnc .= $dados_s["EMAIL"];
		$displayEnc .=  '</div></td>';
	$displayEnc .=  "</tr><tr>";
	$displayEnc .= '<td></td><td colspan="4"><div align="left">';
	$displayEnc .= $dados_s["tipolog"]." ".$dados_s["rua"]." ".$dados_s["numero"]." ".$dados_s["complemento"]." ".$dados_s["bairro"]." ".$dados_s["cidade"]." ".$dados_s["uf"]." ".$dados_s["cep"];
	$displayEnc .=  '</div></td><td colspan="2"><div align="left">';
	$displayEnc .= $dados_s["NOMEGRP"];
	$displayEnc .=  '</div></td>
	<td>
		<button type="button" class="btn btn-sm btn-excluir" onClick="javascript:excluir_cad_duplo('.$dados_s["CODIGO"].')"><i class="fas fa-trash" aria-hidden="true"></i>Excluir cód. '.$dados_s["CODIGO"].' de '.$dados_s["NOME"].'</button>
	</td></tr>';
}
$displayEnc .= '</tbody></table>';
echo $displayEnc;
?>
</div>
<div id="_VReportFooter">
<?php echo $_SESSION['sistemaabrev']." - ".$_SESSION['politico'] ?>	
</div>
<script src="../js/ie10-viewport-bug-workaround.js"></script>
<script src="../js/carrega_ajax.js" type="text/javascript"></script>
<script src="../js/ajax.js" type="text/javascript"></script>
<script src="../js/ie-emulation-modes-warning.js"></script>
<script>
function excluir_cad_duplo(cod_cadastro) {
	if (confirm("Confirma a Exclusão do registro duplo")){
		ajax('../eleitores/exclui_eleitor.php?P0='+cod_cadastro,'carregando');
	}
}
</script>
<script>
function abrir_cadastro_pelo_apoio(cod_cadastro) {
	ajax2("../cad_apoio/inicializa_global.php?cod_cadastro="+cod_cadastro,"carregando");
	var param = '../eleitores/cadastro.php';
	//alert(param);
	open(param,"_self");		
	
}
	  
</script>
<script src="../js/jquery-3.2.1.slim.min.js"></script>
      <script>window.jQuery || document.write('<script src="/../js/jquery-3.2.1.slim.min.js"><\/script>')</script>
      <script src="../js/bootstrap.bundle.min.js" ></script>
	<?php include_once("../utilitarios/rodape-fixo.php");?>
      </body>
</html>

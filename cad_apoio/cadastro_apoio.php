<?php
include_once("../seguranca.php");
protegePagina();
include_once("../utilitarios/funcoes.php");
date_default_timezone_set('America/Sao_Paulo');

if (liberado(5500)==0){
	expulsaVisitante2();
	return;
}
$arquivo_leitura = $_GET['par1'];
$descreve_arquivo = $_GET['par3'];
$chave = $_GET['par2'];

$_SESSION['funcao']="Cadastro ".$arquivo_leitura." = ".$descreve_arquivo;

/* vai ler arquivo de menu para inicializar variaveis globais de controle do menu com FALSE */
$comando_sql = "SELECT 
  c.CODIGO,
  c.NOME,
  c.SEXO,
  c.DTNASC,
  c.FONE_RES,
  c.FONE_CEL,
  c.FONE_COM,
  c.EMAIL,
  c.GRUPO,
  c.ORIGEM,
  c.PROFISSAO,
  c.ZONAL,
  c.PAI_MAE,
  c.FILIADO,
  c.RECEBEMAT,
  c.VOTOU,
  c.RAMO,
  c.RECEBEMAIL,
  e.cep,
  e.tipolog,
  e.rua,
  e.bairro,
  e.cidade,
  e.uf,
  e.numero,
  e.complemento,
  e.tipo,
  e.padrao,
  e.reg,
  g.NOMEGRP,
  origem.Descricao
FROM
  cadastro c
  LEFT OUTER JOIN grupos g ON (c.GRUPO = g.GRUPO)
  LEFT OUTER JOIN enderecos e ON (c.CODIGO = e.codigo)
  LEFT OUTER JOIN origem ON (c.ORIGEM = origem.Origem)";

$comando_sql .= " WHERE c.".$arquivo_leitura." = ".$chave." order by c.NOME";

$mysql_query = $_con->query($comando_sql);

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Lista na tela o cadastro dependendo do arquivo escolhido (ex.: grupos, origens, etc...)">
    <meta name="author" content="Vitor H M Oliveira">

    <title>SIGRE - Cadastro <?php echo $arquivo_leitura ?></title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.3/examples/navbar-fixed/">
	<link rel="icon" href="../imagens/favicon.ico">
  <!--- Component CSS -->
	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	<link href="../css/formata_textos.css" rel="stylesheet">
	<link href="../css/all.css" rel="stylesheet">
	<link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">
	<link href="../css/sticky-footer-navbar.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../css/ajax.css"/>
	<script src="../js/carrega_ajax.js" type="text/javascript"></script>
    <!-- Bootstrap core CSS -->
	<link href="../css/bootstrap.min.css" rel="stylesheet">
<!--	<style>
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
-->
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

<nav class="navbar fixed-top navbar-expand-sm navbar-transparent">
	<div class="container-fluid" style="align-items: center">
		<span class="navbar-brand"></span>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="true" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<button type="button" class="btn btn-sm btn-dark" onclick="javascript:window.history.back();">
                        <i class="fas fa-backward" aria-hidden="true text-muted" aria-hidden="true"></i> Voltar
                    </button>		</div>
	</div>
</nav>
</div>

<div id="_VReportContent" style="margin-top: 35px">
  <?php
	#echo $comando_sql."<br>";
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
						  <th scope="col"2>
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
						  <th scope="col" colspan="9">
							  <div class="col-auto" align="left"><i class="fas fa-user"></i> Endereço
							  </div>
						  </th>
						</tr>
					</thead><tbody>';
		while ($dados_s = $mysql_query->fetch_assoc()) {
			$displayEnc .=  '<tr>
						<td><div align="center">';
					
				$displayEnc .= '<a href="../eleitores/cadastro.php?
				codigo='.$dados_s["CODIGO"].'" class="btn btn-imprimir btn-sm" role="button">
						<i class="fas fa-search" aria-hidden="true text-muted" aria-hidden="true"></i> '.$dados_s["CODIGO"].'
						</a>';
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
			$displayEnc .= '<td></td><td colspan="7"><div align="left">';
			$displayEnc .= $dados_s["tipolog"]." ".$dados_s["rua"]." ".$dados_s["numero"]." ".$dados_s["complemento"]." ".$dados_s["bairro"]." ".$dados_s["cidade"]." ".$dados_s["uf"]." ".$dados_s["cep"];
			$displayEnc .=  '</div></td>';
		}
		$displayEnc .= '</tbody></table>';
		echo $displayEnc;
	}
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
function abrir_cadastro_pelo_apoio(cod_cadastro) {
	AjaxRequest();
	if(!Ajax) {
		alert('não foi  possível iniciar o AJAX');
		return;
	}
    //alert(cod_cadastro);
	var param = '../eleitores/cadastro.php';
	<a href="../eleitores/cadastro.php?codigo="
	ajax2("inicializa_global.php?cod_cadastro="+cod_cadastro,"carregando");
	open(param,"_self");		
	
}
	  
</script>
<script src="../js/jquery-3.2.1.slim.min.js"></script>
      <script>window.jQuery || document.write('<script src="/../js/jquery-3.2.1.slim.min.js"><\/script>')</script>
      <script src="../js/bootstrap.bundle.min.js" ></script>
	<?php include_once("../utilitarios/rodape-fixo.php");?>
      </body>
</html>

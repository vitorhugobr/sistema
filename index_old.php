<?php
require_once("seguranca.php"); // Inclui o arquivo com o sistema de segurança
require_once("utilitarios/funcoes.php");
protegePagina(); // Chama a função que protege a p&Aacute;gina
$primMenu = 0;
$_SESSION['recarrega'] = false;
$_SESSION['mudoutarefa'] = false;
$_SESSION['id_exame'] = 0;
$_SESSION['tab'] = 0;
$_SESSION['mensagem'] = "";
$_SESSION['set_alterou'] = false;
$quadroavisos= "";
// buscar compromissos da agenda e formatar rela
date_default_timezone_set('America/Sao_Paulo');
$datahoje = date('d/m/Y');
$datatoday = ConvertDateToMysqlFormat($datahoje);
$ex = explode("/", $datahoje);
$anohj = $ex[2];
$meshj = $ex[1];
$diahj = $ex[0];


unset($_SESSION['status']);
/* vai ler arquivo de menu para inicializar variaveis globais de controle do menu com FALSE */
$statement = $pdo->prepare('select cod_item_menu from menu');
$statement->execute();

$total = $statement->rowCount();

if($total==0){
  echo '<script>alert("ERRO NA LEITURA do menu");</script>'; 
}else{
  // Definimos a mensagem de erro
  while($row = $statement->fetch()) {	
	  foreach ($row as $campo => $valor) {
		  $nomecampo = $row["cod_item_menu"];
		  //$valor = ($_GET[$nomecampo]);
		  $sessao = "V_" . $nomecampo;
		  $_SESSION[$sessao] = FALSE;
	  }
  }
}

/* Vai ler Liberações para setar variáveis do menu com TRUE para aquelas que estão liberadas */	
$consulta = $pdo->prepare("SELECT cod_item_menu FROM liberado where liberada_sistema=1 and username = :usuario;");
$consulta->bindParam(':usuario', $_SESSION['usuarioUser'], PDO::PARAM_STR);
$consulta->execute();
while($row = $consulta->fetch()) {	
  foreach ($row as $campo => $valor) {
	  $nomecampo = $row["cod_item_menu"];
	  //$valor = ($_GET[$nomecampo]);
	  $sessao = "V_" . $nomecampo;
	  //echo 'variavel '.$sessao.'<br>';
	  $_SESSION[$sessao] = TRUE;
  }
}


// Vê o que a data de hj significa, buscando no banco
$query = "SELECT * FROM datas WHERE mes = $meshj AND dia = $diahj";

$mysql_query = $_concomum->query($query);
if ($mysql_query->num_rows<1) {
  $datas_hoje = "";
}else {
  $datas_hoje = '<strong>'.$diahj.'/'.$meshj.'</strong>';					
  while ($dados_hoje = $mysql_query->fetch_assoc()) {
	  $datas_hoje .= '<br><i class="fas fa-asterisk"></i> '.$dados_hoje['comemoracao'];	
  }
}


$imagem=false;

if ($_SESSION['usuarioSenha']=="e10adc3949ba59abbe56e057f20f883e"){
	$imagem=true;	
}

// as linhas abaico provocam a exibição da mensagem de alterar senha
//if ($_SESSION['usuarioNivel']=="1"){
//		$imagem=true;	
//}

if ($imagem)
	$_SESSION['mensagem'] = '<strong><span class="badge badge-danger">'.strtoupper($_SESSION['primnome']).'!</span></strong> <i class="fas fa-lock"></i> Você deve alterar sua senha. Acesse o menu <a href="senhas/index.php">Segurança</a><br>';

//verifica se existem tarefas em aberto
$tarefas_aberto=0;
if ($_SESSION['usuarioNivel']<9){
	$sqlt = "select * from tarefas_qtde where usuario = '".$_SESSION['usuarioUser']."' and status = 0";
	if ($rest = $_con->query($sqlt)) {
		$tarefas_aberto = $rest->num_rows;
	}else{
		$tarefas_aberto = 0;
	}
}

//verifica se existe encaminhamentos em aberto
if ($_SESSION['usuarioNivel']<9){
	$sql4 = "select * from encaminhamentos where situacao = 0";
	$res5 = $_con->query($sql4);
	$encaminha = $res5->num_rows;
}

$_SESSION['cod_de_busca']= "";
$_SESSION['pagina'] = 0;
$_SESSION['aba_atual'] = 0;
$_SESSION['CodRetorno'] = '';
$_SESSION['opcaoabrirpagina'] = "";

$diasemana = array('Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado');

if ((($diahj>15) and ($diahj<31)) AND ($meshj==12))
	$_SESSION['mensagem'] .= '<strong><img src="imagens/natal_webix-com-br23.gif" height="40"><span class="text text-alert"> Boas Festas '.$_SESSION['primnome'].'! </span></strong>';

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!--<![endif]-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Cadastro de árbitros">
<meta name="author" content="Vitor H M Oliveira">
<meta http-equiv="refresh" content="180">
<title><?php echo $_SESSION['sistemaabrev']?>-<?php echo $_SESSION['politico']?></title>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet">
<link href="css/formata_textos.css" rel="stylesheet">
<link href="css/botoes.css" rel="stylesheet">
<link href="css/sticky-footer-navbar.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/font-awesome.css"/>
<link rel="icon" href="imagens/favicon.ico" />
<link rel="stylesheet" type="text/css" href="css/ajax.css"/>
<link href="css/simple-sidebar.css" rel="stylesheet">
<link rel="stylesheet" href="css/all.css">
<link rel="stylesheet" href="css/sb-admin-2.css">
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script src="js/ie-emulation-modes-warning.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/sb-admin-2.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
<script type="text/javascript" src="js/TimeCircles.js"></script>
<link rel="stylesheet" href="css/TimeCircles.css" />
<!-- Menu Toggle Script --> 
<script>
	$("#menu-toggle").click(function(e) {
			e.preventDefault();
			$("#wrapper").toggleClass("toggled");
	});
	
	$(function () {
  		$('[data-toggle="tooltip"]').tooltip()
})
</script>
</head>
<body">
  <div class="container-fluid">
	<div class="row">
		<div class='col-1 text-center'>
			<img class="float" src="imagens/vhmo.png" width="22" height="22"/>
			<span class="mr-1 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION['sistemaabrev']?></span> 
			<span class="rodape"><?php echo $_SESSION['versao'].'-'.$_SESSION['id'];?></span> 
		</div>
		<div class="col-2 text-center" align="center"> 
			<?php 
			$imgpartido = "imagens/".$_SESSION['partido'].".png";	
			?>
			<img src="<?php echo $imgpartido; ?>" height="30">
		</div>
		<div class='col-2' align="center" style="align-items: baseline">
			<span class="politico">
			<?php 
			$_SESSION['imagem_camp'] = '';	
			if ($meshj==9){	
				$_SESSION['imagem_camp'] = 'imagens/set_amarelo.png';			
			} 
			if ($meshj==10){
			$_SESSION['imagem_camp'] = 'imagens/out_rosa.png';			
			} 
			if ($meshj==11){
				$_SESSION['imagem_camp'] = 'imagens/nov_azul.png';			 
			} 
			if ($meshj==12){
			$_SESSION['imagem_camp'] = 'imagens/dezembro_laranja.jpg';			 
			} 
			if ($_SESSION['imagem_camp'] <> "") {
			echo '<img src="'.$_SESSION['imagem_camp'].'" height="30">'; 
			}
				?>
			<?php echo $_SESSION['politico'] ?>
			</span>
		</div>
		<div class='col-4 text-center'>  
			<div id="mensagem" class="text text-danger"><?php echo $_SESSION['mensagem']?>
			</div>  
		</div>
		<div class='col-2 text-justify'>    
			<i class="fas fa-list fa-fw" title="Tarefas em Aberto"></i>
			<i class="badge badge-danger badge-counter" title="Tarefas em Aberto"><?php echo $tarefas_aberto; ?></i>&nbsp;
			<i class="fas fa-bullhorn  fa-fw" title="Encaminhamentos"></i>
			<i class="badge badge-danger badge-counter" title="Demandas sem Resposta"><?php echo $encaminha; ?></i>
		</div>
		<div class='col-1 text-right'>
			<i class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION['primnome']?></i>
			<?php
				$arquivo = "imagens/fotos/users/".$_SESSION['foto']; ?>
				<img class="img-profile rounded-circle" src="<?php echo $arquivo ?>" height="40px" width="40px" title="<?php echo $_SESSION['usuarioNome']?>">
		</div>
		<div id="wrapper" class="toggled" > 
			<!-- Sidebar -->
			<!-- ALTERAR CONFORME MÊS   -->
			<div id="sidebar-wrapper">
			<ul class="sidebar-nav">
			<li>
				<div align="center" class="text-white-50">MENU PRINCIPAL
				</div>
			</li>
			<?php 
			//if ($_SESSION['id']<2){
				$sqlLib = "SELECT * FROM liberado where username = '" . $_SESSION['usuarioUser'] . "' and nivel = 1 and liberada_sistema= 1 order by descricao_menu";
			//}else {
			//	$sqlLib = "SELECT * FROM liberado where username = '" . $_SESSION['usuarioUser'] . "' and nivel = 1 and liberada_sistema= 1 and exclusivo = 0 order by descricao_menu";			
			//}	
			$res30 = $_con->query($sqlLib);
			if ($res30->num_rows ==0){
				echo '<li>
					<a href="#"><i class="fas fa-skull"> </i> ERRO </a>
					</li>';
			}else{
				if ((liberado(6800)>0) AND ($_SESSION['id'] == 1)){
					echo '<li><a href="https://calendar.google.com/calendar/embed?src=duartethiago025%40gmail.com&ctz=America%2FSao_Paulo" target="new"><i class="fas fa-calendar"> </i> Agenda</a></li>';
				}
				if ((liberado(6800)>0) AND ($_SESSION['id'] == 2)){
					echo '<li><a href="https://calendar.google.com/calendar/embed?src=pujol.sigre%40gmail.com&ctz=America%2FSao_Paulo" target="new"><i class="fas fa-calendar"> </i> Agenda</a></li>';
				}
				if ((liberado(6800)>0) AND ($_SESSION['id'] == 3)){
					echo '<li><a href="https://calendar.google.com/calendar/embed?src=maurop.sigre%40gmail.com&ctz=America%2FSao_Paulo" target="new"><i class="fas fa-calendar"> </i> Agenda</a></li>';
				}
				if ((liberado(6800)>0) AND ($_SESSION['id'] == 4)){
					echo '<li><a href="https://calendar.google.com/calendar/embed?src=domingos.sigre%40gmail.com&ctz=America%2FSao_Paulo" target="new"><i class="fas fa-calendar"> </i> Agenda</a></li>';
				}
				if ((liberado(6800)>0) AND ($_SESSION['id'] == 5)){
					echo '<li><a href="https://calendar.google.com/calendar/embed?src=tessaro.sigre%40gmail.com&ctz=America%2FSao_Paulo" target="new"><i class="fas fa-calendar"> </i> Agenda</a></li>';
				}
				if ((liberado(6800)>0) AND ($_SESSION['id'] == 6)){
					echo '<li><a href="https://calendar.google.com/calendar/embed?src=democrataspoa%40gmail.com&ctz=America%2FSao_Paulo" target="new"><i class="fas fa-calendar"> </i> Agenda</a></li>';
				}
				if ((liberado(6800)>0) AND ($_SESSION['id'] == 7)){
					echo '<li><a href="https://calendar.google.com/calendar/embed?src=melo.sigre%40gmail.com&ctz=America%2FSao_Paulo" target="new"><i class="fas fa-calendar"> </i> Agenda</a></li>';
				}
				if ((liberado(6800)>0) AND ($_SESSION['id'] == 9)){
					echo '<li><a href="https://calendar.google.com/calendar/embed?src=vhmoliveira%40gmail.com&ctz=America%2FSao_Paulo" target="new"><i class="fas fa-calendar"> </i> Agenda</a></li>';
				}
				while($_row =  $res30->fetch_assoc()) {
					$funcao = $_row["funcao"];
					$nome = $_row["label"];
					$pagina = $_row["destino"];
					$descr = $_row["descricao_menu"];	
					$icone = $_row["icone"];
					$theValue = (!get_magic_quotes_gpc()) ? addslashes($icone) : $icone;
					$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
					$icone = $theValue;
					if ($funcao==6800) {
						if ($_SESSION['id'] > 3) {
							#echo '<li><a href='.$pagina.'><i class='.$icone.'></i> '.$nome.'</a></li>';
						}		
					}else {
						if ($funcao==9900) {
							if ($_SESSION['usuarioNivel']==0)
									echo '<li><a href='.$pagina.'><i class='.$icone.'></i> '.$nome.'</a></li>';
							}else{
								echo '<li><a href='.$pagina.'><i class='.$icone.'></i> '.$nome.'</a></li>';
							}
					}
			  } 
			}
			?>
			<li> <a href="logout.php"><i class="fas fa-share-square"></i> Sair Sistema</a> </li>
			
			<?php 
				$_SESSION['imagem_camp']= "../imagens/fundobranco.jpg";
				if ($meshj==9){
					$_SESSION['imagem_camp'] = '../imagens/set_amarelo.png';			
				} 
				if ($meshj==10){
					$_SESSION['imagem_camp'] = '../imagens/out_rosa.png';			
				} 
				if ($meshj==11){
					$_SESSION['imagem_camp'] = '../imagens/nov_azul.png';			 
				} 
			?>
				<p></p>
			<div style="text-align: center; color: yellow; font-size: 11px "><?php echo $datas_hoje;?>
			</div>
			<div align="center"><img src="imagens/alcool_gel2.png" height="40">
			</div>
			</ul>
		</div>
		</div>
	<div>
	  <!-- /#sidebar-wrapper --> 
	  <!-- Page Content -->
	  <!-- AQUI COLOCAR OCULTAR MENU IGUAL AO REDCARD -->
  <div align="center">      
		<?php echo $_SESSION['host_pol']; ?>

		<div id="DateCountdown" data-date="2022-10-03 17:00:00" style="width: 450px; height: 100px; padding: 0px; box-sizing: border-box></div>
		<h5  align="center"><b>Eleições 2022. Para encerramento das urnas!</b></h5>	 
		<script>
		$("#DateCountdown").TimeCircles();
		$("#CountDownTimer").TimeCircles({ time: { Days: { show: false }, Hours: { show: false } }});
		$("#PageOpenTimer").TimeCircles();
							
		var updateTime = function(){
		var date = $("#date").val();
		var time = $("#time").val();
		var datetime = date + " " + time + ":00";
		$("#DateCountdown").data("date", datetime).TimeCircles().start();
		}
			$("#date").change(updateTime).keyup(updateTime);
			$("#time").change(updateTime).keyup(updateTime);
							
			// Start and stop are methods applied on the public TimeCircles instance
			$(".startTimer").click(function() {
			$("#CountDownTimer").TimeCircles().start();
			});
			$(".stopTimer").click(function() {
			$("#CountDownTimer").TimeCircles().stop();
			});

			// Fade in and fade out are examples of how chaining can be done with TimeCircles
			$(".fadeIn").click(function() {
			$("#PageOpenTimer").fadeIn();
			});
			$(".fadeOut").click(function() {
			$("#PageOpenTimer").fadeOut();
			});
			</script> 
	    <!-- /#page-content-wrapper --> 
	   </div>
	</div>    

  </div>

		</div>

  <!-- /#wrapper -->
</div>

  <?php 
  include_once("utilitarios/rodape-fixo.php");?>
  </body>
  </html>

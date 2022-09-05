<?php
require_once ("seguranca.php"); // Inclui o arquivo com o sistema de segurança
require_once ("utilitarios/funcoes.php");


protegePagina(); // Chama a função que protege a p&Aacute;gina
$primMenu = 0;

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
		  $sessao = "V_" . strtoupper($valor);
		  $_SESSION[$sessao] = FALSE;
	  }
  }
}

/* Vai ler Liberações para setar variáveis do menu com TRUE para aquelas que estão liberadas */	
$consulta = $pdo->prepare("SELECT cod_item_menu FROM liberado_view where username = :usuario;");
$consulta->bindParam(':usuario', $_SESSION['usuarioUser'], PDO::PARAM_STR);
$consulta->execute();
while($row = $consulta->fetch()) {	
  foreach ($row as $campo => $valor) {
	  $nomecampo = $row["cod_item_menu"];
	  //$valor = ($_GET[$nomecampo]);
	  $sessao = "V_" . strtoupper($valor);
	  //echo 'variavel '.$sessao.'<br>';
	  $_SESSION[$sessao] = TRUE;
  }
}

$_SESSION['cod_de_busca']= "";
$_SESSION['pagina'] = 0;
$_SESSION['CodRetorno'] = '';
$_SESSION['opcaoabrirpagina'] = "";

// buscar compromissos da agenda e formatar rela
date_default_timezone_set('America/Sao_Paulo');
$datatoday = date('d/m/Y');

$ex = explode("/", $datatoday);
$anohj = $ex[2];
$meshj = $ex[1];
$diahj = $ex[0];

$datamaissete = somadata($datatoday,7);
$ex = explode("/", $datamaissete);	
$anoft = $ex[2];
$mesft = $ex[1];
$diaft = $ex[0];

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

$datatoday = getdate();

$dia = $datatoday["mday"];

$mes = $datatoday["mon"];

$imagem=false;

if ($_SESSION['usuarioSenha']=="e10adc3949ba59abbe56e057f20f883e"){
	$imagem=true;	
}

if ($imagem)
	$_SESSION['mensagem'] = '<strong><span class="badge badge-danger">'.strtoupper($_SESSION['primnome']).'!</span></strong> <i class="fas fa-lock"></i> Você deve alterar sua senha. Acesse o menu <a href="senhas/index.php">Segurança</a><br>';

$hoje = date("Y-m-d"); // data atual formato mysql

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

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="Sistema SIGRE">
<meta name="author" content="Vitor H M Oliveira">
<title><?php echo $_SESSION['sistemaabrev']?>-<?php echo $_SESSION['politico']?></title>

<!-- Bootstrap core CSS -->
<link href="css/bootstrap.min.css" rel="stylesheet">

<!-- Custom styles for this template -->
<link href="css/simple-sidebar.css" rel="stylesheet">
<link rel="SHORTCUT ICON" href="imagens/favicon.ico" />
<link rel="stylesheet" type="text/css" href="css/sticky-footer-navbar.css">
<link rel="stylesheet" type="text/css" href="css/formata_textos.css">
<link href="https://use.fontawesome.com/releases/v5.0.4/css/all.css" rel="stylesheet">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">

<script type="text/javascript" src="js/TimeCircles.js"></script>
<link rel="stylesheet" href="css/TimeCircles.css" />
</head>

<body>
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

	<div id="wrapper" class="toggled"> 
  <!-- Sidebar -->
  	<div id="sidebar-wrapper">
    	<ul class="sidebar-nav">
      	<li class="sidebar-brand text-warning"><strong>Opções Disponíveis</strong></li>
      	<?php 
        $sqlLib = "SELECT * FROM liberado where username = '" . $_SESSION['usuarioUser'] . "' and nivel = 1 and liberada_sistema= 1 order by descricao_menu";
        $res30 = $_con->query($sqlLib);
        if ($res30->num_rows ==0){
        	echo '<li>
                <a href="#">ERRO</a>
                </li>';
          }else{
          	while($_row =  $res30->fetch_assoc()) {
            	$funcao = $_row["funcao"];
              $nome = $_row["label"];
              $pagina = $_row["destino"];
              $descr = $_row["descricao_menu"];	
              $icone = $_row["icone"];
              $theValue = (!get_magic_quotes_gpc()) ? addslashes($icone) : $icone;
              $theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
              $icone = $theValue;
              echo '<li><a href='.$pagina.'><i class='.$icone.'></i> '.$nome.'</a></li>';
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
  <!-- /#sidebar-wrapper --> 
  <!-- Page Content -->
  	<div id="page-content-wrapper">
      <div class="container-fluid">
      <a href="#menu-toggle" class="btn btn-sm btn-secondary" id="menu-toggle">Exibir/Ocultar Menu</a> </div>
		<div>
		<?php echo $_SESSION['host_pol']; ?>
		</div>
		<div id="DateCountdown" data-date="2022-10-03 17:00:00" style="width: 450px; height: 100px; padding: 0px; box-sizing: border-box>
		</div>
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
	</div></div>
<!-- /#wrapper -->
<?php 
echo '<br><br>';
include_once("utilitarios/rodape-fixo.php");?>

<!-- Bootstrap core JavaScript --> 
<script src="js/jquery.min.js"></script> 
<script src="js/bootstrap.bundle.min.js"></script> 
<script src="js/popper.min.js"></script> 
<!-- Menu Toggle Script --> 
<script>
  $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
  });
  </script>
</body>
</html>

<?php
include_once("../seguranca.php");
protegePagina();
include_once("../utilitarios/funcoes.php");
date_default_timezone_set('America/Sao_Paulo');

if (liberado(1000)==0){
	expulsaVisitante2();
	return;
}
$_SESSION['funcao']="Cadastro";
if (isset($_SESSION['tab'])){
	$tab = $_SESSION['tab'];
}else{
	$tab = 0;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Cadastro de Eleitores">
	<meta name="author" content="Vitor H M Oliveira">
	<title>Cadastro</title>
	<link rel="icon" href="../imagens/favicon.ico">
  <!--- Component CSS -->
	<link href="../css/formata_textos.css" rel="stylesheet">
	<link href="../css/all.css" rel="stylesheet">
	<link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">
	<link href="../css/sticky-footer-navbar.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../css/ajax.css"/>
	<link rel="stylesheet" type="text/css" href="../css/autocomplete.css"/>
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="../css/mdb.min.css">
	
	<script type="text/javascript" src="../js/eleitor.js"></script>
	<script type="text/javascript" src="../js/exames.js"></script>
	<script src="../js/jquery.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<script src="../js/ie10-viewport-bug-workaround.js"></script>
	<script src="../js/carrega_ajax.js" type="text/javascript"></script>
	<script src="../js/ajax.js" type="text/javascript"></script>
	<script src="../js/ie-emulation-modes-warning.js"></script>
	<script type="text/javascript" src="../js/autocomplete.js"></script>
	<script type="text/javascript">
    $(document).ready(function(){
        $("button").click(function(){
            location.reload(true);
        });
	});
	</script>	
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" role="document" 
onLoad="PesquisaEleitor(<?php echo $_SESSION["ult_eleitor_pesquisado"]; ?>);">


<?php include("../utilitarios/cabecalho.php"); ?>	  
 <?php

if(isset($_SESSION['msg'])){
	echo $_SESSION['msg'];
	unset($_SESSION['msg']);
}
?>

	<nav class="navbar navbar-expand-sm navbar-light shadow-sm">
    	<div class="container-fluid" style="align-items: center">
            <span class="navbar-brand"></span>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="true" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
					<?php
					if (liberado(1001)>0){ 
							echo '<li class="nav-item active">
							<button type="button" class="btn btn-sm btn-primary" onclick="javascript:validaI();">
							<i class="fas fa-user-plus" aria-hidden="true"></i> Incluir
							</button>
						</li>';
					}
					if (liberado(1002)>0){  
							echo '<li class="nav-item">
							<button type="button" class="btn btn-sm btn-warning" onclick="javascript:validaA();">
							<i class="fas fa-save" aria-hidden="true"></i> Alterar
							</button>
						</li>';
					}
					if (liberado(1003)>0){  
							echo '<li class="nav-item">
							<button type="button" class="btn btn-sm btn-danger" onclick="javascript:validaE();">
							<i class="fas fa-user-times" aria-hidden="true"></i> Excluir
							</button>
						</li>';
					}
					if (liberado(1004)>0){
							echo '<li class="nav-item">
							<button type="button" class="btn btn-sm btn-info">
							<i class="fas fa-print" aria-hidden="true"></i> Imprimir
							</button>
						</li>';
					}
					if (liberado(7500)>0){
							echo '<li class="nav-item">
								  <a href="../clinica/consultas.php" class="btn btn-secondary btn-sm" role="button">
								  <i class="fas fa-calendar-check" aria-hidden="true"></i>  Agendar Consultas
								  </a>
							</li>';
					}
					?>
                    <li class="nav-item">
                         <button type="button" class="btn btn-sm btn-success" onclick="javascript:reload_cadastro();">
                        <i class="fas fa-eraser" aria-hidden="true"></i> Limpar Tela
                    	</button>
                    </li> 
                    <li class="nav-item">
                         <button type="button" class="btn btn-sm btn-light" onclick="javascript:window.history.back();">
                        <i class="fas fa-window-restore" aria-hidden="true"></i> Voltar Tela Anterior
                    </button>
                    </li> 
                    <li class="nav-item">
                        <a href="../index2.php" class="btn btn-dark btn-sm" role="button">
                            <i class="fas fa-list-ul" aria-hidden="true"></i>  Menu
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Tabs na página do cadastro -->
	<ul class="nav nav-tabs" id="myTab" role="document">
		<?php 
		if ($tab==0){ ?>
		<li class="nav-item">
			<a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true"><i class="fas fa-address-card"></i> Dados Políticos</a>
		</li>
		<?php
		}else{ ?>
		<li class="nav-item">
			<a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="false"><i class="fas fa-address-card"></i> Dados Políticos</a>
		</li>
		<?php
		} ?>
		<li class="nav-item">
		  <a class="nav-link" id="menu0-tab" data-toggle="tab" href="#menu0" role="tab" aria-controls="menu0" aria-selected="false"><i class="fas fa-text-width"></i> Observações</a>
		</li>
		<?php 		
		if ($tab==2){ ?>
		<li class="nav-item">
		  <a class="nav-link active" id="menu1-tab" data-toggle="tab" href="#menu1" role="tab" aria-controls="menu1" aria-selected="false"><i class="fas fa-home"></i> Endereços</a>
		</li>
		<?php
			}else{ ?>
		<li class="nav-item">
		  <a class="nav-link" id="menu1-tab" data-toggle="tab" href="#menu1" role="tab" aria-controls="menu1" aria-selected="false"><i class="fas fa-home"></i> Endereços</a>
		</li>
		<?php
		 }		
		if ($tab==3){ ?>
		<li class="nav-item">
		  <a class="nav-link active" id="menu2-tab" data-toggle="tab" href="#menu2" role="tab" aria-controls="menu2" aria-selected="false"><i class="fas fa-phone-square"></i> Contatos</a>
		</li>
		<?php
			}else{ ?>
		<li class="nav-item">
		  <a class="nav-link" id="menu2-tab" data-toggle="tab" href="#menu2" role="tab" aria-controls="menu2" aria-selected="false"><i class="fas fa-phone-square"></i> Contatos</a>
		</li>
		<?php
		 }?>
		<li class="nav-item">
		  <a class="nav-link" id="menu3-tab" data-toggle="tab" href="#menu3" role="tab" aria-controls="menu3" aria-selected="false"><i class="fas fa-bullhorn"></i> Demandas</a>
		</li>
		<?php
		if (liberado(1010)>0){ 
			if ($tab==5){ ?>
			<li class="nav-item">
				<a class="nav-link active" id="menu4-tab" data-toggle="tab" href="#menu4" role="tab" aria-controls="menu4" aria-selected="false"><i class="fas fa-file-medical"></i> Prontuários</a>	
			</li>		
			<?php
			}else{ ?>
			<li class="nav-item">
				<a class="nav-link" id="menu4-tab" data-toggle="tab" href="#menu4" role="tab" aria-controls="menu4" aria-selected="false"><i class="fas fa-file-medical"></i> Prontuários</a>			
			</li>    
			<?php
			}
		}
		if (liberado(1011)>0){ 
			if ($tab==6){ ?>
			<li class="nav-item">
				<a class="nav-link active" id="menu5-tab" data-toggle="tab" href="#menu5" role="tab" aria-controls="menu5" aria-selected="false"><i class="fas fa-capsules"></i> Receituários</a>
			</li>	
			<?php
				}else{ ?>
				<li class="nav-item">
					<a class="nav-link" id="menu5-tab" data-toggle="tab" href="#menu5" role="tab" aria-controls="menu5" aria-selected="false"><i class="fas fa-capsules"></i> Receituários</a>		  	
				</li>	
			<?php } 
		}

		if (liberado(1009)>0){
			if ($tab==7){ ?>
			<li class="nav-item">
				<a class="nav-link active" id="menu6-tab" data-toggle="tab" href="#menu6" role="tab" aria-controls="menu6" aria-selected="false"><i class="fas fa-prescription"></i> Exames</a>
			</li>
			<?php
			}else{ ?>
			<li class="nav-item">
				<a class="nav-link" id="menu6-tab" data-toggle="tab" href="#menu6" role="tab" aria-controls="menu6" aria-selected="false"><i class="fas fa-prescription"></i> Exames</a>
			</li>
				<?php } 
		}?>
	</ul>
<form name="form1" method="post" action="">
	
<div class="tab-content">
	<!-- Dados Políticos -->
	<?php 
	if ($tab==0){ 
		echo '<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">';
	}else{ 
		echo '<div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">';
	} ?>
	<div class="container-fluid">
	  <!-- Grid row 1-->
	  <div class="row">
		<!-- Grid column -->
		<div class="col-12 col-sm-5 col-md-5 col-lg-5 col-xl-3">
		  <!-- Default input -->
			<div class="col-12">
				<label class="textoVermelhoBoldRight">Nome <i class="fas fa-arrow-circle-down"></i></label>
				<input type="text" name="txtNome" id="txtnome" class="form-control" autofocus maxlength="80" size="50" required>
			</div>
		</div>
		<!-- Grid column -->
		<div class="col-12 col-sm-5 col-md-5 col-lg-5 col-xl-3">
			<div class="col-6">
				<label class="textoAzulMar">Código <i class="fas fa-arrow-circle-down"></i></label>			
				<input type="text" class="form-control" id="txtCodigo" name="txtCodigo">
			</div>	
		</div>
		<!-- Grid column -->
		<div class="col-12 col-sm-5 col-md-5 col-lg-5 col-xl-3">
			<div class="col-8">
				<label class="textoAzulMar">Data de Nascimento <i class="fas fa-arrow-circle-down"></i></label>			
				<input type="date" class="form-control" name="txtDataNascimento" id="txtDataNascimento">
			</div>	
		</div>
	  </div>
	  <!-- Grid row 2-->
	  <div class="row">
		<!-- Grid column -->
		<div class="col-12 col-sm-5 col-md-5 col-lg-5 col-xl-3">
		  <!-- Default input -->
			<div class="col-6">
				<label class="textoVermelhoBoldRight">Sexo <i class="fas fa-arrow-circle-down"></i></label>
				<select class="form-control" name="txtSexo" id="txtSexo">
					<option value="F">Feminino</option>
					<option value="M">Masculino</option>
				</select>
			</div>
		</div>
		<!-- Grid column -->
		<div class="col-12 col-sm-5 col-md-5 col-lg-5 col-xl-3">
			<div class="col-12">
				<label class="textoVermelhoBoldRight">Grupo <i class="fas fa-arrow-circle-down"></i></label>
				<select class="form-control" name="txtGrupo">
					<option value="0">Selecione</option>
					<?php
					$sql = "select * from grupos order by NOMEGRP";
					$mysql_query = $_con->query($sql);
					if ($mysql_query->num_rows>0) {
						while ($_row = $mysql_query->fetch_assoc()) {?>
							<option value="<?php echo $_row['GRUPO']; ?>"><?php echo $_row['NOMEGRP']; ?></option>
					<?php
						}
					}?>
				</select>
			</div>	
		</div>
		<!-- Grid column -->
		<div class="col-12 col-sm-5 col-md-5 col-lg-5 col-xl-3">
			<div class="col-12">
				<label class="textoVermelhoBoldRight">Origem <i class="fas fa-arrow-circle-down"></i></label>
				<select class="form-control" name="txtOrigem">
					<option value="0">Selecione</option>
					<?php
					$sql = "select * from origem order by Descricao";
					$mysql_query = $_con->query($sql);
					if ($mysql_query->num_rows>0) {
						while ($_row = $mysql_query->fetch_assoc()) {?>
							<option value="<?php echo $_row['Origem']; ?>"><?php echo $_row['Descricao']; ?></option>
					<?php
						}
					}?>
				</select>
			</div>	
		</div>
	  </div>
	  <!-- Grid row 3-->
	  <div class="row">
		<!-- Grid column -->
		<div class="col-12 col-sm-5 col-md-5 col-lg-5 col-xl-3">
		  <!-- Default input -->
			<div class="col-12">
				<label class="textoAzulMar">E-mail <i class="fas fa-arrow-circle-down"></i></label>
				<input type="email" class="form-control-email"  name="txtEmail" id="txtemail" placeholder="E-mail válido." maxlength="70" size="60" required/>	
			</div>
		</div>
		<!-- Grid column -->
		<div class="col-12 col-sm-5 col-md-5 col-lg-5 col-xl-3">
			<div class="col-12">
				<label class="textoAzulMar">CPF <i class="fas fa-arrow-circle-down"></i></label>
				<input type="text" class="form-control" name="txtCPF" id="txtCPF" placeholder="Somente números" />
			</div>	
		</div>
		<!-- Grid column -->
		<div class="col-12 col-sm-5 col-md-5 col-lg-5 col-xl-3">
			<div class="col-12">
				<label class="textoAzulMar">Estado Civil <i class="fas fa-arrow-circle-down"></i></label>
				<select name="txtEstadoCivil" class="form-control" id="txtEstadoCivil">
					<option value="0">Solteiro(a)</option>
					<option value="1">Casado(a)</option>
					<option value="2">Viúvo(a)</option>
					<option value="3">Separado(a)</option>
					<option value="4">Divorciado(a)</option>
					<option value="5">Desquitado(a)</option>
					<option value="6">Companheiro(a)</option>
				</select>
			</div>	
		</div>
	  </div>
	  <!-- Grid row 4-->
	  <div class="row">
		<!-- Grid column -->
		<div class="col-12 col-sm-5 col-md-5 col-lg-5 col-xl-3">
		  <!-- Default input -->
			<div class="col-7">
				<label class="textoAzulMar">Telefone Celular <i class="fas fa-arrow-circle-down"></i></label>
						<input type="tel" class="form-control" id="txtCelular" placeholder="(99)99999-9999" maxlength="15"/>
			</div>
		</div>
		<!-- Grid column -->
		<div class="col-12 col-sm-5 col-md-5 col-lg-5 col-xl-3">
			<div class="col-7">
				<label class="textoAzulMar">Telefone Residencial <i class="fas fa-arrow-circle-down"></i></label>
				<input type="tel" class="form-control" name="txtResidencial" id="txtResidencial" placeholder="(99)9999-9999" maxlength="15"/>

			</div>	
		</div>
		<!-- Grid column -->
		<div class="col-12 col-sm-5 col-md-5 col-lg-5 col-xl-3">
			<div class="col-7">
				<label class="textoAzulMar">Telefone Comercial <i class="fas fa-arrow-circle-down"></i></label>
				<input type="tel" class="form-control" name="txtComercial" id="txtComercial" placeholder="(99)99999-9999" maxlength="15"/>
			</div>	
		</div>
	  </div>
	  <!-- Grid row 5-->
	  <div class="row">
		<!-- Grid column -->
		<div class="col-12 col-sm-5 col-md-5 col-lg-5 col-xl-3">
		  <!-- Default input -->
			<div class="col-12">
				<label class="textoAzulMar">Profissão <i class="fas fa-arrow-circle-down"></i></label>
				<select class="form-control" name="txtProfissao">
					<option value="0">Selecione</option>
					<?php
					$sql = "select * from profissao order by Descricao2";
					$mysql_query = $_con->query($sql);
					if ($mysql_query->num_rows>0) {
						while ($_row = $mysql_query->fetch_assoc()) {?>
							<option value="<?php echo $_row['Profissao']; ?>"><?php echo $_row['Descricao2']; ?></option>
					<?php
						}
					}?>
				</select>
			</div>
		</div>
		<!-- Grid column -->
		<div class="col-12 col-sm-5 col-md-5 col-lg-5 col-xl-3">
			<div class="col-12">
				<label class="textoAzulMar">Ramo Atividade <i class="fas fa-arrow-circle-down"></i></label>
				<select class="form-control" name="txtRamo">
					<option value="0">Selecione</option>
					<?php
					$sql = "select * from ramo order by DESCRICAO";
					$mysql_query = $_con->query($sql);
					if ($mysql_query->num_rows>0) {
						while ($_row = $mysql_query->fetch_assoc()) {?>
							<option value="<?php echo $_row['CODIGO']; ?>"><?php echo $_row['DESCRICAO']; ?></option>
					<?php
						}
					}?>
				</select>

			</div>	
		</div>
		<!-- Grid column -->
		<div class="col-12 col-sm-5 col-md-5 col-lg-5 col-xl-3">
			<div class="col-12">
				<label class="textoAzulMar">Empresa <i class="fas fa-arrow-circle-down"></i></label>
						<input type="text" id="txtEmpresa" name="txtEmpresa" class="form-control" placeholder="Nome da Empresa"/>
			</div>	
		</div>
	  </div>
	  <!-- Grid row 6-->
	  <div class="row">
		<!-- Grid column -->
		<div class="col-12 col-sm-5 col-md-5 col-lg-5 col-xl-3">
		  <!-- Default input -->
			<div class="col-12">
				<label class="textoAzulMar">Cargo <i class="fas fa-arrow-circle-down"></i></label>
				<input type="text" id="txtCargo" name="txtCargo" class="form-control" placeholder="Cargo na Empresa"/>
			</div>
		</div>
		<!-- Grid column -->
		<div class="col-12 col-sm-5 col-md-5 col-lg-5 col-xl-3">
			<div class="col-12">
				<label class="textoAzulMar">Classificação <i class="fas fa-arrow-circle-down"></i></label>
				<select name="txtClass" class="form-control" id="txtClass">
					<option value="0">Selecione</option>
					<option value="1">Alto</option>
					<option value="2">Médio</option>
					<option value="3">Baixo</option>
				</select>
			</div>	
		</div>
		<!-- Grid column -->
		<div class="col-12 col-sm-5 col-md-5 col-lg-5 col-xl-3">
			<div class="col-12">
				<label class="textoAzulMar">Campanha <i class="fas fa-arrow-circle-down"></i></label>
				<select class="form-control" name="txtCampanha">
					<option value="0">Selecione</option>
					<?php
					$sql = "select * from campanha order by descricao";
						$mysql_query = $_con->query($sql);
						if ($mysql_query->num_rows>0) {
							while ($_row = $mysql_query->fetch_assoc()) {?>
								<option value="<?php echo $_row['codigo']; ?>"><?php echo $_row['descricao']; ?></option>
						<?php
							}
						}?>
				</select>
			</div>	
		</div>
	  </div>
	  <!-- Grid row 7-->
	  <div class="row">
		<!-- Grid column -->
		<div class="col-12 col-sm-5 col-md-5 col-lg-5 col-xl-3">
		  <!-- Default input -->
			<div class="col-12">
				<label class="textoAzulMar">Facebook <i class="fas fa-arrow-circle-down"></i></label>
				<input type="text" id="txtFace" name="txtFace" class="form-control" placeholder="Facebook"/>		
			</div>
		</div>
		<!-- Grid column -->
		<div class="col-12 col-sm-5 col-md-5 col-lg-5 col-xl-3">
			<div class="col-12">
				<label class="textoAzulMar">Twitter <i class="fas fa-arrow-circle-down"></i></label>
				<input type="text" id="txtTwitter" name="txtTwitter" class="form-control" placeholder="Twitter"/>		
			</div>	
		</div>
		<!-- Grid column -->
		<div class="col-12 col-sm-5 col-md-5 col-lg-5 col-xl-3">
			<div class="col-12">
				<label class="textoAzulMar">Outra Rede Social <i class="fas fa-arrow-circle-down"></i></label>
				<input type="text" id="txtOutra" name="txtOutra" class="form-control" placeholder="Outra Rede Social"/>
			</div>	
		</div>
		</div>
	  <!-- Grid row 8 -->
	  <div class="row">
		<!-- Grid column -->
		<div class="col-12 col-sm-5 col-md-5 col-lg-5 col-xl-3">
		  <!-- Default input -->
			<div class="col-12">
				<label class="textoAzulMar">Apelido <i class="fas fa-arrow-circle-down"></i></label>
				<input type="text" id="txtApelido" name="txtApelido" class="form-control" placeholder="Apelido"/>
			</div>
		</div>
		<!-- Grid column -->
		<div class="col-12 col-sm-5 col-md-5 col-lg-5 col-xl-3">
			<div class="col-12">
				<label class="textoAzulMar">Zona Eleitoral <i class="fas fa-arrow-circle-down"></i></label>
				<input type="text" id="txtZona" name="txtZona" class="form-control" placeholder="Zonal"/>
			</div>	
		</div>
		<!-- Grid column -->
		<div class="col-12 col-sm-5 col-md-5 col-lg-5 col-xl-3">
			<div class="col-12">
				<label class="textoAzulMar">Seção Eleitoral <i class="fas fa-arrow-circle-down"></i>s</label>
						<input type="text" id="txtSecao" name="txtSecao" class="form-control" placeholder="Seção"/>
			</div>	
		</div>
	  </div>
	  <!-- Grid row 9 -->
	  <div class="row">
		<!-- Grid column -->
		<div class="col mt-3">
		  <!-- Default input -->
			<div class="col-12 col-sm-5 col-md-5 col-lg-5 col-xl-6">
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="checkbox" value="" id="chkFiliado" name="chkFiliado">
					<label class="textoAzulMar"><i class="fas fa-arrow-circle-left"></i> Filiado</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="checkbox" value="" id="chkEmail" name="chkEmail">
					<label class="textoAzulMar"><i class="fas fa-arrow-circle-left"></i> Recebe E-mail</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="checkbox" value="" id="chkImpresso" name="chkImpresso">
					<label class="textoAzulMar"><i class="fas fa-arrow-circle-left"></i> Recebe Impresso</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="checkbox" value="" id="chkVotou" name="chkVotou">
					<label class="textoAzulMar"><i class="fas fa-arrow-circle-left"></i> Votou</label>
				</div>
			</div>
		</div>       
		<div class="col">
			<div class="col-12 col-sm-5 col-md-5 col-lg-5 col-xl-6">
				<label class="textoAzulMar">Filhos <i class="fas fa-arrow-circle-down"></i></label>
					<select class="form-control" name="txtPaiMae" id="txtPaiMae">
						<option value="0">Não</option>
						<option value="1">Sim</option>
					</select>
			</div>

		</div>

		<!-- Grid column -->
	  </div>

	</div>
	<?php echo '</div>'; ?>

<!-- ---------------------------------------------------------------------------------------------------------------- -->	    
	<!-- observações  -->	
    
     <div class="tab-pane fade" id="menu0" role="tabpanel" aria-labelledby="profile-tab">
		 <div class="row">
			  <div class="col-12 col-sm-5 col-md-5 col-lg-5 col-xl-6" style="width:100%; height: 350; overflow: auto;">
		 	  <div id="lblnome0" class="textoAzul"></div>
				<textarea name="txtObs" cols="300" rows="25" class="form-control form-control-sm" id="txtObs" placeholder="Observações relevantes do Eleitor">
				</textarea>
			  </div>
			  <div class="col-12 col-sm-5 col-md-5 col-lg-5 col-xl-6">
				<div class="img-fluid text-center" style="width:190px"> 
        			<img src="../imagens/fotos/sem.jpg" class="rounded" alt="Foto" id="imgfoto" width="130" onclick="carga_foto();" title="clique sobre a foto para atualizá-la"/>
        		</div>
			  </div>
		</div>
   		<div class="row">
			<div class="col-12 col-sm-5 col-md-5 col-lg-5 col-xl-4">
  				<span class="textoAzulMar">Data Cadastro:</span>
   				<div id="lbldtcad" class="text text-danger"></div>
			</div>
			<div class="col-12 col-sm-5 col-md-5 col-lg-5 col-xl-4">
  				<span class="textoAzulMar">Última Alteração:</span>
          			<div id="lbldtultalt" class="text text-danger"></div>
			</div>
			<div class="col-12 col-sm-5 col-md-5 col-lg-5 col-xl-4">
  				<span class="textoAzulMar">Responsável Cadastro:</span>
       			<div id="lblrespcad" class="text text-danger"></div>
			</div>
   		</div>
    </div>
    
<!-- ---------------------------------------------------------------------------------------------------------------- -->	    
	<!-- Endereços  -->	
   	<?php
   	if ($tab==2){ 
   		echo '<div id="menu1" class="tab-pane fade show active" role="tabpanel" aria-labelledby="menu1-tab">';
	}else{ 
		echo '<div class="tab-pane fade" id="menu1" role="tabpanel" aria-labelledby="menu1-tab">';
	} ?>      
      <div id="lblnome1" class="textoAzul"></div>
      <div class="col-12">
      <?php
	  if ($_SESSION['ult_eleitor_pesquisado'] >0){ ?>
		  <button id="btnincrel" name="btnincrel" type="button" class="btn btn-sm btn-primary" onClick="javascript:NewEnd();"><i class="fas fa-address-book" aria-hidden="true"></i> Novo Endereço</button>
		  <input type="hidden" name="txtEnderecos" id="txtEnderecos">
		  <div id="dados"></div>
	<?php } ?>
	  </div>   	
	
	<?php    
	echo '</div>'; ?>

<!-- ---------------------------------------------------------------------------------------------------------------- -->	    
	<!-- Contatos  -->	
	<?php 
   	if ($tab==3){
   		echo '<div id="menu2" class="tab-pane fade show active" role="tabpanel" aria-labelledby="menu2-tab">';
	}else{
		echo '<div class="tab-pane fade" id="menu2" role="tabpanel" aria-labelledby="menu2-tab">';
	} ?>

    <div id="lblnome2" class="textoAzul"></div>
      <button id="btnincvis" name="btnincvis" type="button" class="btn btn-sm btn-primary" onClick="javascript:OpenVisita();" disabled="disabled"><i class="fas fa-plus" aria-hidden="true"></i> Novo Contato</button>
      <input type="hidden" name="txtVisitas" id ="txtVisitas">
      <div id="visit" style="width:100%; height: 527px; overflow: auto;"></div>
    <?php echo '</div>';?>
    
<!-- ---------------------------------------------------------------------------------------------------------------- -->	    
	<!-- Demandas  -->	
    <div id="menu3" class="tab-pane fade">
		<div id="lblnome3" class="textoAzul"></div>
	  	<input type="hidden" name="txtDemandas" id ="txtDemandas">
	  	<div id="solution" style="width:100%; height: 570px; overflow: auto;"></div>
    </div>
    
	<!-- Prontuários  -->	
	<?php 
	if ($tab==5){ 
		echo '<div class="tab-pane fade show active" id="menu4" role="tabpanel" aria-labelledby="menu4-tab">';
	}else{ 
		echo '<div class="tab-pane fade" id="menu4" role="tabpanel" aria-labelledby="menu4-tab">';
	} ?>
	<div id="lblnome4" class="textoAzul"></div>
	<input type="hidden" name="txtprontuario" id ="txtprontuario">
	<div id="prontuario" style="width:100%; height: 570px; overflow: auto;"></div>
	<?php 
	echo '</div>';
// ---------------------------------------------------------------------------------------------------------------- -->	    
	
	if ($tab==6){ 
		echo '<div class="tab-pane fade show active" id="menu5" role="tabpanel" aria-labelledby="menu5-tab">';
	}else{
		echo '<div class="tab-pane fade" id="menu5" role="tabpanel" aria-labelledby="menu5-tab">';
	} ?>
	<div id="lblnome5" class="textoAzul"></div>
	<input type="hidden" name="txtreceituario" id ="txtreceituario">
	<div id="receituario" style="width:100%; height: 570px; overflow: auto;"></div>
	<?php 
	echo '</div>';
	if ($tab==7){ 
		echo '<div class="tab-pane fade show active" id="menu6" role="tabpanel" aria-labelledby="menu46-tab">';
	}else{ 
		echo '<div class="tab-pane fade" id="menu6" role="tabpanel" aria-labelledby="menu6-tab">';
	} ?>
	<div id="lblnome6" class="textoAzul"></div>
	<input type="hidden" name="txtexames" id ="txtexames">
	<div id="exames" style="width:100%; height: 570px; overflow: auto;"></div>
	<?php echo '</div>'; ?>
</div>
</form>
  
<!-- --------------------------------------------------------------------------------------- -->
	
	<script language="javascript">
  function reload_cadastro() {
	ajax('zera_codigo.php','carregando');
  }
	</script>
	<script type="text/javascript">
		new Autocomplete("txtNome", function() { return "autocomplete_nome.php?typing=" + this.text.value;});
		new Autocomplete("txtEmail", function() { return "autocomplete_email.php?typing=" + this.text.value;});
		new Autocomplete("txtCPF", function() { return "autocomplete_cpf.php?typing=" + this.text.value;});
		new Autocomplete("txtCodigo", function() { return "autocomplete_codigo.php?typing=" + this.text.value;});
		
	</script>
		
	<?php include_once("../utilitarios/rodape.php");?>
 	</body>
	</html>
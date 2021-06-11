<?php
include_once("../seguranca.php");
protegePagina();
include_once("../utilitarios/funcoes.php");
date_default_timezone_set('America/Sao_Paulo');

if (!$_SESSION["V_1000"]){
	expulsaVisitante2();
}else{
	$_SESSION['funcao']="Cadastro";
	$sql = "select * from grupos order by NOMEGRP";
	$mysql_query = $_con->query($sql);
								
	$combo = '<div class="col-sm-8 col-md-8"><select name="txtGrupo" class="form-control" id="txtGrupo">';
	$combo .= " <option value='0'>Selecione</option>";
	if ($mysql_query->num_rows>0) {
		while ($_row = $mysql_query->fetch_assoc()) {
				//concatenamos e damos o valor da option
				$grupo = $_row['GRUPO'];
				$nomegrupo = $_row['NOMEGRP'];
				$combo .= " <option value=$grupo>$nomegrupo</option>";
		}
	}
	//concatenamos e fechamos o select
	$combo .= "</select></div>";
	
	$sql = "select * from origem order by Descricao";
	$mysql_query = $_con->query($sql);
	$comboOrigem = '<div class="col-sm-8 col-md-8"><select name="txtOrigem" class="form-control" id="txtOrigem">';
	$comboOrigem .= " <option value='0'>Selecione</option>";
	if ($mysql_query->num_rows>0) {
		while ($dado_s = $mysql_query->fetch_assoc()) {
			//concatenamos e damos o valor da option
			$origem = $dado_s['Origem'];
			$nomeorigem = $dado_s['Descricao'];
			$comboOrigem .= " <option value=$origem>$nomeorigem</option>";
		}
	}
	//concatenamos e fechamos o select
	$comboOrigem .= "</select></div>";
	
	$sql = "select * from profissao order by Descricao2";
	$mysql_query = $_con->query($sql);
	$comboProf = '<div class="col-sm-8 col-md-8"><select name="txtProfissao" class="form-control" id="txtProfissao">';
	$comboProf .= " <option value='0'>Selecione</option>";
	
	if ($mysql_query->num_rows>0) {
		while ($dado_s = $mysql_query->fetch_assoc()) {
			//concatenamos e damos o valor da option
			$profissao = $dado_s['Profissao'];
			$nomeprofissao = $dado_s['Descricao2'];
			$comboProf .= " <option value=$profissao>$nomeprofissao</option>\n";
		}
	}
	//concatenamos e fechamos o select
	$comboProf .= "</select></div>";
	
	$sql = "select * from ramo order by DESCRICAO";
	$mysql_query = $_con->query($sql);
	$comboRamo = '<div class="col-sm-8 col-md-8"><select name="txtRamo" class="form-control" id="txtRamo">';
	$comboRamo .= " <option value='0'>Selecione</option>";
	if ($mysql_query->num_rows>0) {
		while ($dado_s = $mysql_query->fetch_assoc()) {
			//concatenamos e damos o valor da option
			$ramo = $dado_s['CODIGO'];
			$nomeramo = $dado_s['DESCRICAO'];
			$comboRamo .= " <option value=$ramo>$nomeramo</option>\n";
		}
	}
	//concatenamos e fechamos o select
	$comboRamo .= "</select></div>";
	
	$sql = "select * from `campanha`";
	$mysql_query = $_con->query($sql);
	$comboCampanha = '<div class="col-sm-5 col-md-5"><select name="txtCampanha" class="form-control" id="txtCampanha">';
	$comboCampanha .= " <option value='0'>Selecione</option>\n";
	if ($mysql_query->num_rows>0) {
		while ($dado_s = $mysql_query->fetch_assoc()) {
			$campanha = $dado_s['codigo'];
			$nomecampanha = $dado_s['descricao'];
			//concatenamos e damos o valor da option
			$comboCampanha .= " <option value=$campanha>$nomecampanha</option>\n";	
		}
	}
		//concatenamos e fechamos o select
	$comboCampanha .= "</select></div>";
	
	$comboEstadoCivil ='<div class="col-sm-5 col-md-5"><select name="txtEstadoCivil" class="form-control" id="txtEstadoCivil">
										<option value="0">Solteiro(a)</option>
										<option value="1">Casado(a)</option>
										<option value="2">Viúvo(a)</option>
										<option value="3">Separado(a)</option>
										<option value="4">Divorciado(a)</option>
										<option value="5">Desquitado(a)</option>
										<option value="6">Companheiro(a)</option>
									</select>
									</div>';
	
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Cadastro de Eleitores">
	<meta name="author" content="Vitor H M Oliveira">
	<title>Cadastro</title>
	<link rel="icon" href="../imagens/favicon.ico">
	<link href="../css/formata_textos.css" rel="stylesheet">
  <link href="../css/all.css" rel="stylesheet">

	<link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">
	<link href="../css/sticky-footer-navbar.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../css/ajax.css"/>
	<link rel="stylesheet" type="text/css" href="../css/autocomplete.css"/>
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
	<script type="text/javascript" src="../js/eleitor.js"></script>
	<script src="../js/carrega_ajax.js" type="text/javascript"></script>
	<script src="../js/ajax.js" type="text/javascript"></script>
	<script src="../js/ie-emulation-modes-warning.js"></script>
	<script src="../js/jquery.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../js/autocomplete.js"></script>
  <script src="../js/ie10-viewport-bug-workaround.js"></script>
	<script language="javascript">
  function excluirelation(id) {
    if (confirm("Confirma a Exclusão do relacionamento?")){
      ajax('exclui_relation.php?id='+id,'modal');			
    }
  }
  function reload_cadastro() {
	ajax('zera_codigo.php','modal');
  }
  
  function novoeleitor(cod){
    document.form1.txtCodigo.value = cod;
    window.self.PesqCodEleitor();
  }
  
  </script>
	</head>
	<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"
<?php 
if ($_SESSION['ult_eleitor_pesquisado'] >0){
	echo ' onLoad="PesquisaEleitor('.$_SESSION['ult_eleitor_pesquisado'].')" onBlur="PesquisaEleitor('.$_SESSION['ult_eleitor_pesquisado'].')" onFocus="PesquisaEleitor('.$_SESSION['ult_eleitor_pesquisado'].')"';
	}?>
  >
	<?php include_once("../utilitarios/cabecalho.php");?>
	<form name="form1" method="post" action="">
		<section id="corpo" class="container">
			<ul class="nav nav-tabs">
				<li class="active"><a data-toggle="tab" href="#home">Dados</a></li>
				<li><a data-toggle="tab" href="#menu0">Observações</a></li>
				<li><a data-toggle="tab" href="#menu1">Endereços</a></li>
				<li><a data-toggle="tab" href="#menu2">Contatos</a></li>
				<li><a data-toggle="tab" href="#menu3">Demandas</a></li>
			</ul>
			<div class="tab-content">
				<div id="home" class="tab-pane fade in active">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="12%" align="right">
              	<label class="textoVermelho">Nome:</label>
              </td>
							<td width="37%">
              	<div class="col-sm-9 col-md-9">
									<input name="txtNome" type="text" id="txtnome" class="form-control" placeholder="Informe o nome" max="50" size="50" maxlength="80" autofocus="autofocus"/>
								</div>
							</td>
							<td width="12%" align="right">
              	<label>Código:</label>
              </td>
							<td width="43%">
              	<div class="col-sm-4">
									<input type="text" id="txtCodigo" name="txtCodigo" class="form-control" placeholder="Código">
								</div>
								<button type="button" class="btn btn-sm btn-dark" onclick="javascript:PesqCodEleitor();"><i class="fas fa-search"></i> Consultar</button>
							</td>
						</tr>
						<tr>
							<td width="12%" align="right">
              	<label for="txtDataNascimento">Data de Nascimento:</label>
              </td>
							<td width="37%">
              	<div class="col-sm-5">
									<input type="date" class="form-control" name="txtDataNascimento" id="txtDataNascimento" placeholder="00/00/0000" >
								</div>
              </td>
							<td width="12%" align="right">
              	<label for="txtSexo">Sexo:</label>
              </td>
							<td>
              	<div class="col-sm-5">
									<select class="form-control" name="txtSexo" id="txtSexo">
										<option value="M">Masculino</option>
										<option value="F">Feminino</option>
									</select>
								</div>
            	</td>
						</tr>
						<tr>
							<td width="12%" align="right"><label for="txtGrupo">Grupo:</label></td>
							<td><?php echo $combo; ?></td>
							<td width="12%" align="right"><label for="txtOrigem" class="textoVermelho">Origem:</label></td>
							<td><?php echo $comboOrigem; ?></td>
						</tr>
						<tr>
							<td align="right"><label for="txtEmail">E-mail:</label></td>
							<td><div class="col-sm-9 col-md-9">
              	<input type="email" class="form-control-email"  name="txtEmail" id="txtemail" placeholder="E-mail válido. Obrigatório" maxlength="70" size="60" required/>
              
								</div></td>
							<td align="right"><label for="txtCPF">CPF:</label></td>
							<td><div class="col-sm-4 col-md-4">
									<input type="text" class="form-control" name="txtCPF" id="txtCPF" placeholder="Somente números" />
								</div></td>
						</tr>
						<tr>
							<td align="right"><label for="txtCelular">Celular:</label></td>
							<td><div class="col-sm-5">
									<input type="tel" class="form-control" id="txtCelular" placeholder="(99)99999-9999" maxlength="15"/>
								</div></td>
							<td align="right"><label for="txtResidencial">Residencial:</label></td>
							<td><div class="col-sm-5">
									<input type="tel" class="form-control" name="txtResidencial" id="txtResidencial" placeholder="(99)9999-9999" maxlength="15"/>
								</div></td>
						</tr>
						<tr>
							<td align="right"><label for="txtComercial">Comercial:</label></td>
							<td><div class="col-sm-5">
									<input type="tel" class="form-control" name="txtComercial" id="txtComercial" placeholder="(99)99999-9999" maxlength="15"/>
								</div></td>
							<td width="12%" align="right"><label for="txtProfissao">Profissão:</label></td>
							<td><?php echo $comboProf; ?></td>
						</tr>
						<tr>
							<td width="12%" align="right"><label for="txtEmpresa">Empresa:</label></td>
							<td width="37%"><div class="col-sm-9 col-md-9">
									<input type="text" id="txtEmpresa" name="txtEmpresa" class="form-control" placeholder="Nome da Empresa"/>
								</div></td>
							<td width="12%" align="right"><label for="txtCargo">Cargo:</label></td>
							<td width="43%"><div class="col-sm-9 col-md-9">
									<input type="text" id="txtCargo" name="txtCargo" class="form-control" placeholder="Cargo na Empresa"/>
								</div></td>
						</tr>
						<tr>
							<td align="right"><label for="txtRamo">Ramo Atividade:</label></td>
							<td><?php echo $comboRamo; ?></td>
							<td align="right" nowrap="nowrap"><label for="txtRamo">Estado Civil:</label></td>
							<td><?php echo $comboEstadoCivil; ?></td>
						</tr>
						<tr>
							<td align="right"><label for="txtClass">Classificação:</label></td>
							<td>
								<div class="col-sm-5 col-md-5">
									<select name="txtClass" class="form-control" id="txtClass">
										<option value="0">Selecione</option>
										<option value="1">Alto</option>
										<option value="2">Médio</option>
										<option value="3">Baixo</option>
									</select>
								</div></td>
							<td align="right"><label for="txtRamo">Campanha:</label></td>
							<td><?php echo $comboCampanha; ?> </td>
						</tr>
						<tr>
							<td align="right"><label for="txtFace">Facebook:</label></td>
							<td><div class="col-sm-9 col-md-9">
									<input type="text" id="txtFace" name="txtFace" class="form-control" placeholder="Facebook"/>
								</div></td>
							<td align="right"><label for="txtTwitter">Twitter:</label></td>
							<td><div class="col-sm-9 col-md-9">
									<input type="text" id="txtTwitter" name="txtTwitter" class="form-control" placeholder="Twitter"/>
								</div></td>
						</tr>
						<tr>
							<td align="right"><label for="txtOutra">Outra Rede:</label></td>
							<td><div class="col-sm-9 col-md-9">
									<input type="text" id="txtOutra" name="txtOutra" class="form-control" placeholder="Outra Rede Social"/>
								</div></td>
							<td align="right"><label for="txtApelido">Apelido:</label></td>
							<td><div class="col-sm-9 col-md-9">
									<input type="text" id="txtApelido" name="txtApelido" class="form-control" placeholder="Apelido"/>
								</div></td>
						</tr>
						<tr>
							<td align="right"><label>Zona Eleitoral:</label></td>
							<td><div class="col-sm-3 col-md-3">
									<input type="text" id="txtZona" name="txtZona" class="form-control" placeholder="Zonal"/>
								</div></td>
							<td align="right"><label>Seção Eleitoral:</label></td>
							<td><div class="col-sm-3 col-md-3">
									<input type="text" id="txtSecao" name="txtSecao" class="form-control" placeholder="Seção"/>
								</div></td>
						</tr>
						<tr>
							<td align="right"><label class="text text-success">Informações Diversas:</label></td>
							<td>
								<div class="col-sm-12">
										<label>Filiado:
										<input type="checkbox" name="chkFiliado" id="chkFiliado" />
										</label>
										&nbsp;
										<label>Recebe E-mail:
										<input type="checkbox" name="chkEmail" id="chkEmail" />
										</label>
										&nbsp;
										<label>Recebe Impresso:
										<input type="checkbox" name="chkImpresso" id="chkImpresso" />
										</label>
										&nbsp;
										<label>Votou:
										<input type="checkbox" name="chkVotou" id="chkVotou" />
										</label>
								</div>
							</td>
							<td align="right"><label for="txtClass">Pai/Mãe:</label></td>
							<td>
								<div class="col-sm-5 col-md-3">
									<select class="form-control" name="txtPaiMae" id="txtPaiMae">
										<option value=""></option>
										<option value="P">Pai</option>
										<option value="M">Mãe</option>
									</select>
								</div>
							</td>
						</tr>
						<tr>
							<td align="right">
								<label>Data Cadastro:&nbsp;</label>
							</td>
							<td>
								<div class="col-sm-6">
									<div id="lbldtcad" class="text text-danger"></div>
								</div>
							</td>
							<td align="right">
								<label>Data Última Alteração:&nbsp;</label>
							</td>
							<td>
								<div class="col-sm-6">
									<div id="lbldtultalt" class="text text-danger"></div>
								</div>
							</td>
						</tr>
						<tr>
							<td align="right"><label>Responsável Cadastro:&nbsp;</label></td>
							<td>
								<div class="col-sm-6">
									<div id="lblrespcad" class="text text-danger"></div>
								</div>
							</td>
							<td colspan="2" align="center" class="textoVermelho">CAMPOS EM VERMELHO SÃO OBRIGATÓRIOS</td>
						</tr>
						<tr>
							<td colspan="4"><hr /></td>
						</tr>
						<tr>
							<td colspan="4" align="">
								<div align="center">
									<button type="button" class="btn btn-sm btn-primary" onclick="javascript:validaI();">
										<i class="fas fa-plus" aria-hidden="true"></i> Incluir
									</button>
									<button type="button" class="btn btn-sm btn-warning" onclick="javascript:validaA();">
										<i class="fas fa-refresh"></i> Alterar
									</button>
									<button type="button" class="btn btn-sm btn-danger" onclick="javascript:validaE();">
										<i class="fas fa-remove"></i> Excluir
									</button>
									<button type="button" class="btn btn-sm btn-info">
										<i class="fas fa-print"></i> Imprimir
									</button>
									<button type="button" class="btn btn-sm btn-success" onclick="javascript:reload_cadastro();">
										<i class="fas fa-repeat"></i> Limpa Tela
									</button> 
									<a href="../index2.php" class="btn btn-dark btn-sm" role="button">
										<i class="fas fa-menu-hamburger"></i>  Menu
									</a>
								</div>
							</td>
						</tr>
					</table>
				</div>
				<div id="menu0" class="tab-pane fade">
        	<span id="lblnome" class="textoAzul"></span>
          <div class="col-sm-12">
						<textarea name="txtObs" cols="200" rows="10" class="form-control" id="txtObs" placeholder="Observações relevantes do Eleitor">
          	</textarea>
          </div>
				</div>
				<div id="menu1" class="tab-pane fade">
					<button id="btnincrel" name="btnincrel" type="button" class="btn btn-sm btn-primary" onClick="javascript:NewEnd();">
					<i class="fas fa-plus" aria-hidden="true"></i> Incluir Endereço
					</button>
					<input type="hidden" name="txtEnderecos" id="txtEnderecos">
					<div id="dados">
          </div>
				</div>
				<div id="menu2" class="tab-pane fade">
					<button id="btnincvis" name="btnincvis" type="button" class="btn btn-sm btn-primary" onClick="javascript:OpenVisita();" disabled="disabled">
					<i class="fas fa-plus" aria-hidden="true"></i> Incluir Visita/Contato
					</button>
					<input type="hidden" name="txtVisitas" id ="txtVisitas">
					<div id="visit">
          </div>
				</div>
				<div id="menu3" class="tab-pane fade">
					<input type="hidden" name="txtDemandas" id ="txtDemandas">
					<div id="solution">
          </div>
				</div>
      </div>
		</section>
	</form>
	<script type="text/javascript">
		new Autocomplete("txtNome", function() { return "autocomplete_nome.php?typing=" + this.text.value;});
		new Autocomplete("txtEmail", function() { return "autocomplete_email.php?typing=" + this.text.value;});
		</script>
	<?php include_once("../utilitarios/rodape.php");?>
	</body>
	</html>
<?php }?>
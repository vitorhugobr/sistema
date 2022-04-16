 <?php
	include_once("../utilitarios/funcoes.php");
	$arqconfig = "../".md5("mapa").".txt";
	if (!file_exists($arqconfig)) {
		echo 'IMPOSSÍVEL ACESSAR O SISTEMA.<br>Arquivo de configuração excluído ou danificado! ';
		die;
	} 	

	$linhas = explode("\n", file_get_contents($arqconfig));
	$id = $linhas[0]; // usuario =A(100,80);

	switch ($id) {
		case 0:  // Local Testes
			$_SG['site'] = 'Testes';
			$_SESSION['servidor'] = "localhost";
			$_SESSION['usuario'] = "root";
			$_SESSION['senha'] = "";
			$_SESSION['banco'] = "thiago_sigre"; // LOCAL thiago
			break;		
		case 1:  //Dr Thiago
			$_SG['site'] = 'Dr Thiago';
			$_SESSION['servidor'] = "191.252.101.58";
			$_SESSION['banco'] = "drthiago_sigre";
			$_SESSION['usuario'] = "sigre";
			$_SESSION['senha'] = "sigre2018";
			break;
		case 2:  // Pujol
			$_SG['site'] = 'Pujol';			
			$_SESSION['servidor'] = "www.rpujol.com.br";
			$_SESSION['banco'] = "rpujolco_pujol";
			$_SESSION['usuario'] = "rpujolco_pujol";
			$_SESSION['senha'] = "vhm@2019";
			break;
		case 3:  // Mauro Pinheiro
			$_SG['site'] = 'Mauro Pinheiro';
			$_SESSION['servidor'] = "www.mauropinheiro.net.br";
			$_SESSION['banco'] = "mauropin_mauro";
			$_SESSION['usuario'] = "mauropin_mauro";
			$_SESSION['senha'] = "vitor@2020";
			break;
		case 4:  // Domingos Cunha
			$_SG['site'] = 'Domingos Cunha';
			$_SESSION['servidor'] = "www.domingoscunha.com.br";
			$_SESSION['banco'] = "domingos_domingos";
			$_SESSION['usuario'] = "domingos_domingo";
			$_SESSION['senha'] = "domi@2019";
			break;
		case 5:  // Tessaro
			$_SESSION['servidor'] = "www.vereadortessaro.com.br";
			$_SESSION['banco'] = "vereador_sigre";
			$_SESSION['usuario'] = "vereador_tessaro";
			$_SESSION['senha'] = "tessaro@2019";
			break;
		case 6:  // Democratas Porto Alegre
			$_SG['site'] = 'Democratas';
			$_SESSION['servidor'] = "www.rpujol.com.br";
			$_SESSION['banco'] = "rpujolco_dem";
			$_SESSION['usuario'] = "rpujolco_dem";
			$_SESSION['senha'] = "democrataspoa@2019";
			break;
		case 7:  // Sebastião Melo
			$_SG['site'] = 'Sebastião Melo';
			$_SESSION['servidor'] = "www.sebastiaomelo.poa.br";
			$_SESSION['usuario'] = "sebastia_melo";
			$_SESSION['senha'] = "lmqY{uxa(WrL";
			$_SESSION['banco'] = "sebastia_sigre"; 
			break;
		case 8:  // Luiz Braz
			$_SG['site'] = 'Luiz Braz';
			$_SESSION['servidor'] = "www.vitor.poa.br";
			$_SESSION['usuario'] = "vitorpoa_luiz";
			$_SESSION['senha'] = "braz@2020";
			$_SESSION['banco'] = "vitorpoa_luizbraz"; 
			//	senha cpanel: "=1fTUSoRJ}Ru"  usuário: "sebastiaomelopoa"
			break;
	}

	$_con  = new mysqli($_SESSION['servidor'],$_SESSION['usuario'],$_SESSION['senha'],$_SESSION['banco']);	
	if(!$_con) {  
		echo "Não foi possivel conectar ao MySQL. Erro " .
				mysqli_connect_errno() . " : " . mysql_connect_error();
		exit;
	}
	mysqli_set_charset($_con,"utf8");
	mysqli_query($_con, "SET NAMES 'utf8'");
	mysqli_query($_con, 'SET character_set_connection=utf8');
	mysqli_query($_con, 'SET character_set_client=utf8');
	mysqli_query($_con, 'SET character_set_results=utf8');
//---------------------------------------------------------

?>
  <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br">
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"></meta>
  <meta http-equiv="X-UA-Compatible" content="IE=edge"></meta>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"></meta>
  <meta name="description" content="Cadastro de árbitros"></meta>
  <meta name="author" content="Vitor H M Oliveira"></meta>

  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"></link>
  <link rel="stylesheet" type="text/css" href="../css/formata_textos.css"></link>
  <link rel="stylesheet" type="text/css" href="../css/sticky-footer-navbar.css"></link>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css"></link>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css"></link>
  <link rel="icon" href="../imagens/vhmo.png" type="image/png"></link>
  <link rel="shortcut icon" href="../imagens/vhmo.ico"></link>
  <title>SIGRE - Operações</title>
  <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
	</head>
	<body>
<?php
	$result_user = "SELECT * FROM operacoes order by data desc, hora desc";

	$mysql_query = $_con->query($result_user);
	if ($mysql_query->num_rows<1) {
		echo 'Sem registros!';					
	}else{
		echo '<div class="row">
		<div class="col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2" align="left"><img src="../imagens/vhmo.png"></div>
		<div class="col-12 col-sm-12 col-md-8 col-lg-8 col-xl-8"" align="center">
			<span class="sigla_sistema">SIGRE </div>
		<div class="col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2"" align="right"><span class="badge badge-info">Vitor</span></div>
	  </div>		
	  <h5 align="center">Operações dos Usuários '.$_SG["site"].'</h5>';
		echo '<table id="listar-usuario" class="table table-striped" style="width:100%">
			<thead class="thead-light">
				<tr>
					<th width="10%">Data</th>
					<th width="10%">Hora</th>
					<th width="15%">Tabela</th>
					<th width="20%">Operador</th>
					<th width="25">Operação</th>
				</tr>
				<tr> <th width="80%" colspan="5">Conteúdo</th></tr>
			</thead><tbody>';
		while ($dados_busca = $mysql_query->fetch_assoc()) {	
			$data = date("d/m/Y", strtotime($dados_busca["data"]));
			$hora = $dados_busca['hora'];
			$tabela = $dados_busca['tabela'];
			$operacao = $dados_busca['operacao'];
			$conteudo = $dados_busca['conteudo'];
			switch ($operacao) {
			case "A":  //Dr Thiago
				$operacao = "ALTERAÇÃO";
				break;
			case "E":  //Dr Thiago
				$operacao = "EXCLUSÃO";
				break;
			case "I":  //Dr Thiago
				$operacao = "INCLUSÃO";
				break;
			case "L":  //Dr Thiago
				$operacao = "LOGIN";
				break;
			}
			$operador = $dados_busca['operador'];
			
			echo '<tr>
					<td>'.$data.'</td><td>'.$hora.'</td><td>'.$tabela.'</td><td><b>'.$operador.'</b></td><td>'.$operacao.'</td>
				  </tr>';
			echo '<tr><td colspan="5">'.$conteudo.'</td></tr>';
		}
		echo '</tbody></table>';		
		echo '<footer class="footer">
			<div class="card">
			  <div class="card-text text-muted rodape">
				Vitor H M Oliveira - 
				<span class="rodapeSigla">
				  SIGRE - 
				</span>
				<span class="card-text text-muted rodape">
				  Desenvolvedor
				</span>
			  </div>
			</div>
		  </footer>';
	}
?>
	</body>
</html>

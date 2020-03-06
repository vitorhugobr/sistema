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
			$_SG['servidor'] = "localhost";
			$_SG['usuario'] = "root";
			$_SG['senha'] = "";
			$_SG['banco'] = "thiago_sigre"; // LOCAL thiago
			break;		
		case 1:  //Dr Thiago
			$_SG['servidor'] = "191.252.101.58";
			$_SG['banco'] = "drthiago_sigre";
			$_SG['usuario'] = "sigre";
			$_SG['senha'] = "sigre2018";
			break;
		case 2:  // Pujol
			$_SG['servidor'] = "www.rpujol.com.br";
			$_SG['banco'] = "rpujolco_pujol";
			$_SG['usuario'] = "rpujolco_pujol";
			$_SG['senha'] = "vhm@2019";
			break;
		case 3:  // Mauro Pinheiro
			$_SG['servidor'] = "www.mauropinheiro.net.br";
			$_SG['banco'] = "mauropin_mauro";
			$_SG['usuario'] = "mauropin_mauro";
			$_SG['senha'] = "vitor@2020";
			break;
		case 4:  // Domingos Cunha
			$_SG['servidor'] = "www.domingoscunha.com.br";
			$_SG['banco'] = "domingos_domingos";
			$_SG['usuario'] = "domingos_domingo";
			$_SG['senha'] = "domi@2019";
			break;
		case 5:  // Tessaro
			$_SG['servidor'] = "www.vereadortessaro.com.br";
			$_SG['banco'] = "vereador_sigre";
			$_SG['usuario'] = "vereador_tessaro";
			$_SG['senha'] = "tessaro@2019";
			break;
		case 6:  // Democratas Porto Alegre
			$_SG['servidor'] = "www.rpujol.com.br";
			$_SG['banco'] = "rpujolco_dem";
			$_SG['usuario'] = "rpujolco_dem";
			$_SG['senha'] = "democrataspoa@2019";
			break;
		case 7:  // Sebastião Melo
			$_SG['servidor'] = "www.sebastiaomelo.poa.br";
			$_SG['usuario'] = "sebastia_melo";
			$_SG['senha'] = "lmqY{uxa(WrL";
			$_SG['banco'] = "sebastia_sigre"; 
			break;
		case 8:  // Luiz Braz
			$_SG['servidor'] = "www.vitor.poa.br";
			$_SG['usuario'] = "vitorpoa_luiz";
			$_SG['senha'] = "braz@2020";
			$_SG['banco'] = "vitorpoa_luizbraz"; 
			//	senha cpanel: "=1fTUSoRJ}Ru"  usuário: "sebastiaomelopoa"
			break;
	}

	$_con  = new mysqli($_SG['servidor'],$_SG['usuario'],$_SG['senha'],$_SG['banco']);	
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
		<div class="col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2" align="left"><img src="../imagens/vhmo.png"></div>
		<div class="col-12 col-sm-12 col-md-8 col-lg-8 col-xl-8"" align="center">
			<span class="sigla_sistema">SIGRE </div>
		<div class="col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2"" align="right"><span class="badge badge-info">Vitor</span></div>
	  </div>		
	  <h5 align="center">Operações dos Usuários</h5>';
		echo '<table id="listar-usuario" class="table table-striped" style="width:100%">
			<thead class="thead-light">
				<tr>
					<th>Data</th>
					<th>Hora</th>
					<th>Tabela</th>
					<th>Operação</th>
					<th>Operador</th>
				</tr>
			</thead><tbody>';
		while ($dados_busca = $mysql_query->fetch_assoc()) {	
			$data = date("d/m/Y", strtotime($dados_busca["data"]));
			$hora = $dados_busca['hora'];
			$tabela = $dados_busca['tabela'];
			$operacao = $dados_busca['operacao'];
			$operador = $dados_busca['operador'];
			echo '<tr>
					<td>'.$data.'</td><td>'.$hora.'</td><td>'.$tabela.'</td><td>'.$operacao.'</td><td>'.$operador.'</td>
				  </tr>';
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

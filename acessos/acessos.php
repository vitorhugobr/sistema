<?php
session_start();
	include_once("../utilitarios/funcoes.php");
	$arqconfig = "../".md5("mapa").".txt";
	if (!file_exists($arqconfig)) {
		echo 'IMPOSSÍVEL ACESSAR O SISTEMA.<br>Arquivo de configuração excluído ou danificado! ';
		die;
	} 	
    
	$linhas = explode("\n", file_get_contents($arqconfig));
	$id = $linhas[0]; // usuario =A(100,80);
	//echo $id;
	switch ($id) {
		case 0:  // Local Testes
			$site = 'Testes';
			$servername = "localhost";
			$servername = "root";
			$password  = "";
			$dbname = "thiago_sigre"; // LOCAL thiago
			break;		
		case 1:  //Dr Thiago
			$site = 'Dr Thiago';
			$servername = "191.252.101.58";
			$dbname = "drthiago_sigre";
			$username = "sigre";
			$password = "sigre2018";
			break;
		case 2:  // Emerson
			$site = "Emerson Correa";
			$servername = "www.serverwebdb.com.br";
			$dbname = "chaplinb_chaplin";
			$username = "chaplinb_chaplin";
			$password = "HpcOKYN7b2E-";			
			break;
		case 3:  // 
			break;
		case 4:  // PSC
			$site = "PSC Diretório Metropolitano Porto Algre";
			$servername = "www.vitor.poa.br";
			$dbname = "vitorpoa_psc";
			$username = "vitorpoa_psc";
			$password = "vhmo@2022";
			break;
		case 5:  // 
			$site = 'Sandro Muttoni';
			$servername = "www.serverwebdb.com.br";
			$dbname = "sandromu_sigre";
			$username = "sandromu_sigre";
			$password = "q0?iYG!HM~s$";
			break;
		case 6:  // 
			break;
		case 7:  // Sebastião Melo
			$site = 'Sebastião Melo';
			$servername = "www.sebastiaomelo.poa.br";
			$username = "sebastia_melo";
			$password = "lmqY{uxa(WrL";
			$dbname = "sebastia_sigre"; 
			break;
		case 8:  
			break;
	}

    $_con  = new mysqli($servername,$username,$password,$dbname);  
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
//---------------------------------------------------------?>
  <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br">
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"></meta>
  <meta http-equiv="X-UA-Compatible" content="IE=edge"></meta>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"></meta>
  <meta name="description" content="Cadastro de operações"></meta>
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
//inclusão da conexão com banco de dados
//A quantidade de valor a ser exibida
$quantidade = 20;
//a pagina atual
$pagina     = (isset($_GET['pagina'])) ? (int)$_GET['pagina'] : 1;
//Calcula a pagina de qual valor será exibido
$inicio     = ($quantidade * $pagina) - $quantidade;

//Monta o SQL com LIMIT para exibição dos dados 
$sql = "Select 
id AS codigo,
data AS data,
hora AS hora,
tabela AS tabela,
(case operacao when 'L' then 'Login' when 'I' then 'Inclusão' when 'A' then 'Alteração' when 'E' then 'Exclusão' end) AS operacao,
operador AS operador,
conteudo AS conteudo
from 
operacoes ORDER BY data DESC, hora desc LIMIT $inicio, $quantidade";
//Executa o SQL
$mysql_query = $_con->query($sql);
echo '<div class="row">
<div class="col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2" align="left"><img src="../imagens/vhmo.png"></div>
<div class="col-12 col-sm-12 col-md-8 col-lg-8 col-xl-8"" align="center">
    <span class="sigla_sistema">SIGRE </div>
<div class="col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2"" align="right"><span class="badge badge-info">Vitor</span></div>
</div>        
<h5 align="center">Operações dos Usuários '.$site.' '.date("d/m/Y").'</h5>';
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
while ($dados = $mysql_query->fetch_assoc()) {
    $data = date("d/m/Y", strtotime($dados["data"]));
    $hora = $dados['hora'];
    $tabela = $dados['tabela'];
    $operacao = $dados['operacao'];
    $conteudo = $dados['conteudo'];
    $operacao = $dados['operacao'];
    $operador = $dados['operador'];
    echo '<tr>
            <td>'.$data.'</td><td>'.$hora.'</td><td>'.$tabela.'</td><td><b>'.$operador.'</b></td><td>'.$operacao.'</td>
          </tr>';
    echo '<tr><td colspan="5">'.$conteudo.'</td></tr>';
}
echo '</tbody></table>';        

  /**
   * SEGUNDA PARTE DA PAGINAÇÃO
   */
  //SQL para saber o total
  $sqlTotal   = "SELECT * FROM operacoes ORDER BY data DESC, hora desc";
  //Executa o SQL
  $mysql_query = $_con->query($sqlTotal);
  $numTotal   = $mysql_query->num_rows;

  //$strTotal = mysql_query($strTotal,$_concomum);
  //Total de Registro na tabela
  //$numTotal   = mysql_num_rows($qrTotal);
  //O calculo do Total de página ser exibido
  $totalPagina = ceil($numTotal/$quantidade);
   /**
    * Defini o valor máximo a ser exibida na página tanto para direita quando para esquerda
    */
   $exibir = 5;
   /**
    * Aqui montará o link que voltará uma pagina
    * Caso o valor seja zero, por padrão ficará o valor 1
    */
   $anterior  = (($pagina - 1) == 0) ? 1 : $pagina - 1;
   /**
    * Aqui montará o link que ir para proxima pagina
    * Caso pagina +1 for maior ou igual ao total, ele terá o valor do total
    * caso contrario, ele pegar o valor da página + 1
    */
   $posterior = (($pagina+1) >= $totalPagina) ? $totalPagina : $pagina+1;
   /**
    * Agora monta o Link paar Primeira Página
    * Depois O link para voltar uma página
    */
  /**
    * Agora monta o Link para Próxima Página
    * Depois O link para Última Página
    */
    ?>
    <div id="navegacao">
        <?php
        echo '<a href="?pagina=1" title="Primeira" class="btn btn-primary btn-sm" role="button">
                        <i class="fas fa-copy" aria-hidden="true text-muted" aria-hidden="true"></i> Primeira</a> ';
        echo '<a href=\"?pagina=$anterior\" title="Anterior" class="btn btn-primary btn-sm" role="button">
                        <i class="fas fa-copy" aria-hidden="true text-muted" aria-hidden="true"></i> Anterior</a> ';

        //echo '<a href="?pagina=1">Primeira</a> | ';
        //echo "<a href=\"?pagina=$anterior\">Anterior</a> | ";
    ?>
        <?php
         /**
    * O loop para exibir os valores à esquerda
    */
   for($i = $pagina-$exibir; $i <= $pagina-1; $i++){
       if($i > 0)
        echo '<a href="?pagina='.$i.'"> '.$i.' </a>';
  }

  echo '<a href="?pagina='.$pagina.'"><strong>'.$pagina.'</strong></a>';

  for($i = $pagina+1; $i < $pagina+$exibir; $i++){
       if($i <= $totalPagina)
        echo '<a href="?pagina='.$i.'"> '.$i.' </a>';
  }

   /**
    * Depois o link da página atual
    */
   /**
    * O loop para exibir os valores à direita
    */

    ?>
    <?php 
        echo '<a href="?pagina='.$posterior.'" title="Posterior" class="btn btn-primary btn-sm" role="button">
                        <i class="fas fa-copy" aria-hidden="true text-muted" aria-hidden="true"></i> Próxima</a> ';
        echo '<a href="?pagina='.$totalPagina.'" title="Última" class="btn btn-primary btn-sm" role="button">
                        <i class="fas fa-copy" aria-hidden="true text-muted" aria-hidden="true"></i> Última</a> ';
		
	//	echo " | <a href=\"?pagina=$posterior\">Próxima</a> | ";
	//	echo "  <a href=\"?pagina=$totalPagina\">Última</a>";
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

    ?>
</body>
</html>

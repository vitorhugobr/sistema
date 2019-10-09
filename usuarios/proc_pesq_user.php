<?php
include_once('../connections/banco.php');
include_once("../utilitarios/funcoes.php");
//Receber a requisão da pesquisa 
$requestData= $_REQUEST;


//Indice da coluna na tabela visualizar resultado => nome da coluna no banco de dados
$columns = array( 
	0 =>'data', 
	1 => 'hora',
	2=> 'tabela',
	3=> 'operacao',
	4=> 'operador',
	5=> 'conteudo',
);

//Obtendo registros de número total sem qualquer pesquisa
$result_user = "SELECT * FROM operacoes";
$resultado_user =mysqli_query($_con, $result_user);
$qnt_linhas = mysqli_num_rows($resultado_user);

//Obter os dados a serem apresentados
$result_usuarios = "SELECT * FROM operacoes WHERE 1=1";
if( !empty($requestData['search']['value']) ) {   // se houver um parâmetro de pesquisa, $requestData['search']['value'] contém o parâmetro de pesquisa
	$result_usuarios.=" AND ( id LIKE '".$requestData['search']['value']."%' ";    
	$result_usuarios.=" OR operador LIKE '".$requestData['search']['value']."%' ";
	$result_usuarios.=" OR data LIKE '".$requestData['search']['value']."%' )";
}

$resultado_usuarios=mysqli_query($_con, $result_usuarios);
$totalFiltered = mysqli_num_rows($resultado_usuarios);
//Ordenar o resultado
$result_usuarios.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
$resultado_usuarios=mysqli_query($_con, $result_usuarios);

// Ler e criar o array de dados
$dados = array();
while( $row_usuarios =mysqli_fetch_array($resultado_usuarios) ) {  
	$dado = array(); 
	$dado[] = date("d/m/Y", strtotime($row_usuarios["data"]));
	$dado[] = $row_usuarios["hora"];
	$dado[] = $row_usuarios["tabela"];	
	$dado[] = $row_usuarios["operacao"];	
	$dado[] = $row_usuarios["operador"];	
	$dado[] = $row_usuarios["conteudo"];	
	$dados[] = $dado;
}


//Cria o array de informações a serem retornadas para o Javascript
$json_data = array(
	"draw" => intval( $requestData['draw'] ),//para cada requisição é enviado um número como parâmetro
	"recordsTotal" => intval( $qnt_linhas ),  //Quantidade de registros que há no banco de dados
	"recordsFiltered" => intval( $totalFiltered ), //Total de registros quando houver pesquisa
	"data" => $dados   //Array de dados completo dos dados retornados da tabela 
);

echo json_encode($json_data);  //enviar dados como formato json

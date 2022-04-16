<?php
session_start();
$_SESSION['servidor'] = "www.serverwebdb.com.br";
$_SESSION['banco'] = "chaplinb_chaplin";
$_SESSION['usuario'] = "chaplinb_chaplin";
$_SESSION['senha'] = "HpcOKYN7b2E-";
include_once("../utilitarios/funcoes.php");
//Receber a requisão da pesquisa 
$requestData= $_REQUEST;

//Indice da coluna na tabela visualizar resultado => nome da coluna no banco de dados
$columns = array( 
	0 =>'data', 
	1 => 'hora',
	2=> 'tabela',
	3=> 'operador',
	4=> 'operacao',
	5=> 'conteudo',

);

//Obtendo registros de número total sem qualquer pesquisa
$result_user = "Select 
    `operacoes`.`id` AS `codigo`,
    `operacoes`.`data` AS `data`,
    `operacoes`.`hora` AS `hora`,
    `operacoes`.`tabela` AS `tabela`,
    (case `operacoes`.`operacao` when 'L' then 'Login' when 'I' then 'Inclusão' when 'A' then 'Alteração' when 'E' then 'Exclusão' end) AS `operacao`,
    `operacoes`.`operador` AS `operador`,
    `operacoes`.`conteudo` AS `conteudo`
  from 
    `operacoes`";
$resultado_user =mysqli_query($_con, $result_user);
$qnt_linhas = mysqli_num_rows($resultado_user);

//Obter os dados a serem apresentados
$result_usuarios = "Select 
    `operacoes`.`id` AS `codigo`,
    `operacoes`.`data` AS `data`,
    `operacoes`.`hora` AS `hora`,
    `operacoes`.`tabela` AS `tabela`,
    (case `operacoes`.`operacao` when 'L' then 'Login' when 'I' then 'Inclusão' when 'A' then 'Alteração' when 'E' then 'Exclusão' end) AS `operacao`,
    `operacoes`.`operador` AS `operador`,
    `operacoes`.`conteudo` AS `conteudo`
  from 
    `operacoes` WHERE 1=1";
if( !empty($requestData['search']['value']) ) {   // se houver um parâmetro de pesquisa, $requestData['search']['value'] contém o parâmetro de pesquisa
	$result_usuarios.=" AND ( nome LIKE '".$requestData['search']['value']."%' ";    
	$result_usuarios.=" OR categoria LIKE '".$requestData['search']['value']."%' ";
	$result_usuarios.=" OR federacao LIKE '".$requestData['search']['value']."%' )";
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
	$dado[] = $row_usuarios["data"];	
	$dado[] = $row_usuarios["hora"];	
	$dado[] = $row_usuarios["tabela"];	
	$dado[] = $row_usuarios["operacao"];	
	$dado[] = $row_usuarios["ooperador"];	
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

<?php
//-------------------------------------------------------------------------------------------------------------------------------
function montacep() {
	// setup variables
	$linha=1;
	$qtde_and=0;
	$qtde_or=0;
	$primwhere=1;
	$strorderby="";
	$primorderby=0;
	$strwhere= array();		// array para montar os critérios do where
	#$strwhere[0] = ' (rua > "" and impresso=1 and padrao="S" and ';   ### usar qdo cadastro estiver ok e só recebe quem aceitar receber corresp-ondencias
	$strwhere[0] = ' (rua > "" and ';
	$stringWhere = $strwhere[0];
	$strorderby="";
	$parametros="";
	while ($linha < 13) {
		$varcampo = $_POST["campo".$linha];
		$varoperador = $_POST["operador".$linha];
		$varexpressao = $_POST["valorexpressao".$linha];
		if (isset($_POST["expressao".$linha])){
			$varconteudoexp = $_POST["expressao".$linha];
		}else{
			$varconteudoexp = "";			
		}
		$varconector = $_POST["conector".$linha];
		$varclassifica = $_POST["classifica".$linha];
		$strconector= "";
		if ($varcampo <> "") {
			if ($primwhere == 0){
				$primwhere = 1;
				$stringWhere .="(";
			}
			
			if ($varoperador == "like") {
				$varexpressao = "%" . $varexpressao . "%";				
			}
			if ($varcampo == "nome" || $varcampo=="cidade"|| $varcampo=="rua" || $varcampo=="bairro" || $varcampo=="complemento"){
				$varexpressao= "'" . $varexpressao . "'";				
			}

			$conector = "";
			if ($varconector <> "") {
				//echo "CONECTOR ".$varconector."<br>";
				if ($varconector=="or") {
					$qtde_or++;
					$conector = " OU ";					
					$stringWhere = "(".$stringWhere;					
					$strconector .= ") ".$varconector. " (";
				}else{
					$conector = " E ";
					$strconector .= " ".$varconector." ";				
				}
			}
			
			$strwhere[$linha] = $varcampo ." ". $varoperador ." ". $varexpressao. " ". $strconector;

			$stringWhere .= $strwhere[$linha];
	
			if ($varclassifica <> "") {
				if ($primorderby == 0) {
					$strorderby = " order by ";
					$primorderby=1;			
				}else {
					$strorderby .= ",";
				}
				$strorderby .= $varcampo;
			} 

		}


// -------- variáveis abaixo montadas para imprimir os parâmetros da consulta -------------------
		if ($varclassifica=="S"){
			$classificado = "<Classificado>";
		}else{
			$classificado = "";
		}		
		if ($varoperador=="like"){
			$operacao = " Contém ";
		}else{
			$operacao = $varoperador;
		}
//------------- até a linha acima ---------------------------------------------------------------------

		$linha = $linha + 1;
	}
	$stringWhere .= ")";

	for ($i = 1; $i <= $qtde_or ; $i++) {
		$stringWhere .= ")";
	}	

	$sql = 'SELECT * FROM relatorios_view WHERE ';
	
	if ($primorderby == 0) {
		$strorderby = " order by reg";
		$primorderby=1;			
	}else {
		$strorderby = $strorderby . ", reg";
	}

	$sql .= $stringWhere .' '. $strorderby;
	
	return $sql;
}
//----------------------------------------------------------------------------------------------------------------

function monta_sql(){
	// setup variables
	$linha=1;
	$primwhere=0;	
	$qtde_and=0;
	$qtde_or=0;
	$primorderby=0;
	$stringWhere = "(";    // variável que conterá a string para o WHERE
	$strwhere= array();		// array para montar os critérios do where
	$strorderby="";
	$parametros="";   // variável criada para retornar os critérios da consulta e ser impressoao final do relatório
	while ($linha < 13) {
		$varcampo = $_POST["campo".$linha];
		$varoperador = $_POST["operador".$linha];
		$varexpressao = $_POST["valorexpressao".$linha];
		if (isset($_POST["expressao".$linha])){
			$varconteudoexp = $_POST["expressao".$linha];
		}else{
			$varconteudoexp = "";			
		}
		$varconector = $_POST["conector".$linha];
		$varclassifica = $_POST["classifica".$linha];
		$strconector= "";
		if ($varcampo <> "") {
			
			if ($primwhere == 0){
				$primwhere = 1;
				$stringWhere ="(";
			}
			
			if ($varoperador == "like") {
				$varexpressao = "%" . $varexpressao . "%";				
			}
			if ($varcampo == "nome" || $varcampo=="cidade"|| $varcampo=="rua" || $varcampo=="bairro" || $varcampo=="complemento"){
				$varexpressao= "'" . $varexpressao . "'";				
			}

			$conector = "";
			if ($varconector <> "") {
				//echo "CONECTOR ".$varconector."<br>";
				if ($varconector=="or") {
					$qtde_or++;
					$conector = " OU ";					
					$stringWhere = "(".$stringWhere;					
					$strconector .= ") ".$varconector. " (";
				}else{
					$conector = " E ";
					$strconector .= " ".$varconector." ";				
				}
			}
			
			$strwhere[$linha] = $varcampo ." ". $varoperador ." ". $varexpressao. " ". $strconector;

			$stringWhere .= $strwhere[$linha];
	
			if ($varclassifica <> "") {
				if ($primorderby == 0) {
					$strorderby = " order by ";
					$primorderby=1;			
				}else {
					$strorderby .= ",";
				}
				$strorderby .= $varcampo;
			} 

		}


// -------- variáveis abaixo montadas para imprimir os parâmetros da consulta -------------------
		if ($varclassifica=="S"){
			$classificado = "<Classificado>";
		}else{
			$classificado = "";
		}		
		if ($varoperador=="like"){
			$operacao = " Contém ";
		}else{
			$operacao = $varoperador;
		}
		$parametros .= $varcampo." ".$operacao." ".$varconteudoexp." ".$classificado." ".$conector." "; 
//------------- até a linha acima ---------------------------------------------------------------------

		$linha = $linha + 1;
	}
	$stringWhere .= ")";

	for ($i = 1; $i <= $qtde_or ; $i++) {
		$stringWhere .= ")";
	}	

	$sql = 'SELECT * FROM relatorios_view WHERE ';
	
	if ($primorderby == 0) {
		$strorderby = " order by reg";
		$primorderby=1;			
	}else {
		$strorderby = $strorderby . ", reg";
	}

	$sql .= $stringWhere .' '. $strorderby;

	//echo $sql."<br>".$parametros;
	return array ($sql,$parametros);
}

///-------------------------------------------------------------------------------------------------------------------
function monta_ani(){
	// setup variables
	$dia = $_POST['txtdia'];
	$diaf = $_POST['txtdiaf'];
	$mes = $_POST['txtmes'];
	if ($_POST['hopcao'] == 6){
		$sql = 'SELECT * from relatorios_view where mes = '.$mes.' AND (dia >= '.$dia.' AND dia <= '.$diaf.') ORDER BY mes, dia, nome';
	}else{
		$sql = 'SELECT * from relatorios_view where mes= '.$mes.' AND (dia >= '.$dia.' AND dia <= '.$diaf.') ORDER BY reg';
	}
	return $sql;	
}

// -------------------------------------------------------------------------------------------------------------------
function monta_codbar($codigo_cep){

	if((is_int($codigo_cep))){
			$n1=(substr($codigo_cep,0,1)); 
			$n2=(substr($codigo_cep,1,1));
			$n3=(substr($codigo_cep,2,1));
			$n4=(substr($codigo_cep,3,1));		
			$n5=(substr($codigo_cep,4,1));
			$n6=(substr($codigo_cep,5,1));
			$n7=(substr($codigo_cep,6,1));
			$n8=(substr($codigo_cep,7,1));

			$sum = $n1+$n2+$n3+$n4+$n5+$n6+$n7+$n8;
			//echo $sum;
			//achar o multiplo de 10 superior mais proximo
			if ($sum == 10){
				$dv= 0;
			}else{
				$rest = $sum % 10;
				$mult = ((($sum  - $rest)/ 10) + 1) * 10;
				$dv = $mult - $sum;
			}
			//echo $dv;
			return $dv;
		}
	}
//-----------------------------------------------------------------------------------------------------------------------------
 
/* 
 *  Função de busca de Endereço pelo CEP 
 *  -   Desenvolvido Felipe Olivaes para ajaxbox.com.br 
 *  -   Utilizando WebService de CEP da republicavirtual.com.br 
 */  
function buscar_cep($cep){  
    $resultado = @file_get_contents('http://republicavirtual.com.br/web_cep.php?cep='.urlencode($cep).'&formato=query_string');  
    if(!$resultado){  
        $resultado = "&resultado=0&resultado_txt=erro+ao+buscar+cep";  
    }  
    parse_str($resultado, $retorno);   
    return $retorno;  
}  
  
  
/* 
 * Exemplo de utilização  
 */  
 //----------------------------------------------------------------------------------------------------------------

function monta_sql_get(){
	// setup variables
	$linha=1;
	$primwhere=0;	
	$qtde_and=0;
	$qtde_or=0;
	$primorderby=0;
	$stringWhere = "(";    // variável que conterá a string para o WHERE
	$strwhere= array();		// array para montar os critérios do where
	$strorderby="";
	$parametros="";   // variável criada para retornar os critérios da consulta e ser impressoao final do relatório
	while ($linha < 13) {
		$varcampo = $_GET["campo".$linha];
		$varoperador = $_GET["operador".$linha];
		$varexpressao = $_GET["valorexpressao".$linha];
		if (isset($_GET["expressao".$linha])){
			$varconteudoexp = $_GET["expressao".$linha];
		}else{
			$varconteudoexp = "";			
		}
		$varconector = $_GET["conector".$linha];
		$varclassifica = $_GET["classifica".$linha];
		$strconector= "";
		if ($varcampo <> "") {
			
			if ($primwhere == 0){
				$primwhere = 1;
				$stringWhere ="(";
			}
			
			if ($varoperador == "like") {
				$varexpressao = "%" . $varexpressao . "%";				
			}
			if ($varcampo == "nome" || $varcampo=="cidade"|| $varcampo=="rua" || $varcampo=="bairro" || $varcampo=="complemento"){
				$varexpressao= "'" . $varexpressao . "'";				
			}

			$conector = "";
			if ($varconector <> "") {
				//echo "CONECTOR ".$varconector."<br>";
				if ($varconector=="or") {
					$qtde_or++;
					$conector = " OU ";					
					$stringWhere = "(".$stringWhere;					
					$strconector .= ") ".$varconector. " (";
				}else{
					$conector = " E ";
					$strconector .= " ".$varconector." ";				
				}
			}
			
			$strwhere[$linha] = $varcampo ." ". $varoperador ." ". $varexpressao. " ". $strconector;

			$stringWhere .= $strwhere[$linha];
	
			if ($varclassifica <> "") {
				if ($primorderby == 0) {
					$strorderby = " order by ";
					$primorderby=1;			
				}else {
					$strorderby .= ",";
				}
				$strorderby .= $varcampo;
			} 

		}


// -------- variáveis abaixo montadas para imprimir os parâmetros da consulta -------------------
		if ($varclassifica=="S"){
			$classificado = "<Classificado>";
		}else{
			$classificado = "";
		}		
		if ($varoperador=="like"){
			$operacao = " Contém ";
		}else{
			$operacao = $varoperador;
		}
		$parametros .= $varcampo." ".$operacao." ".$varconteudoexp." ".$classificado." ".$conector." "; 
//------------- até a linha acima ---------------------------------------------------------------------

		$linha = $linha + 1;
	}
	$stringWhere .= ")";

	for ($i = 1; $i <= $qtde_or ; $i++) {
		$stringWhere .= ")";
	}	

	$sql = 'SELECT * FROM relatorios_view WHERE ';
	
	if ($primorderby == 0) {
		$strorderby = " order by reg";
		$primorderby=1;			
	}else {
		$strorderby = $strorderby . ", reg";
	}

	$sql .= $stringWhere .' '. $strorderby;

	//echo $sql."<br>".$parametros;
	return array ($sql,$parametros);
}

///-------------------------------------------------------------------------------------------------------------------
 
?>  

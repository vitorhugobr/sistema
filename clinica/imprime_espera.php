<?php

include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a p&Aacute;gina
require_once('../utilitarios/funcoes.php');
require("../fpdf/fpdf.php");

define('FPDF_FONTPATH','../fpdf/font/');

////////////////////////////////////
global $query ;
$query = $_GET['query'];

$sistemaabrev = $_SESSION['sistemaabrev'];
$entidade=$_SESSION["politico"];

class PDF extends FPDF
{
  function Header(){ //CABECALHO
	global $data;
	global $clinica;

	global $id; // EXEMPLO DE UMA VARIAVEL QUE TERÁ O MESMO VALOR EM QUALQUER ÁREA DO PDF.
	global $cod_cad;
	$data = $_GET['data'];
	$clinica = $_GET['clinica'];

	//$cod_cad = $_GET["cod_cad"];
	$l=5; // DEFINI ESTA VARIAVEL PARA ALTURA DA LINHA
	
	$this->SetXY(5,5); // SetXY -> DEFINE O X E O Y NA PAGINA
	//$this->Rect(10,10,190,20); // CRIA UM RETÂNGULO QUE COMEÇA NO X = 10, Y = 10 E TEM 190 DE LARGURA E 280 DE ALTURA. NESTE CASO, É UMA BORDA DE PÁGINA.
	//$this->Image('../imagens/vhmo.png',11,8,30); // INSERE UMA LOGOMARCA NO PONTO X = 11, Y = 11, E DE TAMANHO 40.
	$this->SetFont('Arial','B',12); // DEFINE A FONTE ARIAL, NEGRITO (B), DE TAMANHO 8
	$titulo = $_SESSION["politico"]; 
	$this->Cell(0,15,utf8_decode($titulo),0,0,'C'); // CRIA UMA CELULA COM OS SEGUINTES DADOS, RESPECTIVAMENTE: 
	// LARGURA = 0 - total, 
	// ALTURA = 15, 
	// TEXTO = 'INSIRA SEU TEXTO AQUI'
	// BORDA = 0. SE = 1 TEM BORDA SE 'R' = RIGTH, 'L' = LEFT, 'T' = TOP, 'B' = BOTTOM
	// QUEBRAR LINHA NO FINAL = 0 = NÃO
	// ALINHAMENTO = 'L' = LEFT
	$this->Ln(); // QUEBRA DE LINHA
	$this->SetLeftMargin(10);
	$this->SetXY(3, 20);
	//                                col lin 
	$this->Image('../imagens/esteto.png', 7, 10, 0, 7);
	//$pdf->Image('../imagens/xxxxx.jpg', 180, 10, 0, 7);					
	$this->SetLeftMargin(55);
	$this->SetXY(0,17); // SetXY -> DEFINE O X E O Y NA PAGINA
	$this->SetFont('Arial','',10); // DEFINE A FONTE ARIAL, NEGRITO (B), DE TAMANHO 8
	$this->Cell(0,0,utf8_decode("Lista Espera ".$clinica." em ".$data),0,0,'C'); // CRIA UMA CELULA COM OS SEGUINTES DADOS, RESPECTIVAMENTE: 
	//FINAL DO CABECALHO COM DADOS
	$this->SetXY(13,23); // SetXY -> DEFINE O X E O Y NA PAGINA
	$this->Cell(0,5,str_pad(utf8_decode("Cód. Cad."),10)." ".str_pad(utf8_decode("Nome"),113)." ".utf8_decode("Últ. Consulta    #faltas"),0,0,'L') ;
	$this->SetLineWidth(0.1);
	$this->Line(3, 30, 200, 30); 

	
  }
  function Footer() {
	//Vai para 1 cm do fundo da página
	$this->SetY(-10);
	//Seleciona Arial cursiva 8
	$this->SetFont('Arial','I',6);
	//Imprime o número da página atual e total
	$this->SetX(5);
	$this->Cell(30, 0, date('d/m/Y'), 0, 0,'L');
	$this->Cell(100,0,$_SESSION['sistemaabrev']." - ".utf8_decode($_SESSION['sistema']),0,0,"C");	
	$this->Cell(65,0,utf8_decode('Página. '.$this->PageNo()),0,0,'R');		  
  }
}$pdf=new PDF('P','mm','A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->SetTopMargin(5);
$pdf->AddPage(); // ADICIONA UMA PAGINA
$pdf->SetTitle(utf8_decode('Lista de Espera '.$clinica));
$pdf->AliasNbPages(); // SELECIONA O NUMERO TOTAL DE PAGINAS, USADO NO RODAPE
$pdf->SetCreator("Sistema SIGRE") ;
$pdf->SetAuthor('Vitor H M Oliveira');
$pdf->SetFont('Courier','',10);
$y = 59; // AQUI EU COLOCO O Y INICIAL DOS DADOS 
$l=4; // ALTURA DA LINHA
$zebrado = false ;
$statement = $pdo->prepare($query);
$statement->execute();
$total = $statement->rowCount();
$linha = 33;
if($total==0){
	$linhadet = '<span>** Sem Consultas **</span>';
}else{
	$pdf->SetLineWidth(0.3);
	while($dado = $statement->fetch()) {	// ENQUANTO OS DADOS VÃO PASSANDO, O FPDF VAI INSERINDO OS DADOS NA PAGINA	
		$id = $dado['id'];
		$cod_cadastro = $dado['cod_cadastro']; 
		$nome = $dado['nome']; 
		$nome = str_pad($nome, 55 , " ",STR_PAD_RIGHT);
		$ult_consulta = buscar_ultima_consulta($cod_cadastro);
		$qtdfaltas = busca_qtde_faltas($cod_cadastro);
		$pdf->SetXY(5,$linha);
		if (!$zebrado){
			$pdf->SetFillColor(255,255,255);
			$zebrado = true ; 
		} else {
			$pdf->SetFillColor(200,200,200);
			$zebrado = false ; 
		}		
		$zebrado = zebrado($pdf, $zebrado );
		$pdf->Cell(200,5,str_pad($cod_cadastro,9," ",STR_PAD_LEFT)." ".utf8_decode($nome)." ".str_pad($ult_consulta,10," ",STR_PAD_RIGHT)."   ".$qtdfaltas,0,0,'L') ;
		$linha = $linha +5;
		}
	}
	


$pdf->Output(); // IMPRIME O PDF NA TELA

?>




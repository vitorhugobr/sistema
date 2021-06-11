<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a p&Aacute;gina
require_once('../utilitarios/funcoes.php');
require("../fpdf/fpdf.php");

$titulo = "Demanda";
define('FPDF_FONTPATH','../fpdf/font/');

////////////////////////////////////
class PDF extends FPDF
{
  function Header(){ //CABECALHO
	global $id; // EXEMPLO DE UMA VARIAVEL QUE TERÁ O MESMO VALOR EM QUALQUER ÁREA DO PDF.
	global $cod_cad;
	//$cod_cad = $_GET["cod_cad"];
	$l=5; // DEFINI ESTA VARIAVEL PARA ALTURA DA LINHA
	
	$this->SetXY(5,5); // SetXY -> DEFINE O X E O Y NA PAGINA
	//$this->Rect(10,10,190,20); // CRIA UM RETÂNGULO QUE COMEÇA NO X = 10, Y = 10 E TEM 190 DE LARGURA E 280 DE ALTURA. NESTE CASO, É UMA BORDA DE PÁGINA.
	//$this->Image('../imagens/vhmo.png',11,8,30); // INSERE UMA LOGOMARCA NO PONTO X = 11, Y = 11, E DE TAMANHO 40.
	$this->SetFont('Arial','B',12); // DEFINE A FONTE ARIAL, NEGRITO (B), DE TAMANHO 8
	$titulo = str_pad($_SESSION["politico"], 150, " ", STR_PAD_BOTH); 
	$this->Cell(0,15,utf8_decode($titulo),0,0,'L'); // CRIA UMA CELULA COM OS SEGUINTES DADOS, RESPECTIVAMENTE: 
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
	$this->Image('../imagens/vhmo.jpg', 7, 10, 0, 7);
	//$pdf->Image('../imagens/xxxxx.jpg', 180, 10, 0, 7);					
	$this->SetLeftMargin(55);
	$x = $this->GetX();
	$y = $this->GetY();
	$this->SetLineWidth(0.1);
	$this->Line(3, $y, 203, $y);
	
	//FINAL DO CABECALHO COM DADOS
  }
  function Footer() {
	//Vai para 1 cm do fundo da página
	$this->SetY(-10);
	//Seleciona Arial cursiva 8
	$this->SetFont('Arial','I',6);
	//Imprime o número da página atual e total
	$this->Cell(100,0,$_SESSION['sistemaabrev']." - ".utf8_decode($_SESSION['sistema']),0,0,"C");	
	$this->Cell(45,0,utf8_decode('Página. '.$this->PageNo()),0,0,'R');		  
  }
}

//----------------- Dados da demanda - buscará no banco -------------------------
$numero = $_GET['numero'];


//--------------------------------------------------------------------------------

$pdf=new PDF('P','mm','A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->SetTopMargin(5);
$pdf->SetTitle('Demanda');
$pdf->AddPage(); // ADICIONA UMA PAGINA
$pdf->SetXY(5,10); // SetXY -> DEFINE O X E O Y NA PAGINA	
$pdf->SetFont('Arial','I',10); // DEFINE A FONTE ARIAL, NEGRITO (B), DE TAMANHO 8
$titulo2 = str_pad("Relatório da Demanda ".str_pad($numero, 5, '0', STR_PAD_LEFT), 160, " ", STR_PAD_BOTH).date('d/m/Y'); 
$pdf->Cell(0,15,utf8_decode($titulo2),0,0,'L');  
$pdf->AliasNbPages(); // SELECIONA O NUMERO TOTAL DE PAGINAS, USADO NO RODAPE
$pdf->SetCreator("Sistema SIGRE") ;
$pdf->SetAuthor('Vitor H M Oliveira');
$pdf->SetFont('Arial','',12);
$y = 59; // AQUI EU COLOCO O Y INICIAL DOS DADOS 
$l=4; // ALTURA DA LINHA

$query = "SELECT e.numero,e.codigo,e.data,e.assunto,e.descricao,e.situacao,e.protocolo, c.nome FROM encaminhamentos as e left JOIN cadastro as c ON c.codigo = e.codigo WHERE numero = $numero";

$mysql_query = $_con->query($query);
$mostra_demanda="";
if ($mysql_query->num_rows<1) {
	echo '<script>alert("DEMANDA não encontrada!");</script>';					
}else{
	while ($dados_s = $mysql_query->fetch_assoc()) {
		$codigo = $dados_s["codigo"];
		$num = str_pad($dados_s["numero"], 5, '0', STR_PAD_LEFT);
		$data = FormatDateTime($dados_s["data"],7);
		$assunto = busca_secretaria($dados_s["assunto"]);
		$desc = $dados_s["descricao"];
		$protocolo = $dados_s["protocolo"];
		$situation = $dados_s["situacao"];
		$situacao = $dados_s["situacao"];
		switch($situacao) {				
		  case 0:
			$situacao ='NÃO RESPONDIDA';
			  break;
		  case 1:	
			$situacao ='RESPONDIDA E NÃO ENCERRADA';
			  break;
		  case 2:
			$situacao ='ENCERRADA';
			  break;
		  default:			
			  break;
		}
		$nome = $dados_s["nome"];
		$_SESSION['codigo_requerente'] = $codigo;	
	}
}


	//DADOS
	
$pdf->SetFont('Arial','U',12);
$pdf->SetXY(5,25);
$pdf->Cell(0,0,utf8_decode('Dados da Demanda'),0,0,'L') ;
$pdf->SetXY(7,30);
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,0,'Solicitante: '.utf8_decode($nome).' (#'.$codigo.')',0,0,'L') ;
$pdf->SetXY(7,35);
$pdf->Cell(0,0,utf8_decode('Data Demanda: '.$data),0,0,'L') ;
$pdf->SetXY(7,40);
$pdf->Cell(0,0,utf8_decode('Situação: '.$situacao),0,0,'L') ;	
$pdf->SetXY(7,45);
$pdf->Cell(0,0,utf8_decode('Assunto: '.$assunto)."  Protocolo: ".$protocolo,0,0,'L') ;	
$pdf->SetXY(7,50);
$pdf->Cell(0,0,utf8_decode('Descrição: '.$desc),0,0,'L') ;	
$pdf->SetLineWidth(0.1);
$pdf->Line(3, 53, 203, 53);
$pdf->SetXY(5,58);
$pdf->SetFont('Arial','BIU',12);
$pdf->Cell(0,0,utf8_decode('RESPOSTAS'),0,0,'L') ;	
$pdf->SetFont('Arial','',10);
	
	// abaixo vai buscar o histórico da demada na tabela 
$query = "SELECT * from `historico_encaminhamentos` WHERE numero = ".$numero." order by data desc";
//echo "<br><br><br><br>".$query;
$mysql_query = $_con->query($query);
$nroresp = $mysql_query->num_rows;
$linha = 63;
if ($mysql_query->num_rows<1) {
}else{
	while ($dados_s = $mysql_query->fetch_assoc()) {
		$data = FormatDateTime($dados_s["data"],8);
		$id = $dados_s["id"];
		$numero = $dados_s["numero"];
		$retorno = $dados_s["retorno"];		
		$usuario = $dados_s["usuario"];	
		$strdata_user = $data." por ".$usuario;
		$pdf->SetXY(5,$linha);
		$pdf->Cell(0,2,utf8_decode("Data: ".$data."   por ".$usuario),0,0,'L') ;
		$linha = $linha +3;
		$pdf->SetXY(8,$linha);		
		$pdf->MultiCell(0, 4,utf8_decode(strtoupper($retorno)),0,1) ;
		$linha = $pdf->GetY();
		if ($linha > 240){
			$pdf->AddPage(); // ADICIONA UMA PAGINA
			$pdf->SetXY(5,10); // SetXY -> DEFINE O X E O Y NA PAGINA	
			$pdf->SetFont('Arial','I',10); // DEFINE A FONTE ARIAL, NEGRITO (B), DE TAMANHO 8
			$titulo2 = str_pad("Relatório da Demanda ".str_pad($numero, 5, '0', STR_PAD_LEFT), 160, " ", STR_PAD_BOTH).date('d/m/Y'); 
			$pdf->Cell(0,15,utf8_decode($titulo2),0,0,'L');  
			$linha = 22;
		}
	}
	// BUSCAR FOTOS DA DEMANDA
//	$pdf->SetXY(5,$linha);
//	$pdf->Cell(0,20,utf8_decode("Imagens"),0,0,'L') ;
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$linha = $y + 15;
	//$pdf->Cell(0,20,$linha,0,0,'L') ; //mostra em que linha está. Usar somente em teste.

	for ($i=0; $i < 1000; $i++) {
		$arqbusca =  "D".str_pad($numero, 7, '0', STR_PAD_LEFT).str_pad($i, 3, '0', STR_PAD_LEFT);
		$arquivo = "../imagens/demandas/".$arqbusca.".jpg";
		if ($linha > 215){
			$pdf->AddPage(); // ADICIONA UMA PAGINA
			$pdf->SetXY(5,10); // SetXY -> DEFINE O X E O Y NA PAGINA	
			$pdf->SetFont('Arial','I',10); // DEFINE A FONTE ARIAL, NEGRITO (B), DE TAMANHO 8
			$titulo2 = str_pad("Relatório da Demanda ".str_pad($numero, 5, '0', STR_PAD_LEFT), 160, " ", STR_PAD_BOTH).date('d/m/Y'); 
			$pdf->Cell(0,15,utf8_decode($titulo2),0,0,'L');  
			$linha = 22;
		}
		if (file_exists($arquivo)) {
			$pdf->Image($arquivo, 7, $linha, 0, 70);	
			$pdf->Ln();
			$linha = $linha + 72;
		} 	
	}			 
	
}
	
//	

$pdf->Output(); // IMPRIME O PDF NA TELA
?>
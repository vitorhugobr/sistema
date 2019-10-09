<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a p&Aacute;gina
require_once('../utilitarios/funcoes.php');
require("../fpdf/fpdf.php");

$titulo = "Atestado";
$cod_cadastro = $_GET["cod_cadastro"];

define('FPDF_FONTPATH','../fpdf/font/');

////////////////////////////////////

class PDF extends FPDF
{
//variables of html parser
	
	function Header(){ //CABECALHO
		global $id; // EXEMPLO DE UMA VARIAVEL QUE TERÁ O MESMO VALOR EM QUALQUER ÁREA DO PDF.
		global $cod_cad;
		//$cod_cad = $_GET["cod_cad"];
		$l=5; // DEFINI ESTA VARIAVEL PARA ALTURA DA LINHA
		$this->SetXY(5,5); // SetXY -> DEFINE O X E O Y NA PAGINA
		//$this->Rect(10,10,190,20); // CRIA UM RETÂNGULO QUE COMEÇA NO X = 10, Y = 10 E TEM 190 DE LARGURA E 280 DE ALTURA. NESTE CASO, É UMA BORDA DE PÁGINA.
		//$this->Image('../imagens/vhmo.png',11,8,30); // INSERE UMA LOGOMARCA NO PONTO X = 11, Y = 11, E DE TAMANHO 40.
		$l = 15;
		$this->SetFont('Arial','BI',14);

		$this->Rect(10,8,80,35);

		$this->SetXY(15,5);
		$this->Cell(0,15,utf8_decode('Dr. Thiago Pereira Duarte'),0,0,'L'); 
		$this->SetFont('Arial','',10);

		$this->SetXY(27,10);
		$this->Cell(0,15,utf8_decode('CREMERS 23.629'),0,0,'L');  
		$this->SetFont('Arial','I',10);
		$this->SetXY(37,18);
		$this->Cell(0,15,utf8_decode('Médico'),0,0,'L'); 
			
		$this->SetFont('Arial','',10);
		$this->SetXY(19,23);
		$this->Cell(0,15,utf8_decode('Rua Dr. Cecílio Monza, 10755'),0,0,'L');

		$this->SetXY(17,28);
		$this->Cell(0,15,utf8_decode('Belém Novo - Fone: (51) 3259-5555'),0,0,'L');

		$this->SetXY(32,33);
		$this->Cell(0,15,utf8_decode('Porto Alegre - RS'),0,0,'L');
		//FINAL DO CABECALHO COM DADOS
	}
	function Footer() {
		$this->SetXY(40,150);
		$this->Cell(0,0,utf8_decode('Dr Thiago Pereira Duarte'),0,0,'L'); 
		$this->SetXY(57,155);
		$this->Cell(0,0,utf8_decode('Médico'),0,0,'L'); 
		$this->SetXY(45,160);
		$this->Cell(0,0,utf8_decode('CREMERS 23.629'),0,0,'L'); 


	}

}
$pdf=new PDF('L','mm','A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4 landscape
$pdf->SetTopMargin(5);
$pdf->SetTitle('Atestado');
$pdf->AddPage(); // ADICIONA UMA PAGINA
$pdf->AliasNbPages(); // SELECIONA O NUMERO TOTAL DE PAGINAS, USADO NO RODAPE
$pdf->SetCreator("Sistema SIGRE") ;
$pdf->SetAuthor('Vitor H M Oliveira');
$pdf->SetFont('Arial','',10);
$y = 59; // AQUI EU COLOCO O Y INICIAL DOS DADOS 
$l=4; // ALTURA DA LINHA

$sql = "select * from enderecos_view where codigo =".$cod_cadastro; //SELECAO paciente
$statement = $pdo->prepare($sql);
$statement->execute();
$total = $statement->rowCount();
if($total==0){
	$pdf->SetFont('Arial','',12);
	$pdf->SetXY(5,40);
	$linhadet = '<span>** Sem Endereço **</span>';
	$pdf->Cell(0,15,utf8_decode($linhadet),0,0,'L') ;

}else{
	$pdf->SetLineWidth(0.3);
	while($row = $statement->fetch()) {	// ENQUANTO OS DADOS VÃO PASSANDO, O FPDF VAI INSERINDO OS DADOS NA PAGINA		
		$cod_cadastro = $row["codigo"];
		$nome = $row["nome"];
		$endereco = $row["tipolog"].' '.$row["rua"].', '.$row["numero"].' '.$row["complemento"];
		$cidade = $row["cidade"].'/'.$row["uf"];
	}

	//DADOS
	
	$pdf->SetFont('Arial','',12);
	$pdf->SetXY(10,40);
	$pdf->Cell(0,15,utf8_decode('Identificação do Paciente'),0,0,'L') ;
	$pdf->SetXY(10,45);
	$pdf->Cell(0,15,'Nome: '.utf8_decode($nome),0,0,'L') ;
	$pdf->SetXY(10,50);
	$pdf->Cell(0,15,utf8_decode('Endereço: '.$endereco),0,0,'L') ;
	$pdf->SetXY(10,55);
	$pdf->Cell(0,15,utf8_decode('Cidade: '.$cidade),0,0,'L') ;	
	$pdf->SetXY(50,70);
	// vai sublinhar o uso
	$pdf->SetFont('Arial','BU',12);	
	$pdf->Cell(0,15,utf8_decode('Atestado'),0,0,'L') ;
	$pdf->SetFont('Arial','',12);
	$pdf->SetXY(15,90);
	$string = "Atesto para os devidos fins, que o paciente acima referido deve ";
	$string2 = "permanecer em repouso absoluto por ____ dias."; 
	$pdf->Cell(0, 5,utf8_decode($string),0,0,"L") ;
	$pdf->SetXY(10,95);
	$pdf->Cell(0,5,utf8_decode($string2),0,0,'L') ;
	$pdf->SetXY(10,100);
	$pdf->Cell(0,15,utf8_decode('CID:_______'),0,0,'L') ;
	
	$pdf->Ln();
	}

$pdf->Output(); // IMPRIME O PDF NA TELA

?>




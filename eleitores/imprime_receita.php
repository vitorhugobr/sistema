<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a p&Aacute;gina
require_once('../utilitarios/funcoes.php');
require("../fpdf/fpdf.php");

$titulo = "Receituário";
define('FPDF_FONTPATH','../fpdf/font/');

////////////////////////////////////

class PDF extends FPDF
{
//variables of html parser
	
	function Header(){ //CABECALHO
		global $id; // EXEMPLO DE UMA VARIAVEL QUE TERÁ O MESMO VALOR EM QUALQUER ÁREA DO PDF.
		global $cod_cad;
		$id = $_GET["id"];
		//$cod_cad = $_GET["cod_cad"];
		$l=5; // DEFINI ESTA VARIAVEL PARA ALTURA DA LINHA
		$this->SetXY(5,5); // SetXY -> DEFINE O X E O Y NA PAGINA
		//$this->Rect(10,10,190,20); // CRIA UM RETÂNGULO QUE COMEÇA NO X = 10, Y = 10 E TEM 190 DE LARGURA E 280 DE ALTURA. NESTE CASO, É UMA BORDA DE PÁGINA.
		//$this->Image('../imagens/vhmo.png',11,8,30); // INSERE UMA LOGOMARCA NO PONTO X = 11, Y = 11, E DE TAMANHO 40.
		$l = 15;
		$this->SetFont('Arial','BI',14);

		$this->Rect(7,8,80,35);
		$this->Rect(157,8,80,35);

		$this->SetXY(13,5);
		$this->Cell(0,15,utf8_decode('Dr. Thiago Pereira Duarte'),0,0,'L'); // CRIA UMA CELULA COM OS SEGUINTES DADOS, RESPECTIVAMENTE: 
		$this->SetXY(163,5);
		$this->Cell(0,15,utf8_decode('Dr. Thiago Pereira Duarte'),0,0,'L'); // CRIA UMA CELULA COM OS SEGUINTES DADOS, RESPECTIVAMENTE: 
		$this->SetFont('Arial','',10);

		$this->SetXY(25,10);
		$this->Cell(0,15,utf8_decode('CREMERS 23.629'),0,0,'L'); // CRIA UMA CELULA COM OS SEGUINTES DADOS, RESPECTIVAMENTE: 
		$this->SetXY(175,10);
		$this->Cell(0,15,utf8_decode('CREMERS 23.629'),0,0,'L'); // CRIA UMA CELULA COM OS SEGUINTES DADOS, RESPECTIVAMENTE: 

		$this->SetFont('Arial','I',10);
		$this->SetXY(37,18);
		$this->Cell(0,15,utf8_decode('Médico'),0,0,'L'); // CRIA UMA CELULA COM OS SEGUINTES DADOS, RESPECTIVAMENTE: 
		$this->SetXY(187,18);
		$this->Cell(0,15,utf8_decode('Médico'),0,0,'L'); // CRIA UMA CELULA COM OS SEGUINTES DADOS, RESPECTIVAMENTE: 
			
		$this->SetFont('Arial','',10);
		$this->SetXY(17,23);
		$this->Cell(0,15,utf8_decode('Rua Dr. Cecílio Monza, 10755'),0,0,'L'); // CRIA UMA CELULA COM OS SEGUINTES DADOS, RESPECTIVAMENTE: 
		$this->SetXY(167,23);
		$this->Cell(0,15,utf8_decode('Rua Dr. Cecílio Monza, 10755'),0,0,'L'); // CRIA UMA CELULA COM OS SEGUINTES DADOS, RESPECTIVAMENTE: 

		$this->SetXY(15,28);
		$this->Cell(0,15,utf8_decode('Belém Novo - Fone: (51) 3259-5555'),0,0,'L'); // CRIA UMA CELULA COM OS SEGUINTES DADOS, RESPECTIVAMENTE: 
		$this->SetXY(165,28);
		$this->Cell(0,15,utf8_decode('Belém Novo - Fone: (51) 3259-5555'),0,0,'L'); // CRIA UMA CELULA COM OS SEGUINTES DADOS, RESPECTIVAMENTE: 

		$this->SetXY(30,33);
		$this->Cell(0,15,utf8_decode('Porto Alegre - RS'),0,0,'L'); // CRIA UMA CELULA COM OS SEGUINTES DADOS, RESPECTIVAMENTE: 
		$this->SetXY(180,33);
		$this->Cell(0,15,utf8_decode('Porto Alegre - RS'),0,0,'L'); // CRIA UMA CELULA COM OS SEGUINTES DADOS, RESPECTIVAMENTE: 


		//FINAL DO CABECALHO COM DADOS
	}
	function Footer() {
		$this->SetXY(84,180);
		$this->Cell(0,0,utf8_decode('Dr Thiago Pereira Duarte'),0,0,'L'); 
		$this->SetXY(100,183);
		$this->Cell(0,0,utf8_decode('Médico'),0,0,'L'); 
		$this->SetXY(90,186);
		$this->Cell(0,0,utf8_decode('CREMERS 23.629'),0,0,'L'); 

		$this->SetXY(230,180);
		$this->Cell(0,0,utf8_decode('Dr Thiago Pereira Duarte'),0,0,'L'); 
		$this->SetXY(246,183);
		$this->Cell(0,0,utf8_decode('Médico'),0,0,'L'); 
		$this->SetXY(236,186);
		$this->Cell(0,0,utf8_decode('CREMERS 23.629'),0,0,'L'); 

	}

}
$pdf=new PDF('L','mm','A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->SetTopMargin(5);
$pdf->SetTitle('Receita');
$pdf->AddPage(); // ADICIONA UMA PAGINA
$pdf->AliasNbPages(); // SELECIONA O NUMERO TOTAL DE PAGINAS, USADO NO RODAPE
$pdf->SetCreator("Sistema SIGRE") ;
$pdf->SetAuthor('Vitor H M Oliveira');
$pdf->SetFont('Arial','',10);
$y = 59; // AQUI EU COLOCO O Y INICIAL DOS DADOS 
$l=4; // ALTURA DA LINHA

$sql = "select * from receituario_view where id = ".$id; //SELECAO DOS DADOS QUE IRÃO PRO Pdf
$statement = $pdo->prepare($sql);
$statement->execute();
$total = $statement->rowCount();
if($total==0){
	$linhadet = '<span>** Sem Remédios **</span>';
}else{
	$pdf->SetLineWidth(0.3);
	while($row = $statement->fetch()) {	// ENQUANTO OS DADOS VÃO PASSANDO, O FPDF VAI INSERINDO OS DADOS NA PAGINA			
		$cod_cad = $row["cod_cadastro"];
		$data_receita = $row["data"]; // NESTE CASO, EU DECODIFIQUEI OS DADOS, POIS É UM CAMPO DE TEXTO.
		$nome = $row["nome"];
		$endereco = $row["tipolog"].' '.$row["rua"].', '.$row["numero"].' '.$row["complemento"];
		$cidade = $row["cidade"].'/'.$row["uf"];
		$tp_uso= $row["tp_uso"];
	}

	//DADOS
	
	$pdf->SetFont('Arial','',10);
	$pdf->SetXY(5,40);
	$pdf->Cell(0,15,utf8_decode('Identificação do Paciente'),0,0,'L') ;
	$pdf->SetXY(5,45);
	$pdf->Cell(0,15,'Nome: '.utf8_decode($nome),0,0,'L') ;
	$pdf->SetXY(5,50);
	$pdf->Cell(0,15,utf8_decode('Endereço: '.$endereco),0,0,'L') ;
	$pdf->SetXY(5,55);
	$pdf->Cell(0,15,utf8_decode('Cidade: '.$cidade),0,0,'L') ;	
	$pdf->SetXY(155,40);
	$pdf->Cell(0,15,utf8_decode('Identificação do Paciente'),0,0,'L') ;
	$pdf->SetXY(155,45);
	$pdf->Cell(0,15,'Nome: '.utf8_decode($nome),0,0,'L') ;
	$pdf->SetXY(155,50);
	$pdf->Cell(0,15,utf8_decode('Endereço: '.$endereco),0,0,'L') ;
	$pdf->SetXY(155,55);
	$pdf->Cell(0,15,utf8_decode('Cidade: '.$cidade),0,0,'L') ;		
	$pdf->SetXY(5,60);
	// vai sublinhar o uso
	$pdf->SetFont('Arial','BU',10);	
	if ($tp_uso==0){	
		$pdf->Cell(0,15,utf8_decode('Uso Interno'),0,0,'L') ;
		$pdf->SetX(155);
		$pdf->Cell(0,15,utf8_decode('Uso Interno'),0,0,'L') ;
	}else{
		$pdf->Cell(0,15,utf8_decode('Uso Externo'),0,0,'L') ;
		$pdf->SetX(155);
		$pdf->Cell(0,15,utf8_decode('Uso Externo'),0,0,'L') ;
	}
	$pdf->SetFont('Arial','B',10);
	
	// abaixo vai buscar os medicamentos da receita na tabela dados_receita
	$sql2 = "select * from dados_receita where cod_receita = ".$id; //SELECAO DOS DADOS QUE IRÃO PRO Pdf
	$statement2 = $pdo->prepare($sql2);
	$statement2->execute();
	$total2 = $statement2->rowCount();
	if($total2==0){
		$linhadet = '<span>** Sem Remédios **</span>';
	}else{
		$pdf->SetLineWidth(0.3);
		$linha=65;
		while($remedios = $statement2->fetch()) {	// ENQUANTO OS DADOS VÃO PASSANDO, O FPDF VAI INSERINDO OS DADOS NA PAGINA			
			$medicamento = $remedios['medicamento'];
			$qtde = $remedios['qtde'];
			$posologia = $remedios['posologia'];
			$pdf->SetXY(5,$linha);
			$linharemedio = str_pad($medicamento, 55 , "___");
			$pdf->Cell(0,15,utf8_decode($linharemedio).utf8_decode($qtde),0,0,'L') ;
			$pdf->SetX(155);
			$pdf->Cell(0,15,utf8_decode($linharemedio).utf8_decode($qtde),0,0,'L') ;
			$linha = $linha +5;
			$pdf->SetXY(10,$linha);
			$pdf->Cell(0,15,utf8_decode($posologia),0,0,'L') ;
			$pdf->SetX(160);
			$pdf->Cell(0,15,utf8_decode($posologia),0,0,'L') ;

			$linha = $linha +5;
		}
	}
	
//	$remedios = $pdf->WriteHTML($remedios);
//	$remedios = str_replace("Â","",$remedios);
// 	$pdf->MultiCell(120,5,utf8_encode($remedios),0);
//	
	$pdf->Ln();
	}

$pdf->Output(); // IMPRIME O PDF NA TELA

?>




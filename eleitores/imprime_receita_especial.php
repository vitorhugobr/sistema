<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a p&Aacute;gina
require_once('../utilitarios/funcoes.php');
require("../fpdf/fpdf.php");

$titulo = "Receituário Especial";
define('FPDF_FONTPATH','../fpdf/font/');


// classe a seguir é para imrimir table como texto comum
//function hex2dec
//returns an associative array (keys: R,G,B) from a hex html code (e.g. #3FE5AA)
function hex2dec($couleur = "#000000"){
    $R = substr($couleur, 1, 2);
    $rouge = hexdec($R);
    $V = substr($couleur, 3, 2);
    $vert = hexdec($V);
    $B = substr($couleur, 5, 2);
    $bleu = hexdec($B);
    $tbl_couleur = array();
    $tbl_couleur['R']=$rouge;
    $tbl_couleur['G']=$vert;
    $tbl_couleur['B']=$bleu;
    return $tbl_couleur;
}

//conversion pixel -> millimeter in 72 dpi
function px2mm($px){
    return $px*25.4/72;
}

function txtentities($html){
    $trans = get_html_translation_table(HTML_ENTITIES);
    $trans = array_flip($trans);
    return strtr($html, $trans);
}
////////////////////////////////////

class PDF extends FPDF {
	//variables of html parser
	protected $B;
	protected $I;
	protected $U;
	protected $HREF;
	protected $fontList;
	protected $issetfont;
	protected $issetcolor;


	function Header(){ //CABECALHO
		global $id; // EXEMPLO DE UMA VARIAVEL QUE TERÁ O MESMO VALOR EM QUALQUER ÁREA DO PDF.
		global $cod_cad;
		$id = $_GET["id"];
		//$cod_cad = $_GET["cod_cad"];
		$l=5; // DEFINI ESTA VARIAVEL PARA ALTURA DA LINHA

		$this->SetXY(5,5); // SetXY -> DEFINE O X E O Y NA PAGINA
		//$this->Rect(10,10,190,20); // CRIA UM RETÂNGULO QUE COMEÇA NO X = 10, Y = 10 E TEM 190 DE LARGURA E 280 DE ALTURA. NESTE CASO, É UMA BORDA DE PÁGINA.
		//$this->Image('../imagens/vhmo.png',11,8,30); // INSERE UMA LOGOMARCA NO PONTO X = 11, Y = 11, E DE TAMANHO 40.
		$this->SetFont('Arial','B',12); // DEFINE A FONTE ARIAL, NEGRITO (B), DE TAMANHO 8
		$tpreceita = str_pad('RECEITUÁRIO DE CONTROLE ESPECIAL', 100, " ", STR_PAD_BOTH); 
		$tpreceita = $tpreceita.$tpreceita;
		$this->Cell(0,15,utf8_decode('              RECEITUÁRIO DE CONTROLE ESPECIAL                                                               RECEITUÁRIO DE CONTROLE ESPECIAL'),0,0,'L'); // CRIA UMA CELULA COM OS SEGUINTES DADOS, RESPECTIVAMENTE: 
		// LARGURA = 0 - total, 
		// ALTURA = 15, 
		// TEXTO = 'INSIRA SEU TEXTO AQUI'
		// BORDA = 0. SE = 1 TEM BORDA SE 'R' = RIGTH, 'L' = LEFT, 'T' = TOP, 'B' = BOTTOM
		// QUEBRAR LINHA NO FINAL = 0 = NÃO
		// ALINHAMENTO = 'L' = LEFT
		$this->Ln(); // QUEBRA DE LINHA
		$this->Rect(10,15,80,40);
		$this->Rect(160,15,80,40);
		$l = 15;
		$this->SetFont('Arial','B',10);
		$this->SetXY(20,10);
		$this->Cell(0,15,utf8_decode('IDENTIFICAÇÃO DO EMITENTE'),0,0,'L'); // CRIA UMA CELULA COM OS SEGUINTES DADOS, RESPECTIVAMENTE: 
		$this->SetXY(100,20);
		$this->Cell(0,15,utf8_decode('1ª VIA - Farmácia'),0,0,'L'); // CRIA UMA CELULA COM OS SEGUINTES DADOS, RESPECTIVAMENTE: 
		$this->SetXY(100,30);	
		$this->Cell(0,15,utf8_decode('2ª VIA - Paciente'),0,0,'L'); // CRIA UMA CELULA COM OS SEGUINTES DADOS, RESPECTIVAMENTE: 
	// -------------------------------------2ªvia------------------------------------------------
		$this->SetXY(170,10);
		$this->Cell(0,15,utf8_decode('IDENTIFICAÇÃO DO EMITENTE'),0,0,'L'); // CRIA UMA CELULA COM OS SEGUINTES DADOS, RESPECTIVAMENTE: 
		$this->SetXY(245,20);
		$this->Cell(0,15,utf8_decode('1ª VIA - Farmácia'),0,0,'L'); // CRIA UMA CELULA COM OS SEGUINTES DADOS, RESPECTIVAMENTE: 
		$this->SetXY(245,30);
		$this->Cell(0,15,utf8_decode('2ª VIA - Paciente'),0,0,'L'); // CRIA UMA CELULA COM OS SEGUINTES DADOS, RESPECTIVAMENTE: 

		$this->SetFont('Arial','BI',12);
		// coluna e linha
		$this->SetXY(20,16);
		$this->Cell(0,15,utf8_decode('Dr. Thiago Pereira Duarte'),0,0,'L'); // CRIA UMA CELULA COM OS SEGUINTES DADOS, RESPECTIVAMENTE: 
		$this->SetXY(170,16);
		$this->Cell(0,15,utf8_decode('Dr. Thiago Pereira Duarte'),0,0,'L'); // CRIA UMA CELULA COM OS SEGUINTES DADOS, RESPECTIVAMENTE: 

		$this->SetFont('Arial','',10);
		$this->SetXY(30,22);
		$this->Cell(0,15,utf8_decode('CREMERS 23.629'),0,0,'L'); // CRIA UMA CELULA COM OS SEGUINTES DADOS, RESPECTIVAMENTE: 
		$this->SetXY(180,22);
		$this->Cell(0,15,utf8_decode('CREMERS 23.629'),0,0,'L'); // CRIA UMA CELULA COM OS SEGUINTES DADOS, RESPECTIVAMENTE: 

		$this->SetFont('Arial','I',10);
		$this->SetXY(40,30);
		$this->Cell(0,15,utf8_decode('Médico'),0,0,'L'); 
		$this->SetXY(190,30);
		$this->Cell(0,15,utf8_decode('Médico'),0,0,'L'); // CRIA UMA CELULA COM OS SEGUINTES DADOS, RESPECTIVAMENTE: 

		$this->SetFont('Arial','',10);
		$this->SetXY(22,37);
		$this->Cell(0,15,utf8_decode('Rua Dr. Cecílio Monza, 10755'),0,0,'L'); 
		$this->SetXY(172,37);
		$this->Cell(0,15,utf8_decode('Rua Dr. Cecílio Monza, 10755'),0,0,'L'); // CRIA UMA CELULA COM OS SEGUINTES DADOS, RESPECTIVAMENTE: 

		$this->SetXY(15,42);
		$this->Cell(0,15,utf8_decode('Fone (51) 3259-5555 - Porto Alegre - RS'),0,0,'L'); 
		$this->SetXY(165,42);
		$this->Cell(0,15,utf8_decode('Fone (51) 3259-5555 - Porto Alegre - RS'),0,0,'L'); 

		//FINAL DO CABECALHO COM DADOS
	}
	function Footer() {
		$this->SetXY(84,150);
		$this->Cell(0,0,utf8_decode('Dr Thiago Pereira Duarte'),0,0,'L'); 
		$this->SetXY(100,153);
		$this->Cell(0,0,utf8_decode('Médico'),0,0,'L'); 
		$this->SetXY(90,156);
		$this->Cell(0,0,utf8_decode('CREMERS 23.629'),0,0,'L'); 

		$this->SetXY(230,150);
		$this->Cell(0,0,utf8_decode('Dr Thiago Pereira Duarte'),0,0,'L'); 
		$this->SetXY(246,153);
		$this->Cell(0,0,utf8_decode('Médico'),0,0,'L'); 
		$this->SetXY(236,156);
		$this->Cell(0,0,utf8_decode('CREMERS 23.629'),0,0,'L'); 

		$this->Rect(5,165,80,32);
		$this->Rect(155,165,80,32);
		$this->SetFont('Arial','B',10);
		$this->SetXY(20,160);
		$this->Cell(0,15,utf8_decode('Identificação do Comprador'),0,0,'L'); // CRIA UMA CELULA COM OS SEGUINTES DADOS, RESPECTIVAMENTE: 
		$this->SetXY(170,160);
		$this->Cell(0,15,utf8_decode('Identificação do Comprador'),0,0,'L'); // CRIA UMA CELULA COM OS SEGUINTES DADOS, RESPECTIVAMENTE: 
		$this->SetFont('Arial','B',9);
		$this->SetXY(88,160);
		$this->Cell(0,15,utf8_decode('Identificação do Fornecedor'),0,0,'L'); // CRIA UMA CELULA COM OS SEGUINTES DADOS, RESPECTIVAMENTE: 
		$this->SetXY(235,160);
		$this->Cell(0,15,utf8_decode('Identificação do Fornecedor'),0,0,'L'); // CRIA UMA CELULA COM OS SEGUINTES DADOS, RESPECTIVAMENTE: 
		$this->SetXY(88,187);
		$this->SetFontSize(6); 
		$this->Cell(0,15,utf8_decode('Data ___/___/___   Assinatura do Farmacêutico'),0,0,'L'); 
		$this->SetXY(235,187);
		$this->Cell(0,15,utf8_decode('Data ___/___/___   Assinatura do Farmacêutico'),0,0,'L'); 
		$this->SetFontSize(8);
		$this->SetXY(8,170);
		$this->Cell(0,10,utf8_decode(str_pad('Nome:', 45 , "___")),0,0,'L'); 
		$this->SetXY(158,168);
		$this->Cell(0,15,utf8_decode(str_pad('Nome:', 45 , "___")),0,0,'L') ;
		$this->SetXY(8,175);
		$this->Cell(0,10,utf8_decode(str_pad('RG:____________________ Órg Emissor:', 47 , "___")),0,0,'L'); 
		$this->SetXY(158,173);
		$this->Cell(0,15,utf8_decode(str_pad('RG:____________________ Órg Emissor:', 47 , "___")),0,0,'L') ;
		$this->SetXY(8,180);
		$this->Cell(0,10,utf8_decode(str_pad('Endereço:', 47 , "___")),0,0,'L'); 
		$this->SetXY(158,178);
		$this->Cell(0,15,utf8_decode(str_pad('Endereço:', 47 , "___")),0,0,'L') ;
		$this->SetXY(8,185);
		$this->Cell(0,10,utf8_decode(str_pad('Cidade:__________________ UF:_____ Fone:', 47 , "___")),0,0,'L'); 
		$this->SetXY(158,183);
		$this->Cell(0,15,utf8_decode(str_pad('Cidade:__________________ UF:_____ Fone:', 47 , "___")),0,0,'L') ;
	}
}
$pdf=new PDF('L','mm','A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->SetTopMargin(5);
$pdf->SetTitle('Receita Especial');
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
		$data_receita = $row["data"]; 
		$nome = $row["nome"];
		$endereco = $row["tipolog"].' '.$row["rua"].', '.$row["numero"].' '.$row["complemento"];
        $cidade = $row["cidade"].'/'.$row["uf"];
		$tp_uso= $row["tp_uso"];
	}

	//DADOS
	$pdf->SetFont('Arial','',10);
	$pdf->SetXY(5,50);
	$pdf->Cell(0,15,utf8_decode('Identificação do Paciente'),0,0,'L') ;
	$pdf->SetXY(5,55);
	$pdf->Cell(0,15,'Nome: '.utf8_decode($nome),0,0,'L') ;
	$pdf->SetXY(5,60);
	$pdf->Cell(0,15,utf8_decode('Endereço: '.$endereco),0,0,'L') ;
    $pdf->SetXY(5,65);
    $pdf->Cell(0,15,utf8_decode('Cidade: '.$cidade),0,0,'L') ;
	$pdf->SetXY(155,50);
	$pdf->Cell(0,15,utf8_decode('Identificação do Paciente'),0,0,'L') ;
	$pdf->SetXY(155,55);
	$pdf->Cell(0,15,'Nome: '.utf8_decode($nome),0,0,'L') ;
	$pdf->SetXY(155,60);
	$pdf->Cell(0,15,utf8_decode('Endereço: '.$endereco),0,0,'L') ;
    $pdf->SetXY(155,65);
    $pdf->Cell(0,15,utf8_decode('Cidade: '.$cidade),0,0,'L') ;
	$pdf->SetXY(5,70);
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
		$linha=75;
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




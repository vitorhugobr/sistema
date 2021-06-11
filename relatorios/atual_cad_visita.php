<?php 

/* PARA IMPRIMIR CADASTROS INDIVIDUAIS POR RUA PARA ATUALIZAçÃO COLOCAR NA LINHA DA WWW -> http://www.luizbraz.com.br/sigre/relatorios/atual_cad_visita.php?rua=NOME DA RUA   onde 'rua' indica a rua a ser impressa, em ordem numérica e depois em ordem de complemento*/

session_start();

include('../connections/banco.php');

include('../utilitarios/phpmkrfn.php');

define('FPDF_FONTPATH','../fpdf/font/');

require_once("../fpdf/fpdf.php");		

$rua = $_GET["rua"];		 

	

$pdf=new FPDF();

$pdf->Open();

$_con  = new mysqli($_SESSION['servidor'],$_SESSION['usuario'],$_SESSION['senha'],$_SESSION$_con  = new mysqli($_SESSION['servidor'],$_SESSION['usuario'],$_SESSION['senha'],$_SESSION['banco']);

if(!$_con) {  

	echo "Não foi possivel conectar ao MySQL. Erro " .

			mysqli_connect_errno() . " : " . mysql_connect_error();

	exit;

}

// relatório Gerencial

$numnapag=0;

$numpag = 0;

//$_sql = 'SELECT c.CODIGO as codigo, c.NOME as nome, c.SEXO as sexo, c.DTNASC as dtnasc, c.FONE_RES as fone_res, c.FONE_CEL as fone_cel, c.FONE_COM as fone_com, c.EMAIL as email, c.GRUPO as grupo, c.ORIGEM as origem, c.PROFISSAO as profissao, c.ZONAL as zonal, c.SECCAO as seccao, c.PAI_MAE as pai_mae, c.FILIADO as filiado, c.RECEBEMAT as recebemat, c.VOTOU as votou, c.RAMO as ramo, c.RECEBEMAIL as recebemail, e.cep as cep, e.tipolog as tipolog, e.rua as rua, e.bairro as bairro, e.cidade as cidade, e.uf as uf, e.numero as numero, e.complemento as complemento, e.tipo as tipo, e.reg as reg, e.padrao as padrao, g.NOMEGRP as nomegrp, p.Descricao2 as nomeprof FROM ((cadastro AS c LEFT JOIN grupos AS g ON c.GRUPO = g.GRUPO) LEFT JOIN profissao as p ON c.PROFISSAO = p.Profissao) LEFT JOIN enderecos as e ON c.CODIGO = e.codigo WHERE e.padrao="S" and rua="'.$rua.'" and cidade = "PORTO ALEGRE" and bairro = "PARTENON" order by numero, complemento';



$_sql = 'SELECT c.CODIGO as codigo, c.NOME as nome, c.SEXO as sexo, c.DTNASC as dtnasc, c.FONE_RES as fone_res, c.FONE_CEL as fone_cel, c.FONE_COM as fone_com, c.EMAIL as email, c.GRUPO as grupo, c.ORIGEM as origem, c.PROFISSAO as profissao, c.ZONAL as zonal, c.SECCAO as seccao, c.PAI_MAE as pai_mae, c.FILIADO as filiado, c.RECEBEMAT as recebemat, c.VOTOU as votou, c.RAMO as ramo, c.RECEBEMAIL as recebemail, e.cep as cep, e.tipolog as tipolog, e.rua as rua, e.bairro as bairro, e.cidade as cidade, e.uf as uf, e.numero as numero, e.complemento as complemento, e.tipo as tipo, e.reg as reg, e.padrao as padrao, g.NOMEGRP as nomegrp, p.Descricao2 as nomeprof FROM ((cadastro AS c LEFT JOIN grupos AS g ON c.GRUPO = g.GRUPO) LEFT JOIN profissao as p ON c.PROFISSAO = p.Profissao) LEFT JOIN enderecos as e ON c.CODIGO = e.codigo WHERE e.padrao="S" and rua="'.$rua.'" and cidade = "PORTO ALEGRE" order by numero, complemento';



$_res = $_con->query($_sql);

$pdf->SetTitle('Cadastro Individual') ;

$pdf->SetAuthor('Vitor H M Oliveira');

$pdf->SetFillColor(170); 

$pdf->SetDrawColor(150);

if($_res->num_rows>0){

	$qtderows = $_res->num_rows;

	while($_row = $_res->fetch_assoc()) {

		$codigo = $_row["codigo"];

		$nome = $_row["nome"];

		$dtnasc = FormatDateTime($_row["dtnasc"],7);

		$fone_res = $_row["fone_res"];

		$fone_com = $_row["fone_com"];

		$fone_cel = $_row["fone_cel"];

		$tipolog = $_row["tipolog"];

		$sexo = $_row["sexo"];

		$rua = $_row["rua"];		

		$numero = $_row["numero"];

		$compl = $_row["complemento"];

		$bairro = $_row["bairro"];	

		$cidade = $_row["cidade"];

		$cep = substr($_row["cep"],0,5).'-'.substr($_row["cep"],5,3);

		$uf = $_row["uf"];

		$email = $_row["email"];

		$grupo = $_row["grupo"];

		$origem = $_row["origem"];

		$profissao = $_row["profissao"];

		$paimae = $_row["pai_mae"];

		$nomegrupo = $_row["nomegrp"];

		$zonal = $_row["zonal"];

		$seccao = $_row["seccao"];

		$tipo = $_row["tipo"];	

		$nomeprof = $_row["nomeprof"];

		$ender = $tipolog.' '.$rua.', '.$numero.' '.$compl.' '.$bairro.' '.$cep;

		$pdf->AddPage();

		$pdf->SetXY(5, 20);

		//                                col lin 

		$pdf->Image('../imagens/vhmo.jpg', 7, 10, 0, 7);

		$pdf->SetFont('Arial', 'B', 12);

		$pdf->Cell(80, 0, '<?php echo $_SESSION['sistemaabrev']?> - Ver Luiz Braz',0,0);

		$pdf->SetFont('Arial','', 12);

		$pdf->Cell(70, 0, 'Cadastro Individual',0,0);

		$pdf->SetFont('Arial','',9);

		$pdf->Cell(49, 0, 'Pag.'.$pdf->PageNo(), 0, 0,'R');

		//$pdf->ln(5);

		

		$pdf->SetLineWidth(0.5);

		$pdf->Line(7, 23, 203, 23);

		$pdf->ln(6);

		$pdf->SetFont('Arial','',12);

		$pdf->Cell(0, 0, 'Codigo......: '.$codigo.' Nome.....: '.$nome.'              Sexo.: '.$sexo, 0, 1);

		$pdf->ln(11);

		$pdf->Rect(34, 29, 169, 5,D);

		$pdf->Cell(0, 0, 'Data Nasc...: '.$dtnasc.'                Grupo....: '.$nomegrupo, 0, 1);

		$pdf->ln(4);

		$pdf->Rect(34, 40, 40, 5,D);

		$pdf->ln(8);

		$pdf->Cell(0, 0, 'Endereco....: '.$ender, 0, 1);

		$pdf->ln(4);

		$pdf->Rect(34, 51, 169, 5,D);

		$pdf->ln(6);

		$pdf->Cell(0, 0, 'Email.......: '.$email, 0, 1);

		$pdf->ln(4);

		$pdf->Rect(34, 62, 169, 5,D);

		$pdf->ln(7);

		$pdf->Cell(0, 0, 'Fone Res....: '.$fone_res.'      Fone Cml...: '.$fone_com.'      Fone Cel...: '.$fone_cel, 0, 1);

		$pdf->ln(4);

		$pdf->Rect(34, 73, 25, 5,D);

		$pdf->Rect(64, 73, 25, 5,D);

		$pdf->Rect(94, 73, 25, 5,D);

		$pdf->ln(7);

		$pdf->Cell(0, 0, 'Profissao:..: '.$nomeprof.'     Zonal...: '.$zonal.'       Seccao...:'.$seccao.'       Pai ou Mae...: '.$paimae, 0, 1);

		$pdf->ln(4);

		$pdf->Rect(34, 84, 25, 5,D);

		$pdf->Rect(64, 84, 25, 5,D);

		$pdf->Rect(94, 84, 25, 5,D);

		$pdf->Rect(124, 84, 10, 5,D);



		$pdf->ln(7);

		$pdf->Cell(0, 0, 'Observacoes', 0, 1);

		$pdf->ln(4);

		$pdf->Rect(10, 95, 190, 20,D);		

		$pdf->ln(22);

		$pdf->Cell(0, 0, 'Problemas da Regiao', 0, 1);

		$pdf->ln(4);

		$pdf->Rect(10, 122, 190, 20,D);		

		$pdf->ln(23);

		$pdf->Cell(0, 0, 'Sugestoes para o trabalho do Vereador', 0, 1);

		$pdf->ln(4);

		$pdf->Rect(10, 148, 190, 20,D);		

		$pdf->ln(23);

		$pdf->Cell(0, 0, 'Qual seu grau de satisfacao com o trabalho do Vereador - 1 (ruim) a 10 (excelente)', 0, 0);

		$pdf->Rect(170, 169, 10, 5,D);		

		$pdf->ln(7);

		$pdf->Cell(0, 0, 'Assiste ou conhece o programa "Comando da Cidade? Conhece         Assiste         Nao', 0, 0);

		$pdf->Rect(134, 176, 7, 5,D);		

		$pdf->Rect(158, 176, 7, 5,D);		

		$pdf->Rect(177, 176, 7, 5,D);		

		$pdf->ln(7);

		$pdf->Cell(0, 0, 'O que voce acha do programa?', 0, 1);

		$pdf->ln(4);

		$pdf->Rect(10, 190, 190, 20,D);		

		$pdf->ln(23);

		$pdf->Cell(0, 0, 'Sugestoes para o programa', 0, 1);

		$pdf->ln(4);

		$pdf->Rect(10, 216, 190, 20,D);		

		$pdf->ln(23);

		$pdf->Cell(0, 0, 'Ja votou no Vereador Luiz Braz?', 0, 0);

		$pdf->Rect(75, 237, 10, 5,D);		

		$pdf->ln(7);

		$pdf->Cell(0, 0, 'Voce votaria novamente no Vereador Luiz Braz?', 0, 0);

		$pdf->Rect(103, 244, 10, 5,D);		

		$pdf->ln(25);

		$pdf->Cell(0, 0, 'Entrevistador:                                     Data:', 0, 0);

		$pdf->Rect(38, 269, 35, 5,D);		

		$pdf->Rect(93, 269, 20, 5,D);		

	}

	$pdf->Output();	

}

?>?>
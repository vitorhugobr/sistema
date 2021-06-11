<?php 
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página

require_once("../fpdf/fpdf.php");
"use strict";
ob_start();
if (isset($_POST['chktodos']))
	$chktodos = $_POST['chktodos'];
else
	$chktodos = "";

if (isset($_POST['chkativos']))
	$chkativos = $_POST['chkativos'];
else
	$chkativos = "";
	
if (isset($_POST['chkinativos']))
	$chkinativos = $_POST['chkativos'];
else
	$chkinativos = "";

$tipo = $_POST['htipo'];
$opcao = $_POST['hopcao'];
$sistemaabrev = $_SESSION['sistemaabrev'];
$entidade=$_SESSION["politico"];
//echo $chktodos."<br>";
//echo $chkativos."<br>";
//echo $chkinativos."<br>";
define('FPDF_FONTPATH','../fpdf/font/');
if (!isset($opcao)){
	$opcao = 8;
}
class PDF extends FPDF
{
  function Header(){ //CABECALHO
	global $id; // EXEMPLO DE UMA VARIAVEL QUE TERÁ O MESMO VALOR EM QUALQUER ÁREA DO PDF.
	global $cod_cad;
	$l=5; // DEFINI ESTA VARIAVEL PARA ALTURA DA LINHA
	$this->SetXY(5,5); // SetXY -> DEFINE O X E O Y NA PAGINA
	//$this->Rect(10,10,190,20); // CRIA UM RETÂNGULO QUE COMEÇA NO X = 10, Y = 10 E TEM 190 DE LARGURA E 280 DE ALTURA. NESTE CASO, É UMA BORDA DE PÁGINA.
	$this->SetFont('Arial','B',12); // DEFINE A FONTE ARIAL, NEGRITO (B), DE TAMANHO 8
	$titulo = str_pad($_SESSION["politico"], 130, " ", STR_PAD_BOTH); 
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
	$this->Image('../imagens/'.$_SESSION['partido'].'.png', 7, 10, 0, 7);
	//$pdf->Image('../imagens/xxxxx.jpg', 180, 10, 0, 7);					
	$this->SetLeftMargin(55);
	
	//FINAL DO CABECALHO COM DADOS
  }
  function Footer() {
	//Vai para 1 cm do fundo da página
	$this->SetY(-10);
	//Seleciona Arial cursiva 8
	$this->SetFont('Arial','I',6);
	//Imprime o número da página atual e total
	$x = $this->GetX();
	$y = $this->GetY();

	 $this->Image('../imagens/vhmo.png',$x,$y-2,0,4); //

	$this->Cell(150,0,$_SESSION['sistemaabrev']." - ".utf8_decode($_SESSION['sistema']),0,0,"C");	
	$this->Cell(45,0,utf8_decode('Página. '.$this->PageNo()),0,0,'R');		  
  }
}

switch($opcao){
case 1:{
	// relatório Gerencial
	$numnapag=0;
	$numpag = 0;
	$numlin=99;
    $registros = 0;
	list ($_sql, $parametros) = monta_sql();    //retornam valores nestas duas variáveis da função #monta_sql()
//    $parametros="";
//	$_sql = 'SELECT 
//  month(cadastro.DTNASC) AS mes,
//  dayofmonth(`cadastro`.`DTNASC`) AS `dia`,
//  cadastro.CODIGO as codigo,
//  cadastro.NOME as nome,
//  cadastro.SEXO as sexo,
//  cadastro.DTCAD as dtcad,
//  cadastro.DTNASC as dtnasc,
//  cadastro.CARGO as cargo,
//  cadastro.FONE_RES as fone_res,
//  cadastro.FONE_CEL as fone_cel,
//  cadastro.FONE_COM as fone_com,
//  cadastro.CPF as cpf,
//  cadastro.CONDICAO as condicao,
//  cadastro.EMAIL as email,
//  cadastro.GRUPO as grupo,
//  cadastro.ORIGEM as origem,
//  cadastro.PROFISSAO as profissao,
//  cadastro.ZONAL as zonal,
//  cadastro.SECCAO as seccao,
//  cadastro.PAI_MAE as pai_mae,
//  cadastro.FILIADO as filiado,
//  cadastro.RECEBEMAT as recebemat,
//  cadastro.RESPCADASTRO as respcadastro,
//  cadastro.DTULTALT as dtultalt,
//  cadastro.EMPRESA as empresa,
//  cadastro.VOTOU as votou,
//  cadastro.RAMO as ramo,
//  cadastro.RECEBEMAIL as recebemail,
//  cadastro.IMPRESSO as impresso,
//  cadastro.ENVIADO as enviado,
//  cadastro.CAMPANHA as campanha,
//  cadastro.FACEBOOK as facebook,
//  cadastro.TWITTER as twitter,
//  cadastro.OUTRAREDE as outrarede,
//  cadastro.APELIDO as apelido,
//  cadastro.EST_CIVIL as est_civil,
//  cadastro.CLASSI as classi,
//  cadastro.OBS as obs,
//  enderecos.cep,
//  enderecos.tipolog,
//  enderecos.rua,
//  enderecos.bairro,
//  enderecos.cidade,
//  enderecos.uf,
//  enderecos.numero,
//  enderecos.complemento,
//  enderecos.padrao,
//  enderecos.tipo,
//  enderecos.reg,
//  origem.Descricao as desc_origem ,
//  grupos.NOMEGRP as desc_grupo,
//  grupos.GRUPO AS cod_grupo,
//  origem.Origem AS cod_origem
//FROM
//  cadastro
//  LEFT OUTER JOIN enderecos ON (cadastro.CODIGO = enderecos.codigo)
//  LEFT OUTER JOIN origem ON (cadastro.ORIGEM = origem.Origem)
//  LEFT OUTER JOIN grupos ON (cadastro.GRUPO = grupos.GRUPO) WHERE
//   (grupo > 1 and grupo < 22) 
//   OR (grupo > 47 and grupo < 61) 
//   OR grupo = 62 
//   OR grupo = 63 
//   OR grupo = 65 
//   OR (grupo > 67 and grupo < 76) 
//   OR (grupo > 77 and grupo < 97) 
//   OR grupo = 179 
//   OR grupo = 163 
//   OR grupo = 169 
//   OR grupo = 98 
//   OR grupo = 23 
//   OR grupo = 24 
//   order by  enderecos.rua, enderecos.numero,
//  enderecos.complemento';	
    #echo $_sql;
	if ($_sql==""){
		$_SESSION['msg'] = "<div class='alert alert-success' role='alert'>NENHUMA OPÇÃO INFORMADA<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		echo '<script>self.window.close();</script>';
	}
	$_res = $_con->query($_sql);
    if($_res->num_rows>0){
			$pdf=new PDF('P','mm','A4');
			$registros = $_res->num_rows;
			//$pdf->Open();
			$pdf->SetLeftMargin(10);
			$pdf->SetTitle(utf8_decode('Relatório Gerencial')) ;
			while($_row = $_res->fetch_assoc()) {
				$codigo = $_row["codigo"];
				$nome = $_row["nome"];
				if ($_row["dtnasc"]==NULL){
					$dtnasc="";
				}else{
					$dtnasc = date("d/m/Y", strtotime($_row["dtnasc"]));
				}					
				$fone_res = $_row["fone_res"];
				$fone_com = $_row["fone_com"];
				$fone_cel = $_row["fone_cel"];
				$tipolog = $_row["tipolog"];
				$rua = $_row["rua"];
				$numero = $_row["numero"];
				$compl = $_row["complemento"];
				$bairro = $_row["bairro"];	
				$cidade = $_row["cidade"];
				if ($_row['cep']===null){
					$cep="";
				}else{
					$cep = substr($_row["cep"],0,5).'-'.substr($_row["cep"],5,3);
				}
				$uf = $_row["uf"];
				$email = $_row["email"];
				$grupo = $_row["grupo"];
				$origem = $_row["origem"];
				$profissao = $_row["profissao"];
				if ($profissao===null)
					$profissao="";
				$paimae = $_row["pai_mae"];
				$nomegrupo = substr($_row["desc_grupo"], 0, 25);
				$nomeorigem = substr($_row["desc_origem"], 0, 25);
				if ($numlin > 63){					
					$numpag++; 
					$pdf->AddPage();
					$pdf->SetFont('Arial','B', 8);
					$pdf->Cell(100, 0, utf8_decode('Relatório Gerencial '),0,0,"C");
					$pdf->SetFont('Arial','', 6);
					$pdf->Cell(49, 0, date('d/m/Y'), 0, 0,'R');
					//$pdf->ln(5);
					$pdf->Line(3, 23, 203, 23);
					$pdf->SetLeftMargin(5);
					// Nome Data Nasc. Grupo Origem Prof. P/M				
					$pdf->SetFont('Courier', 'B', 8);
					$pdf->ln(5);
					$pdf->Cell(0, 0, utf8_decode(str_pad('Cód.',6)).str_pad('Nome',43).str_pad('Data Nasc.',11).str_pad('Grupo',26).str_pad('Origem',21), 0, 0);
					$pdf->ln(3);
					$pdf->Cell(91, 0, utf8_decode('Endereço'), 0, 0);
					$pdf->Cell(40, 0, 'Bairro', 0, 0);
					$pdf->Cell(40, 0, 'Cidade', 0, 0);
					$pdf->Cell(10, 0, 'UF', 0, 0);
					$pdf->Cell(20, 0, 'CEP', 0, 0,'L');
					$pdf->ln(3);
					$pdf->Cell(120, 0, 'E-mail',0,0,'L');
					$pdf->Cell(26, 0, 'Fone Residencial',0,0,'R');
					$pdf->Cell(26, 0, 'Fone Comercial',0,0,'R');
					$pdf->Cell(26, 0, 'Fone Celular',0,0,'R');
					$pdf->ln(3);
					$pdf->SetLineWidth(0.1);
					$pdf->Line(3, 34, 203, 34);
					$pdf->ln(3);			
					$numlin = 5;
				}			
				$pdf->SetFont('Courier', '', 8);
				$pdf->Cell(9, 0, $codigo, 0, 0,'R');
				$pdf->Cell(70, 0, utf8_decode($nome), 0, 0,'L');
				$pdf->Cell(19, 0, $dtnasc, 0, 0,'R');
				$pdf->Cell(45, 0, ' '.utf8_decode($nomegrupo), 0, 0,'L');
				$pdf->Cell(45, 0, utf8_decode($nomeorigem), 0, 0,'L');
				$pdf->ln(3);
				if ($rua <> '') {
					if ($numero<>""){
						$pdf->Cell(91, 0, $tipolog.' '.utf8_decode($rua).', '.$numero.' '.utf8_decode($compl), 0, 0);
					}else{
						$pdf->Cell(91, 0, $tipolog.' '.utf8_decode($rua).', '.utf8_decode($compl), 0, 0);
					}
				}else{
					$pdf->Cell(91, 0, ' ', 0, 0);
				}
				$pdf->Cell(40, 0, utf8_decode($bairro), 0, 0);
				$pdf->Cell(40, 0, utf8_decode($cidade), 0, 0);
				$pdf->Cell(7, 0, $uf, 0, 0);
				$pdf->Cell(20, 0, $cep, 0, 0,'R');
				$pdf->ln(3);
				$pdf->Cell(117, 0,$email,0, 0,'L');
				$pdf->Cell(29, 0,$fone_res,0,0,'L');
				$pdf->Cell(29, 0,$fone_com,0, 0,'L');
				$pdf->Cell(29, 0,$fone_cel,0, 0,'L');
				$pdf->ln(3);
				$x = $pdf->GetX();
				$y = $pdf->GetY();
				$pdf->SetLineWidth(0.1);
				$pdf->Line(3, $y, 203, $y);
				$pdf->ln(3);
				$numlin++; 	
				$numnapag++;
				if ($numnapag==20){
					$numnapag=0;
					$numlin=99;
				}		 
			}
			$pdf->ln(5);
			$pdf->SetFont('Arial', '', 6);
			$pdf->Cell(0, 0, "Total de registros listados = ".str_pad($registros,20),0, 0);
			$pdf->ln(3);
			$pdf->MultiCell(0,3, utf8_decode("Parâmetros : ".$parametros),0,'L',0);
			//$pdf->ln(3);
			//$pdf->MultiCell(0,3, utf8_decode("SQL : ".$_sql),0,'L',0);
			$pdf->Output();	
			ob_end_flush();
			$_SESSION['msg'] = "<div class='alert alert-success' role='alert'><i class='fas fa-check' aria-hidden='true text-muted' aria-hidden='true'></i> Relatório Gerencial criado com ".$_res->num_rows." registros<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";			
			echo '<script>self.window.close();</script>';
		}else{
			$_SESSION['msg'] = "<div class='alert alert-success' role='alert'>NENHUM REGISTRO SELECIONADO <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
			echo '<script>self.window.close();</script>';
		}
	break;
}
case 2:{
	break;
}
case 3:{
	// Etiqueta Geral
	$ebct = array();
	$etq = 0;   // esta variável controla se imprime na etiqueta esquerda ou direita. 0 = esquerda
	$qtdetq = 0;
	$tot_geral_reg = 0;
	//$_sql = montacep();
	list ($_sql, $parametros) = montacep();    //retornam valores nestas duas variáveis da função monta_sql()
	//echo $_sql;
//    $_sql="select 
//    month(`cadastro`.`DTNASC`) AS `mes`,
//    dayofmonth(`cadastro`.`DTNASC`) AS `dia`,
//    `enderecos`.`id` AS `id`,
//    `enderecos`.`cep` AS `cep`,
//    `enderecos`.`tipolog` AS `tipolog`,
//    `enderecos`.`rua` AS `rua`,
//    `enderecos`.`bairro` AS `bairro`,
//    `enderecos`.`cidade` AS `cidade`,
//    `enderecos`.`uf` AS `uf`,
//    `enderecos`.`numero` AS `numero`,
//    `enderecos`.`complemento` AS `complemento`,
//    `enderecos`.`padrao` AS `padrao`,
//    `enderecos`.`tipo` AS `tipo`,
//    `enderecos`.`reg` AS `reg`,
//    `cadastro`.`CODIGO` AS `codigo`,
//    `cadastro`.`NOME` AS `nome`,
//    `cadastro`.`SEXO` AS `sexo`,
//    `cadastro`.`DTNASC` AS `dtnasc`,
//    `cadastro`.`GRUPO` AS `grupo`,
//    `cadastro`.`ORIGEM` AS `origem`,
//    `cadastro`.`RECEBEMAT` AS `recebemat`,
//    `cadastro`.`PROFISSAO` AS `profissao`,
//    `cadastro`.`ZONAL` AS `zonal`,
//    `cadastro`.`SECCAO` AS `seccao`,
//    `cadastro`.`CAMPANHA` AS `campanha`,
//    `cadastro`.`CONDICAO` AS `condicao` 
//  from 
//    (`enderecos` left join `cadastro` on((`cadastro`.`CODIGO` = `enderecos`.`codigo`))) 
//  WHERE
//  (cadastro.CONDICAO = 1 and
//  (cadastro.GRUPO > 1 AND 
//  cadastro.GRUPO < 22) OR 
//  (cadastro.GRUPO > 47 AND 
//  cadastro.GRUPO < 61) OR 
//  cadastro.GRUPO = 62 OR 
//  cadastro.GRUPO = 63 OR 
//  cadastro.GRUPO = 65 OR 
//  (cadastro.GRUPO > 67 AND 
//  cadastro.GRUPO < 76) OR 
//  (cadastro.GRUPO > 77 AND 
//  cadastro.GRUPO < 97) OR 
//  cadastro.GRUPO = 179 OR 
//  cadastro.GRUPO = 163 OR 
//  cadastro.GRUPO = 169 OR 
//  cadastro.GRUPO = 98 OR 
//  cadastro.GRUPO = 23 OR 
//  cadastro.GRUPO = 24)
//ORDER BY
//  enderecos.reg,
//  cadastro.NOME";
	if ($_sql==""){
		$_SESSION['msg'] = "<div class='alert alert-success' role='alert'>NENHUMA OPÇÃO INFORMADA<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		echo '<script>self.window.close();</script>';
	}
	$_res = $_con->query($_sql);
	$tot_geral_reg = 0;
	$_anterior=0;
	if($_res->num_rows>0){
		$pdf=new FPDF();
		//$pdf->Open();
		$pdf->AddFont('ectpostnet');	
		$pdf->SetMargins(0.15,0.5);
		$pdf->SetTitle(utf8_decode('Etiquetas Cadastro')) ;
		$pdf->SetAutoPageBreak(true , 1.2);
		$pdf->AddPage();
	    $x = $pdf->GetX();
		$y = $pdf->GetY();
		$sety=14;
		$prilinha = 0;
		while($_row = $_res->fetch_assoc()) {
		  $codigo = $_row["codigo"];
		  $nome = $_row["nome"];
		  $tipolog = $_row["tipolog"];
		  $rua = $_row["rua"];		
		  $numero = $_row["numero"];
		  $compl = $_row["complemento"];
		  $bairro = $_row["bairro"];	
		  $cidade = $_row["cidade"];
		  $cep = substr($_row["cep"],0,5).'-'.substr($_row["cep"],5,3);
		  $uf = $_row["uf"];
		  $mes = $_row["mes"];
		  $dia = $_row["dia"];	
		  $reg = $_row["reg"];
		  $cep = $_row["cep"];
		  // neste array guardo o reg do correio para imprimir no final
		  if ($reg<>$_anterior){
			  $_anterior = $reg; 
			  $ebct[$reg] = 1;
		  }else{
			  if ((is_numeric($reg)) and ($reg<>0)){
			  	$ebct[$reg] = $ebct[$reg]+1;			  
			  }
		  }
		  $tot_geral_reg = $tot_geral_reg + 1;			  
		  $codbar_cep = $cep.monta_codbar($cep);
		  $codbar_cep = "/" . $codbar_cep;
		  $codbar_cep .= chr(92);	
		  $cep = substr($_row["cep"],0,5).'-'.substr($_row["cep"],5,3);	
		  if ($etq== 0 ){
			  $auxcodbar_cep = $codbar_cep;
			  $auxcod = $codigo;
			  $auxnome = $nome;
			  $auxtipolog = $tipolog;
			  $auxrua = $rua;
			  $auxnumero = $numero;
			  $auxcompl = $compl;
			  $auxbairro = $bairro;
			  $auxcidade = $cidade;
			  $auxcep = $cep;
			  $auxuf = $uf;
			  $auxdia = $dia;
			  $auxmes = $mes;
			  $auxreg = $reg;
			  $etq = 1;
		  }else{						
			  $pdf->SetFont('ectpostnet', '', 14);
			  if ($prilinha ==0 ){
					$sety = 15;					  
					$prilinha =1;
			  }else{
					$sety = $sety + 35;
			  }
			  $pdf->SetY($sety);
			  $pdf->Cell(8);
			  $pdf->Cell(60, 0, $auxcodbar_cep, 0, 0);	
			  $pdf->SetFont('Courier', '',8);
			  if ($auxdia>0){
				  $aniver_etq = "- ".$auxdia.'/'.$auxmes;
			  }else{
				  $aniver_etq="";
			  }
			  $pdf->Cell(20, 0, $auxcod.' '.$aniver_etq, 0, 0,'C');
			  $pdf->Cell(24, 0, '['.$auxreg.']', 0, 0);
			  $pdf->SetFont('ectpostnet', '', 14);
			  $pdf->Cell(60, 0, $codbar_cep, 0, 0);
			  $pdf->SetFont('Courier', '',8);
			  if ($dia>0){
				  $aniver_etq = "- ".$dia.'/'.$mes;
			  }else{
				  $aniver_etq="";
			  }
			  $pdf->Cell(20, 0, $codigo.' '.$aniver_etq, 0, 0,'C');
			  $pdf->Cell(24, 0, '['.$reg.']', 0, 1);
			  $pdf->ln(5);
			  $pdf->Cell(8);
			  $pdf->Cell(104, 0, utf8_decode($auxnome), 0, 0);
			  $pdf->Cell(104, 0, utf8_decode($nome), 0, 1);
			  $pdf->ln(5);
			  $pdf->Cell(8);
			  $pdf->SetFont('Courier', '',7);			  
			  $pdf->Cell(104, 0, $auxtipolog.' '.utf8_decode($auxrua).' '.$auxnumero.'  '.utf8_decode($auxcompl), 0, 0);
			  $pdf->Cell(104, 0,$tipolog.' '.utf8_decode($rua).' '.$numero.'  '.utf8_decode($compl), 0, 1);
			  $pdf->ln(5);
			  $pdf->Cell(8);
			  $pdf->SetFont('Courier', '',7);
			  $pdf->Cell(104, 0, utf8_decode($auxbairro).' '.utf8_decode($auxcidade).' '.$auxuf, 0, 0);
			  $pdf->Cell(104, 0, utf8_decode($bairro).' '.utf8_decode($cidade).' '.$uf, 0, 1);
			  $pdf->ln(5);
			  $pdf->Cell(8);
			  $pdf->Cell(104, 0,$auxcep, 0, 0);
			  $pdf->Cell(104, 0,$cep, 0, 1);
			  $pdf->ln(4);
			  $etq = 0;
			  $qtdetq++;
			  if ($qtdetq==8){  // qtde de etiquetas em cada coluna = 8. total 16 etq por pagina
					$pdf->AddPage();
					$pdf->SetX(0);
					$sety = 15;
					$pdf->SetY($sety);				
					$qtdetq = 0;
					$prilinha =0;
			  }else{				  
					// imprime duas linhas em branco
					$pdf->Cell(105, 0,'  ', 0, 1);
					$pdf->ln(5);
					$pdf->Cell(105, 0,'  ', 0, 1);
					$pdf->ln(4);
			  }
		  }
		}
		if ($etq ==1){
			  $pdf->SetFont('ectpostnet', '', 14);
			  if ($prilinha ==0 ){
				$sety = 15;					  
					$prilinha =1;
			  }else{
				$sety = $sety + 35;
			  }
			  $pdf->SetY($sety);
			  $pdf->Cell(8);
			  $pdf->Cell(60, 0, $auxcodbar_cep, 0, 0);	
			  $pdf->SetFont('Courier', '',8);
			  if ($auxdia>0){
				  $aniver_etq = "- ".$auxdia.'/'.$auxmes;
			  }else{
				  $aniver_etq="";
			  }
			  $pdf->Cell(25, 0, $auxcod.' '.$aniver_etq, 0, 0,'C');
			  $pdf->Cell(19, 0, '['.$auxreg.']', 0, 1);
			  $pdf->SetFont('Courier', '',8);
			  $pdf->ln(5);
			  $pdf->Cell(8);
			  $pdf->Cell(105, 0, utf8_decode($auxnome), 0, 1);
			  $pdf->ln(5);
			  $pdf->Cell(8);
			  $pdf->SetFont('Courier', '',7);
			  $pdf->Cell(105, 0, $auxtipolog.' '.utf8_decode($auxrua).' '.$auxnumero.'  '.$auxcompl, 0, 1);
			  $pdf->ln(5);
			  $pdf->Cell(8);
			  $pdf->SetFont('Courier', '',7);
			  $pdf->Cell(105, 0, utf8_decode($auxbairro).' '.utf8_decode($auxcidade).' '.$auxuf, 0, 1);
			  $pdf->ln(5);
			  $pdf->Cell(8);
			  $pdf->Cell(105, 0,$auxcep, 0, 1);
			  $pdf->ln(4);
		}
		$reg=999;
		$ebct[$reg] = 1;
		$pdf->AddPage();
		$pdf->SetX(0);
		$sety=15;
		$pdf->SetY($sety);
		$pdf->Cell(8);
		$etq = 0;
		$qtdetq=0;
		$descricao='';
		$prilinha = 0;
		$pdf->SetFont('Courier', 'B',8);
		foreach ($ebct as $i => $value) {
		  $chave = $i;
		  if ($i == 999){
			  $descricao = 'TOTAL DE ETIQUETAS IMPRESSAS = '.$tot_geral_reg;
		  }else{
			  if (is_int($i)){
				  $_sql2 = 'Select * from cdd where reg = '.$i;
				  //echo $_sql."<br>";
				  $_res2 = $_concomum->query($_sql2);
				  $total_num_rows = $_res->num_rows;
				  if ($tot_geral_reg>0){
					  while($_row2 = $_res2->fetch_assoc()) {
						  $descricao = $_row2["descricao"];
						  $qtd = "Quantidade de etiquetas: ".$ebct[$i];
					  }
				  }
			  }
		  }
		  if ($etq== 0 ){
			  $auxcod = $i;
			  $auxnome = $descricao;
			  $auxqtd = $qtd;
			  $etq = 1;
		  }else{						
			  if ($prilinha ==0 ){
				$sety = 15;					  
				$prilinha =1;
			  }else{
				$sety = $sety + 35;
			  }
			  $pdf->SetY($sety);
			  $pdf->Cell(8);
			  $pdf->Cell(105, 0, '['.$auxcod.']  '.utf8_decode($auxnome), 0, 0);
			  $pdf->Cell(50, 0, '['.$i.']  '.utf8_decode($descricao), 0, 1);
			  $pdf->ln(5);
			  $pdf->Cell(8);
			  $pdf->Cell(105, 0, utf8_decode($auxqtd), 0, 0);
			  $pdf->Cell(50, 0, utf8_decode($qtd), 0, 1);
			  $pdf->ln(5);
			  $etq = 0;
			  $qtdetq++;
			  if ($qtdetq==8){  // qtde de etiquetas em cada coluna = 8. total 16 etq por pagina
					$pdf->AddPage();
					$pdf->SetX(0);
					$sety = 15;
					$pdf->SetY($sety);				
					$qtdetq = 0;
					$prilinha =0;
			  }else{				  
					// imprime duas linhas em branco
					$pdf->Cell(105, 0,'  ', 0, 1);
					$pdf->ln(5);
					$pdf->Cell(105, 0,'  ', 0, 1);
					$pdf->ln(5);
			  }
		  }
		}
		if ($etq ==1){
			if ($prilinha ==0 ){
			  $sety = 15;					  
			  $prilinha =1;
			}else{
			  $sety = $sety + 35;
			}
			$pdf->SetY($sety);
			$pdf->Cell(8);
			$pdf->Cell(90, 0, '['.$auxcod.']  '.utf8_decode($auxnome), 0, 1);
			$pdf->ln(5);
			$pdf->ln(5);
		}	
		//$pdf->Cell(90, 0, utf8_decode($_sql), 0, 1);

		$pdf->Output();	
		ob_end_flush();
		$_SESSION['msg'] = "<div class='alert alert-success' role='alert'><i class='fas fa-check' aria-hidden='true text-muted' aria-hidden='true'></i> Etiquetas geradas com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";			
		echo '<script>self.window.close();</script>';
	}else{
		$_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Nenhuma etiqueta foi gerada. Nenhum registro satisfez a consulta<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		echo '<script>self.window.close();</script>';
	}
	break;
}
case 4:{
	// Carta Aniversário
	break;
}
case 5:{
	// Etiqueta Aniversario
	$etq = 0;   // esta variável controla se imprime na etiqueta esquerda ou direita. 0 = esquerda
	$qtdetq = 0;
	$_sql = monta_ani();
	$_res = $_con->query($_sql);
	$tot_geral_reg = 0;
	$_anterior=0;
	if($_res->num_rows>0){
		$pdf=new FPDF();
		//$pdf->Open();
		$pdf->AddFont('ectpostnet');	
		$pdf->SetMargins(0.15,0.5);
		$pdf->SetTitle(utf8_decode('Etiquetas Aniversário')) ;
		$pdf->SetAutoPageBreak(true , 1.2);
		$pdf->AddPage();
		$sety=15;
		$prilinha = 0;
		while($_row = $_res->fetch_assoc()) {
		  $codigo = $_row["codigo"];
		  $nome = $_row["nome"];
		  $tipolog = $_row["tipolog"];
		  $rua = $_row["rua"];		
		  $numero = $_row["numero"];
		  $compl = $_row["complemento"];
		  $bairro = $_row["bairro"];	
		  $cidade = $_row["cidade"];
		  $cep = substr($_row["cep"],0,5).'-'.substr($_row["cep"],5,3);
		  $uf = $_row["uf"];
		  $mes = $_row["mes"];
		  $dia = $_row["dia"];	
		  $reg = $_row["reg"];
		  $cep = $_row["cep"];
		  // neste array guardo o reg do correio para imprimir no final
		  if ($reg<>$_anterior){
			  $_anterior = $reg;
			  $ebct[$reg] = 1;
		  }
		  $tot_geral_reg = $tot_geral_reg + 1;			  
		  $codbar_cep = $cep.monta_codbar($cep);
		  $codbar_cep = "/" . $codbar_cep;
		  $codbar_cep .= chr(92);	
		  $cep = substr($_row["cep"],0,5).'-'.substr($_row["cep"],5,3);	
		  if ($etq== 0 ){
			  $auxcodbar_cep = $codbar_cep;
			  $auxcod = $codigo;
			  $auxnome = $nome;
			  $auxtipolog = $tipolog;
			  $auxrua = $rua;
			  $auxnumero = $numero;
			  $auxcompl = $compl;
			  $auxbairro = $bairro;
			  $auxcidade = $cidade;
			  $auxcep = $cep;
			  $auxuf = $uf;
			  $auxdia = $dia;
			  $auxmes = $mes;
			  $auxreg = $reg;
			  $etq = 1;
		  }else{						
			  $pdf->SetFont('ectpostnet', '', 14);
			  if ($prilinha ==0 ){
				$sety = 15;					  
					$prilinha =1;
			  }else{
				$sety = $sety + 35;
			  }
			  $pdf->SetY($sety);
			  $pdf->Cell(8);
			  $pdf->Cell(60, 0, $auxcodbar_cep, 0, 0);	
			  $pdf->SetFont('Courier', '',8);
			  $pdf->Cell(20, 0, $auxcod.'-'.$auxdia.'/'.$auxmes, 0, 0,'C');
			  $pdf->Cell(24, 0, '['.$auxreg.']', 0, 0);
			  $pdf->SetFont('ectpostnet', '', 14);
			  $pdf->Cell(60, 0, $codbar_cep, 0, 0);
			  $pdf->SetFont('Courier', '',8);
			  $pdf->Cell(20, 0, $codigo.'-'.$dia.'/'.$mes, 0, 0,'C');
			  $pdf->Cell(24, 0, '['.$reg.']', 0, 1);
			  $pdf->ln(5);
			  $pdf->Cell(8);
			  $pdf->Cell(104, 0, utf8_decode($auxnome), 0, 0);
			  $pdf->Cell(104, 0, utf8_decode($nome), 0, 1);
			  $pdf->ln(5);
			  $pdf->Cell(8);
			  $pdf->Cell(104, 0, $auxtipolog.' '.utf8_decode($auxrua).', '.$auxnumero.'  '.utf8_decode($auxcompl), 0, 0);
			  $pdf->Cell(104, 0,$tipolog.' '.utf8_decode($rua).' '.$numero.'  '.utf8_decode($compl), 0, 1);
			  $pdf->ln(5);
			  $pdf->Cell(8);
			  $pdf->Cell(104, 0, utf8_decode($auxcidade).' '.$auxuf, 0, 0);
			  $pdf->Cell(104, 0, utf8_decode($cidade).' '.$uf, 0, 1);
			  $pdf->ln(5);
			  $pdf->Cell(8);
			  $pdf->Cell(104, 0,$auxcep, 0, 0);
			  $pdf->Cell(104, 0,$cep, 0, 1);
			  $pdf->ln(5);
			  $etq = 0;
			  $qtdetq++;
			  if ($qtdetq==8){  // qtde de etiquetas em cada coluna = 8. total 16 etq por pagina
					$pdf->AddPage();
					$pdf->SetX(0);
					$sety = 15;
					$pdf->SetY($sety);				
					$qtdetq = 0;
					$prilinha =0;
			  }else{				  
					// imprime duas linhas em branco
					$pdf->Cell(105, 0,'  ', 0, 1);
					$pdf->ln(5);
					$pdf->Cell(105, 0,'  ', 0, 1);
					$pdf->ln(5);
			  }
		  }
		}
		if ($etq ==1){
			  $pdf->SetFont('ectpostnet', '', 14);
			  if ($prilinha ==0 ){
				$sety = 15;					  
					$prilinha =1;
			  }else{
				$sety = $sety + 35;
			  }
			  $pdf->SetY($sety);
			  $pdf->Cell(8);
			  $pdf->Cell(60, 0, $auxcodbar_cep, 0, 0);	
			  $pdf->SetFont('Courier', '',8);
			  $pdf->Cell(20, 0, $auxcod.'-'.$auxdia.'/'.$auxmes, 0, 0,'C');
			  $pdf->Cell(24, 0, '['.$auxreg.']', 0, 1);
			  $pdf->ln(5);
			  $pdf->Cell(8);
			  $pdf->Cell(104, 0, utf8_decode($auxnome), 0, 1);
			  $pdf->ln(5);
			  $pdf->Cell(8);
			  $pdf->Cell(104, 0, $auxtipolog.' '.utf8_decode($auxrua).' '.$auxnumero.'  '.utf8_decode($auxcompl), 0, 1);
			  $pdf->ln(5);
			  $pdf->Cell(8);
			  $pdf->Cell(104, 0, utf8_decode($auxcidade).' '.$auxuf, 0, 1);
			  $pdf->ln(5);
			  $pdf->Cell(8);
			  $pdf->Cell(104, 0,$auxcep, 0, 1);
			  $pdf->ln(5);
		}
		$reg=999;
		$ebct[$reg] = 1;
		$pdf->AddPage();
		$pdf->SetX(0);
		$sety=15;
		$pdf->SetY($sety);
		$pdf->Cell(8);
		$etq = 0;
		$qtdetq=0;
		$prilinha = 0;
		$pdf->SetFont('Courier', '',8);
		foreach ($ebct as $i => $value) {
		  $chave = $i;
		  if ($i == 999){
			  $descricao = 'TOTAL DE ETIQUETAS IMPRESSAS = '.$tot_geral_reg;
		  }else{
				$_sql = 'Select * from cdd where reg = '.$i;
				$_res = $_concomum->query($_sql);
				while($_row = $_res->fetch_assoc()) {
					$descricao = $_row["descricao"];
					$qtd = "Quantidade de etiquetas: ".$ebct[$i];
				}
		  }
		  if ($etq== 0 ){
			  $auxcod = $i;
			  $auxnome = $descricao;
  			  $auxqtd = $qtd;
			  $etq = 1;
		  }else{						
			  if ($prilinha ==0 ){
				$sety = 15;					  
				$prilinha =1;
			  }else{
				$sety = $sety + 35;
			  }
			  $pdf->SetY($sety);
			  $pdf->Cell(8);
			  $pdf->Cell(104, 0, '['.$auxcod.']  '.utf8_decode($auxnome), 0, 0);
			  $pdf->Cell(50, 0, '['.$i.']  '.utf8_decode($descricao), 0, 1);
			  $pdf->ln(5);
			  $pdf->Cell(8);
			  $pdf->Cell(104, 0, utf8_decode($auxqtd), 0, 0);
			  $pdf->Cell(50, 0, utf8_decode($qtd), 0, 1);
			  $pdf->ln(5);
			  $etq = 0;
			  $qtdetq++;
			  if ($qtdetq==8){  // qtde de etiquetas em cada coluna = 8. total 16 etq por pagina
					$pdf->AddPage();
					$pdf->SetX(0);
					$sety = 15;
					$pdf->SetY($sety);				
					$qtdetq = 0;
					$prilinha =0;
			  }else{				  
					// imprime duas linhas em branco
					$pdf->Cell(104, 0,'  ', 0, 1);
					$pdf->ln(5);
					$pdf->Cell(104, 0,'  ', 0, 1);
					$pdf->ln(5);
			  }
		  }
		}
		if ($etq ==1){
			if ($prilinha ==0 ){
			  $sety = 15;					  
			  $prilinha =1;
			}else{
			  $sety = $sety + 35;
			}
			$pdf->SetY($sety);
			$pdf->Cell(8);
			$pdf->Cell(90, 0, '['.$auxcod.']  '.utf8_decode($auxnome), 0, 1);
			$pdf->ln(5);
			$pdf->ln(5);
		}								
		$pdf->Output();	
		ob_end_flush();
		$_SESSION['msg'] = "<div class='alert alert-success' role='alert'><i class='fas fa-check' aria-hidden='true text-muted' aria-hidden='true'></i> Etiquetas de Aniversários geradas com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";			
		echo '<script>self.window.close();</script>';
		
	}else{
		$_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>NENHUMA ETIQUETA GERADA<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		echo '<script>self.window.close();</script>';
	}
	break;
}
case 6:{
	// relatório Aniversariantes do dia
	$numnapag=0;
	$numpag = 0;
	$numlin=99;
	$_sql = monta_ani();	
	$_res = $_con->query($_sql);
	if($_res->num_rows>0){
		$registros = $_res->num_rows;
		$pdf=new PDF();
		$pdf->SetTitle(utf8_decode('Relatório Aniversariantes de '.$_POST['txtdia'].' a '.$_POST['txtdiaf'].'/'.$_POST['txtmes'])) ;
		$pdf->AddFont('ectpostnet');	
		while($_row = $_res->fetch_assoc()) {
			$codigo = $_row["codigo"];
			$nome = $_row["nome"];
			$dtnasc = date("d/m/Y", strtotime($_row["dtnasc"]));
			$fone_res = $_row["fone_res"];
			$fone_com = $_row["fone_com"];
			$fone_cel = $_row["fone_cel"];
			$tipolog = $_row["tipolog"];
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
			$descgrupo =  utf8_decode(substr($_row["desc_grupo"],0,27));
			$tipo = $_row["tipo"];				
			if ($numlin > 60){					
				$numpag++; 
				$pdf->AddPage();
				$pdf->SetLeftMargin(10);
				$pdf->SetXY(5, 20);
				//                                col lin 
				$pdf->SetFont('Arial','B', 10);
				$pdf->Cell(150, 0, 'Aniversariantes de '.$_POST['txtdia'].' a '.$_POST['txtdiaf'].'/'.$_POST['txtmes'],0,0,'C');
				$pdf->SetFont('Arial','B',6);
				$pdf->Cell(49, 0, date('d/m/Y'), 0, 0,'R');
				$pdf->ln(5);
				$pdf->SetLineWidth(0.5);
				$pdf->Line(7, 23, 203, 23);
				$pdf->SetFont('Courier', 'B', 8);
				// Nome Data Nasc. Grupo Origem Prof. P/M				
				$pdf->Cell(11, 0, utf8_decode('Código'), 0, 0);
				$pdf->Cell(61, 0, 'Nome', 0, 0);
				$pdf->Cell(19, 0, 'Data Nasc.', 0, 0);
				$pdf->Cell(42, 0, 'Grupo', 0, 0);
				#$pdf->Cell(35, 0, '', 0,0 );
				$pdf->Cell(21, 0, 'Fone Res', 0,0 );
				$pdf->Cell(21, 0, 'Fone Com', 0,0 );
				$pdf->Cell(21, 0, 'Fone Cel', 0, 0);
				$pdf->ln(3);
				$pdf->Cell(5);
				$pdf->Cell(110, 0, utf8_decode('Endereço'), 0, 0);
				$pdf->Cell(30, 0, 'Bairro', 0, 0);
				$pdf->Cell(25, 0, 'Cidade', 0, 0);
				$pdf->Cell(7, 0, 'UF', 0, 0);
				$pdf->Cell(20, 0, 'CEP', 0, 0);
				$pdf->ln(3);
				$pdf->Cell(0, 0, 'E-mail', 0, 1);
				$pdf->ln(3);
				$pdf->SetLineWidth(0.1);
				$pdf->Line(7, 33, 203, 33);
				$pdf->ln(3);			
				$numlin = 5;
			}			
			$pdf->SetFont('Courier', '', 8);
			$pdf->Cell(11, 0, $codigo, 0, 0,'R');
			$pdf->Cell(66, 0, utf8_decode($nome), 0, 0);
			$pdf->Cell(12, 0, $dtnasc, 0, 0,'R');
			#$pdf->Cell(5, 0, utf8_decode($grupo), 0, 0);
			$pdf->Cell(42, 0, $descgrupo, 0, 0);   
			$pdf->Cell(21, 0, $fone_res, 0,0,'R');
			$pdf->Cell(21, 0, $fone_com, 0,0,'R');
			$pdf->Cell(21, 0, $fone_cel, 0, 0,'R');
			$pdf->ln(3);
			$pdf->Cell(5);
			$pdf->Cell(110, 0, $tipolog.' '.utf8_decode($rua).', '.$numero.' '.utf8_decode($compl), 0, 0);
			$pdf->Cell(30, 0, utf8_decode($bairro), 0, 0);
			$pdf->Cell(25, 0, utf8_decode($cidade), 0, 0);
			$pdf->Cell(4, 0, $uf, 0, 0);
			$pdf->Cell(20, 0, $cep, 0, 1,'R');
			$pdf->ln(3);
			$pdf->Cell(5);
			$pdf->Cell(0, 0, $email, 0, 1);
			$pdf->ln(3);
			$x = $pdf->GetX();
			$y = $pdf->GetY();
			$pdf->SetLineWidth(0.1);
			$pdf->Line(7, $y-1, 203, $y-1);
			$pdf->ln(3);
			$numlin++; 	
			$numnapag++;
			if ($numnapag==19){
				$numnapag=0;
				$numlin=99;
			}		 
		}
		$numlin = $numlin + 5;
		$pdf->SetFont('Arial','B', 10);
		$pdf->ln(5);
		$pdf->Cell(0, 0, "Total aniversariantes ".str_pad($registros,60),0, 0);
		$pdf->Output();	
		ob_end_flush();
		$_SESSION['msg'] = "<div class='alert alert-success' role='alert'><i class='fas fa-check' aria-hidden='true text-muted' aria-hidden='true'></i> Relatório Aniversariantes de ".$_POST['txtdia']." a ".$_POST['txtdiaf'].'/'.$_POST['txtmes']." gerado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";			
		echo '<script>self.window.close();</script>';		
	}else{
		$_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>NENHUM aniversariante no período indicado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		echo '<script>self.window.close();</script>';			}
	break;
}
case 7:{   // Relatório de demandas 
	$numpag = 0;
	$numlin=99;
	$QRel = $_POST['hPV'];
	$datai = $_POST['txtdatai'];
	$dataf = $_POST['txtdataf'];
	$radiosituacao = $_POST['radiosituacao'];
	if(isset($_POST['chkResp']))	{
		$incresposta = true; 
	}
	else 	{
		$incresposta = false;
	}	
	if ($datai == ""){
		$datai = "01/01/1980";
	}
	if ($dataf == ""){
		$dataf = date("d/m/Y");
	}
	$dataini = $datai;
	$datafim = $dataf;
	$datai = date("d/m/Y", strtotime($datai));
	$dataf = date("d/m/Y", strtotime($dataf));
	if ($radiosituacao==3){    //todas
		$_sql='SELECT * FROM demandas_view WHERE `data` BETWEEN "'.$dataini.'" AND "'.$datafim.'" order by data desc';		
	}else{
		$_sql='SELECT * FROM demandas_view WHERE `data` BETWEEN "'.$dataini.'" AND "'.$datafim.'" AND situacao = '.$radiosituacao.' order by data desc';		
	}
	$_res = $_con->query($_sql);
	//echo $datai." - ".$dataf." - ".$_sql;
	if($_res->num_rows>0){
		$pdf=new PDF();
		//s$pdf->AddPage();
		$pdf->SetTitle(utf8_decode('Relatório de Demandas')) ;
		$pdf->AddFont('ectpostnet');
		$data_cab = "<i class='fas fa-sort-down'></i>Data";

		while($_row = $_res->fetch_assoc()) {
			$codigo = $_row["CODIGO"];
			$nome = $_row["nome"];
			$fone_res = $_row["FONE_RES"];
			$fone_com = $_row["FONE_COM"];
			$fone_cel = $_row["FONE_CEL"];
			$grupo = substr($_row["GRUPO"], 0, 22);
			$nomegrupo = substr($_row["NOMEGRP"], 0, 22);
			$numero = $_row["numero"];
			$dtdemanda = date("d/m/Y", strtotime($_row["data"]));
			$assunto = busca_secretaria($_row["assunto"]);
			$situacao = $_row["situacao"];
			$descricao = $_row["descricao"];
			$linha = $pdf->GetY();

			if (($numpag ==0) OR ($linha>250)){
				$numpag++; 
				$pdf->AddPage();
				$pdf->SetFont('Arial','B', 8);
				if ($incresposta) {
					$pdf->Cell(100, 0, utf8_decode('Relatório de Demandas com Respostas entre ').$datai.' e '.$dataf,0,0,'C');
				}else{
					$pdf->Cell(100, 0, utf8_decode('Relatório de Demandas  entre ').$datai.' e '.$dataf,0,0,'C');
				}
				$pdf->SetFont('Arial','', 6);
				$pdf->Cell(49, 0, date('d/m/Y'), 0, 0,'R');
				$pdf->Line(3, 23, 203, 23);
				
				$pdf->SetLeftMargin(5);
				// Nome Data Nasc. Grupo Origem Prof. P/M				
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->ln(5);
								
				$pdf->Cell(11, 0, utf8_decode('# Cad.'), 0, 0,'L');
				$pdf->Cell(75, 0, 'Nome', 0, 0);
				$pdf->Cell(5, 0, 'Grupo', 0, 0);
				$pdf->Cell(46, 0, '', 0,0 );
				$pdf->Cell(15, 0, 'Fone Res', 0,0 );
				$pdf->Cell(15, 0, 'Fone Com', 0,0 );
				$pdf->Cell(15, 0, 'Fone Cel', 0, 0);
				$pdf->Cell(17, 0, 'Demanda', 0, 0,'R');
				$pdf->ln(3);
				$pdf->Cell(2);
				$pdf->Cell(15, 0, $data, 0, 0);
				$pdf->Cell(40, 0, 'Assunto', 0, 0);
				$numlin = 5;
				$pdf->ln(3);
				//$pdf->Cell(2);
				$pdf->Cell(18, 0, utf8_decode('Situação'), 0, 0);
				$pdf->Cell(40, 0, utf8_decode('Descrição'), 0, 0);
				$numlin = 6;
				$pdf->ln(3);
			}			
			$pdf->ln(3);
			$pdf->SetLineWidth(0.1);
			$pdf->Line(3, 34, 203, 34);
			$pdf->SetFont('Arial', '', 8);
			$pdf->Cell(11, 0, $codigo, 0, 0,'L');
			$pdf->Cell(82, 0, utf8_decode($nome), 0, 0);
			$pdf->Cell(5, 0, $grupo, 0, 0);
			$pdf->Cell(38, 0, utf8_decode($nomegrupo), 0, 0);   //22 espaços
			$pdf->Cell(15, 0, $fone_res, 0,0,'L');
			$pdf->Cell(15, 0, $fone_com, 0,0,'L');
			$pdf->Cell(17, 0, $fone_cel, 0, 0,'L');
			$pdf->Cell(15, 0, str_pad($numero,5,"0", STR_PAD_LEFT), 0, 0,'R');
			$pdf->ln(2);
			$pdf->SetFont('Arial', '', 8);
			$pdf->Cell(2);
			$pdf->SetFont('Arial', 'B', 8);
			$pdf->Cell(15, 4, $dtdemanda, 0, 0,'R');
			$pdf->SetFont('Arial', '', 8);
			$pdf->MultiCell(0, 4, utf8_decode($assunto),0,1) ;
			if ($situacao==0){
				$situacao="Aberta";
			}else{
				if ($situacao==1){
					$situacao="Respondida";
				}else{
					$situacao="Encerrada";
				}
			}
			$pdf->SetFont('Arial', 'IU', 8);
			$pdf->Cell(18, 4, $situacao, 0, 0,'L');
			$pdf->SetFont('Arial', '', 8);
			$pdf->MultiCell(0, 4,utf8_decode($descricao),0,1,0,"J") ;
			if ($incresposta){     // vai buscar as resposta no arquivo
				$_sql2='SELECT * FROM historico_encaminhamentos WHERE numero = '.$numero.' order by data desc';
				$_res2 = $_con->query($_sql2);
				//$pdf->ln(3);				
				if($_res2->num_rows>0){
					while($data = $_res2->fetch_assoc()) {
						$data_resp = date("d/m/Y", strtotime($data["data"]));
						$pdf->Cell(10);
						$pdf->Cell(15, 4, 'Data Resposta', 0, 0,'R');
						$pdf->Cell(0, 4,utf8_decode($data_resp)." por ".$data['usuario'],0,1) ;
						//$pdf->ln(3);				
						$pdf->Cell(10);
						$pdf->Cell(15, 4, 'Resposta', 0, 0,'R');
						$pdf->MultiCell(0, 4,utf8_decode(strtoupper($data['retorno'])),0,1,0,"J") ;
						$numlin++; 	
						$linha = $pdf->GetY();
						if ($linha > 250){
							$numpag++; 
							$pdf->AddPage();
							$pdf->SetFont('Arial','B', 8);
							if ($incresposta) {
								$pdf->Cell(100, 0, utf8_decode('Relatório de Demandas com Respostas entre ').$datai.' e '.$dataf,0,0,'C');
							}else{
								$pdf->Cell(100, 0, utf8_decode('Relatório de Demandas  entre ').$datai.' e '.$dataf,0,0,'C');
							}
							$pdf->SetFont('Arial','', 6);
							$pdf->Cell(49, 0, date('d/m/Y'), 0, 0,'R');
							$pdf->Line(3, 23, 203, 23);

							$pdf->SetLeftMargin(5);
							// Nome Data Nasc. Grupo Origem Prof. P/M				
							$pdf->SetFont('Arial', 'B', 8);
							$pdf->ln(5);

							$pdf->Cell(11, 0, utf8_decode('# Cad.'), 0, 0,'L');
							$pdf->Cell(75, 0, 'Nome', 0, 0);
							$pdf->Cell(5, 0, 'Grupo', 0, 0);
							$pdf->Cell(46, 0, '', 0,0 );
							$pdf->Cell(15, 0, 'Fone Res', 0,0 );
							$pdf->Cell(15, 0, 'Fone Com', 0,0 );
							$pdf->Cell(15, 0, 'Fone Cel', 0, 0);
							$pdf->Cell(17, 0, 'Demanda', 0, 0,'R');
							$pdf->ln(3);
							$pdf->Cell(2);
							$pdf->Cell(15, 0, $data, 0, 0);
							$pdf->Cell(40, 0, 'Assunto', 0, 0);
							$numlin = 5;
							$pdf->ln(3);
							//$pdf->Cell(2);
							$pdf->Cell(18, 0, utf8_decode('Situação'), 0, 0);
							$pdf->Cell(40, 0, utf8_decode('Descrição'), 0, 0);
							$numlin = 6;
							$pdf->ln(3);
						}
					}
				}else{
					
				}
			}
			$x = $pdf->GetX();
			$y = $pdf->GetY();
			$pdf->SetLineWidth(0.1);
			$pdf->Line(3, $y, 203, $y);
			$numlin++; 	
			if ($y>250){
				$linha=299;
			}		 
				
		}	
		$pdf->Output();
		ob_end_flush();
		$_SESSION['msg'] = "<div class='alert alert-success' role='alert'><i class='fas fa-check' aria-hidden='true text-muted' aria-hidden='true'></i>Relatório Demandas gerado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";			
		echo '<script>self.window.close();</script>';
		
	}else{
		$_SESSION['msg'] = "<div class='alert alert-warning' role='alert'><i class='fas fa-check' aria-hidden='true text-muted' aria-hidden='true'></i>Nenhuma  Demanda encontrada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		echo '<script>self.window.close();</script>';

	}
	break;
}	
case 8:{
	// exportar Excel
	$_SESSION['funcao']="Exportar Excel";

	list ($_sql, $parametros) = monta_sql();    //retornam valores nestas duas variáveis da função monta_sql()
	$_res = $_con->query($_sql);
	if($_res->num_rows>0){
		$arquivo = 'dados_cad.xls';
		$tabela = '<table border="1">';
		$tabela .= '<tr>';
		$tabela .= '<td>Tratamento</td>';
		$tabela .= '<td>Empresa/Nome(linha 1)</td>';
		$tabela .= '<td>Empresa/Nome(linha 2)</td>';
		$tabela .= '<td>Caixa Postal</td>';
		$tabela .= utf8_decode('<td>Endereço</td>');
		$tabela .= utf8_decode('<td>Número/Lote</td>');
		$tabela .= '<td>Complemento</td>';
		$tabela .= '<td>Bairro</td>';
		$tabela .= '<td>Cidade</td>';
		$tabela .= '<td>UF</td>';
		$tabela .= '<td>E-mail</td>';
		$tabela .= '<td>Telefone</td>';
		$tabela .= '<td>Fax</td>';
		$tabela .= '<td>CEP Caixa Postal</td>';
		$tabela .= '<td>CEP</td>';
		$tabela .= '</tr>';	$_res = $_con->query($_sql);
		while($_row = $_res->fetch_assoc()) {
			$nome = $_row["nome"];
			$tipolog = $_row["tipolog"];
			if ($tipolog ===null)
				$tipolog="";
			$rua = $_row["rua"];
			if ($rua===null)
				$rua="";
			$numero = $_row["numero"];
			if ($numero===null)
				$numero="";
			if ($numero===0)
				$numero="";
			$compl = $_row["complemento"];
			if ($compl===null)
				$compl="";
			$bairro = $_row["bairro"];	
			if ($bairro===null)
				$bairro="";
			$cidade = $_row["cidade"];
			$fone = $_row["fone_cel"];
			if ($cidade===null)
				$cidade="";
			if ($_row['cep']===null){
				$cep="";
			}else{
				$cep = substr($_row["cep"],0,5).'-'.substr($_row["cep"],5,3);
			}
			$uf = $_row["uf"];
			if ($uf===null)
				$uf="";
			$email = $_row["email"];
			if ($email===null)
				$email="";
			$tabela .= '<tr><td></td>';
			$tabela .= '<td>'.utf8_decode($nome).'</td>';
			$tabela .= '<td></td><td></td>';
			$tabela .= '<td>'.$tipolog.' '.$rua.'</td>';
			$tabela .= '<td>'.$numero.'</td><td>'.utf8_decode($compl).'</td>';
			$tabela .= '<td>'.utf8_decode($bairro).'</td>';
			$tabela .= '<td>'.utf8_decode($cidade).'</td>';
			$tabela .= '<td>'.$uf.'</td>';
			$tabela .= '<td>'.$email.'</td>';
			$tabela .= '<td>'.$fone.'</td>';
			$tabela .= '<td></td><td></td>';
			$tabela .= '<td>'.$cep.'</td>';
			$tabela .= '</tr>';
		}
		$tabela .= '</table>';
		header('Content-Type: text/csv; charset=utf-8');
		header ('Cache-Control: no-cache, must-revalidate');
		header ('Pragma: no-cache');
		header ("Content-Disposition: attachment; filename=\"{$arquivo}\"");
		echo $tabela;
	}else{
		$_SESSION['msg'] = "<div class='alert alert-success' role='alert'>NENHUM REGISTRO SELECIONADO<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		#echo '<script>self.window.close();</script>';
	}
	break;
}case 9:{
	break;
}
default:
	echo '<script>alert("'.$opcao.'");self.window.close();</script>';
	break;
}
//=================================================================================================================================
function monta_sql(){
	// setup variables
	$linha=1;
	$primwhere=0;	
	$qtde_param=0;
	$qtde_or=0;
	$primorderby=0;
	$stringWhere = "(";    // variável que conterá a string para o WHERE
	$strwhere= array();		// array para montar os critérios do where
	$strorderby="";
	$parametros="";   // variável criada para retornar os critérios da consulta e ser impressoao final do relatório
	$jatemnome=false;
	$jatemcampanha=false;
	$jatemorigem=false;
	$jatemgrupo=false;
	$jatemprofissao=false;
	$jatemramo=false;
	$jatemseccao=false;
	$jatemzonal=false;
	$jatemrua=false;
	$jatemcidade=false;
	$jatembairro=false;
	$jatemnumero=false;
	$jatemcomplemento=false;
	$jatemrecebemat=false;

	while ($linha < 13) {
		$varcampo = $_POST["campo".$linha];
		$varoperador = $_POST["operador".$linha];
		$varexpressao = $_POST["valorexpressao".$linha];
		
		if (isset($_POST["textoexpressao".$linha])){
			$varconteudoexp = $_POST["textoexpressao".$linha];
		}else{
			$varconteudoexp = "";			
		}
		$varconector = $_POST["conector".$linha];
		$varclassifica = $_POST["classifica".$linha];
		$strconector= "";
		if ($varcampo <> "") {
			$qtde_param++;
			
			if ($primwhere == 0){
				$primwhere = 1;
				$stringWhere ="(";
			}
			if ($varoperador == "like") {
				$varexpressao = "%" . $varexpressao . "%";				
			}
			if ($varcampo == "nome" || $varcampo == "cidade" || $varcampo == "rua" || $varcampo == "bairro" || $varcampo == "complemento"){
				$varexpressao= "'" . $varexpressao . "'";				
			}
			if ($varcampo == "grupo" || $varcampo == "origem"){
				$varcampo= "cadastro." . $varcampo;				
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
			//echo $stringWhere.'<br>';
			if ($varclassifica <> "") {
				$compoesort=false;
				switch ($varcampo) {
					case "nome":
						if ($jatemnome==false){
							$compoesort=true;
							$jatemnome = true;
					}
						break;
					case "campanha":
						if ($jatemcampanha==false){
							$jatemcampanha=true;
							$compoesort=true;
						}
						break;
					case "cadastro.grupo":
						if ($jatemgrupo==false){
							$compoesort=true;
							$jatemgrupo=true;
						}
						break;
					case "cadastro.origem":
						if ($jatemorigem==false){
							$compoesort=true;
							$jatemorigem=true;
						}
						break;
					case "profissao":
						if ($jatemprofissao==false){
							$compoesort=true;
							$jatemprofissao=true;
						}
						break;
					case "ramo":
						if ($jatemramo==false){
							$compoesort=true;
							$jatemramo=true;
						}
						break;
					case "seccao":
						if ($jatemseccao==false){
							$compoesort=true;
							$jatemseccao=true;
						}
						break;
					case "zonal":
						if ($jatemzonal==false){
							$compoesort=true;
							$jatemzonal=true;
						}
						break;
					case "rua":
						if ($jatemrua==false){
							$compoesort=true;
							$jatemrua=true;
						}
						break;
					case "cidade":
						if ($jatemcidade==false){
							$compoesort=true;
							$jatemcidade=true;
						}
						break;
					case "bairro":
						if ($jatembairro==false){
							$compoesort=true;
							$jatembairro=true;
						}
						break;
					case "numero":
						if ($jatemnumero==false){
							$compoesort=true;
							$jatemnumero=true;;
						}
						break;
					case "complemento":
						if ($jatemcomlemento==false){
							$compoesort=true;
							$jatemcomplemento=true;
						}
						break;
					case "recebemat":
						if ($jatemrecebemat==false){
							$compoesort=true;
							$jatemrecebemat=true;
						}
						break;
				}
				
				if ($compoesort){
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
				$classificado = " **CLASSIFICADO** ";
			}else{
				$classificado = "";
			}		
			if ($varoperador=="like"){
				$operacao = " CONTÉM ";
			}else{
				$operacao = $varoperador;
			}
			$parametros .= $varcampo." ".$operacao." ".$varconteudoexp." ".$classificado." ".$conector." "; 
	//------------- até a linha acima ---------------------------------------------------------------------
		}
		$linha = $linha + 1; 
	}
	if ($qtde_param > 0){
		$parametros2 = " (Todos Registros)"; 
		if (isset($_POST['condicao'])) {
			if ($_POST['condicao']=="1"){
				$stringWhere .= " condicao = 1";
				$parametros2= " (registros ATIVOS)"; 
			}
			if ($_POST['condicao']=="0"){
				$stringWhere .= " and condicao = 0";
				$parametros2 = " (registros INATIVOS)"; 
			}
		}
		$parametros .= $parametros2;
	
		$stringWhere .= ")";

		for ($i = 1; $i <= $qtde_or ; $i++) {
			$stringWhere .= ")";
		}	

		$sql = 'SELECT 
        month(cadastro.DTNASC) AS mes,
        cadastro.CODIGO as codigo,
        cadastro.NOME as nome,
        cadastro.SEXO as sexo,
        cadastro.DTCAD as dtcad,
        cadastro.DTNASC as dtnasc,
        cadastro.CARGO as cargo,
        cadastro.FONE_RES as fone_res,
        cadastro.FONE_CEL as fone_cel,
        cadastro.FONE_COM as fone_com,
        cadastro.CPF as cpf,
        cadastro.CONDICAO as condicao,
        cadastro.EMAIL as email,
        cadastro.GRUPO as grupo,
        cadastro.ORIGEM as origem,
        cadastro.PROFISSAO as profissao,
        cadastro.ZONAL as zonal,
        cadastro.SECCAO as seccao,
        cadastro.PAI_MAE as pai_mae,
        cadastro.FILIADO as filiado,
        cadastro.RECEBEMAT as recebemat,
        cadastro.RESPCADASTRO as respcadastro,
        cadastro.DTULTALT as dtultalt,
        cadastro.EMPRESA as empresa,
        cadastro.VOTOU as votou,
        cadastro.RAMO as ramo,
        cadastro.RECEBEMAIL as recebemail,
        cadastro.IMPRESSO as impresso,
        cadastro.ENVIADO as enviado,
        cadastro.CAMPANHA as campanha,
        cadastro.FACEBOOK as facebook,
        cadastro.TWITTER as twitter,
        cadastro.OUTRAREDE as outrarede,
        cadastro.APELIDO as apelido,
        cadastro.EST_CIVIL as est_civil,
        cadastro.CLASSI as classi,
        cadastro.OBS as obs,
        enderecos.cep,
        enderecos.tipolog,
        enderecos.rua,
        enderecos.bairro,
        enderecos.cidade,
        enderecos.uf,
        enderecos.numero,
        enderecos.complemento,
        enderecos.padrao,
        enderecos.tipo,
        enderecos.reg,
        origem.Descricao as desc_origem ,
        grupos.NOMEGRP as desc_grupo,
        grupos.GRUPO AS cod_grupo,
        origem.Origem AS cod_origem
      FROM
        cadastro
        LEFT OUTER JOIN enderecos ON (cadastro.CODIGO = enderecos.codigo)
        LEFT OUTER JOIN origem ON (cadastro.ORIGEM = origem.Origem)
        LEFT OUTER JOIN grupos ON (cadastro.GRUPO = grupos.GRUPO) WHERE ';

//		if ($primorderby == 0) {
//			$strorderby = " order by reg";
//			$primorderby=1;			
//		}else {
//			$strorderby = $strorderby . ", reg";
//		}

		$sql .= $stringWhere .' '. $strorderby;

		//echo $sql."<br>".$parametros;
		#debug();
		return array ($sql,$parametros);
	} else {
		return array ("","");
	}
}
//-------------------------
function montacep() {
	// setup variables
	$linha=1;
	$primwhere=0;	
	$qtde_param=0;
	$qtde_or=0;
	$primorderby=0;
	$stringWhere = "(";    // variável que conterá a string para o WHERE
	$strwhere= array();		// array para montar os critérios do where
	$strorderby="";
	$parametros="";   // variável criada para retornar os critérios da consulta e ser impressoao final do relatório
	$jatemnome=false;
	$jatemcampanha=false;
	$jatemorigem=false;
	$jatemgrupo=false;
	$jatemprofissao=false;
	$jatemramo=false;
	$jatemseccao=false;
	$jatemzonal=false;
	$jatemrua=false;
	$jatemcidade=false;
	$jatembairro=false;
	$jatemnumero=false;
	$jatemcomplemento=false;
	$jatemrecebemat=false;
	while ($linha < 13) {
		$varcampo = $_POST["campo".$linha];
		$varoperador = $_POST["operador".$linha];
		$varexpressao = $_POST["valorexpressao".$linha];
		if (isset($_POST["expressao".$linha])){
			$varconteudoexp = $_POST["textoexpressao".$linha];
		}else{
			$varconteudoexp = "";			
		}
		$varconector = $_POST["conector".$linha];
		$varclassifica = $_POST["classifica".$linha];
		$strconector= "";
		
		if ($varcampo <> "") {
			$qtde_param++;
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
            if ($varcampo == "grupo" || $varcampo == "origem"){
				$varcampo= "cadastro." . $varcampo;				
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
				$compoesort=false;
				switch ($varcampo) {
					case "nome":
						if ($jatemnome==false){
							$compoesort=true;
							$jatemnome = true;
					}
						break;
					case "campanha":
						if ($jatemcampanha==false){
							$jatemcampanha=true;
							$compoesort=true;
						}
						break;
					case "cadastro.grupo":
						if ($jatemgrupo==false){
							$compoesort=true;
							$jatemgrupo=true;
						}
						break;
					case "cadastro.origem":
						if ($jatemorigem==false){
							$compoesort=true;
							$jatemorigem=true;
						}
						break;
					case "profissao":
						if ($jatemprofissao==false){
							$compoesort=true;
							$jatemprofissao=true;
						}
						break;
					case "ramo":
						if ($jatemramo==false){
							$compoesort=true;
							$jatemramo=true;
						}
						break;
					case "seccao":
						if ($jatemseccao==false){
							$compoesort=true;
							$jatemseccao=true;
						}
						break;
					case "zonal":
						if ($jatemzonal==false){
							$compoesort=true;
							$jatemzonal=true;
						}
						break;
					case "rua":
						if ($jatemrua==false){
							$compoesort=true;
							$jatemrua=true;
						}
						break;
					case "cidade":
						if ($jatemcidade==false){
							$compoesort=true;
							$jatemcidade=true;
						}
						break;
					case "bairro":
						if ($jatembairro==false){
							$compoesort=true;
							$jatembairro=true;
						}
						break;
					case "numero":
						if ($jatemnumero==false){
							$compoesort=true;
							$jatemnumero=true;;
						}
						break;
					case "complemento":
						if ($jatemcomlemento==false){
							$compoesort=true;
							$jatemcomplemento=true;
						}
						break;
					case "recebemat":
						if ($jatemrecebemat==false){
							$compoesort=true;
							$jatemrecebemat=true;
						}
						break;
				}
				
				if ($compoesort){
					if ($primorderby == 0) {
						$strorderby = " order by reg, ";
						$primorderby=1;			
					}else {
						$strorderby .= ",";
					}
					$strorderby .= $varcampo;
				}	
			} 
	// -------- variáveis abaixo montadas para imprimir os parâmetros da consulta -------------------
			if ($varclassifica=="S"){
				$classificado = "**CLASSIFICADO**";
			}else{
				$classificado = "";
			}		
			if ($varoperador=="like"){
				$operacao = " CONTÉM ";
			}else{
				$operacao = $varoperador;
			}
			$parametros .= $varcampo." ".$operacao." ".$varconteudoexp." ".$classificado." ".$conector." "; 
	//------------- até a linha acima ---------------------------------------------------------------------
		}
		$linha = $linha + 1; 
	}
	if ($qtde_param > 0){
		$parametros2 = " (Todos Registros)"; 
		if (isset($_POST['condicao'])) {
			if ($_POST['condicao']=="A"){
				$stringWhere .= ") (condicao = 1";
				$parametros2= " (registros ATIVOS)"; 
			}
			if ($_POST['condicao']=="I"){
				$stringWhere .= ") and (condicao = 0";
				$parametros2 = " (registros INATIVOS)"; 
			}
		}
		$parametros .= $parametros2;
	
		$stringWhere .= ")";

		for ($i = 1; $i <= $qtde_or ; $i++) {
			$stringWhere .= ")";
		}	

		$sql = 'SELECT 
        month(cadastro.DTNASC) AS mes,
        dayofmonth(`cadastro`.`DTNASC`) AS `dia`,
        cadastro.CODIGO as codigo,
        cadastro.NOME as nome,
        cadastro.SEXO as sexo,
        cadastro.DTCAD as dtcad,
        cadastro.DTNASC as dtnasc,
        cadastro.CARGO as cargo,
        cadastro.FONE_RES as fone_res,
        cadastro.FONE_CEL as fone_cel,
        cadastro.FONE_COM as fone_com,
        cadastro.CPF as cpf,
        cadastro.CONDICAO as condicao,
        cadastro.EMAIL as email,
        cadastro.GRUPO as grupo,
        cadastro.ORIGEM as origem,
        cadastro.PROFISSAO as profissao,
        cadastro.ZONAL as zonal,
        cadastro.SECCAO as seccao,
        cadastro.PAI_MAE as pai_mae,
        cadastro.FILIADO as filiado,
        cadastro.RECEBEMAT as recebemat,
        cadastro.RESPCADASTRO as respcadastro,
        cadastro.DTULTALT as dtultalt,
        cadastro.EMPRESA as empresa,
        cadastro.VOTOU as votou,
        cadastro.RAMO as ramo,
        cadastro.RECEBEMAIL as recebemail,
        cadastro.IMPRESSO as impresso,
        cadastro.ENVIADO as enviado,
        cadastro.CAMPANHA as campanha,
        cadastro.FACEBOOK as facebook,
        cadastro.TWITTER as twitter,
        cadastro.OUTRAREDE as outrarede,
        cadastro.APELIDO as apelido,
        cadastro.EST_CIVIL as est_civil,
        cadastro.CLASSI as classi,
        cadastro.OBS as obs,
        enderecos.cep,
        enderecos.tipolog,
        enderecos.rua,
        enderecos.bairro,
        enderecos.cidade,
        enderecos.uf,
        enderecos.numero,
        enderecos.complemento,
        enderecos.padrao,
        enderecos.tipo,
        enderecos.reg,
        origem.Descricao as desc_origem ,
        grupos.NOMEGRP as desc_grupo,
        grupos.GRUPO AS cod_grupo,
        origem.Origem AS cod_origem
      FROM
        cadastro
        LEFT OUTER JOIN enderecos ON (cadastro.CODIGO = enderecos.codigo)
        LEFT OUTER JOIN origem ON (cadastro.ORIGEM = origem.Origem)
        LEFT OUTER JOIN grupos ON (cadastro.GRUPO = grupos.GRUPO) WHERE (enderecos.cep > 0) and ';

		if ($primorderby == 0) {
			$strorderby = " order by reg";
			$primorderby=1;			
//		}else {
//			$strorderby = $strorderby . ", reg";
		}

		$sql .= $stringWhere .' '. $strorderby;

		//echo $sql."<br>".$parametros;
		//debug();
		return array ($sql,$parametros);
	} else {
		return array ("","");
	}
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
function monta_ani(){
	// setup variables
	$dia = $_POST['txtdia'];
	$diaf = $_POST['txtdiaf'];
	$mes = $_POST['txtmes'];
	if ($_POST['hopcao'] == 6){
		$sql = 'SELECT 
        month(cadastro.DTNASC) AS mes,
        dayofmonth(`cadastro`.`DTNASC`) AS dia,
        cadastro.CODIGO as codigo,
        cadastro.NOME as nome,
        cadastro.SEXO as sexo,
        cadastro.DTCAD as dtcad,
        cadastro.DTNASC as dtnasc,
        cadastro.CARGO as cargo,
        cadastro.FONE_RES as fone_res,
        cadastro.FONE_CEL as fone_cel,
        cadastro.FONE_COM as fone_com,
        cadastro.CPF as cpf,
        cadastro.CONDICAO as condicao,
        cadastro.EMAIL as email,
        cadastro.GRUPO as grupo,
        cadastro.ORIGEM as origem,
        cadastro.PROFISSAO as profissao,
        cadastro.ZONAL as zonal,
        cadastro.SECCAO as seccao,
        cadastro.PAI_MAE as pai_mae,
        cadastro.FILIADO as filiado,
        cadastro.RECEBEMAT as recebemat,
        cadastro.RESPCADASTRO as respcadastro,
        cadastro.DTULTALT as dtultalt,
        cadastro.EMPRESA as empresa,
        cadastro.VOTOU as votou,
        cadastro.RAMO as ramo,
        cadastro.RECEBEMAIL as recebemail,
        cadastro.IMPRESSO as impresso,
        cadastro.ENVIADO as enviado,
        cadastro.CAMPANHA as campanha,
        cadastro.FACEBOOK as facebook,
        cadastro.TWITTER as twitter,
        cadastro.OUTRAREDE as outrarede,
        cadastro.APELIDO as apelido,
        cadastro.EST_CIVIL as est_civil,
        cadastro.CLASSI as classi,
        cadastro.OBS as obs,
        enderecos.cep,
        enderecos.tipolog,
        enderecos.rua,
        enderecos.bairro,
        enderecos.cidade,
        enderecos.uf,
        enderecos.numero,
        enderecos.complemento,
        enderecos.padrao,
        enderecos.tipo,
        enderecos.reg,
        origem.Descricao as desc_origem ,
        grupos.NOMEGRP as desc_grupo,
        grupos.GRUPO AS cod_grupo,
        origem.Origem AS cod_origem
      FROM
        cadastro
        LEFT OUTER JOIN enderecos ON (cadastro.CODIGO = enderecos.codigo)
        LEFT OUTER JOIN origem ON (cadastro.ORIGEM = origem.Origem)
        LEFT OUTER JOIN grupos ON (cadastro.GRUPO = grupos.GRUPO) 
        where (MONTH(cadastro.DTNASC) = '.$mes.' AND (DAYOFMONTH(cadastro.DTNASC) >= '.$dia.' AND DAYOFMONTH(cadastro.DTNASC) <= '.$diaf.') and cadastro.condicao=1 and enderecos.rua >"" and enderecos.cep >0) ORDER BY MONTH(cadastro.DTNASC), DAYOFMONTH(cadastro.DTNASC), cadastro.NOME';        
        
	}else{
		$sql = 'SELECT 
        month(cadastro.DTNASC) AS mes,
        dayofmonth(`cadastro`.`DTNASC`) AS `dia`,
        cadastro.CODIGO as codigo,
        cadastro.NOME as nome,
        cadastro.SEXO as sexo,
        cadastro.DTCAD as dtcad,
        cadastro.DTNASC as dtnasc,
        cadastro.CARGO as cargo,
        cadastro.FONE_RES as fone_res,
        cadastro.FONE_CEL as fone_cel,
        cadastro.FONE_COM as fone_com,
        cadastro.CPF as cpf,
        cadastro.CONDICAO as condicao,
        cadastro.EMAIL as email,
        cadastro.GRUPO as grupo,
        cadastro.ORIGEM as origem,
        cadastro.PROFISSAO as profissao,
        cadastro.ZONAL as zonal,
        cadastro.SECCAO as seccao,
        cadastro.PAI_MAE as pai_mae,
        cadastro.FILIADO as filiado,
        cadastro.RECEBEMAT as recebemat,
        cadastro.RESPCADASTRO as respcadastro,
        cadastro.DTULTALT as dtultalt,
        cadastro.EMPRESA as empresa,
        cadastro.VOTOU as votou,
        cadastro.RAMO as ramo,
        cadastro.RECEBEMAIL as recebemail,
        cadastro.IMPRESSO as impresso,
        cadastro.ENVIADO as enviado,
        cadastro.CAMPANHA as campanha,
        cadastro.FACEBOOK as facebook,
        cadastro.TWITTER as twitter,
        cadastro.OUTRAREDE as outrarede,
        cadastro.APELIDO as apelido,
        cadastro.EST_CIVIL as est_civil,
        cadastro.CLASSI as classi,
        cadastro.OBS as obs,
        enderecos.cep,
        enderecos.tipolog,
        enderecos.rua,
        enderecos.bairro,
        enderecos.cidade,
        enderecos.uf,
        enderecos.numero,
        enderecos.complemento,
        enderecos.padrao,
        enderecos.tipo,
        enderecos.reg,
        origem.Descricao as desc_origem ,
        grupos.NOMEGRP as desc_grupo,
        grupos.GRUPO AS cod_grupo,
        origem.Origem AS cod_origem
      FROM
        cadastro
        LEFT OUTER JOIN enderecos ON (cadastro.CODIGO = enderecos.codigo)
        LEFT OUTER JOIN origem ON (cadastro.ORIGEM = origem.Origem)
        LEFT OUTER JOIN grupos ON (cadastro.GRUPO = grupos.GRUPO) where MONTH(cadastro.DTNASC) = '.$mes.' AND (DAYOFMONTH(cadastro.DTNASC) >= '.$dia.' AND DAYOFMONTH(cadastro.DTNASC) <= '.$diaf.') and cadastro.condicao=1 and enderecos.rua >"" and enderecos.cep >0 ORDER BY enderecos.reg, cadastro.NOME';
	}
	return $sql;	
}
//--------------------------------------------------------------------------------------------------------------------
function busca_secretaria($codigo) {
  $cons  = new mysqli($_SESSION['servidor'],$_SESSION['usuario'],$_SESSION['senha'],$_SESSION['banco']);  if(!$cons) {  
	  echo "Não foi possivel conectar ao MySQL. Erro " .
			  mysqli_connect_errno() . " : " . mysql_connect_error();
	  exit;
  }  
  mysqli_set_charset($cons,"utf8");
  mysqli_query($cons, "SET NAMES 'utf8'");
  mysqli_query($cons, 'SET character_set_connection=utf8');
  mysqli_query($cons, 'SET character_set_client=utf8');
  mysqli_query($cons, 'SET character_set_results=utf8');

  $query2 = "SELECT * FROM secretarias WHERE codigo=".$codigo;
  $mysql_query2 = $cons->query($query2);
  $qtderegs2 = $mysql_query2->num_rows;
  if ($qtderegs2>0) {
	  while ($dado2 = $mysql_query2->fetch_assoc()) {
		$retorno = $dado2['descricao'];
	  }	
  }else{
	  $retorno= $codigo." não cadastrado";					
  }
mysqli_close($cons);
return $retorno;
}

// -------------------------------------------------------------------------------------------------------------------
?>
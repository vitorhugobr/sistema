<?php 
//**********************************************************************************
// *** MONTA ETIQUETAS OU RELATÓRIOS PARA DR THIAGO                              ***
// ***      para executar localhost/sigre/relatorios/monta_especial.php           ***
//**********************************************************************************
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

//*********************************************************************************************
$tipo = "G";  // G=gerencial  A=aniversariantes

$opcao = 3;  //1=relatorio  3=etiquetas
//*********************************************************************************************
$sistemaabrev = "Sigre";
$entidade=1;
//echo $chktodos."<br>";
//echo $chkativos."<br>";
//echo $chkinativos."<br>";
define('FPDF_FONTPATH','../fpdf/font/');
if (!isset($opcao)){
	$opcao = 8;
}

//*********************************************************************************************

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

//**********************************************************************************************************

switch($opcao){
		
case 1:{
	// relatório Gerencial
	$numnapag=0;
	$numpag = 0;
	$numlin=99;
    $registros = 0;
	//list ($_sql, $parametros) = monta_sql();    //retornam valores nestas duas variáveis da função #monta_sql()
	
    $parametros="";
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
// grupos.GRUPO =	1
//or grupos.GRUPO = 2
//or grupos.GRUPO = 3
//or grupos.GRUPO = 4
//or grupos.GRUPO = 5
//or grupos.GRUPO = 6
//or grupos.GRUPO = 7
//or grupos.GRUPO = 9
//or grupos.GRUPO = 10
//or grupos.GRUPO = 11
//or grupos.GRUPO = 14
//or grupos.GRUPO = 15
//or grupos.GRUPO = 16
//or grupos.GRUPO = 17
//or grupos.GRUPO = 18
//or grupos.GRUPO = 19
//or grupos.GRUPO = 21
//or grupos.GRUPO = 22
//or grupos.GRUPO = 25
//or grupos.GRUPO = 28
//or grupos.GRUPO = 31
//or grupos.GRUPO = 32
//or grupos.GRUPO = 40
//or grupos.GRUPO = 41
//or grupos.GRUPO = 44
//or grupos.GRUPO = 45
//or grupos.GRUPO = 46
//or grupos.GRUPO = 49
//or grupos.GRUPO = 56
//or grupos.GRUPO = 60
//or grupos.GRUPO = 63
//or grupos.GRUPO = 67
//or grupos.GRUPO = 70
//or grupos.GRUPO = 71
//or grupos.GRUPO = 75
//or grupos.GRUPO = 77
//or grupos.GRUPO = 81
//or grupos.GRUPO = 88
//or grupos.GRUPO = 89
//or grupos.GRUPO = 94
//or grupos.GRUPO = 99
//or grupos.GRUPO = 101
//or grupos.GRUPO = 102
//or grupos.GRUPO = 103
//or grupos.GRUPO = 104
//or grupos.GRUPO = 107
//or grupos.GRUPO = 108
//or grupos.GRUPO = 109
//or grupos.GRUPO = 111
//or grupos.GRUPO = 113
//or grupos.GRUPO = 118
//or grupos.GRUPO = 119
//or grupos.GRUPO = 122
//or grupos.GRUPO = 127
//or grupos.GRUPO = 131
//or grupos.GRUPO = 132
//or grupos.GRUPO = 135
//or grupos.GRUPO = 136
//or grupos.GRUPO = 137
//or grupos.GRUPO = 138
//or grupos.GRUPO = 139
//or grupos.GRUPO = 140
//or grupos.GRUPO = 144
//or grupos.GRUPO = 146
//or grupos.GRUPO = 147
//or grupos.GRUPO = 149
//or grupos.GRUPO = 150
//or grupos.GRUPO = 151
//or grupos.GRUPO = 178
//or grupos.GRUPO = 181
//or grupos.GRUPO = 182
//   order by  enderecos.rua, enderecos.numero,
//  enderecos.complemento';	

  $_sql = 'SELECT 
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
  LEFT OUTER JOIN grupos ON (cadastro.GRUPO = grupos.GRUPO) WHERE
  (cidade = "Porto Alegre") and
   ((bairro like "teresopolis%") or
   (bairro like "%nonoai%") )
   order by enderecos.bairro, enderecos.rua, enderecos.numero,
  enderecos.complemento';	
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
		
//*******************************************************************************************************
		
case 2:{
	break;
}
		
//*******************************************************************************************************		
case 3:{
	// Etiqueta Geral
	$ebct = array();
	$etq = 0;   // esta variável controla se imprime na etiqueta esquerda ou direita. 0 = esquerda
	$qtdetq = 0; 
	$tot_geral_reg = 0;
	//$_sql = montacep();
	//list ($_sql, $parametros) = montacep();    //retornam valores nestas duas variáveis da função monta_sql()
	//echo $_sql;
    $_sql="SELECT 
  month(cadastro.DTNASC) AS mes,
  dayofmonth(`cadastro`.`DTNASC`) AS `dia`,	
  enderecos.id,
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
  cadastro.CODIGO AS codigo,
  cadastro.NOME AS nome,
  cadastro.SEXO AS sexo,
  cadastro.DTNASC AS dtnasc,
  cadastro.GRUPO AS grupo,
  cadastro.ORIGEM AS origem,
  cadastro.RECEBEMAT AS recebemat,
  cadastro.PROFISSAO AS profissao,
  cadastro.ZONAL AS zonal,
  cadastro.SECCAO AS seccao,
  cadastro.CAMPANHA AS campanha,
  cadastro.CONDICAO AS condicao
FROM
  enderecos
  LEFT OUTER JOIN cadastro ON (cadastro.CODIGO = enderecos.codigo)
WHERE
  cadastro.CONDICAO = 1 AND 
  enderecos.cep > 0 AND ( 
  (cadastro.GRUPO = 190) OR 
  (cadastro.GRUPO = 206) OR 
  (cadastro.GRUPO = 188) OR 
  cadastro.GRUPO = 181 OR 
  cadastro.GRUPO = 183 OR 
  cadastro.GRUPO = 186 OR 
  cadastro.GRUPO = 204 OR
  cadastro.GRUPO = 208 OR 
  cadastro.GRUPO = 194 OR 
  cadastro.GRUPO = 199 OR 
  cadastro.GRUPO = 193 OR 
  cadastro.GRUPO = 192 OR
  cadastro.GRUPO = 203 OR
  cadastro.GRUPO = 195 OR
  cadastro.GRUPO = 209 OR
  cadastro.GRUPO = 198 OR
  cadastro.GRUPO = 184 OR
  cadastro.GRUPO = 196 OR
  cadastro.GRUPO = 185 OR
  cadastro.GRUPO = 200 OR
  cadastro.GRUPO = 191 OR
  cadastro.GRUPO = 205 OR
  cadastro.GRUPO = 187 OR
  cadastro.GRUPO = 202 OR
  cadastro.GRUPO = 201 OR
  cadastro.GRUPO = 197
	)
ORDER BY
  enderecos.reg,
  cadastro.NOME
";
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
default:
	echo '<script>alert("'.$opcao.'");self.window.close();</script>';
	break;
}

//*********************************************************************************************************

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
//***********************************************************************************************************
?>
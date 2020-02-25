<?php
/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2014 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.8.0, 2014-03-02
 */

/** Error reporting */
error_reporting(E_ALL);

/** Include PHPExcel */
require_once '../classes/PHPExcel.php';


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();
$objPHPExcel->getActiveSheet()->setShowGridlines(false);
// Set document properties
//echo date('H:i:s') , " Definindo propriedades do documento" , EOL;
$objPHPExcel->getProperties()->setCreator("Vitor H M Oliveira")
							 ->setLastModifiedBy("Vitor H M Oliveira")
							 ->setTitle("Cadastro")
							 ->setSubject("Exportado  paea Excel")
							 ->setDescription("Registros Exportados para Excel");

// Create a first sheet, representing sales data
//echo date('H:i:s') , " Adicionando dados" , EOL;
$objPHPExcel->setActiveSheetIndex(0);

//echo date('H:i:s') , " Cabeçalho das informações" , EOL;
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'CÓDIGO');
$objPHPExcel->getActiveSheet()->setCellValue('B1', 'NOME');
$objPHPExcel->getActiveSheet()->setCellValue('C1', 'SEXO');
$objPHPExcel->getActiveSheet()->setCellValue('D1', 'DATA NASC');
$objPHPExcel->getActiveSheet()->setCellValue('E1', 'CARGO');
$objPHPExcel->getActiveSheet()->setCellValue('F1', 'FONE CELULAR');
$objPHPExcel->getActiveSheet()->setCellValue('G1', 'FONE RESID');
$objPHPExcel->getActiveSheet()->setCellValue('H1', 'FONE COM');
$objPHPExcel->getActiveSheet()->setCellValue('I1', 'CPF');
$objPHPExcel->getActiveSheet()->setCellValue('J1', 'GRUPO');
$objPHPExcel->getActiveSheet()->setCellValue('K1', 'ORIGEM');
$objPHPExcel->getActiveSheet()->setCellValue('L1', 'ZONAL');
$objPHPExcel->getActiveSheet()->setCellValue('M1', 'SEÇÃO');
$objPHPExcel->getActiveSheet()->setCellValue('N1', 'FILHOS');
$objPHPExcel->getActiveSheet()->setCellValue('O1', 'FILIADO');
$objPHPExcel->getActiveSheet()->setCellValue('P1', 'VOTOU');
$objPHPExcel->getActiveSheet()->setCellValue('Q1', 'RECEBE MAT');
$objPHPExcel->getActiveSheet()->setCellValue('R1', 'RECEBE EMAIL');
$objPHPExcel->getActiveSheet()->setCellValue('S1', 'RECEBE IMPRESSO');
$objPHPExcel->getActiveSheet()->setCellValue('T1', 'CAMPANHA');
$objPHPExcel->getActiveSheet()->setCellValue('U1', 'FACEBOOK');
$objPHPExcel->getActiveSheet()->setCellValue('V1', 'TWITTER');
$objPHPExcel->getActiveSheet()->setCellValue('W1', 'OUTRAREDE');
$objPHPExcel->getActiveSheet()->setCellValue('X1', 'APELIDO');
$objPHPExcel->getActiveSheet()->setCellValue('Y1', 'EST CIVIL');
$objPHPExcel->getActiveSheet()->setCellValue('Z1', 'CLASSIF');
$objPHPExcel->getActiveSheet()->setCellValue('AA1', 'OBS');
$objPHPExcel->getActiveSheet()->setCellValue('AB1', 'CEP');
$objPHPExcel->getActiveSheet()->setCellValue('AC1', 'TIPOLOGOA');
$objPHPExcel->getActiveSheet()->setCellValue('AD1', 'LOGRADOURO');
$objPHPExcel->getActiveSheet()->setCellValue('AE1', 'NUMERO');
$objPHPExcel->getActiveSheet()->setCellValue('AF1', 'COMPLEMENTO');
$objPHPExcel->getActiveSheet()->setCellValue('AG1', 'BAIRRO');
$objPHPExcel->getActiveSheet()->setCellValue('AH1', 'CIDADE');
$objPHPExcel->getActiveSheet()->setCellValue('AI1', 'UF');
$objPHPExcel->getActiveSheet()->setCellValue('AJ1', 'TIPO');
$objPHPExcel->getActiveSheet()->setCellValue('AK1', 'CDD');
//echo date('H:i:s') , " Buscando informações dos árbitros no banco de dados - tabela 'arbitros'" , EOL;
// info DO BANCO DE DADOS
$ind=2;
$numero = 1;
$sql = 'select cadastro.CODIGO,cadastro.NOME, cadastro.SEXO, cadastro.DTNASC, cadastro.CARGO, cadastro.FONE_CEL, cadastro.FONE_RES, cadastro.FONE_COM, cadastro.CPF ,grupos.NOMEGRP AS NOMEGRP, origem.Descricao AS Descricao, cadastro.ZONAL, cadastro.SECCAO,CASE WHEN cadastro.PAI_MAE = 0 THEN "NÃO" ELSE "SIM" END AS PAI_MAE, CASE WHEN  cadastro.FILIADO = 0 THEN "NÃO" ELSE "SIM" END AS FILIADO,CASE WHEN cadastro.VOTOU = 0 THEN "NÃO" ELSE "SIM" END AS VOTOU, CASE WHEN cadastro.RECEBEMAT = 0 THEN "NÃO" ELSE "SIM" END AS RECEBEMAT, CASE WHEN cadastro.RECEBEMAIL = 0 THEN "NÃO" ELSE "SIM" END AS RECEBEMAIL,CASE WHEN cadastro.IMPRESSO = 0 THEN "NÃO" ELSE "SIM" END AS IMPRESSO,cadastro.CAMPANHA, cadastro.FACEBOOK, cadastro.TWITTER, cadastro.OUTRAREDE, cadastro.APELIDO, cadastro.EST_CIVIL, cadastro.CLASSI, cadastro.OBS, enderecos.cep, enderecos.tipolog, enderecos.rua, enderecos.numero, enderecos.complemento, enderecos.bairro, enderecos.cidade, enderecos.uf, enderecos.tipo, enderecos.reg FROM cadastro LEFT OUTER JOIN enderecos ON (cadastro.CODIGO = enderecos.codigo) INNER JOIN grupos ON (cadastro.GRUPO = grupos.GRUPO) INNER JOIN origem ON  (cadastro.ORIGEM = origem.Origem)' ;
$statement = $pdo->prepare($sql);
$statement->execute();
$total = $statement->rowCount();
if($total==0){
  echo '<script>alert("ERRO NA LEITURA do arquivo");</script>'; 
}else{
  while($_row = $statement->fetch()) {	
	$objPHPExcel->getActiveSheet()->setCellValue('A'.$ind, $_row['CODIGO']);
	$objPHPExcel->getActiveSheet()->setCellValue('B'.$ind, $_row['NOME']);
	$objPHPExcel->getActiveSheet()->setCellValue('C'.$ind, $_row['SEXO']);
	$objPHPExcel->getActiveSheet()->setCellValue('D'.$ind, $_row['DTNASC']);
	$objPHPExcel->getActiveSheet()->setCellValue('E'.$ind, $_row['CARGO']);
	$objPHPExcel->getActiveSheet()->setCellValue('F'.$ind, $_row['FONE_CEL']);
	$objPHPExcel->getActiveSheet()->setCellValue('G'.$ind, $_row['FONE_RES']);
	$objPHPExcel->getActiveSheet()->setCellValue('H'.$ind, $_row['FONE_COM']);
	$objPHPExcel->getActiveSheet()->setCellValue('I'.$ind, $_row['CPF']);
	$objPHPExcel->getActiveSheet()->setCellValue('J'.$ind, $_row['NOMEGRP']);
	$objPHPExcel->getActiveSheet()->setCellValue('K'.$ind, $_row['Descricao']);
	$objPHPExcel->getActiveSheet()->setCellValue('L'.$ind, $_row['ZONAL']);
	$objPHPExcel->getActiveSheet()->setCellValue('M'.$ind, $_row['SECCAO']);
	$objPHPExcel->getActiveSheet()->setCellValue('N'.$ind, $_row['PAI_MAE']);
	$objPHPExcel->getActiveSheet()->setCellValue('O'.$ind, $_row['FILIADO']);
	$objPHPExcel->getActiveSheet()->setCellValue('P'.$ind, $_row['VOTOU']);
	$objPHPExcel->getActiveSheet()->setCellValue('Q'.$ind, $_row['RECEBEMAT']);
	$objPHPExcel->getActiveSheet()->setCellValue('R'.$ind, $_row['RECEBEMAIL']);
	$objPHPExcel->getActiveSheet()->setCellValue('S'.$ind, $_row['IMPRESSO']);
	$objPHPExcel->getActiveSheet()->setCellValue('T'.$ind, $_row['CAMPANHA']);
	$objPHPExcel->getActiveSheet()->setCellValue('U'.$ind, $_row['FACEBOOK']);
	$objPHPExcel->getActiveSheet()->setCellValue('V'.$ind, $_row['TWITTER']);
	$objPHPExcel->getActiveSheet()->setCellValue('W'.$ind, $_row['OUTRAREDE']);
	$objPHPExcel->getActiveSheet()->setCellValue('X'.$ind, $_row['APELIDO']);
	$objPHPExcel->getActiveSheet()->setCellValue('Y'.$ind, $_row['EST_CIVIL']);
	$objPHPExcel->getActiveSheet()->setCellValue('Z'.$ind, $_row['CLASSI']);
	$objPHPExcel->getActiveSheet()->setCellValue('AA'.$ind, $_row['OBS']);
	$objPHPExcel->getActiveSheet()->setCellValue('AB'.$ind, $_row['cep']);
	$objPHPExcel->getActiveSheet()->setCellValue('AC'.$ind, $_row['tipolog']);
	$objPHPExcel->getActiveSheet()->setCellValue('AD'.$ind, $_row['rua']);
	$objPHPExcel->getActiveSheet()->setCellValue('AE'.$ind, $_row['numero']);
	$objPHPExcel->getActiveSheet()->setCellValue('AF'.$ind, $_row['complemento']);
	$objPHPExcel->getActiveSheet()->setCellValue('AG'.$ind, $_row['bairro']);
	$objPHPExcel->getActiveSheet()->setCellValue('AH'.$ind, $_row['cidade']);
	$objPHPExcel->getActiveSheet()->setCellValue('AI'.$ind, $_row['uf']);
	$objPHPExcel->getActiveSheet()->setCellValue('AJ'.$ind, $_row['tipo']);
	$objPHPExcel->getActiveSheet()->setCellValue('AK'.$ind, $_row['reg']);
	$ind = $ind + 1;
	$numero = $numero + 1;
  }
}

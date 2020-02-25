<?php 
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
// exportar Excel
$_SESSION['funcao']="Exportar Excel";
$_sql = "select 
    `cadastro`.`CODIGO` AS `CODIGO`,
    `cadastro`.`NOME` AS `NOME`,
    `cadastro`.`DTNASC` AS `DTNASC`,
    `cadastro`.`FONE_RES` AS `FONE_RES`,
    `cadastro`.`FONE_CEL` AS `FONE_CEL`,
    `cadastro`.`FONE_COM` AS `FONE_COM`,
    `cadastro`.`CPF` AS `CPF`,
	CASE WHEN RECEBEMAT = 0 THEN 'NÃO' ELSE 'SIM' END AS RECEBEMAT,
    `cadastro`.`EMAIL` AS `EMAIL`,
    `enderecos`.`bairro` AS `bairro` 
  from 
    (`cadastro` left join `enderecos` on((`cadastro`.`CODIGO` = `enderecos`.`codigo`)));";    //retornam valores nestas duas variáveis da função monta_sql()
$_res = $_con->query($_sql);
if($_res->num_rows>0){
	$arquivo = 'cadastro_fone.xls';
	$tabela = '<table border="1">';
	$tabela .= '<tr>';
	$tabela .= '<td>CODIGO</td>';
	$tabela .= '<td>NOME</td>';
	$tabela .= '<td>DTNASC</td>';
	$tabela .= '<td>FONE_RES</td>';
	$tabela .= '<td>FONE_CEL</td>';
	$tabela .= '<td>FONE_COM</td>';
	$tabela .= '<td>CPF</td>';
	$tabela .= '<td>WHATSAPP</td>';
	$tabela .= '<td>EMAIL</td>';
	$tabela .=  '<td>bairro</td>';
	$tabela .= '</tr>';	
	while($_row = $_res->fetch_assoc()) {
		$tabela .= '<tr>';
		$tabela .= '<td>'.$_row['CODIGO'].'</td>';
		$tabela .= '<td>'.utf8_decode($_row['NOME']).'</td>';
		$tabela .= '<td>'.$_row['DTNASC'].'</td>';
		$tabela .= '<td>'.$_row['FONE_RES'].'</td>';
		$tabela .= '<td>'.$_row['FONE_CEL'].'</td>';
		$tabela .= '<td>'.$_row['FONE_COM'].'</td>';
		$tabela .= '<td>'.$_row['CPF'].'</td>';
		$tabela .= '<td>'.$_row['RECEBEMAT'].'</td>';
		$tabela .= '<td>'.$_row['EMAIL'].'</td>';
		$tabela .=  '<td>'.utf8_decode($_row['bairro']).'</td>';
		$tabela .= '</tr>';
	}
	$tabela .= '</table>';
	header('Content-Type: text/csv; charset=utf-8');
	header ('Cache-Control: no-cache, must-revalidate');
	header ('Pragma: no-cache');
	header ("Content-Disposition: attachment; filename=\"{$arquivo}\"");
	echo $tabela;
	$_SESSION['msg'] = "<div class='alert alert-success' role='alert'><i class='fas fa-exclamation' aria-hidden='true text-muted' aria-hidden='true'></i> Cadastro Exportado para Excel<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";  		

}
?>
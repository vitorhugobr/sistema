<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
/*
Busca clinicass no banco de dados	*/
require_once('../utilitarios/funcoes.php');

$busca = "Select * from clinicas order by clinica";

$total_reg = "12"; // número de registros por página	

$pagina=$_GET['pagina'];

if (!$pagina) {
	$paginacarregada = "1";
} else {
	$paginacarregada = $pagina;
}

$inicio = $paginacarregada - 1;

$inicio = $inicio * $total_reg;
$limite = $_con->query("$busca LIMIT $inicio,$total_reg");
$todos = $_con->query("$busca");

$totalderegistros = $todos->num_rows; // verifica o número total de registros
$totaldepaginas = ceil($totalderegistros / $total_reg); // verifica o número total de páginas

// vamos criar a visualização
if ($totalderegistros<1) {
	echo '<script>alert("Nenhuma clínica encontrada");</script>';					
} else {
	echo '<table class="table table-striped">
	<thead class="thead-dark">
  <tr>
    <th width="5%"><i class="fas fa-hashtag"></i> Cód.</th>
    <th width="35%"><i class="fas fa-text-width"></i> Nome Clínica</th>
    <th width="40%">Endereço</th>
    <th width="15%">Fone</th>
    <th width="5%"></th>
  </tr>
	</thead><tbody>';
	
	$linha=0;
	$cor='';
	while ($dado = $limite->fetch_assoc()) {
//	while ($dado = mysql_fetch_array($limite)) {
	echo '<tr><td align="right">'.$dado['id'].'</td><td>'.strtoupper($dado['clinica']).'</td><td align="left">'.strtoupper($dado['endereco']).'</td><td align="left">'.$dado['telefone'].'</td><td><button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal" onclick="javascript:mostraclinica('.$dado['id'].')"><i class="fas fa-edit"></i> Editar</button>
				</td></tr>';							
	}		
	echo '</tbody></table>';		
}		

// agora vamos criar os botões "Anterior e próximo";

$anterior = $paginacarregada -1;

$proximo = $paginacarregada +1;

if ($paginacarregada>1) {
	echo '<button type="button" class="btn btn-sm btn-dark" onclick="javascript:carga_clinicas(1);"> <span class="fas fa-arrow-uf"></span> Primeira</button>';
	echo '<button type="button" class="btn btn-sm btn-dark" onclick="javascript:carga_clinicas('.$anterior.');"> <span class="fas fa-backward"></span> Anterior</button>';
}
if ($paginacarregada<$totaldepaginas) {
	echo '<button type="button" class="btn btn-sm btn-dark" onclick="javascript:carga_clinicas('.$proximo.');"> <span class="fas fa-forward"></span> Próxima</button>';
	echo '<button type="button" class="btn btn-sm btn-dark" onclick="javascript:carga_clinicas('.$totaldepaginas.');"> <span class="fas fa-fast-forward"></span> Última</button>';
}
echo '&nbsp;&nbsp;<span class="label label-default">&nbsp;&nbsp;#Pág. '.$paginacarregada.'&nbsp;&nbsp;</span>';

?>
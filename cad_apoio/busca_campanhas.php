<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
/*
Busca campanhas no banco de dados	*/
require_once('../utilitarios/funcoes.php');

$busca = "Select `campanha`.`codigo` AS `codigo`, `campanha`.`descricao` AS `descricao`, count(`cadastro`.`CAMPANHA`) AS `qtdecampanha`from  (`campanha` left join `cadastro` on((`campanha`.`codigo` = `cadastro`.`CAMPANHA`))) group by `campanha`.`descricao`,`campanha`.`codigo`";

//$busca = "SELECT * from campanha order by Descricao2";
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
	echo '<script>alert("Nenhuma campanha encontrada");</script>';					
} else {
	echo '<table class="table table-striped">
	<thead class="thead-dark">
  <tr>
    <th scope="col" align="center" width="10%"><i class="fas fa-hashtag"></i> Cód</th>
    <th scope="col" width="64%"><i class="fas fa-text-width"></i> Descrição</th>
    <th scope="col" align="right" width="13%"># Registros</th>
    <th scope="col" align="right" width="13%">Opções</th>
  </tr>
	</thead><tbody>';
	
	$linha=0;
	$cor='';
	while ($dado = $limite->fetch_assoc()) {
//	while ($dado = mysql_fetch_array($limite)) {
		if ($dado['qtdecampanha'] > 0){
			echo '<tr><td align="right">'.$dado['codigo'].'</td><td>'.strtoupper($dado['descricao']).'</td><td align="right">'.$dado['qtdecampanha'].'</td><td align="right" >
				<img src="../imagens/editar.png" alt="Editar" height="18" onclick="mostracampanha('.$dado['codigo'].')">
				</td></tr>';							
		}else{
			echo '<tr>
    <td align="right">'.$dado['codigo'].'</td>
    <td>'.strtoupper($dado['descricao']).'</td>
    <td align="right">'.$dado['qtdecampanha'].'</td>
    <td align="right">
			<img src="../imagens/excluir.jpg" alt="Excluir" width="18" height="18" onclick="excluicampanha('.$dado['codigo'].')">&nbsp;
			<img src="../imagens/editar.png" alt="Editar" height="18" onclick="mostracampanha('.$dado['codigo'].')"></td>
    </tr>';
		}
	}		
	echo '</tbody></table>';		
}		

// agora vamos criar os botões "Anterior e próximo";

$anterior = $paginacarregada -1;

$proximo = $paginacarregada +1;

if ($paginacarregada>1) {
	echo '<button type="button" class="btn btn-sm btn-dark" onclick="javascript:carga_campanha(1);"> <span class="fas fa-arrow-left"></span> Primeira</button>';
	echo '<button type="button" class="btn btn-sm btn-dark" onclick="javascript:carga_campanha('.$anterior.');"> <span class="fas fa-backward"></span> Anterior</button>';
}
if ($paginacarregada<$totaldepaginas) {
	echo '<button type="button" class="btn btn-sm btn-dark" onclick="javascript:carga_campanha('.$proximo.');"> <span class="fas fa-forward"></span> Próxima</button>';
	echo '<button type="button" class="btn btn-sm btn-dark" onclick="javascript:carga_campanha('.$totaldepaginas.');"> <span class="fas fa-fast-forward"></span> Última</button>';
}
echo '&nbsp;&nbsp;<span class="label label-default">&nbsp;&nbsp;#Pág. '.$paginacarregada.'&nbsp;&nbsp;</span>';

?>
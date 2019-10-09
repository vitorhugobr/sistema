<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
/*Busca grupos no banco de dados	*/
require_once('../utilitarios/funcoes.php');

$busca = "Select `grupos`.`GRUPO` AS `codigo`, `grupos`.`NOMEGRP` AS `descricao`, count(`cadastro`.`GRUPO`) AS `qtdegrupos`from  (`grupos` left join `cadastro` on((`grupos`.`GRUPO` = `cadastro`.`GRUPO`))) group by `grupos`.`NOMEGRP`,`grupos`.`GRUPO`";

//$busca = "SELECT * from grupos order by Descricao2";
//$total_reg = "12"; // número de registros por página	
//
//$pagina=$_GET['pagina'];
//
//if (!$pagina) {
//	$paginacarregada = "1";
//} else {
//	$paginacarregada = $pagina;
//}
//
//$inicio = $paginacarregada - 1;
//
//$inicio = $inicio * $total_reg;
//$limite = $_con->query("$busca LIMIT $inicio,$total_reg");
$todos = $_con->query("$busca");

$totalderegistros = $todos->num_rows; // verifica o número total de registros
//$totaldepaginas = ceil($totalderegistros / $total_reg); // verifica o número total de páginas

// vamos criar a visualização
if ($totalderegistros<1) {
	echo '<script>alert("Nenhum grupo encontrado");</script>';					
} else {
	echo '<table class="table table-striped">
	<thead class="thead-dark">
  <tr>
    <th align="center" width="10%"><i class="fas fa-hashtag"></i> Grupo</th>
    <th width="64%"><i class="fas fa-text-width"></i> Descrição</th>
    <th width="13%"># Registros</th>
    <th width="13%">Opções</th>
  </tr>
	</thead><tbody>';
	$linha=0;
	$cor='';
	while ($dado = $todos->fetch_assoc()) {
//	while ($dado = mysql_fetch_array()) {
		if ($dado['qtdegrupos'] > 0){
			echo '<tr><td align="right">'.$dado['codigo'].'</td><td><a href="../cad_apoio/cadastro_apoio.php?par1=GRUPO&par2='.$dado["codigo"].'&par3='.strtoupper($dado["descricao"]).'">'.strtoupper($dado['descricao']).'</a></td><td align="right">'.$dado['qtdegrupos'].'</td><td align="right" >
				<img src="../imagens/editar.png" alt="Editar" height="18" onclick="mostragrupo('.$dado['codigo'].')">
				</td></tr>';							
		}else{
			echo '<tr>
				<td align="right">'.$dado['codigo'].'</td>
				<td>'.strtoupper($dado['descricao']).'</td>
				<td align="right">'.$dado['qtdegrupos'].'</td>
				<td align="right">
				<img src="../imagens/excluir.jpg" alt="Excluir" width="18" height="18" onclick="excluigrupo('.$dado['codigo'].')">&nbsp;
				<img src="../imagens/editar.png" alt="Editar" height="18" onclick="mostragrupo('.$dado['codigo'].')"></td>
    			</tr>';
		}
	}		
	echo '</tbody></table>';		
}		

// agora vamos criar os botões "Anterior e próximo";

//$anterior = $paginacarregada -1;
//
//$proximo = $paginacarregada +1;
//
//if ($paginacarregada>1) {
//	echo '<button type="button" class="btn btn-sm btn-dark" onclick="javascript:carga_grupos(1);"> <span class="fas fa-fast-backward"></span> Primeira</button>';
//	echo '<button type="button" class="btn btn-sm btn-dark" onclick="javascript:carga_grupos('.$anterior.');"> <span class="fas fa-backward"></span> Anterior</button>';
//}
//if ($paginacarregada<$totaldepaginas) {
//	echo '<button type="button" class="btn btn-sm btn-dark" onclick="javascript:carga_grupos('.$proximo.');"> <span class="fas fa-forward"></span> Próxima</button>';
//	echo '<button type="button" class="btn btn-sm btn-dark" onclick="javascript:carga_grupos('.$totaldepaginas.');"> <span class="fas fa-fast-forward"></span> Última</button>';
//}
//echo '&nbsp;&nbsp;<span class="label label-default">&nbsp;&nbsp;#Pág. '.$paginacarregada.'&nbsp;&nbsp;</span>';

?>
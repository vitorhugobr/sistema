<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
/*
Busca secretarias no banco de dados	*/
require_once('../utilitarios/funcoes.php');

$busca = "Select `secretarias`.`codigo` AS `codigo`, `secretarias`.`descricao` AS `descricao`, count(`encaminhamentos`.`assunto`) AS `qtdesecretaria` from (`secretarias` left join `encaminhamentos` on((`secretarias`.`codigo` = `encaminhamentos`.`assunto`))) group by `secretarias`.`descricao`,`secretarias`.`codigo`";

//$busca = "SELECT * from secretaria order by Descricao2";
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
	echo '<script>alert("Nenhuma secretaria encontrada");</script>';					
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
		if ($dado['qtdesecretaria'] > 0){
			echo '<tr><td align="right">'.$dado['codigo'].'</td><td>'.strtoupper($dado['descricao']).'</td><td align="right">'.$dado['qtdesecretaria'].'</td><td align="right" >
				<img src="../imagens/editar.png" alt="Editar" height="18" onclick="mostrasecretaria('.$dado['codigo'].')">
				</td></tr>';							
		}else{
			echo '<tr>
    <td align="right">'.$dado['codigo'].'</td>
    <td>'.strtoupper($dado['descricao']).'</td>
    <td align="right">'.$dado['qtdesecretaria'].'</td>
    <td align="right">
			<img src="../imagens/excluir.jpg" alt="Excluir" width="18" height="18" onclick="excluisecretaria('.$dado['codigo'].')">&nbsp;
			<img src="../imagens/editar.png" alt="Editar" height="18" onclick="mostrasecretaria('.$dado['codigo'].')"></td>
    </tr>';
		}
	}		
	echo '</tbody></table>';		
}		

// agora vamos criar os botões "Anterior e próximo";

$anterior = $paginacarregada -1;

$proximo = $paginacarregada +1;

if ($paginacarregada>1) {
	echo '<button type="button" class="btn btn-sm btn-dark" onclick="javascript:carga_secretarias(1);"> <span class="fas fa-arrow-left"></span> Primeira</button>';
	echo '<button type="button" class="btn btn-sm btn-dark" onclick="javascript:carga_secretarias('.$anterior.');"> <span class="fas fa-backward"></span> Anterior</button>';
}
if ($paginacarregada<$totaldepaginas) {
	echo '<button type="button" class="btn btn-sm btn-dark" onclick="javascript:carga_secretarias('.$proximo.');"> <span class="fas fa-forward"></span> Próxima</button>';
	echo '<button type="button" class="btn btn-sm btn-dark" onclick="javascript:carga_secretarias('.$totaldepaginas.');"> <span class="fas fa-fast-forward"></span> Última</button>';
}
echo '&nbsp;&nbsp;<span class="label label-default">&nbsp;&nbsp;#Pág. '.$paginacarregada.'&nbsp;&nbsp;</span>';

?>
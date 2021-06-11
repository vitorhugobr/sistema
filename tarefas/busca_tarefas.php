<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
/*
Busca gruposs no banco de dados	*/
require_once('../utilitarios/funcoes.php');

$status =$_GET['status']; 
$_SESSION['status']= $status;
$idusuario = $_SESSION['usuarioCodigo'];
//echo "status: ".$status.'<br>';
//echo "id usuário: ".$idusuario.'<br>';
//echo "nível usuário: ".$_SESSION['usuarioNivel']."<br>";
$busca = "SELECT * from tarefas_pesquisa ";
if ($_SESSION['usuarioNivel']<2){
	if ($_SESSION['status'] <2){
		$busca .= "where cod_status = ".$status." order by data_tarefa desc, status, nome asc";
	}else{
		$busca .= "order by status, data_tarefa desc, nome asc";
	}
}else{
	$busca .= "where tusuario = ".$idusuario;
	if ($_SESSION['status'] <2){
		$busca .= " and cod_status = ".$status." order by data_tarefa desc, status, nome asc";
	}else{ 
		$busca .= " order by status, data_tarefa desc, nome asc";
	}
}
#echo "pesquisa: ".$busca.'<br>';

$limite = $_con->query($busca);

//echo 'Regs: '. $limite->num_rows;
$totreg = $limite->num_rows;

$total_reg = 11; // número de registros por página	

$pagina=$_GET['pagina'];

if (!$pagina) {
	$paginacarregada = "1";
} else {
	$paginacarregada = $pagina;
}

$inicio = $paginacarregada - 1;

$inicio = $inicio * $total_reg;

$query = $busca." LIMIT $inicio,$total_reg";

$limite = $_con->query($query);
$todos = $limite->num_rows;

$totalderegistros = $todos; // verifica o número total de registros
$totaldepaginas = ceil($totreg / $total_reg); // verifica o número total de páginas

	
// vamos criar a visualização
echo '<table class="table table-striped table-sm">
  <thead class="thead-dark">
	  <tr>
		<th width="7%" align="left"><i class="fas fa-calendar-alt"></i>Data</th>
		<th width="10%" align="left"><i class="fas fa-user"></i>Usuário</th>
		<th width="30%" align="left"><i class="fas fa-text-width"></i>Assunto</th>
		<th width="8%" align="left"><i class="fas fa-calendar-alt"></i>Data Início</th>
		<th width="10%" align="left"><i class="fas fa-sort-numeric-down"></i>Prioridade</th>
		<th width="5%" align="center"><i class="fas fa-hashtag"></i>Tarefa</th>
		<th width="10%" align="left">Status</th>
		<th width="20%" align="left">Opções</th>
	  </tr>
  </thead>
  <tbody>';
if ($totalderegistros<1) {
	echo '  <tr><td  class="text-danger" colspan="8" align="center"><strong><em>SEM TAREFAS</em></strong></td> </tr>';	
} else {
	$linha=0;
	$cor='';
	while ($dado = $limite->fetch_assoc()) {
		echo '<tr>
			  <td align="left" nowrap="nowrap">'.FormatDateTime($dado['data_tarefa'],7).'</td>
			  <td align="left">'.$dado['usuario'].'</td>
			  <td align="left">'.strtoupper($dado['assunto']).'</td>';
		if ($dado['data_inicio']==""){	  
			echo '<td align="left" nowrap="nowrap"><span class="text-danger"> NÃO INICIADA</span></td>';
		}else{
			echo '<td align="left" nowrap="nowrap"><strong>'.FormatDateTime($dado['data_inicio'],7).'</strong></td>';

		}
		echo '<td align="left">'.$dado['prioridade'].'</td>
			  <td align="center" nowrap="nowrap">'.$dado['id'].'</td>
			  <td align="left">'.$dado['status'].'</td>
			  <td class="text-left">';
		echo '<button type="button" class="btn btn-sm btn-consultar" onclick="javascript:mostratarefa('.$dado['id'].');">
						<i class="fas fa-search"></i> Visualizar
						</button>';
		if ($_SESSION['usuarioNivel']<2 AND $dado['status']<> "ENCERRADA") {
			echo '&nbsp;<button type="button" class="btn btn-sm btn-excluir" onclick="excluitarefa('.$dado['id'].');">
						<i class="fas fa-trash"></i> Excluir
						</button>';
		}
		echo '</td></tr>';
		}  
}		
echo '</tbody></table>';		
	

// agora vamos criar os botões "Anterior e próximo";

$anterior = $paginacarregada -1;
$proximo = $paginacarregada +1;

if ($paginacarregada>1) {
	echo '<button type="button" class="btn btn-sm btn-dark" onclick="javascript:carga_tarefas(1,'.$_SESSION['status'].');"> <span class="fas fa-fast-backward"></span> Primeira</button>';
	echo '<button type="button" class="btn btn-sm btn-dark" onclick="javascript:carga_tarefas('.$anterior.','.$_SESSION['status'].');"> <span class="fas fa-backward"></span> Anterior</button>';
}
if ($paginacarregada<$totaldepaginas) {
	echo '<button type="button" class="btn btn-sm btn-dark" onclick="javascript:carga_tarefas('.$proximo.','.$_SESSION['status'].');"> <span class="fas fa-forward"></span> Próxima</button>';
	echo '<button type="button" class="btn btn-sm btn-dark" onclick="javascript:carga_tarefas('.$totaldepaginas.','.$_SESSION['status'].');"> <span class="fas fa-fast-forward"></span> Última</button>';
}
echo '&nbsp;&nbsp;<span class="label label-default">&nbsp;&nbsp;#Pág. '.$paginacarregada.'&nbsp;&nbsp;</span>';
$_SESSION['mudoutarefa'] = false;

?>
 <?php
include("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
require_once("../utilitarios/headers.php");
$nomeeleitor = $_GET['nome'];
echo '<span class="textoAzul">'.$nomeeleitor.'</span>';

$query = "SELECT 
		relaciona.id,
		relaciona.codigo_pai AS pai,
		relaciona.codigo_son AS son,
		relaciona.tipo,
		cadastro.NOME AS nome,
		cadastro1.NOME AS nomepai
		FROM
		relaciona
		LEFT OUTER JOIN cadastro ON (relaciona.codigo_son = cadastro.CODIGO)
		INNER JOIN cadastro cadastro1 ON (relaciona.codigo_pai = cadastro1.CODIGO)
	WHERE
  relaciona.codigo_pai = ".$_GET['cod'];
$mysql_query = $_con->query($query);
if ($mysql_query->num_rows>0) {
	$dadosrelacao = '<table class="table table-striped">
	<thead>
  <tr>
    <th>Nome</th>
    <th>Parentesco</th>
    <th>Opções</th>
  </tr>			   	
	</thead>
	<tbody>';
	while ($dado_s = $mysql_query->fetch_assoc()) {
		$nome = $dado_s['nome'];
		$nomepai = $dado_s['nomepai'];
		$tp = $dado_s['tipo'];
		if ($tp ==1){
				$parentesco= "Pai/Mãe";
		}elseif ($tp== 2) {
				$parentesco= "Filho(a)";
		}elseif ($tp==  3){
				$parentesco= "Sobrinho(a)";					
		}elseif ($tp== 4){
				$parentesco= "Esposo(a)";			
		}elseif ($tp==  5){
				$parentesco= "Avó(ô)";				
		}elseif ($tp== 6){
				$parentesco= "Irm&atilde;o(&atilde;)";				
		}elseif ($tp== 7){
				$parentesco= "Enteado(a)";				
		}elseif ($tp== 8){
				$parentesco= "Neto(a)";				
		}elseif ($tp== 9){
				$parentesco= "Outro(a)";				
		}else{
				$parentesco= "NENHUM";				
		}
		$dadosrelacao .= '   <tr>
    <td>'.$nome.'</td>
    <td>'.$parentesco.'</td>
    <td>
			<a href="javascript:novoeleitor('.$dado_s['son'].'" class="btn btn-sm btn-primary" />
				<i class="fas fa-search"></i> Buscar
			</a>
			<a href="#" onclick="javascript:excluirelation('.$dado_s['id'].')" class="btn btn-sm btn-danger" />
				<i class="fas fa-remove"></i> Excluir
			</a>
		</td>
  </tr> ';
	}
	echo $dadosrelacao;
	// Relation é do tipo hidden e serve para imprimir a ficha do eleitor		
}else{
	echo "<p><span class='textoVerde'>Sem Relacionamentos</span></p>";
}
?>
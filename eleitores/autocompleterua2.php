<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); 
require_once ('../utilitarios/funcoes.php');
  $typing = strtoupper($_GET["typing"]);
	$city = strtoupper($_GET["city"]);
	$temcidade = 'N';
	if ($city ==""){
		$query = 'SELECT * from cep where rua like "%'.$typing.'%" ORDER BY rua,cidade';
	}else{
		$query = 'SELECT * from cep where rua like "%'.$typing.'%" and cidade = "'.$city.'" ORDER BY rua';		
		$temcidade = 'S';	}
	/*
	 	Busca eleitor no banco de dados	*/

	if ($result = mysqli_query($_concomum, $query)) {	
		/* fetch associative array */
		while ($row = mysqli_fetch_assoc($result)) {?>
			<li onselect="this.text.value = '<?php echo $row["RUA"] ?>';busca_Cep(<?php echo $row["CEP"]?>);">
			<span class="informal"><?php echo $row["CEP"] ?></span>
        	<?php 	if ($temcidade == 'N'){
			 			echo $row["TIPOLOG"].' '.$row["RUA"].' '.strtoupper($row["NUMERACAO"]).' em '.$row["CIDADE"];
					}else{
						echo $row["TIPOLOG"].' '.$row["RUA"].' '.strtoupper($row["NUMERACAO"]);
					}?>
			</li>

		<?php
		}	
		/* free result set */
		mysqli_free_result($result);
	}	
	/* close connection */
?>
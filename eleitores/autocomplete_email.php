<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); 
require_once ('../utilitarios/funcoes.php');
  $typing = strtoupper($_GET["typing"]);
	$query = 'SELECT * from cadastro where EMAIL like "%'.$typing.'%" ORDER BY EMAIL';

	/* 	Busca eleitor no banco de dados	*/
	if ($result = mysqli_query($_con, $query)) {	
		/* fetch associative array */
 		while ($row = mysqli_fetch_assoc($result)) {?>
			<li onselect="this.text.value = '<?php echo $row["EMAIL"] ?>';$('txtcodigo').value = '<?php echo $row["CODIGO"]?>';PesquisaEleitor(<?php echo $row["CODIGO"]?>);">
			<span class="informal"><?php echo $row["CODIGO"] ?></span>
        	<?php echo $row["EMAIL"] ;
			 $_SESSION['CodRetorno']=$row["CODIGO"];
			?>
			</li>
	<?php
		}

		//}	
		/* free result set */
		mysqli_free_result($result);
	}	
	/* close connection */
  
?>
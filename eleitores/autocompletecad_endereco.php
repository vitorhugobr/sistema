<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); 
require_once ('../utilitarios/funcoes.php');
  $typing = strtoupper($_GET["typing"]);
  $query = 'SELECT * from cadastro_enderecos_grupo where rua like "%'.$typing.'%" ORDER BY cidade, rua';		
	/*
	 	Busca eleitor no banco de dados	*/

	if ($result = mysqli_query($_con, $query)) {	
		/* fetch associative array */
 		while ($row = mysqli_fetch_assoc($result)) {?>
			<li onselect="this.text.value = '<?php echo $row["rua"]?>';PesquisaEleitor(<?php echo $row["CODIGO"]?>);">
			<span ><?php echo $row["rua"].",".$row["numero"]." - ".$row["cidade"] ?></span>
      <?php 
				echo $row["NOME"] ;
				$_SESSION['CodRetorno']=$row["CODIGO"];
				echo "<script>document.form1.txtcodigo.value=".$row["CODIGO"]."</script>";
			?>
			</li>
	<?php
		}
		mysqli_free_result($result);
	}	
?>
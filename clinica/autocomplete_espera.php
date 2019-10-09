<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); 
require_once ('../utilitarios/funcoes.php');

  $typing = strtoupper($_GET["typing"]);
	$query = 'SELECT * from cadastro where NOME like "%'.$typing.'%" ORDER BY NOME, CODIGO';

	if ($result = mysqli_query($_con, $query)) {	
		/* fetch associative array */
 		while ($row = mysqli_fetch_assoc($result)) {
			$para = '<script>echo "document.form1.txtCodigo.value = "'.$row['CODIGO'].'"</script>';
			?>
			<li onselect="this.text.value = '<?php echo $row["NOME"] ?>';movecodigo('<?php echo $row["CODIGO"]?>');busca_faltas('<?php echo $row["CODIGO"]?>');busca_consultas('<?php echo $row["CODIGO"]?>');busca_fone('<?php echo $row["CODIGO"]?>');">
			<span ><?php echo $row["CODIGO"] ?></span>
			<?php echo $row["NOME"] ;
			?>
			</li>
	<?php
		}
		mysqli_free_result($result);
	}	
	?>
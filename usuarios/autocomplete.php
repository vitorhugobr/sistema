<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); 
require_once ('../utilitarios/funcoes.php');
  $typing = strtoupper($_GET["typing"]);
	$query = 'SELECT * from users where nome like "%'.$typing.'%" ORDER BY nome';

	/* 	Busca eleitor no banco de dados	*/
	if ($result = mysqli_query($_con, $query)) {	
		/* fetch associative array */
 		while ($row = mysqli_fetch_assoc($result)) {
				$arquivo = "../imagens/fotos/users/".$row['foto'].".jpg";
				if (file_exists($arquivo)) {
					$imagem = $arquivo;	
				} else {
					$imagem = "../imagens/fotos/users/usuario.png";	
				}		
           ?>
            <li onselect="this.text.value = '<?php echo $row["usuario"] ?>';busca_user('<?php echo $row["usuario"] ?>')">
			<span ><?php echo $row["codigo"] ?></span>
        	<?php echo $row["nome"] ;?>
			</li>
	<?php
		}

		//}	
		/* free result set */
		mysqli_free_result($result);
	}	
	/* close connection */
function carrega_imagem($codigo) {
		$arquivo = "../imagens/fotos/users/".$codigo.".jpg";
		if (file_exists($arquivo)) {
			$imagem = $arquivo;	
		} else {
			$imagem = "../imagens/fotos/users/usuario.png";	
		}	?>	
		<script>
		document.getElementById("imgfoto").src = '<?php echo $imagem ?>';
		</script>
		<?php 
}
?>
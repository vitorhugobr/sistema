<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a p&Aacute;gina
include_once("../utilitarios/funcoes.php");
$cod = NULL;
$usuario   = "";
$nivel = 2;
$nome  = "";
$senha = md5("123456");
$email = "";

// usuario
$theValue = (!get_magic_quotes_gpc()) ? addslashes($usuario) : $usuario;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$usuario = $theValue;

// nivel
$theValue = (!get_magic_quotes_gpc()) ? addslashes($nivel) : $nivel;
$theValue = ($theValue != "") ? intval($theValue) : "NULL";
$nivel = $theValue;

// NOME
$theValue = (!get_magic_quotes_gpc()) ? addslashes($nome) : $nome;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$nome = $theValue;


// SENHA INICIAL 123456
$theValue = (!get_magic_quotes_gpc()) ? addslashes($senha) : $senha;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$senha = $theValue;

// email
$theValue = (!get_magic_quotes_gpc()) ? addslashes($email) : $email;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$email = $theValue;

$strsql = 'INSERT into users VALUES (';
$strsql .= "NULL";
$strsql .= ",".$usuario;
$strsql .= ",".$senha;
$strsql .= ",".$nivel;
$strsql .= ",".$nome;
$strsql .= ",".$email;
$strsql .= ",'NULL','usuario.png'";
$strsql .= ')';

#echo $strsql;

executa_sql($strsql,"Usuário incluído com sucesso!","Erro na inclusão do Usuário",false,false);

$sql = 'SELECT MAX(codigo) AS codigo FROM users';
$mysql_query = $_con->query($sql);
if ($mysql_query->num_rows<1) {
	echo '<script>alert("ERRO ao ler usuários!");</script>';					
}else{
	while ($dados_s = $mysql_query->fetch_assoc()) { ?>
		<script>
		document.form1.txtcodigo.value = <?php echo $dados_s['codigo']?>;
	</script>
	<?php 
	}
}



?>
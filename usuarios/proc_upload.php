<?php
  include_once("../seguranca.php");
  protegePagina();
 
	$codigo = filter_input(INPUT_POST, 'txtcodigo',FILTER_DEFAULT);
	//echo $demanda. " - ".$seq."<br>";
	$foto = $_FILES["foto"];

  	if ($foto["tmp_name"]!=""){
 		//echo $foto.'<br>';
		//  echo $codigo;
		// Largura máxima em pixels
		$largura = 1500;
		// Altura máxima em pixels
		$altura = 2000;
		// Tamanho máximo do arquivo em bytes
		$tamanho = 300000;
		$error = array();
		// Verifica se o arquivo é uma imagem
		if(!preg_match("/^image\/(pjpeg|jpeg)$/", $foto["type"])){
		   $error[1] = "Imagem não carregada - Utilizar somente extensões jpg.";
			$_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>".$error[1]."<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		} 
		// Pega as dimensões da imagem
		$dimensoes = getimagesize($foto["tmp_name"]);
		// Verifica se a largura da imagem é maior que a largura permitida
		if($dimensoes[0] > $largura) {
			$error[2] = "Imagem não carregada - A largura da imagem não deve ultrapassar ".$largura." pixels";
			$_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>".$error[2]."<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		}
		// Verifica se a altura da imagem é maior que a altura permitida
		if($dimensoes[1] > $altura) {
			$error[3] = "Imagem não carregada - Altura da imagem não deve ultrapassar ".$altura." pixels";
			$_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>".$error[3]."<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		}
		// Verifica se o tamanho da imagem é maior que o tamanho permitido
		if($foto["size"] > $tamanho) {
			$error[4] = "Imagem não carregada - A imagem deve ter no máximo ".$tamanho." bytes";
			$_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>".$error[4]."<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		}
		// Se não houver nenhum erro
		if (count($error) == 0) {
			// Pega extensão da imagem
			preg_match("/\.(jpg|jpeg){1}$/i", $foto["name"], $ext);
			// Gera um nome único para a imagem
			$nome_imagem =  $codigo;
			//echo $nome_imagem."<br>";
			// Caminho de onde ficará a imagem
			$caminho_imagem = "../imagens/fotos/users/".$nome_imagem.".jpg";
			// Faz o upload da imagem para seu respectivo caminho
			$moved = move_uploaded_file($foto["tmp_name"], $caminho_imagem);
			$_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Imagem enviada com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
			if(!$moved ) {
				$error[5] = "Imagem não carregada - error #".$_FILES["file"]["error"];
				$_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>".$error[5]."<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
			}else{
				$sql = "UPDATE users SET foto='$nome_imagem.jpg' WHERE codigo=$codigo";
    	         $pdosql = new PDO("mysql:host=".$_SESSION['servidor'].";dbname=".$_SESSION['banco'].";",$_SESSION['usuario'], $_SESSION['senha']);
				$pdosql->exec("set names utf8");
				$pdosql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				array(PDO::ATTR_PERSISTENT => true);
				//echo $msgok;
				try{
					$statementSql = $pdosql->prepare($sql);
					$statementSql->execute();
				}catch(PDOException $e){  // Caso ocorra algum erro exibe a mensagem
					if ($e->errorInfo[1] == 1062) {      // duplicate entry, do something else
						$_SESSION['msg'] = "<div class='alert alert-danger' role='alert'><i class='fas fa-exclamation' aria-hidden='true text-muted' aria-hidden='true'></i> ".$msgerro.". JÁ EXISTE ESTE REGISTRO!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";  		
					} else {      // an error other than duplicate entry occurred
						$_SESSION['msg'] = "<div class='alert alert-danger' role='alert'><i class='fas fa-exclamation' aria-hidden='true text-muted' aria-hidden='true'></i> ".$msgerro." Motivo:\n".$e->getMessage()."<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";  			
					}
					//die;
				}
				$pdosql= null;
			}
		}	
		// Se houver mensagens de erro, exibe-as
  		header("Location: upload_imagem.php");		
	  }else{	  
		header("Location: upload_imagem.php");		
	  }
?>
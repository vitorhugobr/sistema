<?php
  include_once("../seguranca.php");
  protegePagina();
  include_once("../utilitarios/funcoes.php");
 
	$demanda = filter_input(INPUT_POST, 'demanda',FILTER_DEFAULT);
	$seq = filter_input(INPUT_POST, 'seq',FILTER_DEFAULT);
	echo $demanda. " - ".$seq."<br>";
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
		   $error[1] = "Utilizar somente extensões jpg.";
		} 
		// Pega as dimensões da imagem
		$dimensoes = getimagesize($foto["tmp_name"]);
		// Verifica se a largura da imagem é maior que a largura permitida
		if($dimensoes[0] > $largura) {
			$error[2] = "A largura da imagem não deve ultrapassar ".$largura." pixels";
		}
		// Verifica se a altura da imagem é maior que a altura permitida
		if($dimensoes[1] > $altura) {
			$error[3] = "Altura da imagem não deve ultrapassar ".$altura." pixels";
		}
		// Verifica se o tamanho da imagem é maior que o tamanho permitido
		if($foto["size"] > $tamanho) {
			$error[4] = "A imagem deve ter no máximo ".$tamanho." bytes";
		}
		// Se não houver nenhum erro
		if (count($error) == 0) {
			// Pega extensão da imagem
			preg_match("/\.(jpg|jpeg){1}$/i", $foto["name"], $ext);
			// Gera um nome único para a imagem
			$nome_imagem =  "D".str_pad($demanda, 7, '0', STR_PAD_LEFT).str_pad($seq, 3, '0', STR_PAD_LEFT);
			echo "nome imagem ".$nome_imagem."<br>";
			// Caminho de onde ficará a imagem
			$caminho_imagem = "../imagens/demandas/".$nome_imagem.".jpg";
			// Faz o upload da imagem para seu respectivo caminho
			$moved = move_uploaded_file($foto["tmp_name"], $caminho_imagem);
			$_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Imagem enviada com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
			if(!$moved ) {
				$error[5] = "Imagem não carregada - error #".$_FILES["file"]["error"];
				$_SESSION['msg'] = "<div class='alert alert-success' role='alert'>".$error[5]."<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
			}
		}	
		// Se houver mensagens de erro, exibe-as
		if (count($error) != 0) {
			foreach ($error as $erro) {
				echo $erro . "<br />";
			}
		}else{
		  echo '<script>alert ("Envio de imagem com sucesso!\nSe necessário, pressione Recarregar Página.");</script>';
		  echo "<script>self.window.close();</script>";
		}
	  }else{	  
		  echo "<script>self.window.close();</script>";
	  }
?>
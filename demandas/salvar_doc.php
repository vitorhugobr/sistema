<?php
  include_once("../seguranca.php");
  protegePagina();
  include_once("../utilitarios/funcoes.php");
  include_once("func_upl_arq.php");
 
	$demanda = $_GET['demanda'];

	//echo $demanda."<br>";
 
	$msg = false;

	if( isset($_POST['enviou']) && $_POST['enviou'] == 1 ){
 
    // arquivo
	$arquivo = $_FILES['arquivo'];
 
    // Tamanho máximo do arquivo (em Bytes)
    $tamanhoPermitido = 1024 * 1024 * 2; // 2Mb
 
    //Define o diretorio para onde enviaremos o arquivo
    $diretorio = "../imagens/demandas/";
 
    // verifica se arquivo foi enviado e sem erros
    if( $arquivo['error'] == UPLOAD_ERR_OK ){
 
        // pego a extensão do arquivo
        $extensao = extensao($arquivo['name']);
 
        // valida a extensão
        if( in_array( $extensao, array("pdf") ) ){
 
            // verifica tamanho do arquivo
            if ( $arquivo['size'] > $tamanhoPermitido ){
 
                $msg = "<strong>Aviso!</strong> O arquivo enviado é muito grande, envie arquivos de até ".$tamanhoPermitido/MB." MB.";
                $class = "alert-warning";
 
            }else{
 
                // atribui novo nome ao arquivo
				$novo_nome = "D".str_pad($demanda, 7, '0', STR_PAD_LEFT)."000".".".$extensao;
                //$novo_nome  = md5(time()).".".$extensao;
 
				echo $novo_nome;
                // faz o upload
                $enviou = move_uploaded_file($_FILES['arquivo']['tmp_name'], $diretorio.$novo_nome);
 
                if($enviou){
					$_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Arquivo enviado com sucesso<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";			
                }else{
					$_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Arquivo NÃO enviado<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";			                    $msg = "<strong>Erro!</strong> Falha ao enviar o arquivo.";
                }
            }
 
        }else{
			$_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Somente arquivos PDF são permitidos<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";			                    $msg = "<strong>Erro!</strong> Falha ao enviar o arquivo.";
        }
 
    }else{
		$_SESSION['msg'] = "<div class='alert alert-info' role='alert'>Você deve enviar um arquivo<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";			
    }
	echo "<script>self.window.close();</script>";
}
?>
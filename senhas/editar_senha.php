<?php
session_start();
include_once("../connections/banco.php");
if(!empty($_GET['chave'])){
	$chave_alt_senha = $_GET['chave'];
	$result_usuario = "SELECT * FROM users WHERE recuperar_senha = '$chave_alt_senha'";
	$resultado_usuario = mysqli_query($_con, $result_usuario);
	$row_usuario = mysqli_fetch_assoc($resultado_usuario);
	if(isset($row_usuario)){
		$usuario_id = $row_usuario['codigo'];
		?>
    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Cesar Szpak - Celke">
    <link rel="stylesheet" type="text/css" href="../css/formata_textos.css">
    <link rel="icon" href="../imagens/favicon.ico">
    <title>Nova Senha</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <link href="../css/signin.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/botoes.css"/>
    <link rel="stylesheet" type="text/css" href="../css/sticky-footer-navbar.css">
    <script src="../js/ie-emulation-modes-warning.js"></script>
    </head>
    <body>
      <h1 align="center"><img src="../imagens/vhmo.png" width="32" height="32"><span class="sigla_sistema"> 
      <?php echo $_SESSION['sistemaabrev']?> -</span> <span class="politico"><?php echo $_SESSION['politico'] ?></span> <img src="../imagens/vhmo.png" alt="" width="32" height="32"></h1>
      <h5 align="center">
      <div id="time" class="rodape"></div>
      <script >
        function checkTime(i) {
            if (i < 10) {
                i = "0" + i;
            }
            return i;
        }
        function startTime() {
            var today = new Date();
            var h = today.getHours();
            var m = today.getMinutes();
            var s = today.getSeconds();
            // add a zero in front of numbers<10
            m = checkTime(m);
            s = checkTime(s);
            document.getElementById('time').innerHTML = h + ":" + m + ":" + s;
            t = setTimeout(function () {
                startTime()
            }, 500);
        }
        startTime();
        </script>
      <div id="time" class="rodape">
      <?php echo date('d/m/Y')?></div></h5>
      <div class="container">
      <form class="form-signin" method="POST" action="adm_proc_edita_senha.php">
      <h2 class="form-signin-heading">Insira a nova senha</h2>
      <label for="inputEmail" class="sr-only">Senha</label>
      <input type="password" name="txt_senha" id="inputEmail" class="form-control" placeholder="Digite sua nova senha" autofocus 
      <?php
        if(!empty($_SESSION['value_senha'])){
          echo "value='".$_SESSION['value_senha']."'";
          unset($_SESSION['value_senha']);
        }
      ?>					
      />
      <?php 
        if(!empty($_SESSION['usuario_senha_vazio'])){
          echo "<p style='color: #ff0000; '>".$_SESSION['usuario_senha_vazio']."</p>";
          unset($_SESSION['usuario_senha_vazio']);
        }
      ?>
      <input type="hidden" name="id" value="<?php echo $usuario_id; ?>">
      <button class="btn btn-lg btn-success btn-block" type="submit">Atualizar</button>
      <div class="row text-center" style="margin-top:20px;">
	      <a href="../index.php">Login</a>
      </div>
      </form>
    </div>
    <!-- /container --> 
    <script src="../js/ie10-viewport-bug-workaround.js"></script>
    </body>
    </html>
	<?php
	}else{
		$_SESSION['recuperar_senha'] = "Código de recuperação inválido.";
		echo "<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=recuperar_senha.php'>";	
	}
}else{
	$_SESSION['recuperar_senha'] = "Código de recuperação inválido.";
	echo "<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=recuperar_senha.php'>";	
}

<?php  
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); 
include_once("../utilitarios/funcoes.php");
$_SESSION['funcao'] = "Usuários";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Cadastro de Usuários">
<meta name="author" content="Vitor H M Oliveira">
<link rel="stylesheet" type="text/css" href="../css/autocomplete.css" />
<link rel="stylesheet" href="../css/ajax.css" type="text/css">
<link rel="icon" href="../imagens/favicon.ico" />
<link rel="stylesheet" href="../css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../css/sticky-footer-navbar.css"/>
<link rel="stylesheet" type="text/css" href="../css/formata_textos.css"/>
<link href="../css/botoes.css" rel="stylesheet">
<link href="../css/all.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../css/font-awesome.css"/>
<title>Usu&aacute;rios</title>
<script language="javascript" src="../js/ajax.js"></script>
<script language="javascript" src="../js/carrega_ajax.js"></script>
<script language="javascript" src="../js/usuarios.js"></script>
<script type="text/javascript" src="../js/autocomplete.js"></script>
<script src="../js/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script>
	$(document).on('change', "[name='txtusuario']", function(){
		if (document.form1.txtnome.value > ""){
			document.getElementById('msg_alt_usu').innerHTML = "Nome do usuário ALTERADO! <strong>Login</strong> também será alterado.";
			document.form1.mudou_usuario.value = 1;
		}
	});
    window.onload = function() {
        document.getElementById("btncancela").style.display="none";
        document.getElementById("btngrava").style.display="none";
        document.getElementById("btnexclui").style.display="none";
    };
</script>
</head>
<body leftmargin="0" topmargin="0" marginheight="0" marginwidth="0">
<div class="nav fixed-top container-fluid shadow mt-0 mb-0 bg-white rounded sticky-top">
<?php include_once("../utilitarios/cabecalho.php");?>
  <nav class="navbar navbar-expand-sm navbar-light shadow-sm">
  	<div class="container">
    	<span class="navbar-brand">
        </span>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
			  <?php 
              if (liberado(4000)>0){   
                echo '<li class="nav-item"><button type="button" name="btnnovo" id="btnnovo" class="btn btn-sm btn-incluir" onclick="inclui_usuario()">
				<i class="fas fa-plus"></i> Novo
			         </button></li>';
                echo '<li class="nav-item"><button type="button" name="btngrava" id="btngrava" class="btn btn-success btn-sm" value="Gravar" onClick="altera_usuario()" >
				<i class="fas fa-save"></i> Gravar
                    </button></li>';
                echo '<li class="nav-item"><button type="button" class="btn btn-sm btn-excluir" name="btnexclui" id="btnexclui" onclick="excluir_usuario()" >
				<i class="fas fa-user-times" aria-hidden="true text-muted" aria-hidden="true"></i> Excluir
			         </button></li>';
                echo '<li class="nav-item"><button type="button" id="btncancela" name="btncancela" class="btn btn-sm btn-cancelar" onclick="deleta_cancela_usuario()">
				<i class="fas fa-undo" aria-hidden="true text-muted" aria-hidden="true"></i> Cancelar
			         </button></li>';
              }
              echo '<li class="nav-item"><button type="button" class="btn btn-sm btn-limpatela" onclick="javascript:location.reload();">
				<i class="fas fa-eraser" aria-hidden="true text-muted" aria-hidden="true"></i> Limpar Tela
			    </button></li>';
                ?>
              <li class="nav-item">
                  <a href="../senhas/index.php" class="btn btn-voltar btn-sm" role="button">
                      <i class="fas fa-backward" aria-hidden="true"></i>  Voltar
                  </a>
              </li>
              <li class="nav-item">
                  <a href="../index2.php" class="btn btn-menu btn-sm" role="button">
                      <i class="fas fa-list-ul" aria-hidden="true"></i>  Menu
                  </a>
              </li>
          </ul>
      </div>
   	</div>
   </nav>
 </div>
	<?php
	if(isset($_SESSION['msg'])){
		echo $_SESSION['msg'];
		unset($_SESSION['msg']);
	}
	?><div id="carga_foto"></div>
<form action="" method="post" name="form1" id="form1" enctype="multipart/form-data">
      <table width="100%" border="0">
        <tr>
          <td width="16%">&nbsp;</td>
          <td width="68%">&nbsp;</td>
          <td width="16%" rowspan="6" align="center">
          	<div class="img-fluid text-center" style="width:220px"> 
			<img src="../imagens/fotos/users/usuario.png" class="rounded" alt="Foto" name="imgfoto" id="imgfoto" width="100"/>
			</div>
		  </td>
    	</tr>
        <tr>
          <td class="nomedocampo">Usu&aacute;rio:</td>
          <td>
          	<div class="col-sm-7">
				<input name="txtusuario" type="text" autofocus class="form-control" id="txtusuario" size="30" maxlength="100"  onChange="javascript:mudou();">
				<i class="help-block">Informe o nome ou parte do nome do usuário</i>	
				<input type="hidden" name="txtcodigo" id="txtcodigo" />
				<div id="msg_alt_usu" class="text text-danger"></div>
				<input type="hidden" name="mudou_usuario" value="0" id="mudou_usuario"> 
				<input type="hidden" name="nome_usuario" value="" id="nome_usuario" placeholder="Nome Usuário"> 
			</div>
		  </td>
        </tr>
        <tr>
          <td class="nomedocampo">N&iacute;vel:</td>
          <td>
          	<div class="col-sm-3">
			<select name="txtnivel" class="form-control" id="txtnivel">
           <?php
				if($_SESSION['usuarioNivel']==0){ ?>
					<option value="0">Desenvolvedor</option>
			<?php
				}
			?>
            <option value="1">Administrador</option>
            <option value="2" selected="selected">Gabinete</option>
            <option value="9">Web</option>
          	</select>
            </div>
          </td>
        </tr>
        <tr>
          <td class="nomedocampo">Nome:</td>
          <td>
            <div class="col-sm-5">
          	<input name="txtnome" type="text" class="form-control" id="txtnome" size="60" maxlength="60"/>
            </div>
          </td>
        </tr>
        <tr>
          <td class="nomedocampo">E-mail:</td>
          <td>
            <div class="col-sm-8">
              <input name="txtemail" type="text" class="form-control" id="txtemail" size="60" maxlength="100"/>
              </div>          
          </td>
        </tr>
        <tr>
          <td class="nomedocampo">&nbsp;</td>
          <td>
            <input name="txtsenha" type="hidden" id="txtsenha" size="50" maxlength="50" />
            <input name="txtconfirma" type="hidden" id="txtconfirma" size="50" maxlength="50" />
          </td>
        </tr>
	</table>
    <div class="container-fluid"s>
    	<div class="row text-primary">
          	<strong>Usuário(s) Cadastrado(s):</strong></div>
          	<div class="row text-success">
			<div class="col-4"><strong><i>Usuário</i></strong></div>
			<div class="col-4"><strong><i>Nome do Usuário</i></strong></div>
			<div class="col-4"><strong><i>E-mail do Usuário</i></strong></div>
			<?php
			$sql = "select * from users order by nome";
			$mysql_query = $_con->query($sql);
			$set_corfundo = 0;
			if ($mysql_query->num_rows>0) {
				while ($_row = $mysql_query->fetch_assoc()) { ?>
					<div class="row col-12 text-dark 
						<?php
						if ($set_corfundo==0){
							echo 'bg-light';
							$set_corfundo = 1;
						} else {
							echo 'bg-white';
							$set_corfundo = 0;
						}
						?>
					  ">
						<div class="col-4">
							<a href="javascript:busca_user('<?php echo $_row['usuario']?>')" class="text text-primary"><img class="rounded-circle" src="../imagens/fotos/users/<?php echo $_row['foto'] ?>" width="50" height="50">&nbsp;<?php echo $_row['usuario'];?></a>
						</div>
						<div class="col-4 text-dark" style="line-height: 20px; height: 20px; padding: 12px;"> 
							<?php echo $_row['nome']; ?>
						</div>
						<div class="col-4 text-dark" style="line-height: 20px; height: 20px; padding: 12px;"> 
							<?php echo $_row['email']; ?>
						</div>
					</div>
				<?php }
			}?>
		</div>
	</div>
</form>
<?php include_once("../utilitarios/rodape-fixo.php");?>
<script type="text/javascript">
  new Autocomplete("txtusuario", function() { return "autocomplete.php?typing=" + this.text.value;});
</script>
</body>
</html>

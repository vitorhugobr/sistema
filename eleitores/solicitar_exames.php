<?php
include_once("../seguranca.php");
protegePagina();
include_once("../utilitarios/funcoes.php");
date_default_timezone_set('America/Sao_Paulo');
$cod_cadastro = $_GET['cod_cadastro'];
if (!isset($id)){
	$id = "NULL";
}else{
	$id = "$id";
}

$query = "SELECT * from cadastro WHERE cadastro.CODIGO = $cod_cadastro";
//		echo $query;
$mysql_query = $_con->query($query);
if ($mysql_query->num_rows<1) {
	echo '<script>alert("ELEITOR não cadastrado!");</script>';					
}else{
	while ($dados_s = $mysql_query->fetch_assoc()) {
		$nome = $dados_s['NOME'];
	}
}

$query2 = "SELECT * from cadastro_exames order by descricao";
//		echo $query;
$exames="";
$mysql_query2 = $_con->query($query2);
if ($mysql_query2->num_rows>0) {
	echo '<input name="total_exames" type="hidden" id="total_exames" value="'.$mysql_query2->num_rows.'" />';
	while ($dados_receita = $mysql_query2->fetch_assoc()) {
		$id = $dados_receita['id'];
		$descricao = $dados_receita['descricao'];
		$exames .= ' <tr><td width="7%"><input name="chkexame" type="checkbox" class="form-control">';
		$exames .= '<input name="id_exame" type="hidden" id="id_exame" value="'.$id.'" />';
		$exames .= '</td><td width="93%">'.$descricao.'</td></tr>';
	}
}


$_SESSION['funcao']="Solicitação de Exames";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Solictação de Exames">
<meta name="author" content="Vitor H M Oliveira">
<title>Exames para<?php echo $nome ?></title>
<link rel="icon" href="../imagens/favicon.ico">
<link href="../css/formata_textos.css" rel="stylesheet">
<link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">
<link href="../css/sticky-footer-navbar.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../css/ajax.css"/>
<link rel="stylesheet" type="text/css" href="../css/autocomplete.css"/>
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="../css/all.css"/>
<link href="../css/botoes.css" rel="stylesheet">
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" role="document">
<?php include_once("../utilitarios/cabecalho.php");?>
<!-- --------------------------------------------------------------------------------------- --> 
<!-- --- paramêtro 1 passado a seguir significa que será incluído - insert  --> 
<!-- --------------------------------------------------------------------------------------- -->
  <?php
	if(isset($_SESSION['msg'])){
		echo $_SESSION['msg'];
		unset($_SESSION['msg']);
	}
	?>

<form class="needs-validation" novalidate name="form1" method="post" action="" id="form1">
  <section id="corpo" class="container-fluid">
    <input type="hidden" name="cod_cadastro" id="cod_cadastro" value="<?php echo $cod_cadastro?>">
    <table class="table-borderless">
      <thead>
        <tr>
          <th colspan="2" class="text-dark text-center"> Exames para <?php echo $nome?> </th>
        </tr>
        <tr>
          <th>  
            <div class="text-center">
              <button type="button" class="btn btn-sm btn-incluir" onclick="javascript:gravar_exames(<?php echo $cod_cadastro;?>,<?php echo $mysql_query2->num_rows;?>)">
                <i class="fas fa-save" aria-hidden="true"></i> Gravar </button>
              <button type="button" class="btn btn-sm btn-voltar" onclick="javascript:voltaPag('cadastro.php#tela_exames');">
                <i class="fas fa-arrow-left" aria-hidden="true"></i> Voltar Cadastro
              </button>
            </div>
          </th>      
      </tr>
      </thead>
      <tbody>
        <tr>
          <th scope="row" width="15%" align="right"> <div class="col-12 col-8">
              <label>Data do Exame:</label>
            </div>
          </th>
          <td width="85%"><div class="col-3">
              <input type="date" class="form-control" name="data_exame" id="data_exame" required="required" autofocus="autofocus" />
            </div></td>
        </tr>
        <tr>
          <td colspan="2"><hr /></td>
        </tr>
        <tr>
          <th scope="row" width="15%" align="right" valign="top"> </th>
          <td width="85%"><table class="table table-striped table-sm">
              <div class="col-12"> <?php echo $exames
                        ?> </div>
            </table></td>
        </tr>
      </tbody>
    </table>
  </section>
</form>
<script src="../js/exames.js"></script> 
<script src="../js/jquery.min.js"></script> 
<script src="../js/bootstrap.min.js"></script> 
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug --> 
<script src="../js/ie10-viewport-bug-workaround.js"></script> 
<script src="../js/carrega_ajax.js" type="text/javascript"></script> 
<script src="../js/ajax.js" type="text/javascript"></script> 
<script src="../js/ie-emulation-modes-warning.js"></script> 
<script type="text/javascript" src="../js/autocomplete.js"></script>
<?php include_once("../utilitarios/rodape.php");?>
</body>
</html>

<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
require_once("../utilitarios/funcoes.php");
if (liberado(6100)==0){
	expulsaVisitante2();
	return;
}
if (isset($_GET["tipo"])){
	$tipo = $_GET["tipo"];
}else{
	$tipo = "G";
}
if (isset($_GET["opcao"])){
	$opcao = $_GET["opcao"];
}else{
	$opcao = 1;
}
if ($opcao==1){
	$_SESSION['funcao']="Relatórios";
}else{	
	$_SESSION['funcao']="Etiquetas";	
}
if ($opcao==8){
	$_SESSION['funcao']="Exportar Excel";
};

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Cadastro de Eleitores">
<meta name="author" content="Vitor H M Oliveira">
<title>Relatórios - Multi</title>
<link rel="icon" href="../imagens/favicon.ico">
<link href="../css/formata_textos.css" rel="stylesheet">
<link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">
<link href="../css/sticky-footer-navbar.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../css/ajax.css"/>
<link rel="stylesheet" type="text/css" href="../css/autocomplete.css"/>
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="../css/all.min.css"/>
<link rel="stylesheet" type="text/css" href="../css/botoes.css">
<link rel="stylesheet" type="text/css" href="../css/bootstrap-grid.css"/>
<link rel="stylesheet" type="text/css" href="../css/bootstrap-datetimepicker.css"/>
<link rel="stylesheet" type="text/css" href="../css/docs.min.css"/>
<link href="../css/botoes.css" rel="stylesheet">
<script language="javascript" src="../js/relatorios.js"></script>
<script src="../js/carrega_ajax.js" type="text/javascript"></script>
<script src="../js/ajax.js" type="text/javascript"></script>
<script src="../js/ie-emulation-modes-warning.js"></script>
<script src="../js/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script type="text/javascript" src="../js/autocomplete.js"></script>
<script src="../js/ie10-viewport-bug-workaround.js"></script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" role="document"  onFocus="javascript:location.reload();">

<?php include_once("../utilitarios/cabecalho.php");?>
	<?php
	if(isset($_SESSION['msg'])){
		echo $_SESSION['msg'];
		unset($_SESSION['msg']);
	}
	?>

	<form name="form1" method="POST" action="monta.php" target="_blank">
  	<div class="custom-control custom-checkbox custom-control-inline">
		 <input name="htipo" type="hidden" id="htipo" value="<?php echo $tipo; ?>">
		 <?php if ($_SESSION['funcao']=="Exportar Excel") {?>
		 	<button class="btn btn-consultar btn-sm" type="submit"><i class="fas fa-search"></i> Exportar Excel</button>
		 <?php } else {?>
		 	<button class="btn btn-consultar btn-sm" type="submit"><i class="fas fa-search"></i> Gerar PDF</button>
		 <?php }?>
		 <input name="htipo" type="hidden" id="htipo" value="<?php echo $tipo; ?>">
	  	<a href="relatorios.php" class="btn btn-voltar btn-sm" role="button">
		  <i class="fas fa-arrow-left"></i> Voltar
	  	</a>
		 <input name="hopcao" type="hidden" id="hopcao" value="<?php echo $opcao; ?>">
				  <a href="../index2.php" class="btn btn-menu btn-sm" role="button">
					  <i class="fas fa-list-ul"></i> Menu
				  </a>
		<input name="hPV" type="hidden" id="hPV">
  	</div>
  		<div class="text-center"> Defina quais registros serão selecionados:&nbsp;&nbsp;
            <p>
                <input type="radio" name="condicao" value="T" onClick="setacondicao(3)" checked/> Todos
                <input type="radio" name="condicao" value="A" onClick="setacondicao(1)"/> Ativos
                <input type="radio" name="condicao" value="I" onClick="setacondicao(0)"/> Inativos
            </p>
		<input name="condition" type="hidden" id="condition" value="3">
		</div>

		<table class="table table-striped table-sm">
			<thead class="thead-dark">
			  <tr>
				<th width="20%">
					Campo
				</th>
				<th width="10%">
					Operador
				</th>
				<th width="50%">
					Expressão
				</th>
				<th width="5%">
					Conector
				</th>
				<th width="15%">
					Classificar
				</th>
			  </tr>

<!--	// fazer loop para linha	-->		
		<?php  for($i =1; $i < 13; $i++){
			echo '<tr>
			  <td><select name="campo'.$i.'" id="campo'.$i.'">
					<option value="" selected></option>
					<option value="nome">Nome</option>
					<option value="campanha">Campanha</option>
					<option value="grupo">Grupo</option>
					<option value="origem">Origem</option>
					<option value="profissao">Profissão</option>
					<option value="ramo">ramo</option>
					<option value="seccao">Seção Eleitoral</option>
					<option value="zonal">Zonal Eleitoral</option>
					<option value="rua">Logradouro</option>
					<option value="cidade">Cidade</option>
					<option value="bairro">Bairro</option>
					<option value="numero">Número</option>
					<option value="complemento">Complemento</option>
					<option value="recebemat">Recebe Material</option>
					</select>
			  </td>
			  <td><select name="operador'.$i.'" id="operador'.$i.'">
					<option value ="" selected="selected"></option>
					<option value="=">Igual</option>
					<option value=">">Maior</option>
					<option value="<">Menor</option>
					<option value=">=">Maior ou Igual</option>
					<option value="<=">Menor ou Igual</option>
					<option value="like">Contém</option>
					</select></td>
			  <td>
				<div id="expression'.$i.'"></div>	
				<input id="valorexpressao'.$i.'" name="valorexpressao'.$i.'" type="hidden">
				<input id="textoexpressao'.$i.'" name="textoexpressao'.$i.'" type="hidden">
				</td>
			  <td>
				<select name="conector'.$i.'" id="conector'.$i.'">
					<option selected="selected">
					</option><option value="and">E</option>
					<option value="or">OU</option></select>
				</td>
			  <td>
				<select name="classifica'.$i.'" id="classifica'.$i.'">
					<option selected="selected"></option>
					<option value="N">Não</option>
					<option value="S">Sim</option>
					</select>
			  </td>
			</tr>';
			} ?>
		  </tbody>
		</table>
	</form>

	<script type="text/javascript">
	$(function(){
		$('#campo1').change(function(){
			if( $(this).val() ) {
				var campoescolhido = $(this).val();
				var temselect = false;
				switch(campoescolhido) {
				  case "campanha":
					temselect = true;
					break;
				  case "grupo":
					temselect = true;
					break;
				  case "origem":
					temselect = true;
					break;
				  case "profissao":
					temselect = true;
					break;
				  case "ramo":
					temselect = true;
					break;
				  default:
					temselect = false;
				}
				if(temselect){
					AjaxRequest();
					if(!Ajax) {
						alert('Não foi possível iniciar o AJAX');
						return;
					}
					var items='<select id="expressao1" name="expressao1" onChange="myPrametros(1, this.value)"><option selected="selected">Selecione</option>';
					$.getJSON("busca_descricao.php?campoesc="+campoescolhido,function(data){
					$.each(data,function(index,item) 
					{
						items+="<option value='"+item.id+"'>"+item.descricao+"</option>";
					});
					items+="</select>";
					$("#expression1").html(items); 
					});
				}else{
					var items ='<input id="expressao1" type="text" name="expressao1" onChange="valorexpressao1.value = this.value;textoexpressao1.value = this.value">';
					$("#expression1").html(items); 
				}
			}
		});
		$('#campo2').change(function(){
			if( $(this).val() ) {
				var campoescolhido = $(this).val();
				var temselect = false;
				switch(campoescolhido) {
				  case "campanha":
					temselect = true;
					break;
				  case "grupo":
					temselect = true;
					break;
				  case "origem":
					temselect = true;
					break;
				  case "profissao":
					temselect = true;
					break;
				  case "ramo":
					temselect = true;
					break;
				  default:
					temselect = false;
				}
				if(temselect){
					AjaxRequest();
					if(!Ajax) {
						alert('Não foi possível iniciar o AJAX');
						return;
					}
					var items='<select id="expressao2" name="expressao2" onChange="myPrametros(2, this.value)"><option selected="selected">Selecione</option>';
					$.getJSON("busca_descricao.php?campoesc="+campoescolhido,function(data){
					$.each(data,function(index,item) 
					{
						items+="<option value='"+item.id+"'>"+item.descricao+"</option>";
					});
					items+="</select>";
					$("#expression2").html(items); 
					});
				}else{
					var items ='<input id="expressao2" type="text" name="expressao2" onChange="textoexpressao2.value = this.value;textoexpressao2.value = this.value">';
					$("#expression2").html(items); 
				}
			}
		});		
		$('#campo3').change(function(){
			if( $(this).val() ) {
				var campoescolhido = $(this).val();
				var temselect = false;
				switch(campoescolhido) {
				  case "campanha":
					temselect = true;
					break;
				  case "grupo":
					temselect = true;
					break;
				  case "origem":
					temselect = true;
					break;
				  case "profissao":
					temselect = true;
					break;
				  case "ramo":
					temselect = true;
					break;
				  default:
					temselect = false;
				}
				if(temselect){
					AjaxRequest();
					if(!Ajax) {
						alert('Não foi possível iniciar o AJAX');
						return;
					}
					var items='<select id="expressao3" name="expressao3" onChange="myPrametros(3, this.value)"><option selected="selected">Selecione</option>';
					$.getJSON("busca_descricao.php?campoesc="+campoescolhido,function(data){
					$.each(data,function(index,item) 
					{
						items+="<option value='"+item.id+"'>"+item.descricao+"</option>";
					});
					items+="</select>";
					$("#expression3").html(items); 
					});
				}else{
					var items ='<input id="expressao3" type="text" name="expressao3"  onChange="textoexpressao3.value = this.value;textoexpressao3.value = this.value">';
					$("#expression3").html(items); 
				}
			}
		});
		$('#campo4').change(function(){
			if( $(this).val() ) {
				var campoescolhido = $(this).val();
				var temselect = false;
				switch(campoescolhido) {
				  case "campanha":
					temselect = true;
					break;
				  case "grupo":
					temselect = true;
					break;
				  case "origem":
					temselect = true;
					break;
				  case "profissao":
					temselect = true;
					break;
				  case "ramo":
					temselect = true;
					break;
				  default:
					temselect = false;
				}
				if(temselect){
					AjaxRequest();
					if(!Ajax) {
						alert('Não foi possível iniciar o AJAX');
						return;
					}
					var items='<select id="expressao4" name="expressao4" onChange="myPrametros(4, this.value)"><option selected="selected">Selecione</option>';
					$.getJSON("busca_descricao.php?campoesc="+campoescolhido,function(data){
					$.each(data,function(index,item) 
					{
						items+="<option value='"+item.id+"'>"+item.descricao+"</option>";
					});
					items+="</select>";
					$("#expression4").html(items); 
					});
				}else{
					var items ='<input id="expressao4" type="text" name="expressao4" onChange="textoexpressao4.value = this.value;textoexpressao4.value = this.value">';
					$("#expression4").html(items); 
				}
			}
		});		
		$('#campo5').change(function(){
			if( $(this).val() ) {
				var campoescolhido = $(this).val();
				var temselect = false;
				switch(campoescolhido) {
				  case "campanha":
					temselect = true;
					break;
				  case "grupo":
					temselect = true;
					break;
				  case "origem":
					temselect = true;
					break;
				  case "profissao":
					temselect = true;
					break;
				  case "ramo":
					temselect = true;
					break;
				  default:
					temselect = false;
				}
				if(temselect){
					AjaxRequest();
					if(!Ajax) {
						alert('Não foi possível iniciar o AJAX');
						return;
					}
					var items='<select id="expressao5" name="expressao5" onChange="myPrametros(5, this.value)"><option selected="selected">Selecione</option>';
					$.getJSON("busca_descricao.php?campoesc="+campoescolhido,function(data){
					$.each(data,function(index,item) 
					{
						items+="<option value='"+item.id+"'>"+item.descricao+"</option>";
					});
					items+="</select>";
					$("#expression5").html(items); 
					});
				}else{
					var items ='<input id="expressao5" type="text" name="expressao5" onChange="textoexpressao5.value = this.value;textoexpressao5.value = this.value">';
					$("#expression5").html(items); 
				}
			}
		});
		$('#campo6').change(function(){
			if( $(this).val() ) {
				var campoescolhido = $(this).val();
				var temselect = false;
				switch(campoescolhido) {
				  case "campanha":
					temselect = true;
					break;
				  case "grupo":
					temselect = true;
					break;
				  case "origem":
					temselect = true;
					break;
				  case "profissao":
					temselect = true;
					break;
				  case "ramo":
					temselect = true;
					break;
				  default:
					temselect = false;
				}
				if(temselect){
					AjaxRequest();
					if(!Ajax) {
						alert('Não foi possível iniciar o AJAX');
						return;
					}
					var items='<select id="expressao6" name="expressao6" onChange="myPrametros(6, this.value)"><option selected="selected">Selecione</option>';
					$.getJSON("busca_descricao.php?campoesc="+campoescolhido,function(data){
					$.each(data,function(index,item) 
					{
						items+="<option value='"+item.id+"'>"+item.descricao+"</option>";
					});
					items+="</select>";
					$("#expression6").html(items); 
					});
				}else{
					var items ='<input id="expressao6" type="text" name="expressao6" onChange="textoexpressao6.value = this.value;textoexpressao6.value = this.value">';
					$("#expression6").html(items); 
				}
			}
		});		
		$('#campo7').change(function(){
			if( $(this).val() ) {
				var campoescolhido = $(this).val();
				var temselect = false;
				switch(campoescolhido) {
				  case "campanha":
					temselect = true;
					break;
				  case "grupo":
					temselect = true;
					break;
				  case "origem":
					temselect = true;
					break;
				  case "profissao":
					temselect = true;
					break;
				  case "ramo":
					temselect = true;
					break;
				  default:
					temselect = false;
				}
				if(temselect){
					AjaxRequest();
					if(!Ajax) {
						alert('Não foi possível iniciar o AJAX');
						return;
					}
					var items='<select id="expressao7" name="expressao7" onChange="myPrametros(7, this.value)"><option selected="selected">Selecione</option>';
					$.getJSON("busca_descricao.php?campoesc="+campoescolhido,function(data){
					$.each(data,function(index,item) 
					{
						items+="<option value='"+item.id+"'>"+item.descricao+"</option>";
					});
					items+="</select>";
					$("#expression7").html(items); 
					});
				}else{
					var items ='<input id="expressao7" type="text" name="expressao7" onChange="textoexpressao7.value = this.value;textoexpressao7.value = this.value">';
					$("#expression7").html(items); 
				}
			}
		});
		$('#campo8').change(function(){
			if( $(this).val() ) {
				var campoescolhido = $(this).val();
				var temselect = false;
				switch(campoescolhido) {
				  case "campanha":
					temselect = true;
					break;
				  case "grupo":
					temselect = true;
					break;
				  case "origem":
					temselect = true;
					break;
				  case "profissao":
					temselect = true;
					break;
				  case "ramo":
					temselect = true;
					break;
				  default:
					temselect = false;
				}
				if(temselect){
					AjaxRequest();
					if(!Ajax) {
						alert('Não foi possível iniciar o AJAX');
						return;
					}
					var items='<select id="expressao8" name="expressao8" onChange="myPrametros(8, this.value)"><option selected="selected">Selecione</option>';
					$.getJSON("busca_descricao.php?campoesc="+campoescolhido,function(data){
					$.each(data,function(index,item) 
					{
						items+="<option value='"+item.id+"'>"+item.descricao+"</option>";
					});
					items+="</select>";
					$("#expression8").html(items); 
					});
				}else{
					var items ='<input id="expressao8" type="text" name="expressao8" onChange="textoexpressao8.value = this.value;textoexpressao8.value = this.value">';
					$("#expression8").html(items); 
				}
			}
		});		
		$('#campo9').change(function(){
			if( $(this).val() ) {
				var campoescolhido = $(this).val();
				var temselect = false;
				switch(campoescolhido) {
				  case "campanha":
					temselect = true;
					break;
				  case "grupo":
					temselect = true;
					break;
				  case "origem":
					temselect = true;
					break;
				  case "profissao":
					temselect = true;
					break;
				  case "ramo":
					temselect = true;
					break;
				  default:
					temselect = false;
				}
				if(temselect){
					AjaxRequest();
					if(!Ajax) {
						alert('Não foi possível iniciar o AJAX');
						return;
					}
					var items='<select id="expressao9" name="expressao9" onChange="myPrametros(9, this.value)"><option selected="selected">Selecione</option>';
					$.getJSON("busca_descricao.php?campoesc="+campoescolhido,function(data){
					$.each(data,function(index,item) 
					{
						items+="<option value='"+item.id+"'>"+item.descricao+"</option>";
					});
					items+="</select>";
					$("#expression9").html(items); 
					});
				}else{
					var items ='<input id="expressao9" type="text" name="expressao9" onChange="textoexpressao9.value = this.value;textoexpressao9.value = this.value">';
					$("#expression9").html(items); 
				}
			}
		});		
		$('#campo10').change(function(){
			if( $(this).val() ) {
				var campoescolhido = $(this).val();
				var temselect = false;
				switch(campoescolhido) {
				  case "campanha":
					temselect = true;
					break;
				  case "grupo":
					temselect = true;
					break;
				  case "origem":
					temselect = true;
					break;
				  case "profissao":
					temselect = true;
					break;
				  case "ramo":
					temselect = true;
					break;
				  default:
					temselect = false;
				}
				if(temselect){
					AjaxRequest();
					if(!Ajax) {
						alert('Não foi possível iniciar o AJAX');
						return;
					}
					var items='<select id="expressao10" name="expressao10" onChange="myPrametros(10, this.value)"><option selected="selected">Selecione</option>';
					$.getJSON("busca_descricao.php?campoesc="+campoescolhido,function(data){
					$.each(data,function(index,item) 
					{
						items+="<option value='"+item.id+"'>"+item.descricao+"</option>";
					});
					items+="</select>";
					$("#expression10").html(items); 
					});
				}else{
					var items ='<input id="expressao10" type="text" name="expressao10" onChange="textoexpressao10.value = this.value;textoexpressao10.value = this.value">';
					$("#expression10").html(items); 
				}
			}
		});		
		$('#campo11').change(function(){
			if( $(this).val() ) {
				var campoescolhido = $(this).val();
				var temselect = false;
				switch(campoescolhido) {
				  case "campanha":
					temselect = true;
					break;
				  case "grupo":
					temselect = true;
					break;
				  case "origem":
					temselect = true;
					break;
				  case "profissao":
					temselect = true;
					break;
				  case "ramo":
					temselect = true;
					break;
				  default:
					temselect = false;
				}
				if(temselect){
					AjaxRequest();
					if(!Ajax) {
						alert('Não foi possível iniciar o AJAX');
						return;
					}
					var items='<select id="expressao11" name="expressao11" onChange="myPrametros(11, this.value)"><option selected="selected">Selecione</option>';
					$.getJSON("busca_descricao.php?campoesc="+campoescolhido,function(data){
					$.each(data,function(index,item) 
					{
						items+="<option value='"+item.id+"'>"+item.descricao+"</option>";
					});
					items+="</select>";
					$("#expression11").html(items); 
					});
				}else{
					var items ='<input id="expressao11" type="text" name="expressao11" onChange="textoexpressao11.value = this.value;textoexpressao11.value = this.value">';
					$("#expression11").html(items); 
				}
			}
		});
		$('#campo12').change(function(){
			if( $(this).val() ) {
				var campoescolhido = $(this).val();
				var temselect = false;
				switch(campoescolhido) {
				  case "campanha":
					temselect = true;
					break;
				  case "grupo":
					temselect = true;
					break;
				  case "origem":
					temselect = true;
					break;
				  case "profissao":
					temselect = true;
					break;
				  case "ramo":
					temselect = true;
					break;
				  default:
					temselect = false;
				}
				if(temselect){
					AjaxRequest();
					if(!Ajax) {
						alert('Não foi possível iniciar o AJAX');
						return;
					}
					var items='<select id="expressao12" name="expressao12" onChange="myPrametros(12, this.value)"><option selected="selected">Selecione</option>';
					$.getJSON("busca_descricao.php?campoesc="+campoescolhido,function(data){
					$.each(data,function(index,item) 
					{
						items+="<option value='"+item.id+"'>"+item.descricao+"</option>";
					});
					items+="</select>";
					$("#expression12").html(items); 
					});
				}else{
					var items ='<input id="expressao12" type="text" name="expressao12" onChange="textoexpressao12.value = this.value;textoexpressao12.value = this.value">';
					$("#expression12").html(items); 
				}
			}
		});		

	});
	</script>
	
<?php
include_once("../utilitarios/rodape-fixo.php");
?>
</body>
</html>
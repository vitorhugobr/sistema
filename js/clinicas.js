// JavaScript Document

function mostraclinica(clinica) {
	ajax('busca_clinica.php?clinica='+clinica, 'edicao');
}
			
//--------------------------------------------------------------------------------------------------------------------			
function carga_clinicas(pagina) {
	AjaxRequest();
	if(!Ajax) {
		alert('não foi  possível iniciar o AJAX');
		return;
	}
//	alert("Carga");
	ajax('busca_clinicas.php?pagina='+pagina, 'dados');
}
			
//--------------------------------------------------------------------------------------------------------------------			
function altera_clinica(clinica) {
	AjaxRequest();
	if(!Ajax) {
		alert('não foi  possível iniciar o AJAX');
		return;
	}
//	var string ="clinica="+clinica+"&desc="+document.form1.txtdescricao.value+"&endereco="+document.form1.txtendereco.value+"&fone="+document.form1.txtfone.value;
	alert("Altera Clínica");
//	ajax('altera_clinica.php?clinica='+clinica+'&desc='+document.form1.txtdescricao.value+'&endereco='+document.form1.txtendereco.value+'&fone='+document.form1.txttelefone.value, 'carregando');
}
			
//--------------------------------------------------------------------------------------------------------------------			

function inclui_clinica() {
	AjaxRequest();
	if(!Ajax) {
		alert('não foi  possível iniciar o AJAX');
		return;
	}
	Ajax.onreadystatechange = descreveclinica;						
	Ajax.open('GET', 'novo_apoio.php?codigo=novo', true);
	Ajax.send(null);
}
			
//--------------------------------------------------------------------------------------------------------------------			
function descreveclinica() {
  if (Ajax.readyState == 1) {
	  document.getElementById('carregando').innerHTML = '<img src="../imagens/ajax-loading2.gif" class="div-ajax-carregamento-pagina">'; ;
  }
  if (Ajax.readyState == 4) {					
	  if (Ajax.status == 200) {
		  // Receberemos um XML com as informações do CEP...
		  var xmldoc = Ajax.responseXML;						
		  document.getElementById('carregando').innerHTML = "";   
		  if(xmldoc.hasChildNodes()) {
			  var nos = xmldoc.getElementsByTagName('info');
			  if (nos.length==0){
				  return;
			  }
			  var $monta=""
			  for(var i=0;i<nos.length;i++) {
				  var no = nos[i];
				  var clinica   = "";
				  var descricao = "";
				  $monta = '<fieldset><div class="col-sm-12"><label>Clínica: '+clinica+'</label></div><br /><div class="col-sm-12">Descrição:<input class="form-control" name="txtdescricao" type="text" size="50" onChange="javascript:this.value=this.value.toUpperCase();" autofocus/></div>											<div class="col-sm-12"><button type="button" class="btn btn-sm btn-danger" onclick="javascript:inclusao_clinica();"> <i class="fas fa-plus" aria-hidden="true"></i> Incluir </button></div>';
				  document.getElementById('edicao').innerHTML = $monta;
				  document.form1.txtdescricao.value = "";
			  }
		  }
	  } else {
		  alert('Erro no Retorno do Servidor ' + Ajax.statusText);
	  }
  }
}
//------------------------------------------------------------------------------------------------------------------
function inclusao_clinica() {
	ajax('inclui_clinica.php?desc='+document.form1.txtdescricao.value, 'edicao');
}
			
//--------------------------------------------------------------------------------------------------------------------			
function excluiclinica(clinica) {
	AjaxRequest();
	if(!Ajax) {
		alert('não foi  possível iniciar o AJAX');
		return;
	}
	if (confirm("Confirma a Exclusão da Clínica..: "+clinica)){
		ajax2('exclui_clinica.php?clinica='+clinica, 'carregando');
	}
}
			
//--------------------------------------------------------------------------------------------------------------------			

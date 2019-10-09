// JavaScript Document

function mostraprofissao(profissao) {
	ajax('busca_profissao.php?profissao='+profissao, 'edicao');
}
			
//--------------------------------------------------------------------------------------------------------------------			
function carga_profissoes(pagina) {
	AjaxRequest();
	if(!Ajax) {
		alert('não foi  possível iniciar o AJAX');
		return;
	}
//	alert("Carga");
	ajax('busca_profissoes.php?pagina='+pagina, 'dados');
}
			
//--------------------------------------------------------------------------------------------------------------------			
function altera_Profissao(profissao) {
	AjaxRequest();
	if(!Ajax) {
		alert('não foi  possível iniciar o AJAX');
		return;
	}
	ajax('altera_profissao.php?profissao='+profissao+'&desc='+document.form1.txtdescricao.value, 'carregando');
	document.getElementById('edicao').innerHTML = "";
}
			
//--------------------------------------------------------------------------------------------------------------------			

function inclui_Profissao() {
	AjaxRequest();
	if(!Ajax) {
		alert('não foi  possível iniciar o AJAX');
		return;
	}
	Ajax.onreadystatechange = descreveProfissao;						
	Ajax.open('GET', 'novo_apoio.php?codigo=novo', true);
	Ajax.send(null);
}
			
//--------------------------------------------------------------------------------------------------------------------			
function descreveProfissao() {
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
				  var profissao   = "";
				  var descricao = "";
				  $monta = '<fieldset><div class="col-sm-12"><label>Profissão: '+profissao+'</label></div><br /><div class="col-sm-12">Decrição:<input class="form-control" name="txtdescricao" type="text" size="50" onChange="javascript:this.value=this.value.toUpperCase();" autofocus/></div>											<div class="col-sm-12"><button type="button" class="btn btn-sm btn-danger" onclick="javascript:inclusao_Profissao();"> <i class="fas fa-plus" aria-hidden="true"></i> Incluir </button></div>';
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
function inclusao_Profissao() {
	ajax('inclui_profissao.php?desc='+document.form1.txtdescricao.value, 'edicao');
}
			
//--------------------------------------------------------------------------------------------------------------------			
function excluiProfissao(profissao) {
	AjaxRequest();
	if(!Ajax) {
		alert('não foi  possível iniciar o AJAX');
		return;
	}
	if (confirm("Confirma a Exclusão do Profissao..: "+profissao)){
		ajax2('exclui_profissao.php?profissao='+profissao, 'carregando');
	}
}
			
//--------------------------------------------------------------------------------------------------------------------			

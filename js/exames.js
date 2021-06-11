// JavaScript Document
// Cadastro de exames
function altera_exame(exame) {
	AjaxRequest();
	if(!Ajax) {
		alert('não foi  possível iniciar o AJAX');
		return;
	}
	ajax('altera_exame.php?id='+exame+'&descricao='+document.form1.txtdescricao.value, 'modal');
	document.getElementById('edicao').innerHTML = "";
}
			

//--------------------------------------------------------------------------------------------------------------------		// Cadastro de exames
function carga_exames(pagina) {
	AjaxRequest();
	if(!Ajax) {
		alert('não foi  possível iniciar o AJAX');
		return;
	}
//	alert("Carga");
	ajax('busca_exames.php?pagina='+pagina, 'dados');
}
			
//--------------------------------------------------------------------------------------------------------------------			
// Cadastro de exames
function descreveexame() {
  "use strict";
  if (Ajax.readyState == 1) {
	  document.getElementById('modal').innerHTML = '<img src="../imagens/ajax-loading2.gif" class="div-ajax-carregamento-pagina">'; ;
  }
  if (Ajax.readyState == 4) {					
	  if (Ajax.status == 200) {
		  // Receberemos um XML com as informações do CEP...
		  var xmldoc = Ajax.responseXML;						
		  document.getElementById('modal').innerHTML = "";   
		  if(xmldoc.hasChildNodes()) {
			  var nos = xmldoc.getElementsByTagName('info');
			  if (nos.length===0){
				  return;
			  }
			  var $monta="";
			  for(var i=0;i<nos.length;i++) {
				  var no = nos[i];
				  var exame   = "";
				  var descricao = "";
				  $monta = '<fieldset><div class="col-sm-12"><label>Exame: '+exame+'</label></div><br /><div class="col-sm-12">Decrição:<input class="form-control" name="txtdescricao" type="text" size="50" onChange="javascript:this.value=this.value.toUpperCase();" autofocus/></div>											<div class="col-sm-12"><button type="button" class="btn btn-sm btn-danger" onclick="javascript:inclusao_exame();"> <i class="fas fa-plus" aria-hidden="true"></i> Incluir </button></div>';
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
// Cadastro de exames
function excluiexame(exame) {
	AjaxRequest();
	if(!Ajax) {
		alert('não foi  possível iniciar o AJAX');
		return;
	}
	if (confirm("Confirma a Exclusão do exame..: "+exame)){
		ajax2('exclui_exame.php?id='+exame, 'modal');
	}
}
			
//--------------------------------------------------------------------------------------------------------------------			
// Cadastro de exames
function exclui_exame_solicitado(exame) {
	AjaxRequest();
	if(!Ajax) {
		alert('não foi  possível iniciar o AJAX');
		return;
	}
	if (confirm("Confirma a Exclusão da solicitação do exame?")){
		ajax2('exclui_exame_solicitado.php?id='+exame, 'modal');
	}
}

//--------------------------------------------------------------------------------------------------------------------		// Cadastro de exames solicitados
function excluir_item_exame(exame,id_exame) {
	AjaxRequest();
	if(!Ajax) {
		alert('não foi  possível iniciar o AJAX');
		return;
	}
	if (confirm("Confirma a Exclusão do item do Exame?")){
		ajax2('exclui_item_exame.php?cod_exame='+exame+'&id_exame='+id_exame, 'modal');
	}
}
			
//--------------------------------------------------------------------------------------------------------------------		// Cadastro de exames solicitados
function exclui_exame(exame) {
	AjaxRequest();
	if(!Ajax) {
		alert('não foi  possível iniciar o AJAX');
		return;
	}
	if (confirm("Confirma a Exclusão do exame..: "+exame)){
		ajax2('exclui_todo_exame.php?id='+exame, 'modal');
	}
}
			
//--------------------------------------------------------------------------------------------------------------------			
// exames solicitados e itens do exame	
function gravar_exames(cod_cadastro,total) {
  "use strict";
	if (confirm("Confirma a inclusão dos exames?")){
		var qtde_exames=0;
		var data_exame = document.form1.data_exame.value;	
		if (data_exame ===""){
			alert("Informe a data");
			document.form1.data_exame.focus();
			return;
		}

		for (var i=0; i<=total-1;i++){
			if (document.form1.chkexame[i].checked){
				qtde_exames = qtde_exames + 1;
			}
		}
		if (qtde_exames ===0){
			alert("Informe pelo menos um exame");
			document.form1.data_exame.focus();
			return;
		}

		var parString="";
		parString = parString + "cod_cadastro="+cod_cadastro+"&data="+data_exame;
		parString = "gravar_exame.php?"+parString;
		//alert(parString);
		AjaxRequest();
		if(!Ajax) {
			alert('não foi  possível iniciar o AJAX');
			return;
		}
		ajax2(parString, 'modal');

		// vai gravar os exames em itens_exames
		for (var j=0; j<=total-1;j++){
			if (document.form1.chkexame[j].checked){
				var parStr="";
				var codexame = document.form1.id_exame[j].value;
				parStr = parStr + "cod_exame="+codexame;
				 parStr = "gravar_item_exame.php?"+parStr;
				AjaxRequest();
				if(!Ajax) {
					alert('não foi  possível iniciar o AJAX');
					return;
				}
				//alert(parStr);
				ajax(parStr, 'modal');
			}
		}
	}
	//window.location.replace("cadastro.php");

}
//--------------------------------------------------------------------------------------------------------------------			
// Cadastro de exames
function imprime_exames(cod_cadastro,id) {
  "use strict";
	var parametros = 'imprime_exames.php?cod_cadastro='+cod_cadastro+"&id="+id;
	//alert(parametros);
	open(parametros,null,'status=no,titlebar=no,toolbar=no,scrollbars=yes,menubar=no,location=no');
}
//-----------------------------------------------------------------------------------------------------------------
// Cadastro de exames
function inclui_exames(cod_cadastro) {
//  "use strict";
	var parametros = 'solicitar_exames.php?cod_cadastro='+cod_cadastro;
	//alert(parametros);
	window.location.replace(parametros);
}
//-----------------------------------------------------------------------------------------------------------------
	

function inclui_exame() {
	AjaxRequest();
	if(!Ajax) {
		alert('não foi  possível iniciar o AJAX');
		return;
	}
	Ajax.onreadystatechange = descreveexame;						
	Ajax.open('GET', 'novo_apoio.php?codigo=novo', true);
	Ajax.send(null);
}
			
//--------------------------------------------------------------------------------------------------------------------		// Cadastro de exames
function inclusao_exame() {
	ajax('inclui_exame.php?descricao='+document.form1.txtdescricao.value, 'edicao');
}
			
//--------------------------------------------------------------------------------------------------------------------			

function mostraexame(exame) {
	ajax('busca_exame.php?id='+exame, 'edicao');
}
			
//--------------------------------------------------------------------------------------------------------------------			
	
function ver_exame_solicitado(cod_cadastro,data,cod_exame,id_doexame) {
  "use strict";
	var parametros = 'mostrar_exames.php?cod_cadastro='+cod_cadastro+'&data='+data+'&cod_exame='+cod_exame;
	open(parametros,null,'status=no,titlebar=no,toolbar=no,scrollbars=yes,menubar=no,location=no');
	
}
//-----------------------------------------------------------------------------------------------------------------

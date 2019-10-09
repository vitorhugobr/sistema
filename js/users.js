//------------------------------------------

function buscaUser() {
	var usuario = document.form1.txtusuario.value;
	//alert(usuario);
	AjaxRequest();
	if(!Ajax) {
		alert('não foi  possível iniciar o AJAX');
		return;
	}
//	alert(usuario);
	ajax3('busca_user.php?user='+usuario+'&prg=ac','carregando');
	ajax2('busca_liberacoes.php?user='+usuario,'liberacoes');

}			
//---------------------------------------------------------------------------------------------------------------------
function gravar_liberacoes() {
		var usuar = document.form1.txtusuario.value;
		AjaxRequest();
		if(!Ajax) {
			alert('não foi  possível iniciar o AJAX');
			return;
		}

		// monta a string para passar como parametro para o php
		var params = new Array();
		var valor = 0;
		for (var i=0;i < document.form1.elements.length;i++){
			var parametro = encodeURIComponent(document.form1.elements[i].name);
			if (parametro > 999){
				paramet = 'Z'+encodeURIComponent(document.form1.elements[i].name);
				if (document.form1.elements[i].checked){
					valor = 1;		
				}else{
					valor = 0;	
				}																
				paramet += "=";
				paramet += valor;
				params.push(paramet)
			}
		}
		var $dados = 'usu='+usuar+'&'+params.join("&");
//		alert($dados);
		ajax2('../usuarios/inclui_liberacao.php?'+$dados, 'carregando');
	}
			
//--------------------------------------------------------------------------------------------------------------------			
function selecionar_todos() 
{
	var frm = document.form1;
	for(i = 0; i < frm.length; i++)         {
		if(frm.elements[i].type == "checkbox")	{ 
			frm.elements[i].checked = "checked";                        
		}        
	}
}

//------------------------------------------------------------------------------------------------
function deselecionar_todos() 
{
	var frm = document.form1;
	for(i = 0; i < frm.length; i++)         {
		if(frm.elements[i].type == "checkbox")	{ 
			frm.elements[i].checked = "";                        
		}        
	}
}
//-----------------------------------------------------------
function buscar_usuario() {
	var usuario = document.form1.txtusuario.value;
	//alert("====> "+usuario);
	if(usuario=='') {
	  alert('Por Favor informe o usuário');
		  document.form1.txtusuario.focus();
		  return;
	}
	AjaxRequest();
	if(!Ajax) {
		alert('não foi  possível iniciar o AJAX');
		return;
	}
  	//alert('Chama busca_usuario');	
	ajax('busca_usuario.php?user='+usuario,'carregando');
}
//-----------------------------------------------------------

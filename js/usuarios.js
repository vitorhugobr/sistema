"use strict";
//-----------------------------------------------------------------------------------------------------------------------
function busca_usuario() {
 // alert('Usuario: '+document.form1.txtusuario.value);
  var usuar = document.form1.txtusuario.value;
  if (usuar==""){
	  alert ("Por favor informe o Usuário");
	  document.form1.txtusuario.focus();
	  return false;
  }
  ajax('busca_usuario.php?usuario='+usuar, 'modal');
}
			
//--------------------------------------------------------------------------------------------------------------------			
function busca_user(usuario) {
  //alert(usuario);
  ajax('busca_usuario.php?usuario='+usuario, 'modal');
  }
			
//--------------------------------------------------------------------------------------------------------------------			
function altera_usuario() {

  var cod = document.form1.txtcodigo.value;
  var usu = document.form1.txtusuario.value;
  if (usu==""){
	  alert ("Por favor informe o Usuário");
	  document.form1.txtusuario.focus();
	  return false;
  }
  var nome = document.form1.txtnome.value;
  if (nome==""){
	  alert ("Por favor informe o Nome do Usuário");
	  document.form1.txtnome.focus();
	  return false;
  }
  var nivel = document.form1.txtnivel.value;
  if (nivel==""){
	  alert ("Por favor informe o Nível de Acesso do Usuário");
	  document.form1.txtnivel.focus();
	  return false;
  }
  var email = document.form1.txtemail.value;
  if (email==""){
	  alert ("Por favor informe o E-mail do Usuário");
	  document.form1.txtemail.focus();
	  return false;
  }
    
  var mudou = document.form1.mudou_usuario.value;
  
  var usuario_original = document.form1.nome_usuario.value;
    
  AjaxRequest();
  if(!Ajax) {
	  alert('Não foi  possível iniciar o AJAX');
	  return;
  }	
  //alert('codigo='+cod+'usu='+usu+'&niv='+nivel+'&nomeUSUARIO='+nome+'&email='+email);
  if (confirm("Confirma a informações do usuário..: "+usu+" ?")){
		ajax('altera_usuario.php?codigo='+cod+'&usu='+usu+'&niv='+nivel+'&nome='+nome+'&email='+email+'&mudou='+mudou+'&usuario_original='+usuario_original, 'modal');
  }
  
}
//-------------------------------
function carregar_foto(){
	
	ajax('upload_imagem.php', 'carga_foto');
	
}


//-----------------------------------------------------------------------------------------------------------------------
function grava_usuario() {
  //alert('incluir');
  var usu = document.form1.txtusuario.value;
  if (usu==""){
	  alert ("Por favor informe o Usuário");
	  document.form1.txtusuario.focus();
	  return false;
  }
  var nome = document.form1.txtnome.value;
  if (nome==""){
	  alert ("Por favor informe o Nome do Usuário");
	  document.form1.txtnome.focus();
	  return false;
  }
  var nivel = document.form1.txtnivel.value;
  if (nivel==""){
	  alert ("Por favor informe o Nível de Acesso do Usuário");
	  document.form1.txtnivel.focus();
	  return false;
  }
  var email = document.form1.txtemail.value;
  if (email==""){
	  alert ("Por favor informe o E-mail do Usuário");
	  document.form1.txtemail.focus();
	  return false;
  }

  AjaxRequest();
  var dados = 'inclui_usuario.php?usu='+usu+'&niv='+nivel+'&nome='+nome+'&email='+email;
  if(!Ajax) {
	  alert('Não foi  possível iniciar o AJAX');
	  return;
  }	
  //alert(dados);
  if (confirm("Confirma a Inclusão do usuário..: "+usu+" ?\nNão esquecer de liberar acessos ao sistema!\nSenha inicial é 123456")){
		ajax(dados, 'modal');
  }
//  myFunction();

}
//-------------------------------
function inclui_usuario(){
	document.form1.txtusuario.focus();
	document.getElementById("btnnovo").style.display = "none";
	document.getElementById("btngrava").style.display = "block";
	document.getElementById("btnexclui").style.display = "none";
	document.getElementById("btncancela").style.display = "block";
	
	document.getElementById('txtusuario').disabled = false;
	document.getElementById('txtnivel').disabled = false;
	document.getElementById('txtnome').disabled = false;
	document.getElementById('txtemail').disabled = false;
	
	ajax('inclui_usuario.php', 'modal');	
}

//-----------------------------------------------------------------------------------------------------------
function excluir_usuario() {
  var cod = document.form1.txtcodigo.value;
  var usu = document.form1.txtusuario.value;
  if (confirm("Confirma a Exclusão do usuário..: "+usu+" ?\nTodas as liberações também serão excluídas!")){
	  ajax('exclui_usuario.php?cod='+cod+'&usuario='+usu, 'modal');
  }
 limpa_usuario();
}			
//-----------------------------------------------------------------------------------------------------------
function deleta_cancela_usuario() {
	var cod = document.form1.txtcodigo.value;
    ajax('exclui_cancela_usuario.php?cod='+cod, 'modal'); 
	limpa_usuario();
}			
//--------------------------------------------------------------------------------------------------------------------			
function limpa_usuario(){
//  alert('limpa tela');
  document.form1.txtcodigo.value = '';
  document.form1.txtusuario.value='';
  document.form1.txtnome.value='';	
  document.form1.txtemail.value='';	
  document.form1.txtnivel.value=2;	
  document.form1.txtusuario.focus();
}
//---------------------------------------------------------------

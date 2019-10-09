// JavaScript Document
//-------------------------------------------------------------------------------------------------------------
function altera_consulta(id, indice) {
//	alert('function Alterar etapa: '+codetapa+' arbitro: '+codarb+' indice: '+indice);
  var prioridade = document.getElementsByName('prioridade');
  var pri = prioridade[indice].value;
  var fones = document.getElementsByName('fones');
  var tel = fones[indice].value;
  var situacao = document.getElementsByName('situacao');
  var sit = situacao[indice].value;
  var observacoes = document.getElementsByName('observacoes');
  var obs = observacoes[indice].value;
  var parString="id="+id+"&prioridade="+pri+"&situacao="+sit+"&fones="+tel+"&observacoes="+obs;
  //alert (parString);
  if (confirm("Confirma alteração?")){
	ajax3('altera_consulta.php?'+parString,'carregando');
  }else{
	alert("Cancelada pelo usuário!");	
  }			
}
//-------------------------------------------------------------------------------------------------------------
function busca_consulta() {
	var data_pesquisa = document.form1.data_pesquisa.value;
	var clinica = document.form1.clinica.value;
	if (clinica==""){
		alert ("Informe uma clínica para pesquisa");
		document.form1.clinica.focus();
		return false;
	}
	if (data_pesquisa==""){
		alert ("Informe uma data para pesquisa");
		document.form1.data_pesquisa.focus();
		return false;
	}
	//alert(data_pesquisa+' '+document.form1.clinica.value);
	var param = 'mostra_consulta.php?clinica='+clinica+'&data='+data_pesquisa;
	open(param,"_self");

	
}	
//-------------------------------------------------------------------------------------------------------------
function excluir_consulta(id) {
	// esta function salva os medicamentos do recituario no banco
	//alert("function salvar remedio");
	var parString = "excluir_lista_consulta.php?id="+id;
//	alert(parString);
	if (confirm("Confirma a Exclusão da Consulta?")){
		ajax(parString,'carregando');	
	}
}
//-------------------------------------------------------------------------------------------------------------
function fecha_agenda_espera(clinica,data_agenda) {
	// esta function salva os medicamentos do recituario no banco
//	alert("fecha_agenda_espera");
	var parString = "fecha_agenda_espera.php?clinica="+clinica+"&data_agenda="+data_agenda;
//	alert(parString);
	if (confirm("Confirma a Fechamento da Agenda?")){
		ajax(parString,'carregando');	
	}
}
//------------------------------------------------------------------------------
function inclui_consulta(){
	var data_agenda = document.form1.data_consulta.value;
	var cod_clinica = document.form1.cod_clinica.value;
	var nome = document.form1.txtNome.value;
	var cod_paciente = document.form1.txtCodigo.value;
	var fones = document.form1.txtFones.value;
	var obs = document.form1.txtObs.value;
	var parametros = 'incluir_consulta.php?cod_clinica='+cod_clinica+'&data_consulta='+data_agenda+'&cod_paciente='+cod_paciente+'&fones='+fones+'&obs='+obs;
	if (cod_paciente==""){
		alert ("Informe um paciente para consulta");
		document.form1.txtNome.focus();
		return false;
	}
	if (fones==""){
		alert ("Informe um telefone para contato");
		document.form1.txtFones.focus();
		return false;
	}
	//alert(parametros);
//	if (confirm(parametros)){
	if (confirm("Confirma a inclusão da Consulta?")){
		ajax(parametros,"carregando");
	}
	
}
//------------------------------------------------------------------------------
function iniciar_consulta(cod_cadastro,id){
	var cod_cadastro = cod_cadastro;
	var id = id;
	var parametros = 'inicializar_consulta.php?cod_cadastro='+cod_cadastro+'&id='+id;
	if (cod_cadastro==""){
		alert ("Informe um paciente para consulta");
		return false;
	}
//	alert(parametros);
	open(parametros,"_self");

}
//------------------------------------------------------------------------------
function mostra_painel(clinica,data_agenda) {
	var cod_cadastro = cod_cadastro;
	var parametros = "painel.php?clinica="+clinica+"&data="+data_agenda;

//	alert(parametros);
	open(parametros,"_new");

}//------------------------------------------------------------------------------
function movecodigo(id) {
	// esta function salva os medicamentos do recituario no banco
	//alert("moverá o código "+id);
	document.form1.txtCodigo.value = id;
	return true;
}
//------------------------------------------------------------------------------

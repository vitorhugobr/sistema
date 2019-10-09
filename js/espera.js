// JavaScript Document
//------------------------------------------------------------------------------
function abrir_cadastro(cod_cadastro) {
	AjaxRequest();
	if(!Ajax) {
		alert('não foi  possível iniciar o AJAX');
		return;
	}

	ajax2("inicializa_global.php?cod_cadastro="+cod_cadastro,"carregando");
	var param = '../eleitores/cadastro.php';
	//alert(param);
	open(param,"_self");		
	
}
//------------------------------------------------------------------------------
function busca_consultas(id){

	//alert("Buscará por consultas de "+id);
	var parametros = "buscar_consultas.php?cod_cadastro="+id;
	AjaxRequest();
	if(!Ajax) {
		alert('não foi  possível iniciar o AJAX');
		return;
	}

	ajax(parametros,"carregando");
}

//-------------------------------------------------------------------------------------------------------------
function busca_espera() {
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
	var param = 'mostra_espera.php?clinica='+clinica+'&data='+data_pesquisa;
	open(param,"_self");
}
	
//------------------------------------------------------------------------------
function busca_faltas(id){

//	alert("Buscará por faltas de "+id);
	var parametros = "buscar_faltas.php?cod_cadastro="+id;
	AjaxRequest();
	if(!Ajax) {
		alert('não foi  possível iniciar o AJAX');
		return;
	}

	ajax2(parametros,"carregando");

}
//-------------------------------------------------------------------------------------------------------------
function busca_fone(id){
	
//	alert("Buscará por fone de "+id);
	var parametros = "buscar_fone.php?cod_cadastro="+id;
	AjaxRequest();
	if(!Ajax) {
		alert('não foi  possível iniciar o AJAX');
		return;
	}

	ajax2(parametros,"carregando");

}
//-------------------------------------------------------------------------------------------------------------
function excluir_espera(id) {
	// esta function salva os medicamentos do recituario no banco
	//alert("function salvar remedio");
	var parString = "excluir_lista_espera.php?id="+id;
//	alert(parString);
	if (confirm("Confirma a Exclusão da Lista de Espera?")){
		ajax(parString,'carregando');	
	}
}
//------------------------------------------------------------------------------
function gerar_consultas(clinica , data_consulta) {
	if (confirm("Este procedimento vai passar todos os dados\nda Lista de Espera para Agenda de Consultas.\nConfirma?")){
		var param = 'gerar_consultas.php?clinica='+clinica+'&data='+data_consulta;
//		alert(param);
		AjaxRequest();
		if(!Ajax) {
			alert('não foi  possível iniciar o AJAX');
			return;
		}
		ajax(param,'carregando');	
	}
}	
//-----------------------------------------------------------
function gravar_consultas(cod_clinica,total) {
	if (confirm("Este procedimento vai passar os selecionados\nda Lista de Espera para Agenda de Consultas.\nConfirma?")){
	//alert(cod_clinica+" - "+total);

	for (var i=0; i<total;i++){

		var id_l = document.getElementsByName('id');
  		var id = id_l[i].value;

		var cod_cadastro_l = document.getElementsByName('cod_cadastro');
  		var cod_cadastro = cod_cadastro_l[i].value;
		
		var data_consulta_a_l = document.getElementsByName('data_consulta_a');
  		var data_consulta_a = data_consulta_a_l[i].value;
		
		var data_consulta_l = document.getElementsByName('data_consulta');
  		var data_consulta = data_consulta_l[i].value;

		if (data_consulta_a != ""){
		  var data_consulta = data_consulta_a;
		}
		
		var data_inclusao_l = document.getElementsByName('data_inclusao');
  		var data_inclusao = data_inclusao_l[i].value;

		var observacoes_l = document.getElementsByName('observacoes');
  		var observacoes = observacoes_l[i].value;

		var fones_l = document.getElementsByName('fones');
  		var fones = fones_l[i].value;

		var checkconsulta_l = document.getElementsByName('checkconsulta');
  		var checkconsulta = checkconsulta_l[i].value;
		

        if ( checkconsulta_l[i].checked ) {
			checkconsulta = true;
        }else{
			checkconsulta = false;
		}

		
		if (checkconsulta){    //foi selecionado e grava no arquivo agenda_clinicda
			parString = "id="+id+"&cod_clinica="+cod_clinica+"&cod_cadastro="+cod_cadastro+"&data_consulta="+data_consulta+"&data_inc_esp="+data_inclusao+"&observacoes="+observacoes+"&fones="+fones;
			var parString = "gerar_consultas.php?"+parString;
		}else{     //vai ser regravado em espera, pois não foi selecionado
			parString = "id="+id+"&data_consulta="+data_consulta;
			var parString = "atualizar_espera.php?"+parString;
		}
		//alert (parString);
		AjaxRequest();
		if(!Ajax) {
			alert('não foi  possível iniciar o AJAX');
			return;
		}
		ajax(parString, 'carregando');
	}
  }else{
	return false;  
  }

}
//-------------------------------------------------------------------------------------------------------------
function inclui_espera(){
	var data_consulta = document.form1.data_consulta.value;
	var cod_clinica = document.form1.cod_clinica.value;
	var nome = document.form1.txtNome.value;
	var cod_paciente = document.form1.txtCodigo.value;
	var fones = document.form1.txtFones.value;
	var obs = document.form1.txtObs.value;
	var parametros = 'incluir_lista_espera.php?cod_clinica='+cod_clinica+'&data_consulta='+data_consulta+'&cod_paciente='+cod_paciente+'&fones='+fones+'&obs='+obs;
	//alert(parametros);
//	if (confirm(parametros)){
	if (confirm("Confirma a inclusão na Lista de Espera?")){
	AjaxRequest();
		if(!Ajax) {
			alert('não foi  possível iniciar o AJAX');
			return;
		}
		ajax(parametros,"carregando");
	}
	
}
//------------------------------------------------------------------------------
function movecodigo(id) {
	// esta function salva os medicamentos do recituario no banco
	//alert("moverá o código "+id);
	document.form1.txtCodigo.value = id;
	return true;
}
//------------------------------------------------------------------------------
function move_nome(nome) {
	//alert("moverá o código "+id);
	document.form1.txtNome.value = nome;
	return true;
}
//------------------------------------------------------------------------------
function mudou(data,indice) {
	//alert(data);
	document.form1.data_consulta_a.value = data;
	var teste = 0;
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
//--------------------------------------------------------------------------------------------------------------------			

// JavaScript Document

function nova_tarefa() {
	AjaxRequest();
	if(!Ajax) {
		alert('não foi  possível iniciar o AJAX');
		return;
	}
	var parametros = 'nova_tarefa.php';
	open(parametros,'_self');
}
//--------------------------------------------------------------------------------------------------------------------			
function carga_tarefas(pagina,status) {
	AjaxRequest();
	if(!Ajax) {
		alert('não foi  possível iniciar o AJAX');
		return;
	}
//	alert("Status 0");
	ajax('busca_tarefas.php?pagina='+pagina+'&status='+status, 'carregando');
}
//--------------------------------------------------------------------------------------------------------------------			
function incluir_tarefa() {
	AjaxRequest();
	if(!Ajax) {
		alert('não foi  possível iniciar o AJAX');
		return;
	}
	var parametros;
	parametros= "usuario="+document.form1.txtusuario.value+"&priority="+document.form1.txtprioridade.value+"&assunto="+document.form1.txtassunto.value+"&tarefa="+document.form1.txttarefa.value+"&email="+document.form1.txtemail.value+"&chkemail="+document.form1.chkemail.checked;
	//alert(parametros);
	ajax('inclui_tarefa.php?'+parametros, 'carregando');
}
//--------------------------------------------------------------------------------------------------------------------			
function carga_todas() {
	AjaxRequest();
	if(!Ajax) {
		alert('não foi  possível iniciar o AJAX');
		return;
	}
//	alert("Status 3");
	ajax('busca_tarefas.php?pagina=1&status=3', 'dados');
}
			
			
//--------------------------------------------------------------------------------------------------------------------			
function busca_usuario(user) {
	//alert(user);
	AjaxRequest();
	if(!Ajax) {
		alert('não foi  possível iniciar o AJAX');
		return;
	}
//	alert("Status 3");
	ajax('busca_usuario.php?codigo='+user, 'carregando');
}
			
			
//--------------------------------------------------------------------------------------------------------------------			
function mostratarefa(task) {
	AjaxRequest();
	if(!Ajax) {
		alert('não foi  possível iniciar o AJAX');
		return;
	}
	//alert("Mostrar Tarefa "+task);
	open('mostra_tarefa.php?tarefa='+task,"_self");
}
//--------------------------------------------------------------------------------------------------------------------			
function atualiza_info_tarefa(task) {
	AjaxRequest();
	if(!Ajax) {
		alert('não foi  possível iniciar o AJAX');
		return;
	}
	//alert("Atualizar info Tarefa "+task);
	ajax('mostra_tarefa.php?tarefa='+task);
}
//--------------------------------------------------------------------------------------------------------------------			
function excluitarefa(id) {
	AjaxRequest();
	if(!Ajax) {
		alert('não foi  possível iniciar o AJAX');
		return;
	}
	if (confirm("Confirma a Exclusão da tarefa #"+id+"?")){
		ajax('exclui_tarefa.php?id='+id, 'carregando');
	}
}
//--------------------------------------------------------------------------------------------------------------------			
function iniciatarefa(task) {
	AjaxRequest();
	if(!Ajax) {
		alert('não foi  possível iniciar o AJAX');
		return;
	}
	//alert("Vai gravar a data de hoje e histórico de início no arquivo historico_tarefas");
	if (confirm("Confirma o início da tarefa "+task+"?")){
		ajax('inicia_tarefa.php?tarefa='+task, 'carregando');
	}
}
//--------------------------------------------------------------------------------------------------------------------			
function encerratarefa(task) {
	AjaxRequest();
	if(!Ajax) {
		alert('não foi  possível iniciar o AJAX');
		return;
	}
	//alert("Vai gravar a data de hoje e histórico de início no arquivo historico_tarefas");
	if (confirm("Confirma o Encerramento da tarefa "+task+"?")){
		ajax('encerra_tarefa.php?tarefa='+task, 'carregando');
	}
}
//--------------------------------------------------------------------------------------------------------------------			
function inserehistorico(task) {
	AjaxRequest();
	if(!Ajax) {
		alert('não foi  possível iniciar o AJAX');
		return;
	}
	var parametros = 'novo_historico.php?task='+task;
	open(parametros,'_self');
}
//--------------------------------------------------------------------------------------------------------------------			
function incluir_historico() {
	if(document.form1.txtdata.value=="") {
		alert('Data necessita ser informada');
		document.form1.txtdata.focus();
		return;
	}
	AjaxRequest();
	if(!Ajax) {
		alert('não foi  possível iniciar o AJAX');
		return;
	}
	var parametros;
	parametros= "id_tarefa="+document.form1.txtid_hist.value+"&data_hist="+document.form1.txtdata.value+"&descricao_hist="+document.form1.txthistorico.value;
//	alert(parametros);
	if (confirm("Confirma a Inclusão do histórico na tarefa?")){
		ajax('inclui_historico.php?'+parametros, 'carregando');
	}
}

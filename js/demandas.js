// JavaScript Document
var $nivelusu='';
var $condicao=0;
//------------------------------------------------------------------------------------------------------
function arquiva_encaminhamento(numero){
	if (confirm("Confirma o ENCERRAMENTO da demanda?")){
		//var tarefa = document.form2.txttarefa.value;
		var param = 'arquiva_demanda.php?numero='+numero;
		//alert(param);
		AjaxRequest();
		if(!Ajax) {
			alert('não foi  possível iniciar o AJAX');
			return;
		}
		ajax2(param, 'carregando');
	}

}
//-----------------------------------------------------------------------------------------------------
function demandaI(nivel,codigo) {

var param = 'nova_demanda.php?codigo='+codigo+'&nivel='+nivel;
open(param,'_self');
}
//-----------------------------------------------------------------------------------------------------
function encerra_encaminhamento(numero){
	if (confirm("Confirma o ENCERRAMENTO da demanda?")){
		//var tarefa = document.form2.txttarefa.value;
		var param = 'encerra_demanda.php?numero='+numero;
		//alert(param);
		AjaxRequest();
		if(!Ajax) {
			alert('não foi  possível iniciar o AJAX');
			return;
		}
		ajax2(param, 'inserir');
	}

}
//------------------------------------------------------------------------------------------------------
function excluir_imagem(demanda) {
	//alert ('Excluir imagens da demanda '+demanda);
	AjaxRequest();
	if(!Ajax) {
		alert('não foi  possível iniciar o AJAX');
		return;
	}
	open("mostra_img_exc.php?demanda="+demanda,"_blank");
}

//-----------------------------------------------------------------------------------------------------
function excluir_resposta(id){
	if (confirm("Confirma a Exclusão da resposta?")){
		var param = 'exclui_historico.php?id='+id;
	//	alert(param);
		AjaxRequest();
		if(!Ajax) {
			alert('não foi  possível iniciar o AJAX');
			return;
		}
		ajax2(param, 'carregando');
	}

}
//-----------------------------------------------------------------------------------------------------
function grava_Resposta(){
	//alert ("Gravar Resposta");
	var retorno = document.form1.retorno.value;
	var numero = document.form1.numero.value;
	var ccemail = document.form1.ccemail.value;
	var enviar_email = document.form1.enviar_email.checked;
	var num_tarefa = document.form1.num_tarefa.value;	
	var data_demanda = document.form1.data_demanda.value;
	var param = 'inclui_resposta_demanda.php?numero='+numero+'&retorno='+retorno+'&enviar_email='+enviar_email+'&ccemail='+ccemail+'&num_tarefa='+num_tarefa+'&data_demanda='+data_demanda;
//	alert(param);
	AjaxRequest();
	if(!Ajax) {
		alert('não foi  possível iniciar o AJAX');
		return;
	}
	ajax2(param, 'carregando');
}
//------------------------------------------------------------------------------------------------------
function incluir_documento(demanda) {
	//alert ('traz_demanda '+numero);
	AjaxRequest();
	if(!Ajax) {
		alert('não foi  possível iniciar o AJAX');
		return;
	}
	open("documento.php?demanda="+demanda,"_blank");
}

//------------------------------------------------------------------------------------------------------
function incluir_imagem(demanda, seq) {
	//alert ('traz_demanda '+numero);
	AjaxRequest();
	if(!Ajax) {
		alert('não foi  possível iniciar o AJAX');
		return;
	}
	open("foto.php?demanda="+demanda+"&seq="+seq,"_blank");
}

//-----------------------------------------------------------------------------------------------------
function historico_demanda(numero){
	AjaxRequest();
	if(!Ajax) {
		alert('não foi  possível iniciar o AJAX');
		return;
	}
	ajax('busca_historico_demanda.php?numero='+numero, 'historico');
}
//-------------------------------------------------------------------------------------------------------------

// mostrara as demandas. Se condicao=0 mostra não respondia, se =1 mostra em aberto, se =2 mostra encerradas e se =3 mostra todas
function mostrarDemandas(condicao) {
	var $condicao=condicao;
	AjaxRequest();
	if(!Ajax) {
		alert('não foi  possível iniciar o AJAX');
		return;
	}

	var param ="proc_pesq_demandas.php?cond="+$condicao;
	//alert(param);	
	ajax(param, 'mostraE');
}
	
//------------------------------------------------------------------------------
function move_cod_tela(id) {
	// esta function salva os medicamentos do recituario no banco
//	alert("moverá o código "+id);
	document.form1.txtcodigo.value = id;
	return true;
}
//------------------------------------------------------------------------------
function move_cod_tela_alt(id) {
	// esta function salva os medicamentos do recituario no banco
//	alert("moverá o código "+id);
	document.form2.txtcodigo_alt.value = id;
	return true;
}
//------------------------------------------------------------------------------
function print_demanda(demanda) {
	//alert("Imprimirá a demanda "+demanda);
	var parametro = 'print_demanda.php?numero='+demanda;
	//alert(remedios);
	open(parametro,null);

	return true;
}
//------------------------------------------------------------------------------
function responde_demanda(numero) {
var $resposta= '<textarea name="txtresposta" cols="80" rows="10" class="form-control" placeholder="Digite a resposta neste campo" autofocus="autofocus"></textarea><br /><input type="checkbox" class="form-check" name="chkenviaemail" id="chkenviaemail" />  <label for="chkenviaemail">Enviar e-mail ao solicitante</label>&nbsp;<button type="button" class="btn btn-sm btn-primary" onclick="grava_Resposta('+numero+')"><i class="fas fa-plus" aria-hidden="true"></i> Incluir Resposta</button>';

document.getElementById('acaoenc').innerHTML = $resposta;
document.form1.txtResposta.focus();
//document.getElementById('botoes2').innerHTML = $botoes;
}
//-------------------------------------------------------------------------------------------------------
function traz_demanda(numero) {
	//alert ('traz_demanda '+numero);
	AjaxRequest();
	if(!Ajax) {
		alert('não foi  possível iniciar o AJAX');
		return;
	}
	open("busca_demanda.php?numero="+numero,"_self");
}

//-----------------------------------------------------------------------------------------------------

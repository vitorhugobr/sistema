/// JavaScript Document
"use strict";
function AlteraEnd(id){

	//alert(comando);
	var comando = 'enderecos.php?otipo=A&id='+id;
	//alert("OK novo endereço para "+parametros);
	//open(parametros,'_self');
	open(comando,null,'height=450,width=1000,top=100,status=yes,toolbar=no,menubar=no,location=no');
		
}

//----------------------------------------------------------------------------------

function AtualizaEleitor(y_funcao) {
	//alert("function AtualizaEleitor");
	var CadArray = new Array(47);
	
	CadArray[0]  = document.form1.txtcodigo.value;
	CadArray[1]  = document.form1.txtnome.value;
	CadArray[2]  = document.form1.txtsexo.value;
	if (y_funcao==="A"){
		CadArray[3]  = document.getElementById('lbldtcad').innerHTML;  // data cadastramento
	}else{
		  CadArray[3]  =  "";
	}
	CadArray[4]  = document.form1.txtdtnasc.value;
	CadArray[5]  = document.form1.txtcargo.value;
	CadArray[6]  = document.form1.txtresidencial.value;					
	CadArray[7]  = document.form1.txtcelular.value;
	CadArray[8]  = document.form1.txtcomercial.value;
	CadArray[9]  = document.form1.txtcpf.value;
	CadArray[10] = document.form1.txtobs.value;	
	if (document.form1.chkcondicao.checked){
		CadArray[11] = 1;		
	}else{
		CadArray[11] = 0;	
	}																
	CadArray[12] = document.form1.txtemail.value;
	CadArray[13] = document.form1.txtgrupo.value;	
	CadArray[14] = document.form1.txtorigem.value;
	CadArray[15] = document.form1.txtprofissao.value;
	CadArray[16] = document.form1.txtzona.value;
	CadArray[17] = document.form1.txtsecao.value;
	CadArray[18] = document.form1.txtpaimae.value;				
	if (document.form1.chkfiliado.checked){
		CadArray[19] = 1;		
	}else{
		CadArray[19] = 0;	
	}																
	CadArray[20] = 0;		
	CadArray[21] = ""; //responsavel pelo cadastro, será colocado na pagina php
	CadArray[22] = ""; //data da ultima alteraçao será inicializada na pagina php
	CadArray[23] = document.form1.txtempresa.value;
	if (document.form1.chkvotou.checked){
		CadArray[24] = 1;		
	}else{
		CadArray[24] = 0;	
	}		
	CadArray[25] = document.form1.txtramo.value;
	if (document.form1.chkemail.checked){
		CadArray[26] = 1;		
	}else{
		CadArray[26] = 0;	
	}
	if (document.form1.chkimpresso.checked){
		CadArray[27] = 1;		
	}else{
		CadArray[27] = 0;	
	}
	CadArray[28] = ""; //document.getElementById('output').innerHTML;  
//	alert (CadArray[28]);
	CadArray[29] = document.form1.txtcampanha.value;	
	CadArray[30] = document.form1.txtface.value;	
	CadArray[31] = document.form1.txttwitter.value;	
	CadArray[32] = document.form1.txtoutra.value;	
	CadArray[33] = 0;	
	CadArray[34] = document.form1.txtapelido.value;	
	CadArray[35] = document.form1.txtestadocivil.value;	
	CadArray[36] = document.form1.txtclass.value;
    // endereço //
	CadArray[37] = document.form1.id_endereco.value;
    CadArray[38] = document.form1.rua.value;
    CadArray[39] = document.form1.cep.value;
    CadArray[40] = document.form1.tipolog.value;
    CadArray[41] = document.form1.bairro.value;
    CadArray[42] = document.form1.cidade.value;
    CadArray[43] = document.form1.uf.value;
    CadArray[44] = document.form1.numero.value;
    CadArray[45] = document.form1.complemento.value;
    CadArray[46] = document.form1.reg.value;
	// montagem dos parâmetros para passar
	var parString="";
	for (var i=0; i<47; i++) {
		if (i===0){
			parString = "P"+i+"="+CadArray[i];	
		}else{
			parString = parString+"&P"+i+"="+CadArray[i];	
		}
	}
	//alert(y_funcao);
	//alert (parString);
	if (y_funcao==="A"){
		if (confirm("Confirma o cadastro de "+document.form1.txtnome.value)){
			ajax2('altera_eleitor.php?'+parString,'modal');
//           if (document.form1.rua.value != "") {
//                atual_ender();
//            }
		}
	}else{
		if (y_funcao==="P"){
			var parametro = 'imprime_eleitor.php?'+parString;
			open(parametro,null,'height=600,width=1200,top=100,left=100,status=no,titlebar=no,toolbar=no,scrollbars=yes,menubar=no,location=no');
		}else{
			if (confirm("Confirma a Exclusão do registro de "+document.form1.txtnome.value)){
				ajax('exclui_eleitor.php?'+parString,'modal');
			}
		}
	}	
}

//---------------------------------------------------------------------------------------

function carga_foto(){
//	alert ('veio');
  var cod = document.form1.txtcodigo.value;
  if (document.form1.txtcodigo.value==""){
	alert ("Nenhum Eleitor consultado\nPor favor faça a consulta!");
	document.form1.txtnome.focus();
	return false;
  }else{
	var parametros = 'tirar_foto.php?codigo='+cod;
	open(parametros,null,'height=600,width=500,top=100,status=yes,toolbar=no,menubar=no,location=no');
  }
}

//----------------------------------------------------------------------------------------------------------------
function EditSolution(id){
	//--- aqui vai incluir um problema, por isso a variavel otipo recebe I
	var cod = document.form1.txtcodigo.value;
	var nome = document.form1.txtnome.value;
	var param = 'solution.php?otipo=A&cod='+cod+'&nome='+nome+'&id='+id;
	open(param,null,'height=350,width=770,top=200,status=yes,toolbar=no,menubar=no,location=no');
}

//---------------------------------------------------------------------------------------


function Exclui_ender(id) {

	if (confirm("Confirma a Exclusão do Endereço?")){
		ajax('exclui_endereco.php?id='+id,'modal');			
	}

}

//------------------------------------------------------------------------------------
function excluir_receituario(id) {
	// esta function salva os medicamentos do recituario no banco
	//alert("function salvar remedio");
	var parString = "exclui_receituario.php?id="+id;
//	alert(parString);
	if (confirm("Confirma a Exclusão do Receituário")){
		ajax(parString,'modal');	
	}
}
//------------------------------------------------------------------------------

function excluir_remedio(id) {
	// esta function salva os medicamentos do recituario no banco
	//alert("function salvar remedio");
	var parString = "exclui_remedio.php?id="+id;
//	alert(parString);
	if (confirm("Confirma a Exclusão do medicamento")){
		ajax(parString,'modal');	
	}
}
//------------------------------------------------------------------------------

function exclui_visita(id) {

	if (confirm("Confirma a Exclusão do Contato? ")){
		ajax('exclui_visita.php?id='+id,'modal');			
	}

}


//--------------------------------------------------------------------------------------------------------
function grava_prontuario(){
//	var id = document.form1.id_prontuario.value;falta
//	var diagnos = CKEDITOR.instances.diagnostic.getData();
//	alert(parametros);
	if (confirm("Confirma a gravação do Prontuário ")){
		ajaxPost("gravar_prontuario.php","modal");
	}
}

//--------------------------------------------------------------------------
function gravar_remedio(id,indice) {
	// esta function salva os medicamentos do recituario no banco
	//alert("function salvar remedio");
  var remedio = document.getElementsByName('remedio');
  var nomeremedio = remedio[indice].value;
  var qtde = document.getElementsByName('qtde');
  var qtde_remedio = qtde[indice].value;
  var posologia = document.getElementsByName('posologia');
  var comotomar = posologia[indice].value;
  var parString="id="+id+"&remedio="+nomeremedio+"&qtde="+qtde_remedio+"&posologia="+comotomar;
  var parString = "gravar_remedio.php?"+parString;
//	alert(parString);
	if (confirm("Confirma a Alteração do medicamento")){
		ajax(parString,'modal');	
	}
}
//------------------------------------------------------------------------------
function imprime() {
	var cod = document.form1.txtcodigo.value;
		if(cod=='') {
			alert('Por Favor informe o código para imprimir');
			document.form1.txtcodigo.focus();
			return;
		}
		//limpaTela();
		ajax('eleitor_fpdf.php','modal');
}	
//-----------------------------------------------------------------------------------------------------------------
function imprime_atestado(cod_cadastro) {
	var parametro = 'imprime_atestado.php?cod_cadastro='+cod_cadastro;
	//alert(parametro);
	open(parametro,null);
}
//-----------------------------------------------------------------------------------------------------------------
function imprime_receituario_especial(id) {
	var parametro = 'imprime_receita_especial.php?id='+id;
	//alert(remedios);
	open(parametro,null,'top=100,left=100,status=no,titlebar=no,toolbar=no,scrollbars=yes,menubar=no,location=no');
}
//-----------------------------------------------------------------------------------------------------------------
function imprime_receituario(id) {
	var parametro = 'imprime_receita.php?id='+id;
	//alert(remedios);
	open(parametro,null,'top=100,left=100,status=no,titlebar=no,toolbar=no,scrollbars=yes,menubar=no,location=no');
}


//-----------------------------------------------------------------------------------------------------------------

function IncluiEnder(){
	document.form1.sessionCodigo.value = document.form1.txtcodigo.value;
	open('inclui_endereco.php?cod='+document.form1.txtcodigo.value,null,'height=350,width=800,top=150,status=yes,toolbar=no,menubar=no,location=no');
}

//-----------------------------------------------------------------------------------------------------------------

//------------------------------------------------------------------------------------
function inclui_receituario(cod_cad){
	// esta function abre o formulário de receituário
	var parametros = 'novo_receituario.php?cod_cad='+cod_cad;
//	alert(parametros);
	window.location.replace(parametros);
}

//------------------------------------------------------------------------------------
function LimpaSessionCod(){
	ajax3('zera_codigo.php','modal');

}

//-------------------------------------------------------------------------------------------------------------
function mostra_mapa(ender) {
	var nome = document.form1.txtnome.value;
	open('SampleGmaps.php?ender='+ender+'&nome='+nome,null,'height=350,width=900,top=150,status=yes,toolbar=no,menubar=no,location=no');	
}

//----------------------------------------------------------------------------------

function mostra_prontuario(prontuario){
	var parametros = 'prontuario.php?id='+prontuario;
//	alert(parametros);
	window.location.replace(parametros);
}

//-----------------------------------------------------------------------------------------------------------------
function mostra_receituario(id){
	var parametros = 'receituario.php?id='+id;
//	alert(parametros);
	window.location.replace(parametros);
}
//-----------------------------------------------------------------------------------------------------------------
function mostraInputEndereco(){
	document.getElementById('txtpesqendereco').style.visibility = "visible";
	
}
//-----------------------------------------------------------------------------------------------------------------
function NewEnd(){
	"use stricts";
	var cod = document.form1.txtcodigo.value;
	var parametros = 'enderecos.php?otipo=I&id='+cod;
	//alert("OK novo endereço para "+parametros);
	//open(parametros,'_self');
	open(parametros,null,'height=450,width=1000,top=100,status=yes,toolbar=no,menubar=no,location=no');
}

//---------------------------------------------

function OpenSolution(){
	//--- aqui vai incluir um problema, por isso a variavel otipo recebe I
	var cod = document.form1.txtcodigo.value;
	var nome = document.form1.txtnome.value;
	var param = 'solution.php?otipo=I&cod='+cod+'&nome='+nome;
	open(param,null,'height=350,width=770,top=200,status=yes,toolbar=no,menubar=no,location=no');
}

//---------------------------------------------------------------------------------------
function OpenVisita(){
	var cod = document.form1.txtcodigo.value;
	var nome = document.form1.txtnome.value;
	var param = 'visitas.php?cod='+cod+'&nome='+nome;
	open(param,null,'height=350,width=770,top=200,status=yes,toolbar=no,menubar=no,location=no');
}

//---------------------------------------------------------------------------------------
function PesquisaEleitor(cod){
	//alert(cod);
	if (cod===0) {
		document.getElementById("btnExcCad").disabled = false;
		document.getElementById("btnAltCad").disabled = false;		
		return;
	}else{
		enableFields(false);
		//alert(cod);
		ajaxP('busca_eleitor.php?codigo='+cod,'modal');
	}

}
//-----------------------------------------------------------------------------------------------------------------
function pesquisaprontuario(id){
//	alert(id);
	ajax5('busca_prontuario.php?id='+id,'modal');
}

//--------------------------------------------------------------------------
function printcadastro(codigo) {
  if (Ajax.readyState == 1) {
	  document.getElementById('carregando').innerHTML = "<img src='../imagens/ajax-loading2.gif'>";
  }
  if (Ajax.readyState == 4) {					
	  if (Ajax.status == 200) {
		  document.getElementById('carregando').innerHTML = '';
		  document.form1.txtcodigo.value = codigo;
		  PesquisaEleitor(codigo);
	  } else {
		  alert('printcadastro() Erro no Retorno do Servidor ' + Ajax.statusText);
	  }
  }
}

//-----------------------------------------------------------------------------
function valida_cadastro(x_funcao) {
	"use strict";
//	alert(x_funcao);
	if (x_funcao=="A" || x_funcao=="I"){
		if (document.form1.txtnome.value==""){
			alert ("Por favor digite o nome");
			document.form1.txtnome.focus();
			return false;
		} 

		if(document.form1.chkemail.checked){
			if (document.form1.txtemail.value=="") { 
				alert ("Para receber e-mail, o mesmo deve ser informado.");
				document.form1.txtemail.focus();
				return false;
			}
		}
			
		if (!document.form1.txtemail.value=="") { 		
			var er = new RegExp(/^[A-Za-z0-9_\-\.]+@[A-Za-z0-9_\-\.]{2,}\.[A-Za-z0-9]{2,}(\.[A-Za-z0-9])?/);
			var email = $('#txtemail').val();		
			if(!er.test(email) ) { 
				alert('Preencha o campo email corretamente\nApenas com caracteres válidos'); 
				document.form1.txtemail.focus();
				return false; 
			}
			if (document.form1.txtemail.value.indexOf('@', 0) == -1 || document.form1.txtemail.value.indexOf('.', 0) == -1) {
				alert ("E-mail inválido\nPreencha o campo email corretamente.");
				document.form1.txtemail.focus();
				return false;
			}
		}
					
		if (document.form1.txtorigem.value.length<1 || document.form1.txtorigem.value==0 || document.form1.txtorigem.value=="") {
			alert('Campo ORIGEM é obrigatório');
			document.form1.txtorigem.focus();
			return;
		}
		
		if (document.form1.txtgrupo.value.length<1 || document.form1.txtgrupo.value==0 || document.form1.txtgrupo.value=="") {
			alert('Campo GRUPO é obrigatório');
			document.form1.txtgrupo.focus();
			return;
		}
	}
	AtualizaEleitor(x_funcao);
return true;

}
//---------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------
function validaA(){
	valida_cadastro("A");
}
//-->
function validaE(){
	valida_cadastro("E");
}
//-->
function validaP(){
	valida_cadastro("P");
}
//-------------------------------------------------------------------------------------------------
function atual_ender() {
	var tipo;
	//alert(' Atualiza endereço');
		//return;
/*	if(document.form1.numero.value=="0" || document.form1.numero.value=="") {
		alert('Obrigatório informar o Número');
		document.form1.numero.select();
		return false;
	}
	if(document.form1.numero.value.length<1) {
		alert('Obrigatório informar o Número');
		document.form1.numero.select();
		return false;
	}*/

	var CadArray = new Array(13);
	if (document.form1.id_endereco.value ==''){
		CadArray[0]   = "NULL"; //id
		tipo = "I";
	}else{
		CadArray[0]   = document.form1.id_endereco.value; //id
		tipo = "A";
	}				
	CadArray[1]  = document.form1.txtcodigo.value;  //codigo
	CadArray[2]  = document.form1.cep.value;  //cep
	CadArray[3]  = document.form1.tipolog.value;  //tipolog
	CadArray[4]  = document.form1.rua.value;  //rua
	CadArray[5]  = document.form1.bairro.value;  //bairro
	CadArray[6]  = document.form1.cidade.value;  //cidade
	CadArray[7]  = document.form1.uf.value;  //uf
	CadArray[8]  = document.form1.numero.value;  //numero
	CadArray[9]  = document.form1.complemento.value;  //complemento
	CadArray[10] = document.form1.padrao.value; //padrao
	CadArray[11] = document.form1.tipo.value; //tipo
	CadArray[12] = document.form1.reg.value; //reg
	var parString="";
	for (var x=0; x<13; x++) {
		if (x==0){
			parString = "P"+x+"="+CadArray[x];	
		}else{
			parString = parString+"&P"+x+"="+CadArray[x];	
		}
	}
	//alert(parString);
	if (tipo==='A'){
   		ajax5('atualiza_endereco.php?'+parString, 'modal');
	}else{
   		ajax5('inclui_endereco.php?'+parString, 'modal');
	}
}

//------------------------------------------------------------------

function buscacep(cod) {
	var cod = document.form1.cep.value;
	//alert (cod);
	 if (isNaN(cod)) {
		alert ("Por favor informe somente números no CEP");
		document.form1.cep.focus();
		return false;
	}
	if(cod.length<8) {
		alert('favor informar o CEP com 8 números');
		document.form1.cep.focus();
		return false;
	}
	//alert(cod);
	ajax5('busca_cep.php?codigo='+cod, 'modal');

}			
//----------------------------------------------------------------------------------------------------------------------------------
function busca_cod_cep(cod) {
	//var cod = document.form1.cep.value;
	//alert (cod);
	 if (isNaN(cod)) {
		alert ("Por favor informe somente números no CEP");
		document.form1.cep.focus();
		return false;
	}
	if(cod.length<8) {
		alert('favor informar o CEP com 8 n\u00fameros');
		document.form1.cep.focus();
		return false;
	}
	//alert(cod);
	ajax5('busca_cep.php?codigo='+cod, 'modal');

}			
//------------------------------------------------------------------------------------------------------------------------------------			
function buscarua() {
	var rua = document.form1.rua.value;
	if(rua=="") {
		alert('favor informar a rua para pesquisar');
		document.form1.rua.focus();
		return false;
	}
	ajax5('busca_rua.php?rua='+rua, 'modal');

}			
//---------------------------------------------------------------------------------------------------------

function abrir_cadastro_pelo_apoio(cod_cadastro) {
    //$_SESSION['ult_eleitor_pesquisado'] = cod_cadastro;
	ajax4("../cad_apoio/inicializa_global.php?cod_cadastro="+cod_cadastro,"carregando");
	var param = '../eleitores/cadastro.php';
	//alert(param);
	open(param,"_self");		
	
}
	  
//---------------------------------------------------------------------------------------------------------

//------------------------------------------
function atual_ender(tipo,id) {

	//alert(tipo+' - '+id);
	if(document.alteracadastro.numero.value=="0" || document.alteracadastro.numero.value=="") {
		alert('Obrigatório informar o N\u00daMERO');
		document.alteracadastro.numero.focus();
		return false;
	}
	if(document.alteracadastro.numero.value.length<1) {
		alert('Obrigatório informar o N\u00daMERO');
		document.alteracadastro.numero.focus();
		return false;
	}

	var CadArray = new Array(13);
	if (tipo=='A'){
		CadArray[0]   = document.alteracadastro.id.value; //id
	}else{
		CadArray[0]   = "NULL"; //id
	}				
	CadArray[1]  = document.alteracadastro.codigo.value;  //codigo
	CadArray[2]  = document.alteracadastro.cep.value;  //cep
	CadArray[3]  = document.alteracadastro.tipolog.value;  //tipolog
	CadArray[4]  = document.alteracadastro.rua.value;  //rua
	CadArray[5]  = document.alteracadastro.bairro.value;  //bairro
	CadArray[6]  = document.alteracadastro.cidade.value;  //cidade
	CadArray[7]  = document.alteracadastro.uf.value;  //uf
	CadArray[8]  = document.alteracadastro.numero.value;  //numero
	CadArray[9]  = document.alteracadastro.complemento.value;  //complemento
	CadArray[10] = document.alteracadastro.padrao.value; //padrao
	CadArray[11] = document.alteracadastro.tipo.value; //tipo
	CadArray[12] = document.alteracadastro.reg.value; //reg
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
   		ajax5('atualiza_endereco.php?'+parString, 'carregando');
	}else{
   		ajax5('inclui_endereco.php?'+parString, 'carregando');
	}
}

//------------------------------------------------------------------

function buscacep(cod) {
	var cod = document.alteracadastro.cep.value;
	//alert (cod);
	 if (isNaN(cod)) {
		alert ("Por favor informe somente números no CEP");
		document.alteracadastro.cep.focus();
		return false;
	}
	if(cod.length<8) {
		alert('favor informar o CEP com 8 n\u00fameros');
		document.alteracadastro.cep.focus();
		return false;
	}
	//alert(cod);
	ajax5('busca_cep.php?codigo='+cod, 'carregando');

}			
//----------------------------------------------------------------------------------------------------------------------------------
function busca_cod_cep(cod) {
	//var cod = document.alteracadastro.cep.value;
	//alert (cod);
	 if (isNaN(cod)) {
		alert ("Por favor informe somente números no CEP");
		document.alteracadastro.cep.focus();
		return false;
	}
	if(cod.length<8) {
		alert('favor informar o CEP com 8 n\u00fameros');
		document.alteracadastro.cep.focus();
		return false;
	}
	//alert(cod);
	ajax5('busca_cep.php?codigo='+cod, 'carregando');

}			
//------------------------------------------------------------------------------------------------------------------------------------			
function buscarua() {
	var rua = document.alteracadastro.rua.value;
	if(rua=="") {
		alert('favor informar a rua para pesquisar');
		document.alteracadastro.rua.focus();
		return false;
	}
	ajax5('busca_rua.php?rua='+rua, 'carregando');

}			
//------------------------------------------------------------------------------------------------------------------------------------			

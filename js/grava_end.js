//------------------------------------------
function atual_ender() {
	var tipo;
	//alert(' Atualiza endereço');
		//return;
	if(document.form1.numero.value=="0" || document.form1.numero.value=="") {
		alert('Obrigatório informar o Número');
		document.form1.numero.select();
		return false;
	}
	if(document.form1.numero.value.length<1) {
		alert('Obrigatório informar o Número');
		document.form1.numero.select();
		return false;
	}

	var CadArray = new Array(13);
	if (document.form1.id_endereço ==''){
		CadArray[0]   = "NULL"; //id
		tipo = "I";
	}else{
		CadArray[0]   = document.form1.id.value; //id
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
   		ajax5('atualiza_endereco.php?'+parString, 'carregando');
	}else{
   		ajax5('inclui_endereco.php?'+parString, 'carregando');
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
		alert('favor informar o CEP com 8 n\u00fameros');
		document.form1.cep.focus();
		return false;
	}
	//alert(cod);
	ajax5('busca_cep.php?codigo='+cod, 'carregando');

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
	ajax5('busca_cep.php?codigo='+cod, 'carregando');

}			
//------------------------------------------------------------------------------------------------------------------------------------			
function buscarua() {
	var rua = document.form1.rua.value;
	if(rua=="") {
		alert('favor informar a rua para pesquisar');
		document.form1.rua.focus();
		return false;
	}
	ajax5('busca_rua.php?rua='+rua, 'carregando');

}			
//------------------------------------------------------------------------------------------------------------------------------------			

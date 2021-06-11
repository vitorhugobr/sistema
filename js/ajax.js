var texto = "";
var ini=0;
var codigo="";
var url ="";
var url1 ="";
var url2 ="";
var url3 ="";
var url4 ="";
var url5 ="";
var url6 ="";
var urlP ="";
var urlN ="";
var div ="";
var div1 ="";
var div2 ="";
var div3 ="";
var div4 ="";
var div5 ="";
var div6 ="";
var divP ="";
var divN ="";
var xhReq = createXMLHttpRequest();
var xhReq2 = createXMLHttpRequest();
var xhReq3 = createXMLHttpRequest();
var xhReq4 = createXMLHttpRequest();
var xhReq5 = createXMLHttpRequest();
var xhReq6 = createXMLHttpRequest();
var xhReqP = createXMLHttpRequest();
//----------------------------------------------------------------

function createXMLHttpRequest() {

"use strict";
 try{ return new ActiveXObject("Msxml2.XMLHTTP"); }catch(e){}
 try{ return new ActiveXObject("Microsoft.XMLHTTP"); }catch(e){}
 try{ return new XMLHttpRequest(); }catch(e){}
 alert("XMLHttpRequest não suportado");
 return null;
}
//-------------------------------------------------------------------------------------------------------

function geraJS(texto){
"use strict";
	var ini = 0;
	while (ini!==-1){
		ini = texto.indexOf('<script', ini);
		if (ini >=0){
			ini = texto.indexOf('>', ini) + 1;
			var fim = texto.indexOf('</script>', ini);
			codigo = texto.substring(ini,fim);
			eval(codigo);
		}
	}
}
//-------------------------------------------------------------------------------------------------------
function geraJS2(texto){
"use strict";
        
	var ini = 0;
	while (ini!==-1){
		ini = texto.indexOf('<script', ini);
		if (ini >=0){
			ini = texto.indexOf('>', ini) + 1;
			var fim = texto.indexOf('</script>', ini);
			codigo = texto.substring(ini,fim);
			eval(codigo);
		}
	}
 }
//-------------------------------------------------------------------------------------------------------
function geraJS3(texto){
"use strict";
        
	var ini = 0;
	while (ini!==-1){
		ini = texto.indexOf('<script', ini);
		if (ini >=0){
			ini = texto.indexOf('>', ini) + 1;
			var fim = texto.indexOf('</script>', ini);
			codigo = texto.substring(ini,fim);
			eval(codigo);
		}
	}
 }
//-------------------------------------------------------------------------------------------------------
function geraJS4(texto){
"use strict";
        
	var ini = 0;
	while (ini!==-1){
		ini = texto.indexOf('<script', ini);
		if (ini >=0){
			ini = texto.indexOf('>', ini) + 1;
			var fim = texto.indexOf('</script>', ini);
			codigo = texto.substring(ini,fim);
			eval(codigo);
		}
	}
 }
//-------------------------------------------------------------------------------------------------------
function geraJS5(texto){
"use strict";
        
	var ini = 0;
	while (ini!==-1){
		ini = texto.indexOf('<script', ini);
		if (ini >=0){
			ini = texto.indexOf('>', ini) + 1;
			var fim = texto.indexOf('</script>', ini);
			codigo = texto.substring(ini,fim);
			eval(codigo);
		}
	}
 }
//-------------------------------------------------------------------------------------------------------
function geraJS6(texto){
"use strict";
        
	var ini = 0;
	while (ini!==-1){
		ini = texto.indexOf('<script', ini);
		if (ini >=0){
			ini = texto.indexOf('>', ini) + 1;
			var fim = texto.indexOf('</script>', ini);
			codigo = texto.substring(ini,fim);
			eval(codigo);
		}
	}
 }
//-------------------------------------------------------------------------------------------------------
function geraJSP(texto){
"use strict";
        
	var ini = 0;
	while (ini!==-1){
		ini = texto.indexOf('<script', ini);
		if (ini >=0){
			ini = texto.indexOf('>', ini) + 1;
			var fim = texto.indexOf('</script>', ini);
			codigo = texto.substring(ini,fim);
			eval(codigo);
		}
	}
 }
//-------------------------------------------------------------------------------------------------------
function geraJSN(texto){
"use strict";
        
	var ini = 0;
	while (ini!==-1){
		ini = texto.indexOf('<script', ini);
		if (ini >=0){
			ini = texto.indexOf('>', ini) + 1;
			var fim = texto.indexOf('</script>', ini);
			codigo = texto.substring(ini,fim);
			eval(codigo);
		}
	}
 }
 //-------------------------------------------------------------------------------------------------------
function ajaxN(urlN,divN){
"use strict";
	  //alert('funcao ajax com '+url+' - '+div);
	 var divN = document.getElementById(div);
	 divN.innerHTML = '<img src="../imagens/aguardar.gif" class="div-ajax-carregamento-pagina">'; 

	 xhReqN.open("GET",urlN,true);
	 
	 xhReqN.onreadystatechange=function() {
		  if(xhReqN.readyState === 4) {
			   divN.innerHTML = xhReqN.responseText ;
			   geraJSN(xhReqN.responseText);
		  }
	 }
	 xhReqN.send(null);
}

//-------------------------------------------------------------------------------------------------------
function ajax(url,div){
"use strict";
    var div = document.getElementById(div);
    div.innerHTML = '<img src="../imagens/aguarde_engrenagens.gif">'; 
    openModal();
    xhReq.open("GET",url,true);      
    xhReq.onreadystatechange=function() {
    	if(xhReq.readyState == 4 && xhReq.status == 200) {
          closeModal();            
     	  div.innerHTML = xhReq.responseText ;
      	  geraJS(xhReq.responseText);
    	}
    }
    xhReq.send(null);
}
//-------------------------------------------------------------------------------------------------------		  
function ajax2(url2,div2){
"use strict";
    var div2 = document.getElementById(div2);
    div2.innerHTML = '<img src="../imagens/aguarde_engrenagens.gif">'; 
    openModal();
    xhReq2.open("GET",url2,true);      
    xhReq2.onreadystatechange=function() {
    	if(xhReq2.readyState == 4 && xhReq2.status == 200) {
          closeModal();            
     	  div2.innerHTML = xhReq2.responseText ;
      	  geraJS2(xhReq2.responseText);
    	}
    }
    xhReq2.send(null);
}
		  
//-------------------------------------------------------------------------------------------------------		  
function ajax3(url3,div3){
"use strict";
    var div3 = document.getElementById(div3);
    div3.innerHTML = '<img src="../imagens/aguarde_engrenagens.gif">'; 
    openModal();
    xhReq3.open("GET",url3,true);      
    xhReq3.onreadystatechange=function() {
    	if(xhReq3.readyState == 4 && xhReq3.status == 200) {
          closeModal();            
     	  div3.innerHTML = xhReq3.responseText ;
      	  geraJS3(xhReq3.responseText);
    	}
    }
    xhReq3.send(null);
}
//-------------------------------------------------------------------------------------------------------
function ajax4(url4,div4){
"use strict";
    var div4 = document.getElementById(div4);
    div4.innerHTML = '<img src="../imagens/aguarde_engrenagens.gif">'; 
    openModal();
    xhReq4.open("GET",url4,true);      
    xhReq4.onreadystatechange=function() {
    	if(xhReq4.readyState == 4 && xhReq4.status == 200) {
          closeModal();            
     	  div4.innerHTML = xhReq4.responseText ;
      	  geraJS4(xhReq4.responseText);
    	}
    }
    xhReq4.send(null);
}
//-------------------------------------------------------------------------------------------------------
function ajax5(url5,div5){
"use strict";
    var div5 = document.getElementById(div5);
    div5.innerHTML = '<img src="../imagens/aguarde_engrenagens.gif">'; 
    openModal();
    xhReq5.open("GET",url5,true);      
    xhReq5.onreadystatechange=function() {
    	if(xhReq5.readyState == 4 && xhReq5.status == 200) {
          closeModal();            
     	  div5.innerHTML = xhReq5.responseText ;
      	  geraJS5(xhReq5.responseText);
    	}
    }
    xhReq5.send(null);
}

//-------------------------------------------------------------------------------------------------------
function ajax6(url6,div6){
"use strict";
    var div6 = document.getElementById(div6);
    div6.innerHTML = '<img src="../imagens/aguarde_engrenagens.gif">'; 
    openModal();
    xhReq6.open("GET",url6,true);      
    xhReq6.onreadystatechange=function() {
    	if(xhReq6.readyState == 4 && xhReq6.status == 200) {
          closeModal();            
     	  div6.innerHTML = xhReq6.responseText ;
      	  geraJS6(xhReq6.responseText);
    	}
    }
    xhReq6.send(null);
}
//-------------------------------------------------------------------------------------------------------
function ajaxP(urlP,divP){
"use strict";
    
    document.getElementById(divP).innerHTML = '<img src="../imagens/aguarde_engrenagens.gif">'; 
    openModal();
    xhReqP.open("GET",urlP,true);      
    xhReqP.onreadystatechange=function() {
    	if(xhReqP.readyState == 4 && xhReqP.status == 200) {
          closeModal();            
      	  document.getElementById(divP).innerHTML = xhReq6.responseText ;
      	  geraJSP(xhReqP.responseText);
    	}
    }
    xhReqP.send(null);

}
//-----------------------------------------------------------------------------------------------------
function voltaPag(IDPag) {
"use strict";
	document.location=IDPag;
}
//-----------------------------------------------------------------------------------------------------
function atribuir_funcao(nomedafuncao){
"use strict";
	document.getElementById('nomefuncao').innerHTML = nomedafuncao;	
}
//-----------------------------------------------------------------------------------------------------
function myFunction() {
"use strict";
    location.reload();
}
//-----------------------------------------------------------------------------------------------------
function openModal() {
    document.getElementById('modal').style.display = 'block';
    document.getElementById('fade').style.display = 'block';
}

function closeModal() {
    document.getElementById('modal').style.display = 'none';
    document.getElementById('fade').style.display = 'none';
}

function loadAjax(page) {
    document.getElementById('results').innerHTML = '';
    openModal();
    var xhr = false;
    if (window.XMLHttpRequest) {
        xhr = new XMLHttpRequest();
    }
    else {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }
    if (xhr) {
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                closeModal();
                document.getElementById("results").innerHTML = xhr.responseText;
            }
        }
        xhr.open("GET", page, true);
        xhr.send(null);
    }
}

function createXMLHttpRequestPOST() {
   try{ return new ActiveXObject("Msxml2.XMLHTTP"); }catch(e){}
   try{ return new ActiveXObject("Microsoft.XMLHTTP"); }catch(e){}
   try{ return new XMLHttpRequest(); }catch(e){}
   alert("XMLHttpRequest n\u00e3o suportado");
   return null;
}


var xhReq = createXMLHttpRequest();
	            this.xhReq.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
	            this.xhReq.setRequestHeader("Cache-Control", "no-store, no-cache, must-revalidate");
	            this.xhReq.setRequestHeader("Cache-Control", "post-check=0, pre-check=0");
	            this.xhReq.setRequestHeader("Pragma", "no-cache");
function geraJSPOST(texto){
        
          var ini = 0;
          while (ini!=-1){
              ini = texto.indexOf('<script', ini);
              if (ini >=0){
                  ini = texto.indexOf('>', ini) + 1;
                  var fim = texto.indexOf('</script>', ini);
                  codigo = texto.substring(ini,fim);
                  eval(codigo);
              }
          }
 }

          function ajaxPOST(url,div,valores){
               var div = document.getElementById(div);
               div.innerHTML = "<img src='../ajax/espera.gif' width='16' height='16'><img src='../ajax/aguarde_azul.gif'>"; 
    	        xhReq.open("POST",url,true);
	            this.xhReq.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
	            this.xhReq.setRequestHeader("Cache-Control", "no-store, no-cache, must-revalidate");
	            this.xhReq.setRequestHeader("Cache-Control", "post-check=0, pre-check=0");
	            this.xhReq.setRequestHeader("Pragma", "no-cache");               
               xhReq.onreadystatechange=function() {
                    if(xhReq.readyState == 4) {
                         div.innerHTML = xhReq.responseText ;
                         geraJSPOST(xhReq.responseText);
                    }
               }
               xhReq.send(valores);
          }

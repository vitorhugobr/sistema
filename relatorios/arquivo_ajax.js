//CRIA A VARI¡VEL RETORNO
var retorno;
function CarregaArquivo(url,valor)
{
    retorno = null;
	//CRIA O OBJETO HttpRequest PARA O RESPECTIVO NAVEGADOR
	//Mozilla Fire Fox / Safari ...
	//
    if (window.XMLHttpRequest) {
		alert('1');
        retorno = new XMLHttpRequest();
		//SETA A FUNÁ√O QUE SER¡ CHAMADA QUANDO O AJAX DER UM RETORNO
        retorno.onreadystatechange = processReqChange;
		 //ABRE A REQUISIÁ√O AJAX, PASSANDO O M…TODO DE ACESSO, URL E O PAR¬METRO
        retorno.open("GET", url+'?grupo='+valor, true);
		//INICIA O TRANSPORTA DOS OBJETOS NA REQUISIÁ√O
        retorno.send(null);
    } else if (window.ActiveXObject) {
		alert('2');
		//
		//IE
		//
        retorno = new ActiveXObject("Microsoft.XMLHTTP");
        if (retorno) {
			//SETA A FUNÁ√O QUE SER¡ CHAMADA QUANDO O AJAX DER  UM RETORNO
            retorno.onreadystatechange = processReqChange;
		    //ABRE A REQUISIÁ√O AJAX, PASSANDO O M…TODO DE ACESSO, URL E O PAR¬METRO
            retorno.open("GET", url+'?grupo='+valor, true);
			//INICIA O TRANSPORTA DOS OBJETOS NA REQUISIÁ√O
            retorno.send();
        }
    }
}
//FUNÁ√O QUE TRATA O RETORNO DO AJAX
function processReqChange()
{
	//CASO O STATUS DO AJAX SEJA OK, CHAMA A FUNÁ√O mudar()
	//A LISTA COMPLETA DOS VALORES readyState … A SEGUINTE:
	//0 (uninitialized) 
	//1 (a carregar) 
	//2 (carregado) 
	//3 (interactivo) 
	//4 (completo) 
    if (retorno.readyState == 4)
	{
		if(retorno.status == 200) 
			{
				//PROCURA PELA DIV MOSTRACOMBO E INSERE O OBJETO
				document.getElementById('mostraCombo').innerHTML = retorno.responseText;
			} 
				else 
				{
					//MOSTRA UM ALERTA AO OBTER UM RETORNO DE OK.
					alert("Houve um problema ao obter os dados:\n" + retorno.statusText);
				}
   }
}

//FUNÁ√O MUDAR, QUE CHAMA AS INFORMAÁ’ES PASSADAS NO PAR¬METRO E CARREGA O ARQUIVO EXTERNO
function mudar(valor)
{
	//alert(valor+ ' Entrou');
	//CARREGA O ARQUIVO EXTERNO DO AJAX
    CarregaArquivo("mostra_combo.php",valor);
}
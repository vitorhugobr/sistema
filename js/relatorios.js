// JavaScript Document
"use strict";
function parametrosRel(variavel) {
	// chamar outro php multiselecao.php
	var parametros = 'multiselecao.php?tipo=G&opcao='+variavel;
	//alert(parametros);
	window.location.replace(parametros);
	document.getElementById('opcAniver').innerHTML = '';	
	
}

//---------------------------------------------------------------------------------------------------------------------
//	Quando: 
//	setaopcao =1 é Relatório Gerecial
//	setaopcao =2 é Carta Personalizada
//	setaopcao =3 é Etiquetas
//	setaopcao =4 é Carta de Aniversário
//	setaopcao =5 é Etiqueta Aniversário
//  setaopcao =6 é Relação de Aniversariantes
//  setaopcao =7 é Relatório de demandas
//  setaopcao =8 é exportar para excel
//  setaopcao =9 é Tiras para enviar jornal/impresso
//	o Tipo é:
//	'G' para Cadastro Geral ou 'A' para Aniversários


function mostraGeral() {
	var $mostra='<fieldset><legend>Opções Cadastro Geral</legend> <input class="radio-inline" name="opcG" type="radio" value="radiobutton" onClick="setaOpcao(1)"/>  Relatório Gerencial<br />  <input class="radio-inline" name="opcG" type="radio" value="radiobutton" onClick="setaOpcao(3)"/> Etiquetas<br /><input class="radio-inline" name="opcG" type="radio" value="radiobutton" onClick="setaOpcao(7)"/> Demandas<br /><input class="radio-inline" name="opcG" type="radio" value="radiobutton" onClick="setaOpcao(8)"/> Exportar Excel para Correspondência<br /></fieldset>';
	document.getElementById('opcGeral').innerHTML = $mostra;
	document.getElementById('opcAniver').innerHTML = '';
	document.form1.htipo.value = "G";
	document.form1.hopcao.value = '';

}

//---------------------------------------------------------------------------------------------------------------------

function setacondicao(variavel) {
	//alert("Opção "+variavel);
	document.form1.condition.value = variavel;
}
//---------------------------------------------------------------------------------------------------------------------

function setaOpcao(variavel) {
	//alert("Opção "+variavel);
	document.form1.hopcao.value = variavel;
	if (document.form1.htipo.value=="A"){
		parametrosAni(variavel);
	}else{
		if (variavel == 7){
			pedeData();
		}else 
			// chamar outro php multiselecao.php
			parametrosRel(variavel);
	}
}

//---------------------------------------------------------------------------------------------------------------------

function mostraAniver() {
	var $mostra='<fieldset>	<div class="col-sm-12">  <legend>Opções Aniversários</legend>  <input class="radio-inline" name="opcAni" type="radio" value="radiobutton" onClick="setaOpcao(5)"/>  Etiquetas Aniversários<br />  <input class="radio-inline" name="opcAni" type="radio" value="radiobutton" onclick="setaOpcao(6)"/>  Rela&ccedil;&atilde;o de Aniversariantes<br />  </div></fieldset>';
	document.getElementById('opcGeral').innerHTML = $mostra;
	document.getElementById('cabusuarios').innerHTML = '';
	document.getElementById('opcAniver').innerHTML = '';	
	document.form1.htipo.value = "A";
	document.form1.hopcao.value = "";

}

//---------------------------------------------------------------------------------------------------------------------
function parametrosAni(){
	var $mostra='<fieldset>  <legend>Informe</legend>  <table width="200" class="table table-striped">    <tr>      <td width="11%" align="right"><label>Dia Inicial:</label></td>      <td width="39%">     	<div class="col-sm-12">      <div class="form-group">      <select class="form-control" id="txtdia" name="txtdia">        <option>1</option>        <option>2</option>	        <option>3</option>        <option>4</option>        <option>5</option>        <option>6</option>        <option>7</option>        <option>8</option>        <option>9</option>        <option>10</option>        <option>11</option>        <option>12</option>        <option>13</option>        <option>14</option>        <option>15</option>        <option>16</option>        <option>17</option>        <option>18</option>        <option>19</option>        <option>20</option>        <option>21</option>        <option>22</option>        <option>23</option>        <option>24</option>        <option>25</option>        <option>26</option>        <option>27</option>        <option>28</option>        <option>29</option>        <option>30</option>        <option>31</option>      </select>      </div>      </div>      </td>      <td width="11%" align="right"><label>Dia Final:</label></td>      <td width="39%" >     	<div class="col-sm-12">      <div class="form-group">      <select class="form-control" id="txtdiaf" name="txtdiaf">        <option>1</option>        <option>2</option>        <option>3</option>        <option>4</option>        <option>5</option>        <option>6</option>        <option>7</option>        <option>8</option>        <option>9</option>        <option>10</option>        <option>11</option>        <option>12</option>        <option>13</option>        <option>14</option>        <option>15</option>        <option>16</option>        <option>17</option>        <option>18</option>        <option>19</option>        <option>20</option>        <option>21</option>        <option>22</option>        <option>23</option>        <option>24</option>        <option>25</option>        <option>26</option>        <option>27</option>        <option>28</option>        <option>29</option>        <option>30</option>        <option>31</option>      </select>      </div>      </div>		</td>    </tr>    <tr>      <td align="right"><label>Mês:</label></td>      <td colspan="3">     	<div class="col-sm-6">      <select class="form-control" name="txtmes" id="txtmes">      <option>Escolha o mês</option>      <option value="01">Janeiro</option>      <option value="02">Fevereiro</option>      <option value="03">Março</option>      <option value="04">Abril</option>      <option value="05">Maio</option>      <option value="06">Junho</option>      <option value="07">Julho</option>      <option value="08">Agosto</option>      <option value="09">Setembro</option>      <option value="10">Outubro</option>      <option value="11">Novembro</option>      <option value="12">Dezembro</option>      </select>      </div>    </tr>  </table><button class="btn btn-consultar btn-sm" type="submit"><i class="fas fa-search"></i> Gerar PDF</button></fieldset>';
	document.getElementById('opcAniver').innerHTML = $mostra;

	document.form1.txtdia.focus();
}

//-----------------------------------------------------------------------------------------------
function pedeData(){

	var mostra = '';
	mostra = mostra + '<fieldset><strong>Informe as datas</strong>';
	mostra = mostra + '<table class="table table-sm ">';
	mostra = mostra + '<tr>';
	mostra = mostra + '<th width="10%">';
	mostra = mostra + '<div align="right">Inicial:</div>';
	mostra = mostra + '</th>';            
	mostra = mostra + '<td width="90%" >';
	mostra = mostra + '<input type="date" name="txtdatai" id="txtdatai">';    
	mostra = mostra + '</td>';     
	mostra = mostra + '</tr>';      
	mostra = mostra + '<tr>';
	mostra = mostra + '<th>';     	
	mostra = mostra + '<div align="right">Final:</div>';
	mostra = mostra + '</th>';
	mostra = mostra + '<td>';
	mostra = mostra + '<input type="date" name="txtdataf" id="txtdataf"> (opcional)';
	mostra = mostra + '</td>';
	mostra = mostra + '</tr>';
	mostra = mostra + '<tr>';
	mostra = mostra + '<th>';
	mostra = mostra + '<div align="right">Incluir Respostas</div>';
	mostra = mostra + '</th>';
	mostra = mostra + '<td>';
	mostra = mostra + '<div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" name="chkResp" id="chkResp"></div>';
	mostra = mostra + '</td>';
	mostra = mostra + '</tr>';
	mostra = mostra + '<tr>';
	mostra = mostra + '<th>';
	mostra = mostra + '<div align="right">Situação:</div>';
	mostra = mostra + '</th>';
	mostra = mostra + '<td>';
	mostra = mostra + '		<div class="form-check form-check-inline">';
	mostra = mostra + '<input class="form-check-input" type="radio" name="radiosituacao" id="inlineCheckbox0" value="3">';
	mostra = mostra + '<label class="form-check-label" for="inlineCheckbox1">Todas</label>';
	mostra = mostra + '</div>';
	mostra = mostra + '<div class="form-check form-check-inline">';
	mostra = mostra + '<input class="form-check-input" type="radio" name="radiosituacao" id="inlineCheckbox1" value="0">';
	mostra = mostra + '<label class="form-check-label" for="inlineCheckbox1">Abertas</label>';
	mostra = mostra + '	</div>';
	mostra = mostra + '	<div class="form-check form-check-inline">';
	mostra = mostra + '	  <input class="form-check-input" type="radio" name="radiosituacao" id="inlineCheckbox2" value="1">';
	mostra = mostra + '	  <label class="form-check-label" for="inlineCheckbox2">Respondidas</label>';
	mostra = mostra + '	</div>';
	mostra = mostra + '	<div class="form-check form-check-inline">';
	mostra = mostra + '	  <input class="form-check-input" type="radio" name="radiosituacao" id="inlineCheckbox3" value="2" >';
	mostra = mostra + '	  <label class="form-check-label" for="inlineCheckbox3">Encerradas</label>';
	mostra = mostra + '	</div>';
	mostra = mostra + '</td>';
	mostra = mostra + '</tr>';
	mostra = mostra + '</table><button class="btn btn-consultar btn-sm" type="submit"><i class="fas fa-search"></i> Gerar PDF</button></fieldset>';
	mostra = mostra + '</fieldset>';
	document.getElementById('opcAniver').innerHTML = mostra;
	document.getElementById('cabusuarios').innerHTML = '';
	document.form1.txtdatai.focus();
	
}
//---------------------------------------------------------------------------------------------------------------------

function setaPV(variavel) {
	//alert(variavel);
	document.form1.hPV.value = variavel;
}
//---------------------------------------------------------------------------------------------------------------------
function pedeDetRua(){
	document.form1.hPV.value = 0;	
	var $mostra ='<fieldset>  <legend class="style16"><strong>Informe os dados</strong></legend>  <table width="100%" border="0" cellpadding="0" cellspacing="2">  <tr>    <td><div align="right"><span class="textoAzul">Cidade:</span></div></td>    <td><label>    <input name="txtcityficha" type="text" value="PORTO ALEGRE" size="20" maxlength="29" id="txtcityficha" ></label></td></tr>  <tr>    <td><div align="right"><span class="textoAzul">Bairro</span></div></td>      <td><label><input name="txtbairroficha" type="text" value="PARTENON" size="30" maxlength="30" id="txtbairroficha" >  </label></td></tr>    <tr>      <td><div align="right"><span class="textoAzul">Rua:</span></div></td>      <td><label>        <input name="txtruaficha" type="text" value="Informe a rua" size="50" maxlength="50" id="txtruaficha"/>      </label></td>    </tr> </table></fieldset>';
	new Autocomplete("txtruaficha", function() { return "../cadastro/autocompleterua2.php?typing=" + this.text.value+"&city=" + txtcityficha.text.value;});
	document.getElementById('opcAniver').innerHTML = $mostra;
	document.getElementById('cabusuarios').innerHTML = '';
	document.form1.txtruaficha.focus();

}
//---------------------------------------------------------------------------------------------------------------------
function montarel() {
	var tipo = document.form1.htipo.value;
	var opcao = document.form1.hopcao.value;
	ajax('monta.php?htipo='+tipo+'&hopcao='+opcao,'carregando');
}	
//---------------------------------------------------------------------------------------------------------------------
function myPrametros(lin,valorpassado) {
	var select = document.querySelector("#expressao"+lin);
	var option = select.children[select.selectedIndex];
	var texto = option.textContent;
	switch(lin) {
	  case 1:
		document.form1.textoexpressao1.value = texto;		
		document.form1.valorexpressao1.value = valorpassado;
		break;
	  case 2:
		document.form1.textoexpressao2.value = texto;		
		document.form1.valorexpressao2.value = valorpassado;
		break;
	  case 3:
		document.form1.textoexpressao3.value = texto;		
		document.form1.valorexpressao3.value = valorpassado;
		break;
	  case 4:
		document.form1.textoexpressao4.value = texto;		
		document.form1.valorexpressao4.value = valorpassado;
		break;
	  case 5:
		document.form1.textoexpressao5.value = texto;		
		document.form1.valorexpressao5.value = valorpassado;
		break;
	  case 6:
		document.form1.textoexpressao6.value = texto;		
		document.form1.valorexpressao6.value = valorpassado;
		break;
	  case 7:
		document.form1.textoexpressao7.value = texto;		
		document.form1.valorexpressao7.value = valorpassado;
		break;
	  case 8:
		document.form1.textoexpressao8.value = texto;		
		document.form1.valorexpressao8.value = valorpassado;
		break;
	  case 9:
		document.form1.textoexpressao9.value = texto;		
		document.form1.valorexpressao9.value = valorpassado;
		break;
	  case 10:
		document.form1.textoexpressao10.value = texto;		
		document.form1.valorexpressao10.value = valorpassado;
		break;
	  case 11:
		document.form1.textoexpressao11.value = texto;		
		document.form1.valorexpressao11.value = valorpassado;
		break;
	  default:
		document.form1.textoexpressao12.value = texto;		
		document.form1.valorexpressao12.value = valorpassado;
		break;
	}

}	
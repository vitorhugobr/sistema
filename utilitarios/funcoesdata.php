<?php
/*
--------------------------------------------------------------------------------
Functions for PHPMaker 2.0
(C)2002-2004 e.World Technology Limited. All rights reserved.
--------------------------------------------------------------------------------
*/
define("DEFAULT_CURRENCY_SYMBOL", "$");
define("DEFAULT_MON_DECIMAL_POINT", ".");
define("DEFAULT_MON_THOUSANDS_SEP", ",");
define("DEFAULT_POSITIVE_SIGN", "");
define("DEFAULT_NEGATIVE_SIGN", "-");
define("DEFAULT_FRAC_DIGITS", 2);
define("DEFAULT_P_CS_PRECEDES", true);
define("DEFAULT_P_SEP_BY_SPACE", false);
define("DEFAULT_N_CS_PRECEDES", true);
define("DEFAULT_N_SEP_BY_SPACE", false);
define("DEFAULT_P_SIGN_POSN", 3);
define("DEFAULT_N_SIGN_POSN", 3);

// PHPMaker DEFAULT_DATE_FORMAT:
/* "yyyy/mm/dd"(default)  or "mm/dd/yyyy" or "dd/mm/yyyy" */
define("DEFAULT_DATE_FORMAT", "dd/mm/yyyy");

// FormatDateTime
/*
Format a timestamp, datetime, date or time field from MySQL
$namedformat:
0 - General Date,
1 - Long Date,
2 - Short Date (Default),
3 - Long Time,
4 - Short Time,
5 - Short Date (yyyy/mm/dd),
6 - Short Date (mm/dd/yyyy),
7 - Short Date (dd/mm/yyyy)
*/
function FormatDateTime($ts, $namedformat)
{
  $DefDateFormat = str_replace("yyyy", "%Y", DEFAULT_DATE_FORMAT);
	$DefDateFormat = str_replace("mm", "%m", $DefDateFormat);
	$DefDateFormat = str_replace("dd", "%d", $DefDateFormat);
	if (is_numeric($ts)) // timestamp
	{
		switch (strlen($ts)) {
			case 14:
			    $patt = '/(\d{4})(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/';
			    break;
			case 12:
			    $patt = '/(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/';
			    break;
			case 10:
			    $patt = '/(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/';
			    break;
			case 8:
			    $patt = '/(\d{4})(\d{2})(\d{2})/';
			    break;
			case 6:
			    $patt = '/(\d{2})(\d{2})(\d{2})/';
			    break;
			case 4:
			    $patt = '/(\d{2})(\d{2})/';
			    break;
			case 2:
			    $patt = '/(\d{2})/';
			    break;
			default:
					return $ts;
		}		
		if ((isset($patt))&&(preg_match($patt, $ts, $matches)))
		{
			$year = $matches[1];
			$month = @$matches[2];
			$day = @$matches[3];
			$hour = @$matches[4];
			$min = @$matches[5];
			$sec = @$matches[6];
		}
		if (($namedformat==0)&&(strlen($ts)<10)) $namedformat = 2;
	}
	elseif (is_string($ts))
	{		
		if (preg_match('/(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/', $ts, $matches)) // datetime
		{
			$year = $matches[1];
			$month = $matches[2];
			$day = $matches[3];
			$hour = $matches[4];
			$min = $matches[5];
			$sec = $matches[6];
		}
		elseif (preg_match('/(\d{4})-(\d{2})-(\d{2})/', $ts, $matches)) // date
		{
			$year = $matches[1];
			$month = $matches[2];
			$day = $matches[3];
			if ($namedformat==0) $namedformat = 2;
		}
		elseif (preg_match('/(^|\s)(\d{2}):(\d{2}):(\d{2})/', $ts, $matches)) // time
		{
			$hour = $matches[2];
			$min = $matches[3];
			$sec = $matches[4];
			if (($namedformat==0)||($namedformat==1)) $namedformat = 3;
			if ($namedformat==2) $namedformat = 4;
		}
		else
		{
			return $ts;
		}
	}
	else
	{
		return $ts;
	}
	if (!isset($year)) $year = 0; // dummy value for times
	if (!isset($month)) $month = 1;
	if (!isset($day)) $day = 1;	
	if (!isset($hour)) $hour = 0;
	if (!isset($min)) $min = 0;
	if (!isset($sec)) $sec = 0;
	$uts = @mktime($hour, $min, $sec, $month, $day, $year);
	if ($uts == -1) { // failed to convert
		$year = substr_replace("0000", $year, -1 * strlen($year));
		$month = substr_replace("00", $month, -1 * strlen($month));
		$day = substr_replace("00", $day, -1 * strlen($day));
		$hour = substr_replace("00", $hour, -1 * strlen($hour));
		$min = substr_replace("00", $min, -1 * strlen($min));
		$sec = substr_replace("00", $sec, -1 * strlen($sec));
		$DefDateFormat = str_replace("yyyy", $year, DEFAULT_DATE_FORMAT);
		$DefDateFormat = str_replace("mm", $month, $DefDateFormat);
		$DefDateFormat = str_replace("dd", $day, $DefDateFormat);
		switch ($namedformat) {
			case 0:
			    return $DefDateFormat." $hour:$min:$sec";
			    break;
			case 1://unsupported, return general date
			    return $DefDateFormat." $hour:$min:$sec";
			    break;
			case 2:
			    return $DefDateFormat;
			    break;
			case 3:
					if (intval($hour)==0)
						return "12:$min:$sec AM";
					elseif (intval($hour)>0 && intval($hour)<12)
						return "$hour:$min:$sec AM";
					elseif (intval($hour)==12)
						return "$hour:$min:$sec PM";
					elseif (intval($hour)>12 && intval($hour)<=23)
						return (intval($hour)-12).":$min:$sec PM";
					else
						return "$hour:$min:$sec";
			    break;
			case 4:
			    return "$hour:$min:$sec";
			    break;
			case 5:
			    return "$year/$month/$day";
			    break;
			case 6:
			    return "$month/$day/$year";
			    break;
			case 7:
			    return "$day/$month/$year";
			    break;
			case 8:
			    return "$day/$month/$year";
			    break;
		}
	} else {
		switch ($namedformat) {
			case 0:
			    return strftime($DefDateFormat." %H:%M:%S", $uts);
			    break;
			case 1:
			    return strftime("%A, %B %d, %Y", $uts);		
			    break;
			case 2:
			    return strftime($DefDateFormat, $uts);
			    break;
			case 3:
			    return strftime("%I:%M:%S %p", $uts);
			    break;
			case 4:
			    return strftime("%H:%M:%S", $uts);
			    break;
			case 5:
			    return strftime("%Y/%m/%d", $uts);
			    break;
			case 6:
			    return strftime("%m/%d/%Y", $uts);
			    break;
			case 7:
			    return strftime("%d/%m/%Y" , $uts);
			    break;
			case 8:
			    return strftime("%d/%m/%Y %H:%M" , $uts);
			    break;
			case 9:
			    return strftime("%Y-%m-%d" , $uts);
			    break;
		}
	}
}

// Convert a date to MySQL format
function ConvertDateToMysqlFormat($dateStr)
{
	@list($datePt, $timePt) = explode(" ", $dateStr);
	$arDatePt = explode("/", $datePt);
	if (count($arDatePt) == 3) {
		switch (DEFAULT_DATE_FORMAT) {
		case "yyyy/mm/dd":
	    list($year, $month, $day) = $arDatePt;
	    break;
		case "mm/dd/yyyy":
	    list($month, $day, $year) = $arDatePt;
	    break;
		case "dd/mm/yyyy":
	    list($day, $month, $year) = $arDatePt;
	    break;
		}
		return trim($year . "-" . $month . "-" . $day . " " . $timePt);
	} else {
		return $dateStr;
	}
}

//----------------------------------------------------------------------------------------------------------------------
/*****
**
**  Biblioteca de funções para tratamento de data
**  Autor: Mauro Fonseca - mauro.morato@bol.com.br
**  Obs. Peço que mesmo nas implementações que mantenham
*** o meu nome neste cabeçalho
**
*****/


/**
**  Retorna nro de dias entre duas datas
**  Sintaxe: EntreDatas( "01/12/2002","02/12/2002" );
**  Retorno: 1  
**/
function EntreDatas( $inicio, $fim )
{
    $aInicio = Explode( "/",$inicio );
    $aFim    = Explode( "/",$fim    );
    $nTempo = mktime(0,0,0,$aFim[1],$aFim[0],$aFim[2]);
    $nTempo1= mktime(0,0,0,$aInicio[1],$aInicio[0],$aInicio[2]);
    return round(($nTempo-$nTempo1)/86400)+1;
}

/**
**  Soma numero de dias a uma data
**  Sintaxe: somadata( "01/12/2002",5 );
**  Retorno: 06/12/2002
**/
function somadata( $data, $nDias )
{
    if( !isset( $nDias ) )
    {
	$nDias = 1;
    }
    $aVet = Explode( "/",$data );
    return date( "d/m/Y",mktime(0,0,0,$aVet[1],$aVet[0]+$nDias,$aVet[2])); 
}


/**
**  Traz o numero de dias entre duas datas
**  Sintaxe: difdata( "01/12/2002","06/12/2002" );
**  Retorno: 5
**/
function difdata( $inicio, $fim )
{
	$aInicio = Explode("/",$inicio);
	$aFinal  = Explode("/",$fim   );
       
 date( "d",mktime(0,0,0,$aFinal[0]-$aInicio[0],$aFinal[1]-$aInicio[1],$aFinal[2]-$aInicio[2]));
}

/**
**  Retorna no numero de dias de uma data
**  Sintaxe: semana( "25/12/2002" );
**  Retorno: qua
**/
function semana( $data )
{
	$aVet=Explode( "/",$data );
        $nDia = date("w", mktime(0,0,0,$aVet[1],$aVet[0],$aVet[2] ));
	return substr("domsegterquaquisexsab", ($nDia+1)*3-3,3 );
}


/**
**  Transforma uma data do formato americano para o brasileiro
**  Sintaxe: databr( "12/25/2002" );
**  Retorno: 25/12/2002
**/
function databr( $data )
{
	 $qual = strchr( "/", $data );
	 if( $qual=="" ){ $qual = "-"; }
	 $aVet = Explode( $qual,$data );
	 $ano = $aVet[0];
	 $mes = $aVet[1];
	 $dia = $aVet[2];
	 return date("d".$qual."m".$qual."Y",mktime(0,0,0,$mes,$dia,$ano ) );
}


/**
**  Transforma uma data do formato brasileiro para o americano
**  Sintaxe: dataen( "25/12/2002" );
**  Retorno: 12/25/2002
**/
function dataen( $data )
{
	 $qual = strpos( $data,"/" );
	 if( $qual>0 )
	 { 
		$qual = "/"; 
	 }
	 else
	 {
	 	$qual = "-";
	 }
	 $aVet = Explode( $qual,$data );
	 $ano = $aVet[2];
	 $mes = $aVet[1];
	 $dia = $aVet[0];
	 //return date("Y/m/d",mktime(0,0,0,$mes,$dia,$ano ) );
	 return date("Y".$qual."m".$qual."d",mktime(0,0,0,$mes,$dia,$ano ) );
}


/**
**  Retorna a data de hoje
**  Sintaxe: datadehoje();
**  Retorno: a data atual no formata dd/mm/aaaa
**/
function datadehoje()
{
  $dia = date("d");
  $mes = date("m");
  $ano = date("Y");
  $aux = mktime( 0,0,0, $mes, $dia, $ano );
  //return date("d") ."/". date("m")."/" . date("Y");
  return date("d/m/Y", $aux );
}

//---------------------------------------------------------------------------------------------------------------------

?>  
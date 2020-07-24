<?php

$is_dev = true;

function debug() {
    global $is_dev;

    if ($is_dev) {
        $debug_arr = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        $line = $debug_arr[0]['line'];
        $file = $debug_arr[0]['file'];

        #header('Content-Type: text/plain');

        echo "linha: $line\n";
        echo "arquivo: $file\n\n";
        print_r(array('GET' => $_GET, 'POST' => $_POST, 'SERVER' => $_SERVER));
        exit;
    }
}
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

// FormatCurrency
/*
FormatCurrency(Expression[,NumDigitsAfterDecimal [,IncludeLeadingDigit
 [,UseParensForNegativeNumbers [,GroupDigits]]]])
NumDigitsAfterDecimal is the numeric value indicating how many places to the
right of the decimal are displayed
-1 Use Default
The IncludeLeadingDigit, UseParensForNegativeNumbers, and GroupDigits
arguments have the following settings:
-1 True 
0 False 
-2 Use Default
*/
function FormatCurrency($amount, $NumDigitsAfterDecimal, $IncludeLeadingDigit, $UseParensForNegativeNumbers, $GroupDigits) 
{

  // export the values returned by localeconv into the local scope
  if (function_exists("localeconv")) extract(localeconv());

	// set defaults if locale is not set
	if (empty($currency_symbol)) $currency_symbol = DEFAULT_CURRENCY_SYMBOL;
	if (empty($mon_decimal_point)) $mon_decimal_point = DEFAULT_MON_DECIMAL_POINT;
	if (empty($mon_thousands_sep)) $mon_thousands_sep = DEFAULT_MON_THOUSANDS_SEP;
	if (empty($positive_sign)) $positive_sign = DEFAULT_POSITIVE_SIGN;
	if (empty($negative_sign)) $negative_sign = DEFAULT_NEGATIVE_SIGN;
	if (empty($frac_digits) || $frac_digits == CHAR_MAX) $frac_digits = DEFAULT_FRAC_DIGITS;
	if (empty($p_cs_precedes) || $p_cs_precedes == CHAR_MAX) $p_cs_precedes = DEFAULT_P_CS_PRECEDES;
	if (empty($p_sep_by_space) || $p_sep_by_space == CHAR_MAX) $p_sep_by_space = DEFAULT_P_SEP_BY_SPACE;
	if (empty($n_cs_precedes) || $n_cs_precedes == CHAR_MAX) $n_cs_precedes = DEFAULT_N_CS_PRECEDES;
	if (empty($n_sep_by_space) || $n_sep_by_space == CHAR_MAX) $n_sep_by_space = DEFAULT_N_SEP_BY_SPACE;
	if (empty($p_sign_posn) || $p_sign_posn == CHAR_MAX) $p_sign_posn = DEFAULT_P_SIGN_POSN;
	if (empty($n_sign_posn) || $n_sign_posn == CHAR_MAX) $n_sign_posn = DEFAULT_N_SIGN_POSN;

	// check $NumDigitsAfterDecimal
	if ($NumDigitsAfterDecimal > -1) 
		$frac_digits = $NumDigitsAfterDecimal;

	// check $UseParensForNegativeNumbers
	if ($UseParensForNegativeNumbers == -1) {
		$n_sign_posn = 0;
		if ($p_sign_posn == 0) {
			if (DEFAULT_P_SIGN_POSN != 0)
				$p_sign_posn = DEFAULT_P_SIGN_POSN;
			else
				$p_sign_posn = 3;
		}
	} elseif ($UseParensForNegativeNumbers == 0) {
		if ($n_sign_posn == 0)
			if (DEFAULT_P_SIGN_POSN != 0)
				$n_sign_posn = DEFAULT_P_SIGN_POSN;
			else
				$n_sign_posn = 3;
	}

	// check $GroupDigits
	if ($GroupDigits == -1) {
		$mon_thousands_sep = DEFAULT_MON_THOUSANDS_SEP;
	} elseif ($GroupDigits == 0) {
		$mon_thousands_sep = "";
	}

	// start by formatting the unsigned number
	$number = number_format(abs($amount),
	                        $frac_digits,
	                        $mon_decimal_point,
	                        $mon_thousands_sep);

	// check $IncludeLeadingDigit
	if ($IncludeLeadingDigit == 0) {
		if (substr($number, 0, 2) == "0.")
			$number = substr($number, 1, strlen($number)-1);		
	}
	if ($amount < 0) {
        $sign = $negative_sign;

        // "extracts" the boolean value as an integer 
        $n_cs_precedes  = intval($n_cs_precedes  == true);
        $n_sep_by_space = intval($n_sep_by_space == true);
        $key = $n_cs_precedes . $n_sep_by_space . $n_sign_posn;
    } else {
        $sign = $positive_sign;
        $p_cs_precedes  = intval($p_cs_precedes  == true);
        $p_sep_by_space = intval($p_sep_by_space == true);
        $key = $p_cs_precedes . $p_sep_by_space . $p_sign_posn;
    }
  $formats = array(

      // currency symbol is after amount

      // no space between amount and sign
      '000' => '(%s' . $currency_symbol . ')',
      '001' => $sign . '%s ' . $currency_symbol,
      '002' => '%s' . $currency_symbol . $sign,
      '003' => '%s' . $sign . $currency_symbol,
      '004' => '%s' . $sign . $currency_symbol,

      // one space between amount and sign
      '010' => '(%s ' . $currency_symbol . ')',
      '011' => $sign . '%s ' . $currency_symbol,
      '012' => '%s ' . $currency_symbol . $sign,
      '013' => '%s ' . $sign . $currency_symbol,
      '014' => '%s ' . $sign . $currency_symbol,

      // currency symbol is before amount

      // no space between amount and sign
      '100' => '(' . $currency_symbol . '%s)',
      '101' => $sign . $currency_symbol . '%s',
      '102' => $currency_symbol . '%s' . $sign,
      '103' => $sign . $currency_symbol . '%s',
      '104' => $currency_symbol . $sign . '%s',

      // one space between amount and sign
      '110' => '(' . $currency_symbol . ' %s)',
      '111' => $sign . $currency_symbol . ' %s',
      '112' => $currency_symbol . ' %s' . $sign,
      '113' => $sign . $currency_symbol . ' %s',
      '114' => $currency_symbol . ' ' . $sign . '%s');

  // lookup the key in the above array
  return sprintf($formats[$key], $number);
}

// FormatNumber
/*
FormatNumber(Expression[,NumDigitsAfterDecimal [,IncludeLeadingDigit
	[,UseParensForNegativeNumbers [,GroupDigits]]]])
NumDigitsAfterDecimal is the numeric value indicating how many places to the
right of the decimal are displayed
-1 Use Default
The IncludeLeadingDigit, UseParensForNegativeNumbers, and GroupDigits
arguments have the following settings:
-1 True 
0 False 
-2 Use Default
*/
function FormatNumber($amount, $NumDigitsAfterDecimal, $IncludeLeadingDigit, $UseParensForNegativeNumbers, $GroupDigits) 
{

  // export the values returned by localeconv into the local scope
  if (function_exists("localeconv")) extract(localeconv());

	// set defaults if locale is not set
	if (empty($currency_symbol)) $currency_symbol = DEFAULT_CURRENCY_SYMBOL;
	if (empty($mon_decimal_point)) $mon_decimal_point = DEFAULT_MON_DECIMAL_POINT;
	if (empty($mon_thousands_sep)) $mon_thousands_sep = DEFAULT_MON_THOUSANDS_SEP;
	if (empty($positive_sign)) $positive_sign = DEFAULT_POSITIVE_SIGN;
	if (empty($negative_sign)) $negative_sign = DEFAULT_NEGATIVE_SIGN;
	if (empty($frac_digits) || $frac_digits == CHAR_MAX) $frac_digits = DEFAULT_FRAC_DIGITS;
	if (empty($p_cs_precedes) || $p_cs_precedes == CHAR_MAX) $p_cs_precedes = DEFAULT_P_CS_PRECEDES;
	if (empty($p_sep_by_space) || $p_sep_by_space == CHAR_MAX) $p_sep_by_space = DEFAULT_P_SEP_BY_SPACE;
	if (empty($n_cs_precedes) || $n_cs_precedes == CHAR_MAX) $n_cs_precedes = DEFAULT_N_CS_PRECEDES;
	if (empty($n_sep_by_space) || $n_sep_by_space == CHAR_MAX) $n_sep_by_space = DEFAULT_N_SEP_BY_SPACE;
	if (empty($p_sign_posn) || $p_sign_posn == CHAR_MAX) $p_sign_posn = DEFAULT_P_SIGN_POSN;
	if (empty($n_sign_posn) || $n_sign_posn == CHAR_MAX) $n_sign_posn = DEFAULT_N_SIGN_POSN;

	// check $NumDigitsAfterDecimal
	if ($NumDigitsAfterDecimal > -1) 
		$frac_digits = $NumDigitsAfterDecimal;

	// check $UseParensForNegativeNumbers
	if ($UseParensForNegativeNumbers == -1) {
		$n_sign_posn = 0;
		if ($p_sign_posn == 0) {
			if (DEFAULT_P_SIGN_POSN != 0)
				$p_sign_posn = DEFAULT_P_SIGN_POSN;
			else
				$p_sign_posn = 3;
		}
	} elseif ($UseParensForNegativeNumbers == 0) {
		if ($n_sign_posn == 0)
			if (DEFAULT_P_SIGN_POSN != 0)
				$n_sign_posn = DEFAULT_P_SIGN_POSN;
			else
				$n_sign_posn = 3;
	}

	// check $GroupDigits
	if ($GroupDigits == -1) {
		$mon_thousands_sep = DEFAULT_MON_THOUSANDS_SEP;
	} elseif ($GroupDigits == 0) {
		$mon_thousands_sep = "";
	}

  // start by formatting the unsigned number
  $number = number_format(abs($amount),
                          $frac_digits,
                          $mon_decimal_point,
                          $mon_thousands_sep);

	// check $IncludeLeadingDigit
	if ($IncludeLeadingDigit == 0) {
		if (substr($number, 0, 2) == "0.")
			$number = substr($number, 1, strlen($number)-1);
	}
	if ($amount < 0) {
        $sign = $negative_sign;
        $key = $n_sign_posn;
    } else {
        $sign = $positive_sign;
        $key = $p_sign_posn;
    }
	$formats = array(
		'0' => '(%s)',
		'1' => $sign . '%s',
		'2' => $sign . '%s',
		'3' => $sign . '%s',
		'4' => $sign . '%s');

	// lookup the key in the above array
	return sprintf($formats[$key], $number);
}

// FormatPercent
/*
FormatPercent(Expression[,NumDigitsAfterDecimal [,IncludeLeadingDigit
	[,UseParensForNegativeNumbers [,GroupDigits]]]])
NumDigitsAfterDecimal is the numeric value indicating how many places to the
right of the decimal are displayed
-1 Use Default
The IncludeLeadingDigit, UseParensForNegativeNumbers, and GroupDigits
arguments have the following settings:
-1 True 
0 False 
-2 Use Default
*/
function FormatPercent($amount, $NumDigitsAfterDecimal, $IncludeLeadingDigit, $UseParensForNegativeNumbers, $GroupDigits) 
{

  // export the values returned by localeconv into the local scope
  if (function_exists("localeconv")) extract(localeconv());

	// set defaults if locale is not set
	if (empty($currency_symbol)) $currency_symbol = DEFAULT_CURRENCY_SYMBOL;
	if (empty($mon_decimal_point)) $mon_decimal_point = DEFAULT_MON_DECIMAL_POINT;
	if (empty($mon_thousands_sep)) $mon_thousands_sep = DEFAULT_MON_THOUSANDS_SEP;
	if (empty($positive_sign)) $positive_sign = DEFAULT_POSITIVE_SIGN;
	if (empty($negative_sign)) $negative_sign = DEFAULT_NEGATIVE_SIGN;
	if (empty($frac_digits) || $frac_digits == CHAR_MAX) $frac_digits = DEFAULT_FRAC_DIGITS;
	if (empty($p_cs_precedes) || $p_cs_precedes == CHAR_MAX) $p_cs_precedes = DEFAULT_P_CS_PRECEDES;
	if (empty($p_sep_by_space) || $p_sep_by_space == CHAR_MAX) $p_sep_by_space = DEFAULT_P_SEP_BY_SPACE;
	if (empty($n_cs_precedes) || $n_cs_precedes == CHAR_MAX) $n_cs_precedes = DEFAULT_N_CS_PRECEDES;
	if (empty($n_sep_by_space) || $n_sep_by_space == CHAR_MAX) $n_sep_by_space = DEFAULT_N_SEP_BY_SPACE;
	if (empty($p_sign_posn) || $p_sign_posn == CHAR_MAX) $p_sign_posn = DEFAULT_P_SIGN_POSN;
	if (empty($n_sign_posn) || $n_sign_posn == CHAR_MAX) $n_sign_posn = DEFAULT_N_SIGN_POSN;

	// check $NumDigitsAfterDecimal
	if ($NumDigitsAfterDecimal > -1) 
		$frac_digits = $NumDigitsAfterDecimal;

	// check $UseParensForNegativeNumbers
	if ($UseParensForNegativeNumbers == -1) {
		$n_sign_posn = 0;
		if ($p_sign_posn == 0) {
			if (DEFAULT_P_SIGN_POSN != 0)
				$p_sign_posn = DEFAULT_P_SIGN_POSN;
			else
				$p_sign_posn = 3;
		}
	} elseif ($UseParensForNegativeNumbers == 0) {
		if ($n_sign_posn == 0)
			if (DEFAULT_P_SIGN_POSN != 0)
				$n_sign_posn = DEFAULT_P_SIGN_POSN;
			else
				$n_sign_posn = 3;
	}

	// check $GroupDigits
	if ($GroupDigits == -1) {
		$mon_thousands_sep = DEFAULT_MON_THOUSANDS_SEP;
	} elseif ($GroupDigits == 0) {
		$mon_thousands_sep = "";
	}

	// start by formatting the unsigned number
	$number = number_format(abs($amount)*100,
	                        $frac_digits,
	                        $mon_decimal_point,
	                        $mon_thousands_sep);

	// check $IncludeLeadingDigit
	if ($IncludeLeadingDigit == 0) {
		if (substr($number, 0, 2) == "0.")
			$number = substr($number, 1, strlen($number)-1);		
	}
	if ($amount < 0) {
        $sign = $negative_sign;
        $key = $n_sign_posn;
    } else {
        $sign = $positive_sign;
        $key = $p_sign_posn;
    }
	$formats = array(
		'0' => '(%s%%)',
		'1' => $sign . '%s%%',
		'2' => $sign . '%s%%',
		'3' => $sign . '%s%%',
		'4' => $sign . '%s%%');

  // lookup the key in the above array
  return sprintf($formats[$key], $number);
}
//------------------------------------------------------------------
/**
 * Função para formatar Telefone, CEP, CPF, CNPJ e RG
 *
 * Escolher tipo de formatação ( fone, cep, cpf, cnpj ou rg) 
 * Lembrar de colocar em lowercase
 * @param $tipo  string
 *   
 * Enviar string que para ser formata ex: 13974208014;
 * @param $string  string   
 *
 * Quantidade de caracteres a serem formatados, 
 * só serve para o telefone 10 para o padrão antigo e 11 para novo padrão com 9
 * @param $size  integer  
 *
 *
 * Valor formatado do padrão escolhido
 * @return $string  string   
 */
function formatar ($tipo = "", $string, $size = 10)
{
    $string = ereg_replace("[^0-9]", "", $string);
    
    switch ($tipo)
    {
        case 'fone':
            if($size === 10){
             $string = '(' . substr($tipo, 0, 2) . ') ' . substr($tipo, 2, 4) 
             . '-' . substr($tipo, 6);
         }else
         if($size === 11){
             $string = '(' . substr($tipo, 0, 2) . ') ' . substr($tipo, 2, 5) 
             . '-' . substr($tipo, 7);
         }
         break;
        case 'cep':
            $string = substr($string, 0, 5) . '-' . substr($string, 5, 3);
         break;
        case 'cpf':
            $string = substr($string, 0, 3) . '.' . substr($string, 3, 3) . 
                '.' . substr($string, 6, 3) . '-' . substr($string, 9, 2);
         break;
        case 'cnpj':
            $string = substr($string, 0, 2) . '.' . substr($string, 2, 3) . 
                '.' . substr($string, 5, 3) . '/' . 
                substr($string, 8, 4) . '-' . substr($string, 12, 2);
         break;
        case 'rg':
            $string = substr($string, 0, 2) . '.' . substr($string, 2, 3) . 
                '.' . substr($string, 5, 3);
         break;
        default:
         $string = 'É ncessário definir um tipo(fone, cep, cpg, cnpj, rg)';
         break;
    }
    return $string;
}
//-------------------------------------------------------------------
function trocadata($var)
{
$data2=$var;
$data2=explode("-",$data2); //explode desmonta a variavel
return($data2[2]."/".$data2[1]."/".$data2[0]); // Formato PT-BR(DD/MM/YYYY)
}
//------------------------------------------------------------------

function trocadataBarra($var)
{
$data2=$var;
$data2=explode("/",$data2); //explode desmonta a variavel
return($data2[2]."-".$data2[1]."-".$data2[0]); // Formato PT-BR(DD/MM/YYYY)
}
//------------------------------------------------------------------

function trocavirgula($var)
{
$moeda=$var;
$moeda=explode(".",$moeda);
return ($moeda[0].""."".$moeda[1]."");
}
//------------------------------------------------------------------

function trocaPontoVirgula($var)
{
$moeda=$var;
$moeda=explode(",",$moeda); //explode desmonta a variavel
return($moeda[0].".".$moeda[1]); // Formato PT-BR(DD/MM/YYYY)
}

//------------------------------------------------------------------

function calcpv($desconto,$preco) {
$descontototal = ($preco*($desconto/100));
$pv=$preco - $descontototal;
return $pv;
}

//------------------------------------------------------------------

function Verify_Email_Address($email_address)
         {
         //Assumes that valid email addresses consist of user_name@domain.tld
//		 echo ('verificando email');
         $at = strpos($email_address, "@");
         $dot = strrpos($email_address, ".");

         if($at === false ||
            $dot === false ||
            $dot <= $at + 1 ||
            $dot == 0 ||
            $dot == strlen($email_address) - 1)
            return(false);

         $user_name = substr($email_address, 0, $at);
         $domain_name = substr($email_address, $at + 1, strlen($email_address));

         if(Validate_String($user_name,true) === false ||
            Validate_String($domain_name,true) === false)
            return(false);

         return(true);
         }
//--------------------------------------------------------------------------------------------------
function Validate_String($string, $return_invalid_chars)
         {
         $valid_chars = "1234567890-_.^~abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
         $invalid_chars = "";

         if($string == null || $string == "")
            return(true);

         //For every character on the string.
         for($index = 0; $index < strlen($string); $index++)
            {
            $char = substr($string, $index, 1);

            //Is it a valid character?
            if(strpos($valid_chars, $char) === false)
              {
              //If not, is it already on the list of invalid characters?
              if(strpos($invalid_chars, $char) === false)
                {
                //If it's not, add it.
                if($invalid_chars == "")
                   $invalid_chars .= $char;
                else
                   $invalid_chars .= ", " . $char;
                }
              }
            }

         //If the string does not contain invalid characters, the function will return true.
         //If it does, it will either return false or a list of the invalid characters used
         //in the string, depending on the value of the second parameter.
         if($return_invalid_chars == true && $invalid_chars != "")
           {
           $last_comma = strrpos($invalid_chars, ",");

           if($last_comma != false)
              $invalid_chars = substr($invalid_chars, 0, $last_comma) .
              " and " . substr($invalid_chars, $last_comma + 1, strlen($invalid_chars));

           return($invalid_chars);
           }
         else
           return($invalid_chars == "");
         }

//----------------------------------------------------------------------------------------------------------------------
/** Função para gravar no journal
*/
function gravaoperacoes($tabela, $operacao, $usuario, $conteudo) {
	
	date_default_timezone_set('America/Sao_Paulo');
	
//	$data = date("d/m/Y", mktime(gmdate("d"), gmdate("m"), gmdate("Y")));
	$data = date('Y-m-d H:i:s');	
	$hora = date("H:i:s", mktime(gmdate("H")-3, gmdate("i"), gmdate("s")));	 

	// operacao
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($operacao) : $operacao;
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$operacao = $theValue;
	// conteudo
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($conteudo) : $conteudo;
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$conteudo = $theValue;
	// tabela
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($tabela) : $tabela;
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$tabela = $theValue;
	// usuario
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($usuario) : $usuario;
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$usuario = $theValue;
	// data
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($data) : $data;
	$theValue = ($theValue != "") ? " '" . ConvertDateToMysqlFormat($theValue) . "'" : "NULL";
	$data = $theValue;
	// hora
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($hora) : $hora;
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$hora = $theValue;
	
  // grava na tabela 'operacoes' transação realizada
	$strsqlo = 'INSERT into operacoes VALUES(NULL';
	$strsqlo .= ",".$data;
	$strsqlo .= ",".$hora;
	$strsqlo .= ",".$tabela;
	$strsqlo .= ",".$operacao;
	$strsqlo .= ",".$usuario;
	$strsqlo .= ",".$conteudo;
	$strsqlo .= ')';
	
	// Faz conexão com banco de dados
	$pdosqlo = new PDO("mysql:host=".HOST.";dbname=".DB.";",USER, PASS);
	$pdosqlo->exec("set names utf8");
	$pdosqlo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	array(PDO::ATTR_PERSISTENT => true);
	//echo $msgok;
	try{
		$statementSql = $pdosqlo->prepare($strsqlo);
		$statementSql->execute();
		return $statementSql->rowCount();;
	}catch(PDOException $e){
	  // Caso ocorra algum erro exibe a mensagem
		//die;
		return false;
	}
	$pdosqlo= null;
}
//----------------------------------------------------------------------------------------------------------------------
/** Função para executar comando mysql*/
function executa_sql($sql, $msgok, $msgerro, $display_msg, $atualiza_pagina) {
	// $sql é a instrução sql a ser executada
	// $msgok é a mensagem em caso de OK
	// $msgerro é a mensagem em casa de ERRO
	// $display_msg é se a mensagem será mostrada(true) ou não(false)
	// $atualiza_pagina é se a tela será atualizada(true) ou não(false)
	// Faz conexão com banco de dados
	$pdosql = new PDO("mysql:host=".HOST.";dbname=".DB.";",USER, PASS);
	$pdosql->exec("set names utf8");
	$pdosql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	array(PDO::ATTR_PERSISTENT => true);
	//echo $msgok;
	try{
		$statementSql = $pdosql->prepare($sql);
		$statementSql->execute();
		if ($display_msg){
			$_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><i class='fas fa-check' aria-hidden='true text-muted' aria-hidden='true'></i> ".$msgok."<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";			
		}
		if ($atualiza_pagina){

				echo '<script>window.location.reload();</script>'; 
			
		}
		return $statementSql->rowCount();
	}catch(PDOException $e){  // Caso ocorra algum erro exibe a mensagem
		if ($e->errorInfo[1] == 1062) {      // duplicate entry, do something else
 			$_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show'' role='alert'><i class='fas fa-exclamation' aria-hidden='true text-muted' aria-hidden='true'></i> ".$msgerro.". JÁ EXISTE ESTE REGISTRO!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";  		
		} else {      // an error other than duplicate entry occurred
 			$_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show'' role='alert'><i class='fas fa-exclamation' aria-hidden='true text-muted' aria-hidden='true'></i> ".$msgerro." Motivo:\n".$e->getMessage()."<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";  			
		}
		//die;
		return false;
	}
	$pdosql= null;
}

//----------------------------------------------------------------------------------------------------------------------
/** Função para executar comando mysql*/
function executa_sql_comum($sql, $msgok, $msgerro, $display_msg, $atualiza_pagina) {
	// $sql é a instrução sql a ser executada
	// $msgok é a mensagem em caso de OK
	// $msgerro é a mensagem em casa de ERRO
	// $display_msg é se a mensagem será mostrada(true) ou não(false)
	// $atualiza_pagina é se a tela será atualizada(true) ou não(false)
	// Faz conexão com banco de dados
	$pdosql = new PDO("mysql:host=".HOSTCOMUM.";dbname=".DBCOMUM.";",USERCOMUM, PASSCOMUM);
	$pdosql->exec("set names utf8");
	$pdosql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	array(PDO::ATTR_PERSISTENT => true);
	//echo $msgok;
	try{
		$statementSql = $pdosql->prepare($sql);
		$statementSql->execute();
		if ($display_msg){
			$_SESSION['msg'] = "<div class='alert alert-success' role='alert'><i class='fas fa-check' aria-hidden='true text-muted' aria-hidden='true'></i> ".$msgok."<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";			
		}
		if ($atualiza_pagina){
			echo '<script>window.location.reload();</script>'; 
		}
		return $statementSql->rowCount();
	}catch(PDOException $e){  // Caso ocorra algum erro exibe a mensagem
		if ($e->errorInfo[1] == 1062) {      // duplicate entry, do something else
 			$_SESSION['msg'] = "<div class='alert alert-danger' role='alert'><i class='fas fa-exclamation' aria-hidden='true text-muted' aria-hidden='true'></i> ".$msgerro.". JÁ EXISTE ESTE REGISTRO!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";  		
		} else {      // an error other than duplicate entry occurred
 			$_SESSION['msg'] = "<div class='alert alert-danger' role='alert'><i class='fas fa-exclamation' aria-hidden='true text-muted' aria-hidden='true'></i> ".$msgerro." Motivo:\n".$e->getMessage()."<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";  			
		}
		//die;
		return false;
	}
	$pdosql= null;
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
function buscar_ultima_consulta($cod_cadastro) {
  $cons  = new mysqli(HOST,USER,PASS,DB);	
  if(!$cons) {  
	  echo "Não foi possivel conectar ao MySQL. Erro " .
			  mysqli_connect_errno() . " : " . mysql_connect_error();
	  exit;
  }

  $query2 = "SELECT * from agenda_clinica WHERE cod_cadastro = ".$cod_cadastro." order by data_agenda desc limit 1";
  $mysql_query2 = $cons->query($query2);
  $qtderegs2 = $mysql_query2->num_rows;
  $msg = "";
  if ($qtderegs2>0) {
	  while ($dado2 = $mysql_query2->fetch_assoc()) {
		  return FormatDateTime($dado2['data_agenda'],7);
	  }				
  }else{
	  return "";					
  }
}
//---------------------------------------------------------------------------------------------------------------------
function busca_qtde_respostas($cod_demanda) {
  $cons  = new mysqli(HOST,USER,PASS,DB);	
  if(!$cons) {  
	  echo "Não foi possivel conectar ao MySQL. Erro " .
			  mysqli_connect_errno() . " : " . mysql_connect_error();
	  exit;
  }

  $query2 = "SELECT * from historico_encaminhamentos_count WHERE numero = ".$cod_demanda;
  $mysql_query2 = $cons->query($query2);
  $qtderegs2 = $mysql_query2->num_rows;
  $msg = "";
  if ($qtderegs2>0) {
	  while ($dado2 = $mysql_query2->fetch_assoc()) {
		  return $dado2['qtde_respostas'];
	  }				
  }else{
	  return 0;					
  }
}
//--------------------------------------------------------------------------------------------------------------------
function busca_qtde_faltas($cod_cadastro) {
  $cons  = new mysqli(HOST,USER,PASS,DB);	
  if(!$cons) {  
	  echo "Não foi possivel conectar ao MySQL. Erro " .
			  mysqli_connect_errno() . " : " . mysql_connect_error();
	  exit;
  }

  $query2 = "SELECT * from agenda_clinica_count WHERE cod_cadastro = ".$cod_cadastro." AND situacao = 2";
  $mysql_query2 = $cons->query($query2);
  $qtderegs2 = $mysql_query2->num_rows;
  $msg = "";
  if ($qtderegs2>0) {
	  while ($dado2 = $mysql_query2->fetch_assoc()) {
		  return $qtderegs2;
	  }				
  }else{
	  return " ";					
  }
}
//--------------------------------------------------------------------------------------------------------------------
function busca_tarefa($demanda) {
	
  $cons  = new mysqli(HOST,USER,PASS,DB);	
  if(!$cons) {  
	  echo "Não foi possivel conectar ao MySQL. Erro " .
			  mysqli_connect_errno() . " : " . mysql_connect_error();
	  exit;
  }  
  mysqli_set_charset($cons,"utf8");
  mysqli_query($cons, "SET NAMES 'utf8'");
  mysqli_query($cons, 'SET character_set_connection=utf8');
  mysqli_query($cons, 'SET character_set_client=utf8');
  mysqli_query($cons, 'SET character_set_results=utf8');

  $query2 = "SELECT * FROM busca_encaminha WHERE numero=".$demanda;
  $mysql_query2 = $cons->query($query2);
  $qtderegs2 = $mysql_query2->num_rows;
  if ($qtderegs2>0) {
	  while ($dado2 = $mysql_query2->fetch_assoc()) {
		$retorno = $dado2['tarefa'];
	  }	
  }else{
	  $retorno=0;					
  }
	return $retorno;
}
//--------------------------------------------------------------------------------------------------------------------
function busca_grupos() {
  $cons  = new mysqli(HOST,USER,PASS,DB);	
  if(!$cons) {  
	  echo "Não foi possivel conectar ao MySQL. Erro " .
			  mysqli_connect_errno() . " : " . mysql_connect_error();
	  exit;
  }  
  mysqli_set_charset($cons,"utf8");
  mysqli_query($cons, "SET NAMES 'utf8'");
  mysqli_query($cons, 'SET character_set_connection=utf8');
  mysqli_query($cons, 'SET character_set_client=utf8');
  mysqli_query($cons, 'SET character_set_results=utf8');

  $query2 = "SELECT * FROM grupos ORDER BY NOMEGRP";
  $mysql_query2 = $cons->query($query2);
  $qtderegs2 = $mysql_query2->num_rows;
  $retorno = 'select name="descricao" id="descricao">';
  if ($qtderegs2>0) {
	  while ($dado2 = $mysql_query2->fetch_assoc()) {
		$retorno .= '<option value="'.$dado2['GRUPO'].'">'.$dado2['NOMEGRP'].'</option>';
	  }	
	  $retorno .= '</select>';
  }else{
	  $retorno="";					
  }
	return $retorno;
}
//--------------------------------------------------------------------------------------------------------------------
function busca_secretaria($codigo) {
  $cons  = new mysqli(HOST,USER,PASS,DB);	
  if(!$cons) {  
	  echo "Não foi possivel conectar ao MySQL. Erro " .
			  mysqli_connect_errno() . " : " . mysql_connect_error();
	  exit;
  }  
  mysqli_set_charset($cons,"utf8");
  mysqli_query($cons, "SET NAMES 'utf8'");
  mysqli_query($cons, 'SET character_set_connection=utf8');
  mysqli_query($cons, 'SET character_set_client=utf8');
  mysqli_query($cons, 'SET character_set_results=utf8');

  $query2 = "SELECT * FROM secretarias WHERE codigo=".$codigo;
  $mysql_query2 = $cons->query($query2);
  $qtderegs2 = $mysql_query2->num_rows;
  if ($qtderegs2>0) {
	  while ($dado2 = $mysql_query2->fetch_assoc()) {
		$retorno = $dado2['descricao'];
	  }	
  }else{
	  $retorno= $codigo." não cadastrado";					
  }
return $retorno;
}
//--------------------------------------------------------------------------------------------------------------------
function busca_email_user($codigo) {
  $cons  = new mysqli(HOST,USER,PASS,DB);	
  if(!$cons) {  
	  echo "Não foi possivel conectar ao MySQL. Erro " .
			  mysqli_connect_errno() . " : " . mysql_connect_error();
	  exit;
  }  
  mysqli_set_charset($cons,"utf8");
  mysqli_query($cons, "SET NAMES 'utf8'");
  mysqli_query($cons, 'SET character_set_connection=utf8');
  mysqli_query($cons, 'SET character_set_client=utf8');
  mysqli_query($cons, 'SET character_set_results=utf8');

  $query2 = "SELECT * FROM users WHERE codigo=".$codigo;
  $mysql_query2 = $cons->query($query2);
  $qtderegs2 = $mysql_query2->num_rows;
  if ($qtderegs2>0) {
	  while ($dado2 = $mysql_query2->fetch_assoc()) {
		$retorno = $dado2['email'];
	  }	
  }else{
	  $retorno="";					
  }
	return $retorno;
}
//--------------------------------------------------------------------------------------------------------------------
function busca_user($codigo) {
  $cons  = new mysqli(HOST,USER,PASS,DB);	
  if(!$cons) {  
	  echo "Não foi possivel conectar ao MySQL. Erro " .
			  mysqli_connect_errno() . " : " . mysql_connect_error();
	  exit;
  }  
  mysqli_set_charset($cons,"utf8");
  mysqli_query($cons, "SET NAMES 'utf8'");
  mysqli_query($cons, 'SET character_set_connection=utf8');
  mysqli_query($cons, 'SET character_set_client=utf8');
  mysqli_query($cons, 'SET character_set_results=utf8');

  $query2 = "SELECT * FROM users WHERE codigo=".$codigo;
  $mysql_query2 = $cons->query($query2);
  $qtderegs2 = $mysql_query2->num_rows;
  if ($qtderegs2>0) {
	  while ($dado2 = $mysql_query2->fetch_assoc()) {
		$retorno = $dado2['nome'];
	  }	
  }else{
	  $retorno="";					
  }
	return $retorno;
}
//--------------------------------------------------------------------------------------------------------------------
// Esta função buscará se o user está liberado para usar uma função do sistema
function liberado($funcao) {  
	#echo "Liberado ".$funcao."<br>";
	$query2 = "SELECT * FROM liberacao WHERE username = '".$_SESSION['usuarioUser']."' and funcao = '".$funcao."'";
	$achou = executa_sql($query2,"","",false,false);
	#echo $achou."<br>";
	return $achou;
}
//--------------------------------------------------------------------------------------------------------------------

function salva_imagem($demanda, $seq) {

	echo $demanda. " - ".$seq."<br>";
  	
	$foto = $_FILES["foto"];

  	if ($foto["tmp_name"]!=""){
		echo $foto.'<br>';
	  	//  echo $codigo;
		// Largura máxima em pixels
		$largura = 1500;
		// Altura máxima em pixels
		$altura = 2000;
		// Tamanho máximo do arquivo em bytes
		$tamanho = 300000;
		$error = array();
		// Verifica se o arquivo é uma imagem
		if(!preg_match("/^image\/(pjpeg|jpeg)$/", $foto["type"])){
		   $error[1] = "Utilizar somente extensões jpg.";
		} 
		// Pega as dimensões da imagem
		$dimensoes = getimagesize($foto["tmp_name"]);
		// Verifica se a largura da imagem é maior que a largura permitida
		if($dimensoes[0] > $largura) {
			$error[2] = "A largura da imagem não deve ultrapassar ".$largura." pixels";
		}
		// Verifica se a altura da imagem é maior que a altura permitida
		if($dimensoes[1] > $altura) {
			$error[3] = "Altura da imagem não deve ultrapassar ".$altura." pixels";
		}
		// Verifica se o tamanho da imagem é maior que o tamanho permitido
		if($foto["size"] > $tamanho) {
			$error[4] = "A imagem deve ter no máximo ".$tamanho." bytes";
		}
		// Se não houver nenhum erro
		if (count($error) == 0) {
			// Pega extensão da imagem
			preg_match("/\.(jpg|jpeg){1}$/i", $foto["name"], $ext);
			// Gera um nome único para a imagem
			$nome_imagem =  "D".str_pad($demanda, 7, '0', STR_PAD_LEFT).str_pad($seq, 3, '0', STR_PAD_LEFT);
			echo $nome_imagem."<br>";
			// Caminho de onde ficará a imagem
			$caminho_imagem = "../imagens/demandas/" . strtolower($nome_imagem);
			// Faz o upload da imagem para seu respectivo caminho
			$moved = move_uploaded_file($foto["tmp_name"], $caminho_imagem);
			if(!$moved ) {
				$error[5] = "Imagem não carregada - error #".$_FILES["file"]["error"];
			}
		}	
		// Se houver mensagens de erro, exibe-as
		if (count($error) != 0) {
			foreach ($error as $erro) {
				echo $erro . "<br />";
			}
		}else{
		  echo '<script>alert ("Envio de imagem com sucesso!");</script>';
		  //echo "<script>self.window.close();</script>";
		}
	  }else{	  
		  //echo "<script>self.window.close();</script>";
	  }
}
//===========================================================================================================
function s_datediff( $str_interval, $dt_menor, $dt_maior, $relative=false){

       if( is_string( $dt_menor)) $dt_menor = date_create( $dt_menor);
       if( is_string( $dt_maior)) $dt_maior = date_create( $dt_maior);

       $diff = date_diff( $dt_menor, $dt_maior, ! $relative);
       
       switch( $str_interval){
           case "y": 
               $total = $diff->y + $diff->m / 12 + $diff->d / 365.25; break;
           case "m":
               $total= $diff->y * 12 + $diff->m + $diff->d/30 + $diff->h / 24;
               break;
           case "d":
               $total = $diff->y * 365.25 + $diff->m * 30 + $diff->d + $diff->h/24 + $diff->i / 60;
               break;
           case "h": 
               $total = ($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h + $diff->i/60;
               break;
           case "i": 
               $total = (($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h) * 60 + $diff->i + $diff->s/60;
               break;
           case "s": 
               $total = ((($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h) * 60 + $diff->i)*60 + $diff->s;
               break;
          }
       if( $diff->invert)
               return -1 * $total;
       else    return $total;
   }
//-----------------------------------------------------------------------------------------------------
function ve_situacao($sit) {
	switch ($sit) {
	  case '0':
		return("ABERTA");
		break;
	  case '1':
		return("RESPONDIDA");
		break;
	  case '2':
		return("ENCERRADA");
		break;
	  case '5':
		return("ARQUIVADA");
		break;
	  default:
		return("NÃO CAD.");
		break;

	}
}
//-----------------------------------------------------------------------------------------------------
function zebrado($pdf, $value_zeb){
            
            if (!$value_zeb){
                $pdf->SetFillColor(255,255,255);
                $value_zeb = true ; 
            } else {
                $pdf->SetFillColor(200,200,200);
                $value_zeb = false ; 
            }
            $pdf->SetX(5); 
            $pdf->Cell(190,5, ' ',0,0,'L',true); 
            $pdf->SetX(5); 
            
            return !$value_zeb ; 
        }

?>  
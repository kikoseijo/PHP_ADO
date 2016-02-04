<?php

function get_age_by_date($dob_year, $dob_month, $dob_day){

    if (checkdate($dob_month, $dob_day, $dob_year)) {
        $dob_date = "$dob_year" . "$dob_month" . "$dob_day";
        $age = floor((date("Ymd")-intval($dob_date))/10000);
        if (($age < 0) or ($age > 114)) {
            return 'Error/' . $dob_year.'-'. $dob_month.'-'. $dob_day  ;
        }
        return $age;
    }
    return 'Error/'. $dob_year.'-'. $dob_month.'-'. $dob_day;
}


function timeDiferencia($timestamp,$modo=''){
	$date_a = date_create($timestamp);
	$date_b = date_create(date('Y-m-d H:i:s'));
	$interval = $date_a->diff($date_b);
	
	$dias = $interval->format('%a');
	$horas = $interval->format('%H');
	
	$theTime = '';
	if ($dias>0) 
		$theTime .= $dias .' dias ';
	if ($horas>0) 
		$theTime .= $horas .'h ';
	
	return $theTime .=  $interval->format('%im %ss');
}


function days_from_date($fecha){
	$login_date = strtotime($fecha); // change x with your login date var
 	$current_date = strtotime(date('Y-m-d')); // change y with your current date var
 	$datediff = $current_date - $login_date;
	$numero_dias = floor($datediff/(60*60*24));	
	if ($numero_dias<1) 
		return 'Nuevo';
	else 
	 	return $numero_dias;
}


function FormatTime($timestamp,$modo=''){
	// Get time difference and setup arrays
	$difference = time() - $timestamp;
	$periods = array("second", "minute", "hour", "day", "week", "month", "years");
	$periods = array("segundo", "minuto", "hora", "dia", "semana", "mes", "años");
	$lengths = array("60","60","24","7","4.35","12");
	// Past or present
	if ($difference >= 0) 	{
		$ending = "ago";
		$start = "Hace";
	}
	else	{
		$difference = -$difference;
		$ending = "to go";
		$start = "Dentro de";
	}
 
	// Figure out difference by looping while less than array length
	// and difference is larger than lengths.
	$arr_len = count($lengths);
	for($j = 0; $j < $arr_len && $difference >= $lengths[$j]; $j++)	{
		$difference /= $lengths[$j];
	}
	// Round up		
	$difference = round($difference);
	// Make plural if needed
	if($difference != 1) 	{
		$periods[$j].= "s";
	}
	// Default format
	if ($modo<>''){
		$text = " $difference $periods[$j] ";
		$text = " $difference $periods[$j]";
	} else {
		$text = " $difference $periods[$j] $ending";
		$text = " $start $difference $periods[$j]";
	}
	// over 24 hours
	if($j > 2)	{
		// future date over a day formate with year
		if($ending == "to go"){
			if($j == 3 && $difference == 1)	{
				$text = "Mañana a las ". strftime("%H:%M", $timestamp);
			}else{
				$text = strftime("%A %d %b %Y a las %H:%M", $timestamp);
			}
			return $text;
		}
 
		if($j == 3 && $difference == 1) {						// Yesterday
			$text = "Ayer a las ". strftime("%H:%M", $timestamp);
		} else if($j == 3) {									// Less than a week display -- Monday at 5:28pm
			$text = strftime("%A a las %H:%M", $timestamp);
		} else if($j < 6 && !($j == 5 && $difference == 12)) {	// Less than a year display -- June 25 at 5:23am
			$text = strftime("%A %d %b %Y - %H:%M", $timestamp);
			$text = strftime("%d %b %Y - %H:%M", $timestamp);
		} else {												// if over a year or the same month one year ago -- June 30, 2010 at 5:34pm
			$text = strftime('%d %b %Y - %H:%M', $timestamp);
		}
	}
	return utf8_encode($text);
}














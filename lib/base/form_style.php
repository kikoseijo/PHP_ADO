<?php



/*

	Bootstrap3 form styling, 
	We must manualy define class for $fbColLabel, $fbColInput
	$fbColLabel = 'col-sm-4';
	$fbColLabel = 'col-sm-8';
	
	REF: http://bootsnipp.com/forms?version=3

*/


function fbTextField(&$tabindex, $label, $name, $value, $errorValue, $class='', $required=false){
	global $fbColLabel, $fbColInput;
	$res='';
	$res.='<!-- Text input-->';
	$res.='<div class="form-group">';
	$res.='<label for="'.$name.'" class="'.$fbColLabel.' control-label">'.$label.'</label>';
	$res.='<div class="'.$fbColInput.'">';
	$res.='<input type="text" class="form-control '.$class.'" id="'.$name.'" name="'.$name.'" placeholder="'.$label.'" tabindex="'.$tabindex.'" value="'.$value.'"';
	if ($required) $res.=' required';
	$res.='>';
	if ($errorValue <> '') $res.= '<p class="text-danger">'.$errorValue.'</p>';
	$res.='</div>';
	$res.='</div>';
	$res.='';
	$res.='';
	
	$tabindex++;
	
	return $res;
	
}



function fbFileField(&$tabindex, $label, $name, $value, $errorValue, $class='', $required=false){
	global $fbColLabel, $fbColInput;
	$res='';
	$res.='<!-- File Button -->';
	$res.='<div class="form-group">';
	$res.='<label class="'.$fbColLabel.' control-label" for="'.$name.'">'.$label.'</label>';
	$res.='<div class="'.$fbColInput.'">';
	$res.='<input id="'.$name.'" name="'.$name.'" class="input-file" type="file" tabindex="'.$tabindex.'"';
	if ($required) $res.=' required';
	$res.='>';
	if ($errorValue <> '') $res.= '<p class="text-danger">'.$errorValue.'</p>';
	$res.='</div>';
	$res.='</div>';
	$tabindex++;
	
	return $res;
}


function fbMultipleRadios(&$tabindex, $label, $name, $value, $opciones, $errorValue, $class='', $required=false){
	global $fbColLabel, $fbColInput;
	$res='';
	$res.='<!-- Multiple Radios -->';
	$res.='<div class="form-group">';
	$res.='<label class="'.$fbColLabel.' control-label" for="'.$name.'">'.$label.'</label>';
	$res.='<div class="'.$fbColInput.'">';
	if (count($opciones)>0){
		$i=0;
		foreach ($opciones as $opcion) {
			$res.='<div class="radio">';
			$res.='<label for="'.$name.'-'.$i.'">';
			$res.='<input type="radio" name="'.$name.'" id="'.$name.'-'.$i.'" value="'.$opcion.'" tabindex="'.$tabindex.'"';
			if ($value==$opcion) $res.= ' checked="checked"';
			$res.='>';
			$res.=''.$opcion;
			$res.='</label>';
			$res.='</div>';
			$i++;
			$tabindex++;
		}
	}
	$res.='</div>';
	$res.='</div>';	
	
	return $res;
}

function fbMultipleRadiosInline(&$tabindex, $label, $name, $value, $opciones, $errorValue, $class='', $required=false){
	global $fbColLabel, $fbColInput;
	$res='';
	$res.='<!-- Multiple Radios (inline) -->';
	$res.='<div class="form-group">';
	$res.='<label class="'.$fbColLabel.' control-label" for="'.$name.'">'.$label.'</label>';
	$res.='<div class="'.$fbColInput.'">';
	if (count($opciones)>0){
		$i=0;
		foreach ($opciones as $opcion) {
			
			$res.='<label class="radio-inline" for="'.$name.'-'.$i.'">';
			$res.='<input type="radio" name="'.$name.'" id="'.$name.'-'.$i.'" value="'.$opcion.'" tabindex="'.$tabindex.'"';
			if ($value==$opcion) $res.= ' checked="checked"';
			$res.='>';
			$res.=''.$opcion;
			$res.='</label>';
			$i++;
			$tabindex++;
		}
	}
	$res.='</div>';
	$res.='</div>';	
	
	return $res;
}



/*
	Plantilla vacía
*/
function fbPlantillaVacia(&$tabindex){
	global $fbColLabel, $fbColInput;
	$res='';
	$res.='';
	$tabindex++;
	return $res;
}






    
    
      
    
  






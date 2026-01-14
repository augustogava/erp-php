<?

function horas($hora1,$hora2){
	$ex=explode(":",$hora1);
	$ex2=explode(":",$hora2);
	
	$horas=$ex[0]-$ex2[0];
	$horas=str_replace("-","",$horas);
	if(strlen($horas)=="1"){
		$horas="0$horas";
	}

	$minutos=$ex[1]-$ex2[1];
	$minutos=str_replace("-","",$minutos);
	if(strlen($minutos)=="1"){
		$minutos="0$minutos";
	}

	$segundos=$ex[2]-$ex2[2];
	$segundos=str_replace("-","",$segundos);
	if(strlen($segundos)=="1"){
		$segundos="0$segundos";
	}
	$var="$horas:$minutos:$segundos";
	print $var;

}

horas("02:15:33","05:20:05");

// para pegar a data atual é date("h:m:s");
?>
<?
$pal="the hell is coming as faster as you can see";
for($i=0; $i<strlen($pal); $i++){
	for($e=0; $e<strlen($pal); $e++){
		($e==$i) ? print "<strong>".$pal{$e}."</strong>" : print $pal{$e};
	}
	print "<br>";
}
?>
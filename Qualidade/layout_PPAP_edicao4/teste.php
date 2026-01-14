<?php
/*
$a=1;
//$a ? print "T" : print "F";
function &teste($a){
	foreach($a as $name=>$valor){
 		return $$name=$valor;
	}
}
$b=array('teste1','teste2','teste3');
$c=&teste($b);
print $teste1;
print "FOI";
*/
 if (!isset($_SERVER['PHP_AUTH_USER']) or $a==1) {
    header('WWW-Authenticate: Basic realm="My Realm"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Text to send if user hits Cancel button';
    exit;
  } else {
    if($_SERVER['PHP_AUTH_USER']=="zao" and $_SERVER['PHP_AUTH_PW']=="15325874"){ print "entro"; }else{ print "nao entro"; }
  }


?>
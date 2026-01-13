//onkeypress="return validatecla(this, event)"
function chvalidos( caractere ){ 
	var strValidos = "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM1234567890" 
	if ( strValidos.indexOf( caractere ) == -1 ) 
		return false; 
	return true;  
} 
function validatecla(campo, event) { 
	var BACKSPACE= 8;   
	var key; 
	var tecla; 
	CheckTAB=true; 
	if(navigator.appName.indexOf("Netscape")!= -1) 
		tecla= event.which; 
	else 
		tecla= event.keyCode; 
	key = String.fromCharCode( tecla);   
	if ( tecla == 13 ) 
		return true; 
	if ( tecla == 32 ) 
		return true; 
	if ( tecla == BACKSPACE ) 
		return true; 
	return ( chvalidos(key)); 
}   
//onkeypress="return validanum(this, event)"
function chnum( caractere ){ 
	var strValidos = "0123456789" 
	if ( strValidos.indexOf( caractere ) == -1 ) 
		return false; 
	return true;  
} 
function validanum(campo, event) { 
	var BACKSPACE= 8;   
	var key; 
	var tecla; 
	CheckTAB=true; 
	if(navigator.appName.indexOf("Netscape")!= -1) 
		tecla= event.which; 
	else 
		tecla= event.keyCode; 
	key = String.fromCharCode( tecla);   
	if ( tecla == 13 ) 
		return true; 
	if ( tecla == BACKSPACE ) 
		return true; 
	return ( chnum(key)); 
}
//onkeypress="return validaval(this, event)"
function chval( caractere ){ 
	var strValidos = "0123456789," 
	if ( strValidos.indexOf( caractere ) == -1 ) 
		return false; 
	return true;  
} 
function validaval(campo, event) { 
	var BACKSPACE= 8;   
	var key; 
	var tecla; 
	CheckTAB=true; 
	if(navigator.appName.indexOf("Netscape")!= -1) 
		tecla= event.which; 
	else 
		tecla= event.keyCode; 
	key = String.fromCharCode( tecla);   
	if ( tecla == 13 ) 
		return true; 
	if ( tecla == BACKSPACE ) 
		return true; 
	return ( chval(key)); 
}
//mascara data onkeyup="mdata(this)" onkeypress="return validanum(this, event)"
 function mdata(campo){
     if (campo.value.length > 2)
     	if (campo.value.charAt(campo.value.length - 1) == '/' && campo.value.charAt(campo.value.length - 2) == '/')
        	campo.value = campo.value.substr(0,campo.value.length - 2);
	 if (event.keyCode != 8)			   
     	if (campo.value.length == 2 || campo.value.length == 5)
    		campo.value += '/';
  }
//mascara cep onkeyup="mcep(this)" onkeypress="return validanum(this, event)"
 function mcpf(campo){
	 if (event.keyCode != 8)			   
     	if (campo.value.length == 3 || campo.value.length == 7)
    		campo.value += '.';
     	if (campo.value.length == 11)
    		campo.value += '-';
  }

 function mcgc(campo){
	 if (event.keyCode != 8)			   
     	if (campo.value.length == 2 || campo.value.length == 6)
    		campo.value += '.';
     	if (campo.value.length == 10)
    		campo.value += '/';
     	if (campo.value.length == 15)
    		campo.value += '-';
  }
function mcep(campo){
	 if (campo.value.length == 5)
   	 	campo.value += "-";
  }
  function mtel(campo){
	 if (campo.value.length == 4)
   	 	campo.value += "-";
  }
//mascara hora onkeyup="mhora(this)" onkeypress="return validanum(this, event)"
 function mhora(campo){
     if (campo.value.length > 2)
       if(campo.value.charAt(campo.value.length - 1) == ':' && campo.value.charAt(campo.value.length - 2) == ':')
          campo.value = campo.value.substr(0,campo.value.length - 2);
	 if (event.keyCode != 8)
   	  if (campo.value.length == 2 || campo.value.length == 5) 
	  	campo.value += ':';
  }
  function retornaKeyCode(evt) {
 var isNav, isIE;
 var theKey;
 
 if (parseInt(navigator.appVersion.charAt(0)) >= 4) {
  isNav = (navigator.appName == "Netscape") ? true : false;
  isIE = (navigator.appName.indexOf("Microsoft" != -1)) ? true : false;
 }
   
 if (isNav) 
  theKey = evt.which;
 else if (isIE) 
  theKey = window.event.keyCode;
   
 return theKey;
}
function retiraNaoNumericos( OBJ ){
 var i;
 STR = new String("");
 
 for(i=0;i<OBJ.value.length;i++)
  if (OBJ.value.charAt(i)>="0" && OBJ.value.charAt(i)<="9")
   STR = STR + OBJ.value.charAt(i);
 
 OBJ.value = STR;
 return STR;
}
function inverteString ( VLR ){
 var i; 
 STR = new String("");
 
 for(i=VLR.length; i>=0; i--)
  STR = STR + VLR.charAt(i);
 
 return STR;
}
function trimZerosAEsquerda( VLR ){
 var i;
 STR = new String("");
 
 for (i=0; i<VLR.length; i++)
  if ( ( VLR.charAt(i) != '0') && ( VLR.charAt(i) != '.') )
   break;
 
 for (;i<VLR.length;i++)
  STR = STR + VLR.charAt(i);
  
 return STR;  
}
function fillZerosAEsquerda( VLR, minLength ){
 var i;
 STR = new String("");
 
 VLR = trimZerosAEsquerda (VLR);
 
 for (i=0; i < (minLength - VLR.length); i++)
  STR = "0" + STR;
 
 return STR;  
}
function identificaBrowser(){
 var strBrowser;
 
 versao = navigator.appVersion;
 nomeBrowser = navigator.appName;
 
 if (navigator.appName.indexOf("Microsoft") != -1) 
  strBrowser = "IE";
 else if(navigator.appName.indexOf("Netscape") != -1)
  strBrowser = "NE";
 else
  strBrowser = "OO";
 
 return strBrowser;
}
function posicionaCursor(OBJ, LOC, POS)
{
 
 LOC = LOC.toUpperCase();
 
 //Só funciona no IE
 if (identificaBrowser() !="IE")
 
  return;
 
 else
 
 {
  if ((LOC == "I") || (LOC == "M") || (LOC == "F"))
  { 
  
   var posicao;
   
   if (LOC == "I")
    posicao = 0;
   
   if (LOC == "F")
    posicao = OBJ.value.length;
   
   if (LOC == "M")
    posicao = POS;
     
   var tRange = OBJ.createTextRange();
   tRange.move("character",posicao);
   tRange.select();
   
  }
  return;
 
 }
}
function formataMoedaa(param){

    param2 = Number(Math.round(Number(param)*100));

    param2 = param2/100;

    param2 = new String(param2);
    pos = param2.indexOf(".");
    a1 = param2.substring(0,pos);
      a2 = param2.substring(pos,param2.length);
      if (pos == -1) {
        param2 = param2 + ".00";
    } else if (a2.length == 2) {
        param2 = param2 + "0";
    } else if (a2.length > 3) {
           param2 = a1 + a2.substring(0,3);
    }

    return param2;
}
// onkeydown="formataMoeda(this,retornaKeyCode(event))" onkeyup="formataMoeda(this,retornaKeyCode(event))"
function formataMoeda( OBJ, key ){
 var i, uBound;
 //teclas delete, backspace, shift, nao disparam o evento
 if( key!=16 && !(key>36 && key<41) ){
  invertedSTR = new String("");
  invertedSTR = retiraNaoNumericos ( OBJ );
  invertedSTR = inverteString ( invertedSTR );
  if ( invertedSTR.length < 12 ){
   UBound = invertedSTR.length;
  }
  else{
   UBound = 12;
  }
 
  if ( invertedSTR.length == 0 ){
   UBound = 3;
   invertedSTR = invertedSTR + "0000";
  }
 
  if ( invertedSTR.length == 1 ){
   UBound = 3;
   invertedSTR = invertedSTR + "000";
  }
 
  if ( invertedSTR.length == 2 ){
   UBound = 3;
   invertedSTR = invertedSTR + "00";
  }
 
  STR = new String("");
  for ( i=0; i<UBound; i++){
   STR = STR + invertedSTR.charAt(i);
   
   if (i==1)
    STR = STR + ",";
 
   if ( (i==4) || (i==7) || (i==10) )
    STR = STR + ".";
  }
  
  STR = inverteString(STR);
  STR = trimZerosAEsquerda ( STR );
  STR = fillZerosAEsquerda ( STR, 4 );
 
  OBJ.value = STR;
  
  posicionaCursor(OBJ, "F", 0)
 }
}


function formata_numero(p,d) 
{
  var r;
  if(p<0){p=-p;r=format_number2(p,d);r="-"+r;}
  else   {r=format_number2(p,d);}
  return r;
}

function format_number2(pnumber,decimals) 
{
  var strNumber = new String(pnumber);
  var arrParts = strNumber.split('.');
  var intWholePart = parseInt(arrParts[0],10);
  var strResult = '';
  if (isNaN(intWholePart))
    intWholePart = '0';
  if(arrParts.length > 1)
  {
    var decDecimalPart = new String(arrParts[1]);
    var i = 0;
    var intZeroCount = 0;
     while ( i < String(arrParts[1]).length )
     {
       if( parseInt(String(arrParts[1]).charAt(i),10) == 0 )
       {
         intZeroCount += 1;
         i += 1;
       }
       else
         break;
    }
    decDecimalPart = parseInt(decDecimalPart,10)/Math.pow(10,parseInt(decDecimalPart.length-decimals-1)); 
    Math.round(decDecimalPart); 
    decDecimalPart = parseInt(decDecimalPart)/10; 
    decDecimalPart = Math.round(decDecimalPart); 

   //If the number was rounded up from 9 to 10, and it was for 1 'decimal' 
   //then we need to add 1 to the 'intWholePart' and set the decDecimalPart to 0. 

    if(decDecimalPart==Math.pow(10, parseInt(decimals)))
    { 
      intWholePart+=1; 
      decDecimalPart="0"; 
    } 
    var stringOfZeros = new String('');
    i=0;
    if( decDecimalPart > 0 )
    {
      while( i < intZeroCount)
      {
        stringOfZeros += '0';
        i += 1;
      }
    }
    decDecimalPart = String(intWholePart) + "." + stringOfZeros + String(decDecimalPart); 
    var dot = decDecimalPart.indexOf('.');
    if(dot == -1)
    {
      decDecimalPart += '.'; 
      dot = decDecimalPart.indexOf('.'); 
    } 
    var l=parseInt(dot)+parseInt(decimals); 
    while(decDecimalPart.length <= l) 
    {
      decDecimalPart += '0'; 
    }
    strResult = decDecimalPart;
  }
  else
  {
    var dot; 
    var decDecimalPart = new String(intWholePart); 

    decDecimalPart += '.'; 
    dot = decDecimalPart.indexOf('.'); 
    var l=parseInt(dot)+parseInt(decimals); 
    while(decDecimalPart.length <= l) 
    {
      decDecimalPart += '0'; 
    }
    strResult = decDecimalPart;
  }
  return strResult;
}
// onkeydown="formataMoeda3(this,retornaKeyCode(event))" onkeyup="formataMoeda3(this,retornaKeyCode(event))"
function formataMoeda3( OBJ, key ){
 var i, uBound;
 //teclas delete, backspace, shift, nao disparam o evento
 if( key!=16 && !(key>36 && key<41) ){
  invertedSTR = new String("");
  invertedSTR = retiraNaoNumericos ( OBJ );
  invertedSTR = inverteString ( invertedSTR );
  if ( invertedSTR.length < 12 ){
   UBound = invertedSTR.length;
  }
  else{
   UBound = 12;
  }
/* 
  if ( invertedSTR.length == 0 ){
   UBound = 3;
   invertedSTR = invertedSTR + "0000";
  }
 
  if ( invertedSTR.length == 1 ){
   UBound = 3;
   invertedSTR = invertedSTR + "000";
  }
 
  if ( invertedSTR.length == 2 ){
   UBound = 3;
   invertedSTR = invertedSTR + "00";
  }
*/
  if ( invertedSTR.length == 0 ){
   UBound = 4;
   invertedSTR = invertedSTR + "0000";
  }
 
  if ( invertedSTR.length == 1 ){
   UBound = 4;
   invertedSTR = invertedSTR + "000";
  }
 
  if ( invertedSTR.length == 2 ){
   UBound = 4;
   invertedSTR = invertedSTR + "00";
  }
  
  if ( invertedSTR.length == 3 ){
   UBound = 4;
   invertedSTR = invertedSTR + "0";
  }
  STR = new String("");
  for ( i=0; i<UBound; i++){
   STR = STR + invertedSTR.charAt(i);
   
   if (i==2)
    STR = STR + ",";
 
   if ( (i==5) || (i==8) || (i==11) )
    STR = STR + ".";
  }
  
  STR = inverteString(STR);
  STR = trimZerosAEsquerda ( STR );
  STR = fillZerosAEsquerda ( STR, 5 );
 
  OBJ.value = STR;
  
  posicionaCursor(OBJ, "F", 0)
 }
}
// onkeydown="formataMoeda4(this,retornaKeyCode(event))" onkeyup="formataMoeda4(this,retornaKeyCode(event))"
function formataMoeda4( OBJ, key ){
 var i, uBound;
 //teclas delete, backspace, shift, nao disparam o evento
 if( key!=16 && !(key>36 && key<41) ){
  invertedSTR = new String("");
  invertedSTR = retiraNaoNumericos ( OBJ );
  invertedSTR = inverteString ( invertedSTR );
  if ( invertedSTR.length < 12 ){
   UBound = invertedSTR.length;
  }
  else{
   UBound = 12;
  }
  if ( invertedSTR.length == 0 ){
   UBound = 5;
   invertedSTR = invertedSTR + "00000";
  }
 
  if ( invertedSTR.length == 1 ){
   UBound = 5;
   invertedSTR = invertedSTR + "0000";
  }
 
  if ( invertedSTR.length == 2 ){
   UBound = 5;
   invertedSTR = invertedSTR + "000";
  }
  
  if ( invertedSTR.length == 3 ){
   UBound = 5;
   invertedSTR = invertedSTR + "00";
  }

  if ( invertedSTR.length == 4 ){
   UBound = 5;
   invertedSTR = invertedSTR + "0";
  }
  STR = new String("");
  for ( i=0; i<UBound; i++){
   STR = STR + invertedSTR.charAt(i);
   
   if (i==3)
    STR = STR + ",";
 
   if ( (i==6) || (i==9) || (i==12) )
    STR = STR + ".";
  }
  
  STR = inverteString(STR);
  STR = trimZerosAEsquerda ( STR );
  STR = fillZerosAEsquerda ( STR, 6 );
 
  OBJ.value = STR;
  
  posicionaCursor(OBJ, "F", 0)
 }
}

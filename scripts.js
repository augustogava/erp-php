function verifica_data(sdata){
day2 = sdata.substr(0,2);
month2 = sdata.substr(3,2);
year2 = sdata.substr(6,4);

if ((sdata.substr(2,1) != "/") || (sdata.substr(5,1) != "/"))
{
	day2 = "";
	month2 = "";
	year2 = "";
}

var DayArray = new Array(31,28,31,30,31,30,31,31,30,31,30,31);
var MonthArray = new Array("01","02","03","04","05","06","07","08","09","10","11","12");
var inpDate = day2 + month2 + year2;
var filter=/^[0-9]{2}[0-9]{2}[0-9]{4}$/;

//Check ddmmyyyy date supplied
if (! filter.test(inpDate))
  {
  return false;
  }
/* Check Valid Month */
filter=/01|02|03|04|05|06|07|08|09|10|11|12/;
if (! filter.test(month2))
  {
  return false;
  }
/* Check For Leap Year */
var N = Number(year2);
if ( ( N%4==0 && N%100 !=0 ) || ( N%400==0 ) )
  	{
   DayArray[1]=29;
  	}
/* Check for valid days for month */
for(var ctr=0; ctr<=11; ctr++)
  	{
   if (MonthArray[ctr]==month2)
   	{
      if (day2<= DayArray[ctr] && day2 >0 )
        {
        inpDate = day2 + '/' + month2 + '/' + year2;
        return true;
        }
      else
        {
        return false;
        }
   	}
   }
}
function verifica_email(imeiu){
	erro=0;
	if(imeiu.indexOf('@')<=0){
		erro=1;
	}else if(imeiu.indexOf('.')== -1 || imeiu.indexOf('.')==imeiu.indexOf('@')+1){
		erro=1;
	}else if(imeiu.length -1 == imeiu.indexOf('.')){
	    erro=1;
	}else{
        erro=1;
	    for(i=imeiu.indexOf('@')+1;i<imeiu.length-1;i++){
			if(imeiu.charAt(i)=='.' && imeiu.charAt(imeiu.length-1)!='.'){
	  		   erro=0;
	           break;
   			}
	    }
    }
	if(erro==1){
		return false;
	}else{
		return true;
	}
}
function limpa_form(){
	for(i=0;i<document.forms.length;i++){
		document.forms[i].reset();
	}
	return false;
}
// muda a cor da linha na tabelas onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')"
function changeto(highlightcolor){
source=event.srcElement
if (source.tagName=="TR"||source.tagName=="TABLE")
return
while(source.tagName!="TR")
source=source.parentElement
if (source.style.backgroundColor!=highlightcolor&&source.id!="ignore")
source.style.backgroundColor=highlightcolor
}
function changeback(originalcolor){
if (event.fromElement.contains(event.toElement)||source.contains(event.toElement)||source.id=="ignore")
return
if (event.toElement!=source)
source.style.backgroundColor=originalcolor
}
function pergunta(wmsg,wsim){
	if(confirm(wmsg)){
		window.location.href = wsim;
	}
	return false;
}
function mensagem(wmsg){
	alert(wmsg);
	return false
}
function abre(wurl,wjan,wpar){
	window.open(wurl,wjan,wpar);
	return false;
}
// onLoad="enterativa=1;"onkeypress="return ent()"
// ativar desativar onFocus="enterativa=0;" onBlur="enterativa=1;"
function ent(){
	if(enterativa==1){
		if(event.keyCode==13) return event.keyCode=9;
	}
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
function formata_numero(p,d){
  var r;
  if(p<0){p=-p;r=format_number2(p,d);r="-"+r;}
  else   {r=format_number2(p,d);}
  return r;
}

function valor2real(val){
	val = val.replace(".","");
	val = eval(val.replace(",","."));
	return val;
}
function real2valor(val){
	val=formata_numero(val,2);
	val = val.replace(".",",");
	return val;
}
function imprimir(botao){
	var guarda=botao.src;
	botao.src='imagens/dot.gif';
	window.print();
	botao.src=guarda;
	return false;
}
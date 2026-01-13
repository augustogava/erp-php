function envia(url, metodo, modo, tipo)
{
    var login = document.getElementById('frmcar').numero.value;
	//var tipo = document.getElementById('frmcar').tipo.value;
    remoto  = new ajax();
    xmlhttp = remoto.enviar(url + "?login=" + login + '&tipo=' + tipo, metodo, modo );
    if(xmlhttp=='1') {
      document.getElementById("teste2").innerHTML = 'Número já cadastrado!';
	  document.getElementById('frmcar').incluir.disabled=true;
    } else {
       document.getElementById("teste2").innerHTML = '';
	   document.getElementById('frmcar').incluir.disabled=false;
    }    
}
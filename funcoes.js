function teste(url, metodo, modo)
{
    var campo = document.getElementById('form1').texto.value;
    remoto    = new ajax();
    envia     = remoto.enviar(url + "?" + "texto=" + campo, metodo, modo );
    document.getElementById("conteudo").innerHTML = envia;
}

function editar(nn, atual, id_usuario, nome_campo) {
    elem = document.getElementById("campo" + nn);
    elem.innerHTML = "<input maxlength=\"50\"type=\"text\" size=\"20\" onkeypress=\"return enter(this, event," + nn + "," + id_usuario +", '"+ nome_campo + "')\" onblur=\"return semfoco(this," + nn + "," + id_usuario +", '"+ nome_campo + "')\" />";
    elem.firstChild.focus();
}

function enter(campo, evt, idfld, id_usuario, nome_campo) {

    evt = (evt) ? evt : window.event;
    if (evt.keyCode == 13 && campo.value!="") {
        elem = document.getElementById("campo" + idfld);
        xmlhttp  = new ajax();
        xmlhttp.enviar('salvar.php?id=' + id_usuario + "&campo="+ nome_campo + "&valor=" + campo.value, "POST", false);
        elem.innerHTML = "<span onclick=\" editar(" + idfld + ", this," + id_usuario +", '"+ nome_campo + "');\">Clique aqui para inserir um Grupo</span>";
		javascript:Atualiza6('atualiza_grupo.php?pr=c',this.value);
        return false;
    } else {
        return true;
    }
}

function semfoco(campo, idfld, id_usuario, nome_campo) {
    if (campo.value!="") {
        elem = document.getElementById("campo" + idfld);
        xmlhttp = new ajax();
        xmlhttp.enviar('salvar.php?id=' + id_usuario + "&campo="+ nome_campo + "&valor=" + campo.value, "POST", false);
        elem.innerHTML = "<span onclick=\" editar(" + idfld + ", this," + id_usuario +", '"+ nome_campo + "');\">Clique aqui para inserir</span>";
		javascript:Atualiza6('atualiza_grupo.php?pr=c',this.value);
        //elem.firstChild.innerHTML = campo.value;
        return false;
    }
}
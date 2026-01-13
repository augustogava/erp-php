<?
include("conecta.php");
include("seguranca.php");
if(empty($acao)) $acao="entrar";
if($acao=="res"){
	$sql=mysql_query("SELECT * FROM postit WHERE id='$id'");
	$res=mysql_fetch_array($sql);
	$titulo="RES:".$res["titulo"];
	$denum=$res["denum"];
	$acao="entrar";
}elseif($acao=="ok"){
	$ray=explode(" ",$_SESSION["login_nome"]);
	$de=$ray[0];
	$denum=$_SESSION["login_codigo"];
	$data=date("Y-m-d");
	$hora=hora();
	if($todos=="S"){
		$sql=mysql_query("SELECT clientes.id AS cliente,clientes.nome AS nome FROM clientes,cliente_login,niveis WHERE clientes.id=cliente_login.cliente AND cliente_login.nivel=niveis.id AND niveis.tipo='F' ORDER BY clientes.nome ASC");
		while($res=mysql_fetch_array($sql)){
			$quem=$res["cliente"];
			$sql2=mysql_query("INSERT INTO postit (quem,titulo,msg,data,hora,de,denum) VALUES ('$quem','$titulo','$msg','$data','$hora','$de','$denum')");		
		}
	}else{
		$sql2=mysql_query("INSERT INTO postit (quem,titulo,msg,data,hora,de,denum) VALUES ('$quem','$titulo','$msg','$data','$hora','$de','$denum')");
	}
	if($sql2){
		$_SESSION["mensagem"]="Post-It enviado com sucesso!";
		header("Location:corpo.php");
		exit;
	}else{
		$_SESSION["mensagem"]="O seu Post-It não pôde ser enviado!";
	}
	$acao="entrar";		
}
?>
<html>
<head>
<title>CyberManager</title>
<meta http-equiv="Content-Type" content="text/html; UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script>
function verifica(cad){
	if(cad.quem[cad.quem.selectedIndex].value=='' && cad.todos.checked==false){
		alert('Informe para quem é o Post-It');
		return false;
	}
	if(cad.titulo.value==''){
		alert('Digite um Título');
		cad.titulo.focus();
		return false;
	}	
	if(cad.msg.value==''){
		alert('Digite sua Mensagem');
		cad.msg.focus();
		return false;
	}
	return true;
}
</script>
</head>
<body background="imagens/mdagua.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="594" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td align="left" valign="top"><form name="form1" method="post" action="" onSubmit="return verifica(this)">
        <table width="300" border="0" cellpadding="0" cellspacing="0">
          <tr bgcolor="#003366" class="texto"> 
            <td colspan="2" align="center" class="textoboldbranco">Enviar um Post-It</td>
          </tr>
          <tr class="texto"> 
            <td width="72" class="textobold">Para:</td>
            <td width="225" class="textobold"> 
              <select name="quem" class="formularioselect" id="select">
                <option value="" <? if(empty($denum)) print "selected"; ?>>Selecione</option>
                <?
							$sql=mysql_query("SELECT clientes.id AS cliente,clientes.nome AS nome FROM clientes,cliente_login,niveis WHERE clientes.id=cliente_login.cliente AND cliente_login.nivel=niveis.id AND niveis.tipo='F' ORDER BY clientes.nome ASC");
							while($res=mysql_fetch_array($sql)){
								$nome=$res["nome"];
						   	    $ray=explode(" ",$nome);
 	                            $nome=$ray[0];
							?>
                <option value="<? print $res["cliente"]; ?>"<? if($denum==$res["cliente"]) print "selected"; ?>><? print($nome); ?></option>
                <? } ?>
              </select>
            </td>
          </tr>
          <tr class="texto"> 
            <td class="textobold">&nbsp;</td>
            <td class="textobold"> 
              <input name="todos" type="checkbox" id="todos" value="S">
              Todos </td>
          </tr>
          <tr class="texto"> 
            <td class="textobold">T&iacute;tulo:</td>
            <td> 
              <input name="titulo" type="text" class="formularioselect" id="titulo" value="<? print $titulo; ?>" size="43"></td>
          </tr>
          <tr class="texto"> 
            <td class="textobold">Mensagem:</td>
            <td> 
              <textarea name="msg" cols="45" rows="6" wrap="VIRTUAL" class="formularioselect" id="msg" onFocus="enterativa=0;" onBlur="enterativa=1;"><? print $msg; ?></textarea></td>
          </tr>
          <tr class="texto"> 
            <td colspan="2" align="center"><input name="Submit2" type="submit" class="microtxt" value="Enviar">
            <input name="acao" type="hidden" id="acao" value="ok">
            </td>
          </tr>
        </table>
      </form></td>
  </tr>
</table>
</body>
</html>
<? include("mensagem.php"); ?>
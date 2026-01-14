<?php
include("conecta.php");
if(empty($id)){
	print"<script>window.close();</script>;";
}
if(empty($acao))$acao="entrar";
if($acao=="exc"){
	$sql=mysql_query("DELETE FROM postit WHERE id='$id'");
	print"<script>window.close();</script>;";
}
if($acao=="entrar"){
	$sql=mysql_query("SELECT * FROM postit WHERE id='$id'");
	if(mysql_num_rows($sql)==0){
		print"<script>window.close();</script>;";
	}else{
		$sqlup=mysql_query("UPDATE postit SET sit='a' WHERE id='$id'");
		$res=mysql_fetch_array($sql);
	}
}
?>
<html>
<head>
<title>Cyber Post-it________________________________________</title>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
windowWidth=201;
windowHeight=135;
if (parseInt(navigator.appVersion) >= 4) window.moveTo((screen.width/2)-(windowWidth/2+10),(screen.height/2)-(windowHeight/2+20));
function responde(){
	opener.location.href='postit_add.php?acao=res&id=<?php print $id; ?>';
	opener.focus();
}
</script>
</head>
<body background="imagens/postit_bg.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onunload="opener.location.href='corpo.php';"">
<table width="201" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#666666" id="tab1">
  <tr> 
      
    <td bgcolor="#FFFFCC">
<table width="200" border="0" align="center" cellpadding="0" cellspacing="0" background="imagens/postit_bg.gif" id="tab2" name="tabelaum">
        <tr> 
            <td bgcolor="#FFFFCC"><table width="200" border="0" align="center" cellpadding="0" cellspacing="1">
                <tr> 
                  <td width="15" align="right"><img src="imagens/postit_mini.gif" width="15" height="14"></td>
                  
                <td bgcolor="#003366" class="textoboldbranco"><img src="imagens/dot.gif" width="1" height="1"><?php print $res["titulo"]; ?></td>
                </tr>
              </table></td>
          </tr>
          <tr> 
            <td height="18" bgcolor="#FFFFCC" class="texto"> <table width="190" border="0" align="center" cellpadding="0" cellspacing="0">
                
              <tr> 
                <td><table width="200" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="18" align="center" class="textobold">DE:</td>
                      <td width="124" class="texto">&nbsp;<?php print $res["de"]; ?></td>
                      <td width="58" align="center" class="textobold"><a href="#" class="textobold" onClick="responde()">Responder</a></td>
                    </tr>
                  </table>
                </td>
              </tr>
				<tr>   
                <td class="texto"><textarea name="mensagem" cols="45" rows="6" wrap="VIRTUAL" class="postit" id="mensagem"><?php print $res["msg"]; ?></textarea></td>
                </tr>
              </table></td>
          </tr>
          <tr> 
            <td bgcolor="#FFFFCC"><table width="190" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr> 
                  <td><img src="imagens/postit_bar.gif" width="100%" height="1"></td>
                </tr>
              </table></td>
          </tr>
          <tr> 
            <td bgcolor="#FFFFCC"><table width="189" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr> 
                <td width="132" class="textobold"><?php print banco2data($res["data"]); ?> &nbsp;<?php print $res["hora"]; ?></td>
                <td width="57" align="center" class="textobold"><a href="postit.php?acao=exc&id=<?php print $id; ?>" class="textobold">Apagar</a></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
    </tr>
  </table>
</body>
</html>
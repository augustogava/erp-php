<?php
include("conecta.php");
include("seguranca.php");
$acao=Input::request("acao");
$id=Input::request("id");
if(empty($acao)) $acao="entrar";
?>
<html>
<head>
<title>CyberManager</title>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script>
function verifica(cad){
	if(cad.nome.value==''){
		alert('O campo Arquivo não foi preenchido');
		cad.nome.focus();
		return false;
	}
	return true;
}
function verifica2(cad){
	if(cad.arquivos.value==''){
		alert('O campo Arquivo não foi preenchido');
		cad.arquivos.focus();
		return false;
	}
	return true;
}

</script>
</head>
<body background="imagens/mdagua.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="594" border="0" cellpadding="0" cellspacing="0">
<tr>
    <td align="left" valign="top"><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_estudo_capabi.html','','width=680,height=501')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Estudo de Capabilidade'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('<strong>Caracter&iacute;stica - </strong>Caracter&iacute;stica da pe&ccedil;a a ser estudada.<br><strong>Especifica&ccedil;&atilde;o - </strong>Forma ou medida para ser seguida.<br><strong>Realizado por - </strong>Nome do respons&aacute;vel pelo estudo de R&R.<br><strong>Opera&ccedil;&atilde;o - </strong>Opera&ccedil;&atilde;o da manufatura na qual a especifica&ccedil;&atilde;o de engenharia &eacute; originada.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1">Arquivos</div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
<?php //ação entrar
if($acao=="entrar"){ ?>
  <tr>
    <td height="85" align="left" valign="top" class="chamadas"><br>      
      <table width="500" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><div align="center" class="textobold"><a href="up_arq.php?acao=inc" class="textobold">Salvar  Arquivo</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;<a href="up_pastas.php?acao=inc" class="textobold">Criar Pasta </a></div></td>
      </tr>
    </table>            <table width="500" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
        <tr class="textoboldbranco">
          <td width="20">&nbsp;</td>
          <td width="634">&nbsp;Pasta </td>
          <td width="91" align="center">Tamanho</td>
          <td width="98" align="center">Arquivos</td>
        </tr>
        <?php		//Busca as na tabela UP_PASTAS os arquivos do Dono da pasta, a pasta Temp e as pastas Publicas
			  $sql=mysql_query("SELECT * FROM up_pastas WHERE dono='$_SESSION[login_codigo]' OR publica='S' ORDER BY nome ASC");
			  if(mysql_num_rows($sql)==0){
		?>
       			 <tr bgcolor="#FFFFFF">
       		     <td colspan="4" align="center" class="textobold">NENHUMA PASTA ENCONTRADO</td>
        </tr>
        <?php
			  }else{
			    while($res=mysql_fetch_array($sql)){
					//Exibe o relatório de tamanho de bytes, quant de arquivos e quant de pastas
					$sql2=mysql_query("SELECT SUM(tamanho) AS tamanho, COUNT(*) AS total FROM up_arq WHERE pasta='$res[id]'");
					$res2=mysql_fetch_array($sql2);
					if(!$res2["tamanho"]) $res2["tamanho"]=0;
					$totp++;
					$tott+=$res2["tamanho"];
					$tota+=$res2["total"];
		?>
        <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
          <td width="20" height="18" align="center"><a href="up_arq.php?acao=abre_pasta&id=<?php print $res["id"]?>"><img src="imagens/folder.gif" width="17" height="17" border="0"></a></td>
          <td>&nbsp;<?php print $res["nome"]; ?>&nbsp;
		  <?php
		  	// Código especifico para trazer na frente dos nomes das PASTAS PUBLICAS o 1° nome do DONO DA PASTA
		  	if ($res["dono"]!=0 and $res["dono"]!=$_SESSION["login_codigo"]){
				$sql3=mysql_query("SELECT nome FROM clientes WHERE id='$res[dono]'");
				$res3=mysql_fetch_array($sql3);
				$ray=explode(" ",$res3["nome"]);
 	            $res3["nome"]=$ray[0];
				print "($res3[nome])";
			}  
		  ?></td>
          <td width="91" align="center"><?php print bytes($res2["tamanho"]); ?></td>
          <td width="98" align="center"><?php print $res2["total"]; ?></td>
        </tr>
        <?php
			  	}
			  }
			  ?>
      </table>

	  <br>
	  <table width="164" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
        <tr>
          <td width="117" align="left" class="textoboldbranco">&nbsp;Total de pastas:</td>
          <td width="44" align="center" bgcolor="#FFFFFF" class="textobold"><span class="textoboldbranco">&nbsp;</span><?php print "$totp";?></td>
        </tr>
        <tr>
          <td align="left"><span class="textoboldbranco">&nbsp;Total de arquivos: </span></td>
          <td align="center" bgcolor="#FFFFFF" class="textobold">&nbsp;<?php print "$tota";?></td>
        </tr>
        <tr>
          <td align="left"><span class="textoboldbranco">&nbsp;Tamanho total:</span></td>
          <td align="center" bgcolor="#FFFFFF" class="textobold">&nbsp;<?php print bytes("$tott");?></td>
        </tr>
    </table>	  </td>
	 <?php //ação abre pasta
	  }else if($acao=="abre_pasta"){
	  		if(!empty($id)){
				$_SESSION["idpasta"]=$id;
			}else{
				$id=$_SESSION["idpasta"];
			}
	  //Busca o id da pasta conforme link da pagina anterior
	 		 $sql=mysql_query("SELECT * FROM up_pastas WHERE id='$id'");
	 		 $res=mysql_fetch_array($sql);
	 
	  ?>
  </tr>
  <tr>
    <td height="69" align="left" valign="top"><table width="500" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><div align="center"><a href="up_arq.php?acao=inc" class="textobold">Salvar Arquivo </a> </div></td>
      </tr>
      <tr>
        <td><span class="textobold">Pasta Atual: <?php print $res["nome"]."&nbsp;"; 
		  	// Código especifico para trazer na frente dos nomes das PASTAS PUBLICAS o 1° nome do DONO DA PASTA
		if ($res["dono"]!=0 and $res["dono"]!=$_SESSION["login_codigo"]){
				$sql3=mysql_query("SELECT nome FROM clientes WHERE id='$res[dono]'");
				$res3=mysql_fetch_array($sql3);
				$ray=explode(" ",$res3["nome"]);
 	            $res3["nome"]=$ray[0];
				print "($res3[nome])";
			}
		?> </span></td>
      </tr>
    </table>
    <table width="500" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
        <tr class="textoboldbranco">
          <td width="218">&nbsp;Arquivo</td>
          <td width="140" ><div align="center">Data</div></td>
          <td width="60" ><div align="center">Tamanho</div></td>
          <td width="26" align="center">&nbsp;</td>
          <td width="26" align="center">&nbsp;</td>
          <td width="23" align="center">&nbsp;</td>
        </tr>
        <?php
 			  $sql=mysql_query("SELECT * FROM up_arq WHERE pasta='$id'");
			  $tott=0;
			  $tota=0;
 			  if(mysql_num_rows($sql)==0){
			  ?>
        <tr bgcolor="#FFFFFF">
          <td colspan="6" align="center" class="textobold">NENHUMA ARQUIVO ENCONTRADO</td>
        </tr>
        <?php
			  }else{
			  	while($res=mysql_fetch_array($sql)){
				//Exibe o relatório de tamanho de bytes, quant de arquivos da pasta corrente
					$tott+=$res["tamanho"];
					$tota++;
			  ?>
			  
		  <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
          <td width="218">&nbsp;<?php print $res["nome"]; ?></td>
		  <td width="140" align="center"><?php print banco2data($res["data"])." &agrave;s ".$res["hora"]; ?></td>
          <td width="60"><div align="center"><?php print bytes($res["tamanho"]); ?></div></td>
          <td width="26" align="center"><a href="up_arq_sql.php?acao=down&id=<?php print $res["id"]; ?>"><img src="imagens/icon_14_down.gif" width="14" height="14" border="0"></a></td>
          <td width="26" align="center"><a href="up_arq.php?acao=alt&id=<?php print $res["id"]; ?>"><img src="imagens/icon14_alterar.gif" alt="Alterar" width="14" height="14" border="0"></a></td>
          <td width="23" align="center"><a href="#" onClick="return pergunta('Deseja excluir este Arquivo?','up_arq_sql.php?acao=exc&id=<?php print $res["id"]; ?>')"><img src="imagens/icon14_lixeira.gif" alt="Excluir" width="14" height="14" border="0"></a></td>
        </tr>
        <?php
			 }
			  }
			  ?>
      </table>    
    <br>
    <table width="164" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
      <tr>
        <td width="117" align="left"><span class="textoboldbranco">&nbsp;Total de arquivos: </span></td>
        <td width="44" align="center" bgcolor="#FFFFFF" class="textobold">&nbsp;<?php print "$tota";?></td>
      </tr>
      <tr>
        <td align="left"><span class="textoboldbranco">&nbsp;Tamanho total:</span></td>
        <td align="center" bgcolor="#FFFFFF" class="textobold">&nbsp;<?php print bytes("$tott");?></td>
      </tr>
    </table>
    <p align="center"><span class="textobold">
      <input name="Submit222" type="button" class="microtxt" value="voltar" onClick="window.location='up_arq.php'">
   </span></p></td>
	   <?php
	  }else if($acao=="inc"){
	  ?>
	  
  </tr>
  <tr> 
    <td align="left" valign="top"><form action="up_arq_sql.php" method="post" enctype="multipart/form-data" name="form" onSubmit="return verifica2(this);">
      <table width="500" cellspacing="0" cellpadding="0">
        <tr>
          <td colspan="2" align="center" bgcolor="#003366" class="textoboldbranco &gt;&lt;div align=">Salvar Aquivos </td>
          </tr>
      </table>
      <table width="500" border="0" cellpadding="0" cellspacing="0" bgcolor="#003366">
        <tr bgcolor="#FFFFFF">
          <td width="63" class="textobold">Pasta</td>
          <td width="437">
		  <select name="pasta" class="formulario" id="pasta">
		  <?php
		  //
			  $sql=mysql_query("SELECT * FROM up_pastas WHERE dono='$_SESSION[login_codigo]' OR publica='S' ORDER BY nome ASC");
			  //$sql=mysql_query("SELECT * FROM up_pastas ORDER BY nome ASC");
			  if(mysql_num_rows($sql)){
			 	
				while($res=mysql_fetch_array($sql)){
				 ?>
			 	 <option value="<?php print $res["id"]; ?>"><?php print $res["nome"]."&nbsp";
				
				 // Código especifico para trazer na frente dos nomes das PASTAS PUBLICAS o 1° nome do DONO DA PASTA
				if ($res["dono"]!=0 and $res["dono"]!=$_SESSION["login_codigo"]){
				$sql3=mysql_query("SELECT nome FROM clientes WHERE id='$res[dono]'");
				$res3=mysql_fetch_array($sql3);
				$ray=explode(" ",$res3["nome"]);
 	            $res3["nome"]=$ray[0];
				print "($res3[nome])";
				}
				  ?></option>
			<?php  
			 	 }
			  }
			 ?>  
          	</select> <span class="textobold"><a href="up_pastas.php?acao=inc" class="textobold">Criar Pasta </a></span>
		  </td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td class="textobold">Arquivo</td>
          <td><input name="arquivos" type="file" class="formularioselect" id="arquivos"></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td colspan="2" class="textobold"><img src="imagens/dot.gif" width="20" height="8"></td>
          </tr>
        <tr bgcolor="#FFFFFF">
          <td class="textobold">

</td>
          <td><span class="textobold">
            <input name="Submit2222" type="button" class="microtxt" value="voltar" onClick="window.location='up_arq.php'">
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input name="Submit22" type="submit" class="microtxt" value="Continuar">
            <input name="acao" type="hidden" id="acao" value="inc">
          </span></td>
        </tr>
        </table>
    </form></td>
  </tr>
   <?php //ação altera_arq
	  }else if($acao=="alt"){
	  
	  $sql4=mysql_query("SELECT * FROM up_arq WHERE id='$id'");
	  $res4=mysql_fetch_array($sql4);
	  ?>
  <tr>
    <td align="left" valign="top"><form action="up_arq_sql.php" method="post" name="form" id="form" onSubmit="return verifica(this);">
      <table width="500" border="0" cellpadding="0" cellspacing="0" bgcolor="#003366">
        <tr bgcolor="#FFFFFF">
          <td width="66" class="textobold"></td>
          <td width="233" class="textobold"></td>
        </tr>
             <tr bgcolor="#003366" class="textoboldbranco ><div align="center">
          <td colspan="2" align="center">Alterar Aquivos</td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td class="textobold">Pasta</td>
          <td>  
		  <select name="pasta" class="formulario" id="pasta">
            <?php
		  //
			  $sql=mysql_query("SELECT * FROM up_pastas WHERE dono='$_SESSION[login_codigo]' OR publica='S' ORDER BY nome ASC");
			  if(mysql_num_rows($sql)){
				while($res=mysql_fetch_array($sql)){
				 ?>
            <option value="<?php print $res["id"]; ?>" <?php if($res4["pasta"]==$res["id"]) print "selected";?>><?php print $res["nome"]."&nbsp";
				 // C&oacute;digo especifico para trazer na frente dos nomes das PASTAS PUBLICAS o 1&deg; nome do DONO DA PASTA
				if ($res["dono"]!=0 and $res["dono"]!=$_SESSION["login_codigo"]){
				$sql3=mysql_query("SELECT nome FROM clientes WHERE id='$res[dono]'");
				$res3=mysql_fetch_array($sql3);
				$ray=explode(" ",$res3["nome"]);
 	            $res3["nome"]=$ray[0];
				print "($res3[nome])";
				}
				  ?></option>
            <?php  
			 	 }
			  }
			 ?>
          </select>
		  </td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td class="textobold">Arquivo</td>
		 <td>
			<?php
			//$sql4=mysql_query("SELECT * FROM up_arq WHERE id=2");
			//$res4=mysql_fetch_array(sql4);
		  ?>
		  <input name="nome" class="formularioselect" value="<?php print $res4["nome"];?>" size="40"></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td colspan="2" class="textobold"><img src="imagens/dot.gif" width="20" height="8"></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td class="textobold">&nbsp;</td>
          <td><span class="textobold"><a href="up_arq.php?acao=abre_pasta">
            <input name="Submit2223" type="button" class="microtxt" value="voltar" onClick="window.location='up_arq.php'">
          </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input name="Submit2" type="submit" class="microtxt" value="Continuar">
            <input name="acao" type="hidden" id="acao3" value="<?php print $acao; ?>">
                <input name="id" type="hidden" id="id" value="<?php print $id; ?>">
          </span></td>
        </tr>
        </table>
    </form></td>
    <?php } ?>
  </tr>
</table>
</body>
</html>
<?php include("mensagem.php"); ?>
<?
include("conecta.php");
include("seguranca.php");
$nivel=$_SESSION["login_nivel"];
if(!empty($acao)){
	$loc="Funcionarios";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if(empty($acao)){
	$acao="entrar";
	}
/*
if(!empty($bnome)){
	$cond="where (nome like '%$bnome%')";
}
if(!empty($bcod)){
	$cond="where id='$bcod'";
}
if(!empty($bnome) and !empty($bcod)){
	$cond="where (nome like '%$bnome%' OR id='$bcod')";
}
*/
if($acao=="exc"){
$sql=mysql_query("DELETE FROM cliente_login WHERE funcionario='$id'");
$sql=mysql_query("DELETE FROM funcionarios WHERE id='$id'");
}
?>
<html>
<head>
<title>CyberManager</title>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<style type="text/css">
<!--
.style1 {font-size: 14px}
-->
</style>
</head>
<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="594" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td><table width="594" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td>
<form name="form1" method="post" action="">
            <table width="591" border="0" cellpadding="0" cellspacing="0" class="texto">
              <tr>
                <td width="27" align="center"><div align="left"><img src="imagens/icon14_ahn.gif" width="14" height="14" onMouseOver="this.T_TITLE='Campos Preenchimentos obrigatorio'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('Nome: Entre com nome<br>Nascimento: xx/xx/xxxx<br>RG: xx.xxx.xxx-x<br>Cart. Profissional: xxxxx<br>Admiss&atilde;o: xx/xx/xxxx<br>Cargo: Escolha um item na lista')"><span class="impTextoBold">&nbsp;</span></div></td>
                <td width="564" align="right"><div align="left"><span class="textobold style1 style1 style1">Vendedores</span></div></td>
              </tr>
              <tr>
                <td align="center">&nbsp;</td>
                <td align="right">&nbsp;</td>
              </tr>
            </table>
            </form></td>
        </tr>
        <tr> 
          <td><table width="200" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td align="center"></td>
            </tr>
          </table>
          <table width="594" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
              <tr bgcolor="#003366" class="textoboldbranco"> 
                <td width="37" align="center">C&oacute;d</td>
                <td width="489">&nbsp;Nome</td>
                <td width="10" align="center">&nbsp;</td>
               <? if($nivel=="1"){ ?>  <td width="10" align="center">&nbsp;</td><? } ?>
                <td width="20" align="center">&nbsp;</td>
              </tr>
              <?
			  
			  $sql=mysql_query("SELECT c.fantasia,c.id FROM clientes AS c, cliente_login AS cl, niveis AS n WHERE cl.nivel=n.id AND n.vendedor=1 AND cl.cliente=c.id ORDER BY c.fantasia ASC");
			  if(mysql_num_rows($sql)==0){
			  ?>
              <tr bgcolor="#FFFFFF" class="texto"> 
                <td colspan="5" align="center" class="textobold">NENHUM FUNCION&Aacute;RIO 
                  ENCONTRADO </td>
              </tr>
              <?
			  }else{
			  	while($res=mysql_fetch_array($sql)){
			  ?>
              <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')"> 
                <td align="center"><? print $res["id"]; ?></td>
                <td>&nbsp;<? print $res["fantasia"]; ?></td>
                <td align="center"><a href="funcionarios_geral.php?id=<? print $res["id"]; print "&bcod=$bcod&bnome=$bnome";?>"><img src="imagens/icon14_pessoas.gif" alt="Dados Gerais" width="14" height="14" border="0"></a></td>
               <? if($nivel=="1"){ ?>
			    <td align="center"><a href="funcionario_login.php?id=<? print $res["id"]; ?>"><img src="imagens/icon14_key.gif" alt="Senha" width="24" height="14" border="0"></a></td>
				<? } ?>
                <td align="center"><a href="#" onClick="return pergunta('Deseja excluir este funcionário?','funcionarios.php?acao=exc&id=<? print $res["id"]; ?>')"><img src="imagens/icon14_lixeira.gif" alt="Excluir" width="14" height="14" border="0"></a></td>
              </tr>
              <?
			  	}
			  }
			  ?>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<? include("mensagem.php"); ?>
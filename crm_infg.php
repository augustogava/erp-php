<?
include("conecta.php");
include("seguranca.php");
$_SESSION["idp"]=$id;
if(!empty($acao)){
	$loc="CRM";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if(empty($acao)) $acao="entrar";
if($acao=="entrar"){
	$sql=mysql_query("SELECT * FROM clientes WHERE id='$cli'");
	if(mysql_num_rows($sql)){
		$res=mysql_fetch_array($sql);
	}else{
		print "<script>window.alert('Selecione primeiro um cliente');window.location='crm_clientes.php';</script>";
	}
		$maior=max($res["porte_che"],$res["porte_fun"],$res["porte_fat"]);
		switch($maior){
			case 1:
			$porte="Pequeno";
			break;
			case 2:
			$porte="Médio";
			break;
			case 3:
			$porte="Grande";
			break;
		}
}
?>
<html>
<head>
<title>CyberManager</title>
<meta http-equiv="Content-Type" content="text/html; UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script src="mascaras.js"></script>
<script>
<!--

//-->
</script>
<style type="text/css">
<!--
.style1 {color: #CCCCCC}
-->
</style>
<link href="style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style2 {font-size: 14px}
.style3 {font-size: 14px; font-family: Arial, Helvetica, sans-serif; }
-->
</style>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="626" align="left" valign="top"><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="return abre('<? $_SERVER['PHP_SELF']; ?>?cli=<?= $cli; ?>','Contatos','width='+screen.availWidth+',height='+screen.availHeight
);"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0"></a></div></td>
        <td width="563" align="right"><div align="left"><span class="chamadas"><span class="titulos">M&oacute;dulo CRM - Informa&ccedil;&otilde;es Gerais</span></span></div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table>      
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="27"><img src="imagens/dot.gif" width="20" height="8">
              <table width="100%" border="2" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
                <tr>
                  <td height="48" bgcolor="#F8F8F8"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="17%" class="style1"><div align="center"><a href="#" class="textobold" onClick="return abre('crm_clientes_geral.php?acao=alt&id=<?= $cli; ?>&crm=S','Contatos','width=520,height=480,scrollbars=1');"><img src="imagens/icon_forn_cad.jpg" width="21" height="20" border="0"></a></div></td>
                        <td width="11%" class="style1"><div align="center"><a href="#" class="textobold" onClick="return abre('cliente_contatos.php?cli=<?= $cli; ?>','Contatosaa','width=520,height=280,scrollbars=1');"><img src="imagens/icon_repre.jpg" width="36" height="35" border="0"></a></div></td>
                        <td width="11%" class="style1"><div align="center"><a href="crm_finan.php?cli=<?= $cli; ?>"><img src="imagens/icon_tcb.jpg" width="35" height="35" border="0"></a></div></td>
                        <td width="12%" class="style1"><div align="center"><a href="crm_status.php?cli=<?= $cli; ?>"><img src="imagens/icon_ct.jpg" width="36" height="35" border="0"></a></div></td>
                        <td width="19%" align="center" class="style1"><div align="center"><img src="imagens/icon_cp.jpg" alt="crm_tabpreco.php" width="62" height="35"></div></td>
                        <td width="16%" align="center" class="style1"><a href="crm_marca.php?cli=<?= $cli; ?>"><img src="imagens/icon_cf.jpg" alt="crm_tabpreco.php" width="27" height="35" border="0"></a></td>
                        <td width="16%" class="style1"><div align="center"><a href="agenda_inc.php?dia=<? print $cal_dia; ?>&mes=<? print $cal_mes; ?>&ano=<? print $cal_ano; ?>&cli=<?= $cli; ?>"><img src="imagens/icon_ap.jpg" width="27" height="35" border="0"></a></div></td>
                        <td width="14%" class="style1"><div align="center"><a href="crm_clientes.php"><img src="imagens/icon_no.jpg" width="37" height="35" border="0"></a></div></td>
                      </tr>
                      <tr>
                        <td class="textobold style1"><div align="center" class="textobold"><a href="#" class="textobold" onClick="return abre('crm_clientes_geral.php?acao=alt&id=<?= $cli; ?>&crm=S','Contatos','width=520,height=480,scrollbars=1');">Detalhe do Cadastro</a> </div></td>
                        <td class="textobold style1"><div align="center" class="textobold"><a href="#" class="textobold" onClick="return abre('cliente_contatos.php?cli=<?= $cli; ?>','Contatosaa','width=520,height=280,scrollbars=1');">Contatos</a></div></td>
                        <td class="textobold style1"><div align="center" class="textobold"><a href="crm_finan.php?cli=<?= $cli; ?>" class="textobold">Financeiro</a></div></td>
                        <td class="textobold style1"><div align="center" class="textobold"><a href="crm_status.php?cli=<?= $cli; ?>" class="textobold">Log&iacute;stica</a></div></td>
                        <td align="center" class="textobold style1"><div align="center" class="textobold"><a href="crm_tabpreco.php" class="textobold">Consultar Tabela de Pre&ccedil;o </a></div></td>
                        <td align="center" class="textobold style1"><a href="crm_marca.php?cli=<?= $cli; ?>" class="textobold">Ac&atilde;o Marketing </a></td>
                        <td class="textobold style1"><div align="center" class="textobold"><a href="agenda_inc.php?dia=<? print $cal_dia; ?>&mes=<? print $cal_mes; ?>&ano=<? print $cal_ano; ?>&cli=<?= $cli; ?>" class="textobold">Agendar Contato</a> </div></td>
                        <td class="textobold style1"><div align="center" class="textobold"><a href="crm_clientes.php" class="textobold">Buscar Cliente</a> </div></td>
                      </tr>
                  </table></td>
                </tr>
          </table></td>
        </tr>
        <tr>
          <td height="89"><table width="100%" border="2" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
              <tr>
                <td height="57" bgcolor="#F8F8F8"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td colspan="2" class="textopreto"><strong>C&oacute;digo:</strong>&nbsp;<? print $res["id"]; ?><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Raz&atilde;o Social:</strong> <? print $res["nome"]; ?></td>
                      <td colspan="2" class="textopreto"><strong>Nome Fantasia:</strong> <? print $res["fantasia"]; ?></td>
                      <td width="24%" class="textopreto"><strong>Unidade: <? print ucfirst($res["loja"]); ?></strong>&nbsp;</td>
                    </tr>
                    <tr>
                      <td width="23%" class="textopreto"><strong>Endere&ccedil;o:</strong> <? print ucfirst($res["endereco"]); ?></td>
                      <td width="19%" class="textopreto"><strong>Cidade:</strong>&nbsp;<? print ucfirst($res["cidade"]); ?></td>
                      <td width="15%" class="textopreto"><strong>UF:</strong>&nbsp;<? $est=mysql_query("SELECT * FROM estado WHERE id='$res[estado]'"); $estr=mysql_fetch_array($est); print $estr["nome"]; ?></td>
					  <?
					  switch($res["status"]){
					  	case "A":
						$status="Ativo";
						break;
						case "I":
						$status="Inativo";
						break;
						case "P":
						$status="Prospect";
						break;
						}
					  ?>
                      <td width="19%" class="textopreto"><strong>Tel: </strong><? print $res["ddd"]." - ".$res["fone"]; ?></td>
                      <td class="textopreto"><strong>Situa&ccedil;&atilde;o:</strong>&nbsp;<? print $status; ?></td>
                    </tr>
					<?	$a=mysql_query("select SUM(crm_acao.custo) as total from clientes,crm_acao,crm_acaor WHERE clientes.id=crm_acaor.cliente AND crm_acao.id=crm_acaor.acao AND clientes.id='$cli'");
				$ra=mysql_fetch_array($a);
				?>
                    <tr>
                      <td colspan="4" class="textopreto"><strong>Porte:</strong>&nbsp;<? print $porte; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Total Gasto Em Marketing:</strong><? print banco2valor($ra["total"]); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>&Uacute;ltima Atuliza&ccedil;&atilde;o</strong>: <? print banco2data($res["atualizacao"]); ?></td>
                      <td class="textopreto"><strong>&Uacute;ltimo Pedido:</strong>
                        <? $sqla=mysql_query("select data from e_compra WHERE cliente='$cli' ORDER By id DESC"); $resa=mysql_fetch_array($sqla); print banco2data($resa["data"]); ?></td>
                    </tr> 
				
                    
                </table></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td height="380"><table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td colspan="2"><div align="center"><span class="titulos"><a href="#" class="titulos" onClick="return abre('crm_followup_inc.php?cli=<?= $cli; ?>','FollowUp','width=620,height=350,scrollbars=1');">Contact Center / Incluir Follow Up</a></span></div></td>
              </tr>
              
              <tr>
                <td colspan="2"><iframe name="lista" id="lista" src="crm_infg1.php?cli=<?= $cli; ?>" width="100%" height="200" frameborder="0" scrolling="yes"> </iframe></td>
              </tr>
              <tr>
                <td height="22" align="center" class="titulos">&nbsp;</td>
                <td height="22" align="center" class="titulos">&nbsp;</td>
              </tr>
              <tr>
                <td height="23" align="center" class="titulos">Pedidos</td>
                <td height="23" align="center" class="titulos"><a href="vendas_orc_sql.php?acao=inc&cli=<?= $cli; ?>" class="titulos">Proposta / Incluir</a></td>
              </tr>
              <tr>
                <td align="center" valign="bottom"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="textoboldbranco">
                  <tr bgcolor="#999999">
                    <td width="13%" bgcolor="#999999" class="textoboldbranco"><div align="center">Data</div></td>
                    <td width="10%" align="center" bgcolor="#999999" class="textoboldbranco"><div align="center">N&uacute;mero</div></td>
                    <td width="37%" bgcolor="#999999" class="textoboldbranco"><div align="center">Vendedor</div></td>
                    <td width="22%" bgcolor="#999999" class="textoboldbranco"><div align="center">Valor R$</div></td>
                    <td width="18%" align="left" bgcolor="#999999" class="textoboldbranco"><div align="center" class="textoboldbranco">
                      <div align="left">&nbsp;&nbsp;&nbsp;Status</div>
                    </div></td>
                    </tr>
                  
                </table></td>
                <td align="center"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="textoboldbranco">
                  <tr bgcolor="#999999">
                    <td width="15%" bgcolor="#999999" class="textoboldbranco"><div align="center">Data</div></td>
                    <td width="8%" align="center" bgcolor="#999999" class="textoboldbranco"><div align="center">N&ordm;</div></td>
                    <td width="33%" bgcolor="#999999" class="textoboldbranco"><div align="center">Vendedor</div></td>
                    <td width="9%" align="center" bgcolor="#999999" class="textoboldbranco">Valor</td>
                    <td width="22%" bgcolor="#999999" class="textoboldbranco"><div align="center">Contato</div></td>
                    <td width="13%" align="left" bgcolor="#999999" class="textoboldbranco"><div align="center" class="textoboldbranco">
                        <div align="left">Status</div>
                    </div></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td height="102" align="center"><IFRAME name="lista" id="lista" src="crm_infg2.php?cli=<?= $cli; ?>" width="100%" height="200" frameborder="0" scrolling="yes"> </IFRAME></td>
                <td align="center"><iframe name="lista" id="lista" src="crm_infg3.php?cli=<?= $cli; ?>" width="100%" height="200" frameborder="0" scrolling="yes"> </iframe></td>
              </tr>
              <tr>
                <td align="center" valign="bottom"><span class="textobold style2">Acumulado:
                  </span><span class="style3">
                  <? $sql3=mysql_query("SELECT SUM(vendas_list.qtd*vendas_list.unitario) as total FROM vendas,vendas_list WHERE vendas.cliente='$cli' AND vendas.id=vendas_list.venda"); $res3=mysql_fetch_array($sql3); print banco2valor($res3["total"]); ?></span></td>
                <td align="center" valign="bottom"><span class="textobold style2">Acumulado: </span><span class="style3">
                  <? $sql3=mysql_query("SELECT SUM(vendas_orcamento_list.qtd*vendas_orcamento_list.unitario) as total FROM vendas_orcamento,vendas_orcamento_list  WHERE vendas_orcamento.cliente='$cli' AND vendas_orcamento.sit='0' AND vendas_orcamento.id=vendas_orcamento_list.orcamento"); $res3=mysql_fetch_array($sql3); print banco2valor($res3["total"]); ?>
                </span></td>
              </tr>
              <tr>
                <td height="37" align="center" class="textopretobold">&nbsp;</td>
                <td height="37" align="center" class="textopretobold">&nbsp;</td>
              </tr>
              <tr>
                <td height="29" colspan="2" align="center"><label>
                  <input name="Voltar" type="submit" class="treemenu" id="Voltar" value="Voltar">
                </label></td>
              </tr>
          </table></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>
<script language="javascript" src="tooltip.js"></script>
<? include("mensagem.php"); ?>
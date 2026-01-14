<?php
include("conecta.php");
require_once('classes/PDF_Label.php');
	$data=date("Y-m-d");
	$hora=hora();
$bd=new set_bd;
$pdf = new PDF_Label("6182", 1, 2);
$pdf->Open();
$pdf->AddPage();
$pdf->Set_Char_Size(1);
	$nome=$bd->pega_nome_bd2("crm_acao","nome","$id");
	mysql_query("UPDATE crm_acao SET sit='2' WHERE id='$id'");
	$sql=mysql_query("SELECT clientes.*,crm_acao.contato as cto FROM clientes,crm_acaor,crm_acao WHERE crm_acaor.acao='$id' AND crm_acaor.cliente=clientes.id AND crm_acao.id=crm_acaor.acao");
	while($res=mysql_fetch_array($sql)){
		$sql2=mysql_query("SELECT * FROM cliente_contato WHERE cliente='$res[id]' AND atuacao='$res[cto]'");
		if(mysql_num_rows($sql2)){ $res2=mysql_fetch_array($sql2); $contato=$res2["nome"]; }else{ $contato=$res["contato"]; }
		//FollowUp
		mysql_query("INSERT INTO followup (cliente,data,hora,titulo,descricao,tipo) VALUES('$res[id]','$data','$hora','Ação Marketing','Foi enviado a seguinte Ação de Marketing para este cliente: $nome','3')");
			
			$estado=$bd->pega_nome_bd2("estado","nome","$res[estado]");
	   		$pdf->Add_PDF_Label(sprintf("%s\n%s\n%s\n%s", "$contato", "$res[endereco]", "$res[bairro]   $res[cidade]   $estado", "CEP $res[cep]"));
	}
$pdf->Output();
?>
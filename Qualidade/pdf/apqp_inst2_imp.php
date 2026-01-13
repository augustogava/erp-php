<?php
//include('../conecta.php');
//require('fpdf.php');

//$pc=$_SESSION["mpc"];
//$npc=$_SESSION["npc"];
$sql=mysql_query("SELECT *,apqp_pc.nome AS nome, clientes.fantasia AS nomecli FROM apqp_pc,clientes WHERE apqp_pc.id='$pc' AND apqp_pc.cliente=clientes.id");
$res=mysql_fetch_array($sql);
if(!mysql_num_rows($sql)) exit;
$sql=mysql_query("SELECT * FROM empresa");
if(mysql_num_rows($sql)) $rese=mysql_fetch_array($sql);
$sql=mysql_query("SELECT * FROM apqp_inst WHERE id='$id'");
if(mysql_num_rows($sql)) $resp=mysql_fetch_array($sql);
$sql=mysql_query("SELECT op.* FROM apqp_op AS op WHERE op.id='$resp[op]'");
if(mysql_num_rows($sql)) $resop=mysql_fetch_array($sql);

/*//$pdf=new FPDF();
$pdf->AddPage();
if($logo=="OK"){
$pdf->Image('empresa_logo/logo.jpg',5,1,25);
}else{
$pdf->Image('empresa_logo/logo.jpg',5,1,25);
}
$pdf->SetXY(5, 1);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(80);
$pdf->Cell(0, 18, 'OP'.$resop["numero"].' - '.$resop["descricao"].'');
$pdf->SetXY(5, 18);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(75,5,"Cliente \n ".$res["nomecli"]."",1);
$pdf->SetXY(80, 18);
$pdf->MultiCell(85,5,"Número da Peça (cliente) \n $res[pecacli]",1);
$pdf->SetXY(165, 18);
$pdf->MultiCell(40,5,"Rev. / Data do Desenho \n $res[rev] - ".banco2data($res["dtrev"])."",1);
//linha 2
$pdf->SetXY(5, 28);
$pdf->MultiCell(75,5,"Fornecedor\n $rese[razao]",1);
$pdf->SetXY(80, 28);
$pdf->MultiCell(125,5,"Nome da Peça \n $res[nome]",1);
//linha 3
$pdf->SetXY(5, 38);
$pdf->MultiCell(75,5,"Máquina/Local \n $resop[macloc]",1);
$pdf->SetXY(80, 38);
$pdf->MultiCell(85,5,"Preparado por \n $resp[prep]",1);
$pdf->SetXY(165, 38);
$pdf->MultiCell(40,5,"Data \n ".banco2data($resp["prep_data"])."",1);
//linha 4
$pdf->SetXY(5, 48);
$pdf->MultiCell(75,5,"Aprovado por \n $resop[macloc]",1);
$pdf->SetXY(80, 48);
$pdf->MultiCell(85,5,"Número/Rev. Peça (fornecedor) \n $res[numero] - $res[rev]",1);
$pdf->SetXY(165, 48);
$pdf->MultiCell(40,5,"Data \n ".banco2data($resp["dtquem"])."",1);
//linha 5
$pdf->SetXY(5, 58);
$pdf->MultiCell(75,5,"Revisão Número \n $resop[macloc]",1);
$pdf->SetXY(80, 58);
$pdf->MultiCell(85,5,"Descrição das Alterações \n $resp[rev_alt]",1);
$pdf->SetXY(165, 58);
$pdf->MultiCell(40,5,"Data Efetivação  \n ".banco2data($resp["rev_data"])."",1);*/
//linha6
$y+=10;
if($logo=="OK"){
$pdf->Image("apqp_inst/$id.jpg",30,$y);
}else{
$pdf->Image("../apqp_inst/$id.jpg",30,$y);
}
//fim
//$pdf->Output('apqp_inst2.pdf','I');
?>

<?php
$npc=$_SESSION["npc"];
$sql=mysql_query("SELECT *,apqp_pc.nome AS nome, clientes.fantasia AS nomecli FROM apqp_pc,clientes WHERE apqp_pc.id='$pc' AND apqp_pc.cliente=clientes.id");
$res=mysql_fetch_array($sql);
if(!mysql_num_rows($sql)) exit;
$sql=mysql_query("SELECT * FROM empresa");
if(mysql_num_rows($sql)) $rese=mysql_fetch_array($sql);
$sql=mysql_query("SELECT * FROM apqp_sum WHERE peca='$pc'");
if(mysql_num_rows($sql)) $resp=mysql_fetch_array($sql);

$pdf->AddPage();
$pdf->Image('empresa_logo/logo.jpg',5,1,25);
$pdf->SetXY(5, 1);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(35);
$pdf->Cell(0, 15, 'Zusammenfassung der Zustimmung der Planung von der Produktqualität');
$pdf->SetXY(5, 18);
$pdf->SetXY(100, 18);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(15,5,"Datum:");
$pdf->SetXY(115, 18);
$pdf->MultiCell(30,5,banco2data($resp["data"]),0);
$pg=1;
$pdf->Line(115,23,145,23);
$pdf->SetXY(180, 8);
$pdf->MultiCell(40,5,"PPAP Nr. $res[numero] \n Blatt: $pg");
//linha 2
$pdf->SetXY(5, 30);
$pdf->MultiCell(25,10,"Kunde: ");
$pdf->SetXY(30, 30);
$pdf->MultiCell(70,10,$res["pecacli"],0);
$pdf->Line(30,38,100,38);
$pdf->SetXY(100, 30);
$pdf->MultiCell(25,10,"Teilename: ");
$pdf->SetXY(125, 30);
$pdf->MultiCell(70,10,$res["nome"],0);
$pdf->Line(125,38,195,38);
//linha 3
$pdf->SetXY(5, 42);
$pdf->MultiCell(25,10,"Teilenummer: ");
$pdf->SetXY(30, 42);
$pdf->MultiCell(70,10,$res["numero"],0);
$pdf->Line(30,50,100,50);
$pdf->SetXY(100, 42);
$pdf->MultiCell(25,5,"Neuausgabe des Teils:");
$pdf->SetXY(125, 42);
$pdf->MultiCell(70,10,$res["rev"],0);
$pdf->Line(125,50,195,50);
//linha 4
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(6, 51);
$pdf->MultiCell(100,5,"1. EINLEITENDE STUDIE DES CAPABILIDADE DES PROZESSES ");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(140, 51);
$pdf->MultiCell(30,5,"MENGE");
$pdf->SetXY(105, 56);
$pdf->MultiCell(30,5,"ERFORDERT",1);
$pdf->SetXY(135, 56);
$pdf->MultiCell(30,5,"ANNEHMBAR",1);
$pdf->SetXY(165, 56);
$pdf->MultiCell(30,5,"ANHÄNGER*",1);
$pdf->SetXY(105, 61);
$pdf->MultiCell(30,5,$resp["ppk_req"],1);
$pdf->SetXY(135, 61);
$pdf->MultiCell(30,5,$resp["ppk_ace"],1);
$pdf->SetXY(165, 61);
$pdf->MultiCell(30,5,$resp["ppk_pen"],1);
$pdf->SetXY(6, 61);
$pdf->MultiCell(100,5,"Ppk - EIGENSCHAFTEN SPEZIELL");
//linha 4
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(6, 67);
$pdf->MultiCell(100,5,"2. ZUSTIMMUNG DES STEUERPLANES (WENN ERFORDERLICH) ");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(105, 67);
if($resp["pca"]=="1"){ $msg="Ya"; }else{ $msg="Nein"; }
$pdf->MultiCell(15,5,"Anerkan.:");
$pdf->SetXY(120, 67);
$pdf->MultiCell(20,5,$msg);
$pdf->Line(120,72,140,72);
$pdf->SetXY(140, 67);

$pdf->MultiCell(35,5,"Datum Der Zustimmung:");
$pdf->SetXY(170, 77);
$pdf->MultiCell(20,5,banco2data($resp["pca_dt"]));
$pdf->Line(170,72,190,72);
//linha 5
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(6, 79);
$pdf->MultiCell(100,5,"3. KATEGORIE DER EIGENSCHAFTEN DER AUSGANGSPROBE \n VON DER PRODUKTION");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(140, 79);
$pdf->MultiCell(30,5,"MENGE");
$pdf->SetXY(105, 84);
$pdf->MultiCell(22.5,5,"PROBEN",1);
$pdf->SetXY(127.5, 84);
$pdf->MultiCell(22.5,5,"CARACT/",1);
$pdf->SetXY(150, 84);
$pdf->MultiCell(22.5,5,"ANNEHMBAR",1);
$pdf->SetXY(172.5, 84);
$pdf->MultiCell(22.5,5,"ANHÄNGER*",1);
	//linha 1
	$pdf->SetXY(105, 89);
	$pdf->MultiCell(22.5,5,$resp["dim_amo"],1);
	$pdf->SetXY(127.5, 89);
	$pdf->MultiCell(22.5,5,$resp["dim_car"],1);
	$pdf->SetXY(150, 89);
	$pdf->MultiCell(22.5,5,$resp["dim_ace"],1);
	$pdf->SetXY(172.5, 89);
	$pdf->MultiCell(22.5,5,$resp["dim_pen"],1);
	//linha 2
	$pdf->SetXY(105, 94);
	$pdf->MultiCell(22.5,5,$resp["vis_amo"],1);
	$pdf->SetXY(127.5, 94);
	$pdf->MultiCell(22.5,5,$resp["vis_amo"],1);
	$pdf->SetXY(150, 94);
	$pdf->MultiCell(22.5,5,$resp["vis_amo"],1);
	$pdf->SetXY(172.5, 94);
	$pdf->MultiCell(22.5,5,$resp["vis_amo"],1);
	//linha 3
	$pdf->SetXY(105, 99);
	$pdf->MultiCell(22.5,5,$resp["lab_amo"],1);
	$pdf->SetXY(127.5, 99);
	$pdf->MultiCell(22.5,5,$resp["lab_amo"],1);
	$pdf->SetXY(150, 99);
	$pdf->MultiCell(22.5,5,$resp["lab_amo"],1);
	$pdf->SetXY(172.5, 99);
	$pdf->MultiCell(22.5,5,$resp["lab_amo"],1);
	//linha 4
	$pdf->SetXY(105, 104);
	$pdf->MultiCell(22.5,5,$resp["des_amo"],1);
	$pdf->SetXY(127.5, 104);
	$pdf->MultiCell(22.5,5,$resp["des_amo"],1);
	$pdf->SetXY(150, 104);
	$pdf->MultiCell(22.5,5,$resp["des_amo"],1);
	$pdf->SetXY(172.5,104);
	$pdf->MultiCell(22.5,5,$resp["des_amo"],1);
	$pdf->SetXY(6, 89);
$pdf->MultiCell(100,5,"MASSAUSSEHEN-LABORLEISTUNG");
//linha 6
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(6, 111);
$pdf->MultiCell(100,5,"4. ANALYSE DES SYSTEMS DES MASSES DER VORRICHTUNGEN \n UND DER INSTRUMENTE");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(140, 111);
$pdf->MultiCell(30,5,"MENGE");
$pdf->SetXY(105, 116);
$pdf->MultiCell(30,5,"ERFORDERT",1);
$pdf->SetXY(135, 116);
$pdf->MultiCell(30,5,"ANNEHMBAR",1);
$pdf->SetXY(165, 116);
$pdf->MultiCell(30,5,"ANHÄNGER*",1);
$pdf->SetXY(105, 121);
$pdf->MultiCell(30,5,$resp["care_req"],1);
$pdf->SetXY(135, 121);
$pdf->MultiCell(30,5,$resp["care_ace"],1);
$pdf->SetXY(165, 121);
$pdf->MultiCell(30,5,$resp["care_pen"],1);
$pdf->SetXY(6, 121);
$pdf->MultiCell(100,5,"SPEZIELLE EIGENSCHAFT");
//linha 7
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(6, 128);
$pdf->MultiCell(100,5,"5. MONITORAMENTO DES PROZESSES");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(140, 128);
$pdf->MultiCell(30,5,"MENGE");
$pdf->SetXY(105, 133);
$pdf->MultiCell(30,5,"ERFORDERT",1);
$pdf->SetXY(135, 133);
$pdf->MultiCell(30,5,"ANNEHMBAR",1);
$pdf->SetXY(165, 133);
$pdf->MultiCell(30,5,"ANHÄNGER*",1);
	//linha 1
	$pdf->SetXY(105, 138);
	$pdf->MultiCell(30,5,$resp["instm_req"],1);
	$pdf->SetXY(135, 138);
	$pdf->MultiCell(30,5,$resp["instm_ace"],1);
	$pdf->SetXY(165, 138);
	$pdf->MultiCell(30,5,$resp["instm_pen"],1);
	//linha 2
	$pdf->SetXY(105, 143);
	$pdf->MultiCell(30,5,$resp["folha_req"],1);
	$pdf->SetXY(135, 143);
	$pdf->MultiCell(30,5,$resp["folha_ace"],1);
	$pdf->SetXY(165, 143);
	$pdf->MultiCell(30,5,$resp["folha_pen"],1);
	//linha 3
	$pdf->SetXY(105, 148);
	$pdf->MultiCell(30,5,$resp["instv_req"],1);
	$pdf->SetXY(135, 148);
	$pdf->MultiCell(30,5,$resp["instv_ace"],1);
	$pdf->SetXY(165, 148);
	$pdf->MultiCell(30,5,$resp["instv_pen"],1);
$pdf->SetXY(6, 138);
$pdf->MultiCell(105,5,"MONITORAMENTO ANWEISUNGEN PROZESSLEVES \n SICHTBARMACHUNG ANWEISUNGEN");
//linha 8
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(6, 155);
$pdf->MultiCell(100,5,"6. PACKING/EXPEDITION");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(140, 155);
$pdf->MultiCell(30,5,"MENGE");
$pdf->SetXY(105, 160);
$pdf->MultiCell(30,5,"ERFORDERT",1);
$pdf->SetXY(135, 160);
$pdf->MultiCell(30,5,"ANNEHMBAR",1);
$pdf->SetXY(165, 160);
$pdf->MultiCell(30,5,"ANHÄNGER*",1);
	//linha 1
	$pdf->SetXY(105, 165);
	$pdf->MultiCell(30,5,$resp["apro_req"],1);
	$pdf->SetXY(135, 165);
	$pdf->MultiCell(30,5,$resp["apro_ace"],1);
	$pdf->SetXY(165, 165);
	$pdf->MultiCell(30,5,$resp["apro_pen"],1);
	//linha 2
	$pdf->SetXY(105, 170);
	$pdf->MultiCell(30,5,$resp["teste_req"],1);
	$pdf->SetXY(135, 170);
	$pdf->MultiCell(30,5,$resp["teste_ace"],1);
	$pdf->SetXY(165, 170);
	$pdf->MultiCell(30,5,$resp["teste_pen"],1);
$pdf->SetXY(6, 165);
$pdf->MultiCell(100,5,"ZUSTIMMUNG DES VERPACKUNG ANLIEFERUNG TESTS");
//linha 9
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(6, 177);
$pdf->MultiCell(100,5,"7. ZUSTIMMUNG");
$pdf->SetFont('Arial','',8);
	//coluna 1
	$pdf->SetFont('Arial','',8);
	$pdf->SetXY(6, 182);
	$pdf->MultiCell(94,5,$resp["ap1"]." / ".banco2data($resp["dap1"]));
	$pdf->Line(6,187,96,187);
	$pdf->SetXY(5, 188);
	$pdf->MultiCell(100,5,"Mitglied der Mannschaft / Position / Datum");
	$pdf->SetXY(6, 193);
	$pdf->MultiCell(94,5,$resp["ap3"]." / ".banco2data($resp["dap3"]));
	$pdf->Line(6,198,96,198);
	$pdf->SetXY(5, 199);
	$pdf->MultiCell(100,5,"Mitglied der Mannschaft / Position / Datum");
	$pdf->SetXY(6, 206);
	$pdf->MultiCell(94,5,$resp["ap5"]." / ".banco2data($resp["dap5"]));
	$pdf->Line(6,211,96,211);
	$pdf->SetXY(5, 212);
	$pdf->MultiCell(100,5,"Mitglied der Mannschaft / Position / Datum");
	//coluna 2
	$pdf->SetFont('Arial','',8);
	$pdf->SetXY(106, 182);
	$pdf->MultiCell(94,5,$resp["ap2"]." / ".banco2data($resp["dap2"]));
	$pdf->Line(106,187,196,187);
	$pdf->SetXY(105, 188);
	$pdf->MultiCell(100,5,"Mitglied der Mannschaft / Position / Datum");
	$pdf->SetXY(106, 193);
	$pdf->MultiCell(94,5,$resp["ap4"]." / ".banco2data($resp["dap4"]));
	$pdf->Line(106,198,196,198);
	$pdf->SetXY(105, 199);
	$pdf->MultiCell(100,5,"Mitglied der Mannschaft / Position / Datum");
	$pdf->SetXY(106, 206);
	$pdf->MultiCell(94,5,$resp["ap6"]." / ".banco2data($resp["dap6"]));
	$pdf->Line(106,211,196,211);
	$pdf->SetXY(105, 212);
	$pdf->MultiCell(100,5,"Mitglied der Mannschaft / Position / Datum");

	// desenvolvedor
	$pdf->SetFont('Arial','B',5);  
	$pdf->SetXY(168,269);
	$pdf->MultiCell(50,7,"Powered by www.qualitymanager.com.br");

if(!empty($resp["plano"])){
	include('pdf/alemao/apqp_sum_imp2.php');
}
//fim
?>

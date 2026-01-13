<? 
$npc=$_SESSION["npc"];
$sql=mysql_query("SELECT *,apqp_pc.nome AS nome, clientes.fantasia AS nomecli FROM apqp_pc,clientes WHERE apqp_pc.id='$pc' AND apqp_pc.cliente=clientes.id");
$res=mysql_fetch_array($sql);
if(!mysql_num_rows($sql)) exit;
$sql=mysql_query("SELECT * FROM empresa");
if(mysql_num_rows($sql)) $rese=mysql_fetch_array($sql);
$sql=mysql_query("SELECT * FROM apqp_cap WHERE id='$id'");
if(mysql_num_rows($sql)) $resp=mysql_fetch_array($sql);
$sql=mysql_query("SELECT * FROM apqp_car WHERE id='$resp[car]'");
if(mysql_num_rows($sql)) $resc=mysql_fetch_array($sql);

$pdf->AddPage();
$pdf->Image('empresa_logo/logo.jpg',5,1,25);
$pdf->SetXY(5, 1);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(70);
$pdf->Cell(0, 18, 'ESTUDO DE CAPABILIDADE');
$pdf->SetXY(5, 18);
$pdf->SetFont('Arial','',8);
$pdf->SetXY(5, 18);
$pdf->MultiCell(100,5,"Cliente \n $res[nomecli]",1);
$pdf->SetXY(105, 18);
$pdf->MultiCell(50,5,"Número da Peça (cliente) \n $res[pecacli]",1);
$pdf->SetXY(155, 18);
$pdf->MultiCell(50,5,"Rev. / Data do Desenho \n $res[rev] - ".banco2data($res[dtrev])."",1);
//linha 2
$pdf->SetXY(5, 28);
$pdf->MultiCell(100,5,"Fornecedor\n $rese[razao]",1);
$pdf->SetXY(105, 28);
$pdf->MultiCell(100,5,"Nome da Peça \n $res[nome]",1);
//linha 3
$pdf->SetXY(5, 38);
$pdf->MultiCell(100,5,"Realizado \n $resp[quem]",1);
$pdf->SetXY(105, 38);
$pdf->MultiCell(100,5,"Data \n ".banco2data($resp["dtquem"])."",1);
//linha 4
$pdf->SetXY(5, 48);
$pdf->MultiCell(30,5,"Caract Nº \n $resc[numero]",1);
$pdf->SetXY(35, 48);
$pdf->MultiCell(30,5,"Característica \n $resc[descricao]",1);
$pdf->SetXY(65, 48);
$pdf->MultiCell(40,5,"Especificação \n $resc[espec]",1);
$pdf->SetXY(105, 48);
$pdf->MultiCell(55,5,"LIE \n".banco2valor3($resc[lie])."",1);
$pdf->SetXY(205, 48);
$pdf->MultiCell(30,5,"LSE \n".banco2valor3($resc[lse])."",1);
//linha 5
$pdf->SetXY(5, 58);
$pdf->MultiCell(100,5,"Observações \n $resp[obs]",1);
$pdf->SetXY(105, 58);
$pdf->MultiCell(50,5,"Tamanho do Subgrupo \n".completa(5,2)."",1);
$pdf->SetXY(155, 58);
$pdf->MultiCell(50,5,"Qtd. de Grupos \n".completa($resp["nli"],2)."",1);
//linha 6
$pdf->SetXY(5, 75);
$pdf->SetFont('Arial','B',14);
$pdf->MultiCell(205,5,"Médias",0,'C');
$pdf->SetXY(5, 145);
$pdf->MultiCell(205,5,"Amplitudes",0,'C');
$pdf->SetXY(5, 215);
$pdf->MultiCell(205,5,"Histograma",0,'C');
//linha 7
$num_graf=$resp["id"];
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(5, 140);
include('apqp_cap_xbar.php');
$pdf->Image("../imagens_fotos/xgraf$num_graf.png",60,80,100,60);
$pdf->MultiCell(205,5,"X:".banco2valor3($resp["xbar"])."  LICX:".banco2valor3($resp["lcl"])."   LSCX:".banco2valor3($resp["uclx"])."",0,'C');
$pdf->SetXY(5, 210);
include('apqp_cap_rbar.php');
$pdf->Image("../imagens_fotos/rgraf$num_graf.png",60,150,100,60);
$pdf->MultiCell(205,5,"R:".banco2valor3($resp["rmax"]-$resp["rmin"])."  LSCR:".banco2valor3($resp["uclr"])."",0,'C');
include('apqp_cap_hbar.php');
$pdf->Image("../imagens_fotos/hgraf$num_graf.png",60,220,100,60);

	// desenvolvedor
	$pdf->SetFont('Arial','B',5);  
	$pdf->SetXY(168,269);
	$pdf->MultiCell(50,7,"Powered by www.qualitymanager.com.br");
	
//fim
?>

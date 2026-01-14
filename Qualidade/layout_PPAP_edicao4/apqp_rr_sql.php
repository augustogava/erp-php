<?php
include("conecta.php");
$apqp=new set_apqp;
$acao=verifi($permi,$acao);
$pc=$_SESSION["mpc"];
$npc=$_SESSION["npc"];
$quem=$_SESSION["login_nome"];
$user=$_SESSION["login_codigo"];
$hj=date("Y-m-d");
$hora=hora();

// sql para buscar o nome da empresa
$sql_emp=mysql_query("SELECT fantasia FROM empresa");
$res_emp=mysql_fetch_array($sql_emp);
//

if(!empty($acao)){
	$loc="APQP - R&R";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if($acao=="imp"){
	$end="apqp_impressao.php?acao=$acao&local=$local&email=$email&pc=$pc&car=$car";
	header("Location: $end");
	exit;
}
if($acao=="email"){
	$end="apqp_impressao.php?acao=$acao&local=$local&email=$email&pc=$pc&car=$car";
	header("Location: $end");
	exit;
}

		//verificar Cliente
		$apqp->cliente_apro("apqp_rr.php");
		// - - - - - - - -  -
		///Tirar Aprovaçõesss
	$sql=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Estudos de R&R'");
	if(mysql_num_rows($sql)){
			$sqlba=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ<>'Viabilidade' AND ativ<>'Diagrama de Fluxo' AND ativ<>'FMEA de Processo' AND ativ<>'Plano de Controle'");
			while($resba=mysql_fetch_array($sqlba)){
				$sqle=mysql_query("UPDATE apqp_cron SET perc='95',resp='',fim='' WHERE peca='$pc' AND ativ='$resba[ativ]'");
			}	
				//Sub
				$sqll=mysql_query("UPDATE apqp_sub SET sit='N', quem='', dtquem='0000-00-00' WHERE peca='$pc'");
				//Sumario
				$sqlk=mysql_query("UPDATE apqp_sum SET ap1='',ap2='',ap3='',ap4='',ap5='',ap6='', dap1='0000-00-00', dap2='0000-00-00', dap3='0000-00-00', dap4='0000-00-00', dap5='0000-00-00', dap6='0000-00-00' WHERE peca='$pc'");
				//Dimensional
				$sqlj=mysql_query("UPDATE apqp_endi SET sit='N', quem='', dtquem='0000-00-00' WHERE peca='$pc'");
				//material
				$sqli=mysql_query("UPDATE apqp_enma SET sit='N', quem='', dtquem='0000-00-00' WHERE peca='$pc'");
				//CAP
				$sqlh=mysql_query("UPDATE apqp_cap SET sit=0,quem='',dtquem='' WHERE peca='$pc'");
				//RR
				$sqlg=mysql_query("UPDATE apqp_rr SET sit=0,quem='', dtquem='' WHERE peca='$pc'");
	}
// - - - - - - - - - - - - - - - - - - - - - -  --  - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -- - - - - - -


if($acao=="rr2"){
	$dtpor=data2banco($dtpor);
	$a11=valor2banco2($a11);
	$a12=valor2banco2($a12);
	$a13=valor2banco2($a13);
	$a14=valor2banco2($a14);
	$a15=valor2banco2($a15);
	$a16=valor2banco2($a16);
	$a17=valor2banco2($a17);
	$a18=valor2banco2($a18);
	$a19=valor2banco2($a19);
	$a110=valor2banco2($a110);
	$a21=valor2banco2($a21);
	$a22=valor2banco2($a22);
	$a23=valor2banco2($a23);
	$a24=valor2banco2($a24);
	$a25=valor2banco2($a25);
	$a26=valor2banco2($a26);
	$a27=valor2banco2($a27);
	$a28=valor2banco2($a28);
	$a29=valor2banco2($a29);
	$a210=valor2banco2($a210);
	$a31=valor2banco2($a31);
	$a32=valor2banco2($a32);
	$a33=valor2banco2($a33);
	$a34=valor2banco2($a34);
	$a35=valor2banco2($a35);
	$a36=valor2banco2($a36);
	$a37=valor2banco2($a37);
	$a38=valor2banco2($a38);
	$a39=valor2banco2($a39);
	$a310=valor2banco2($a310);
	$b11=valor2banco2($b11);
	$b12=valor2banco2($b12);
	$b13=valor2banco2($b13);
	$b14=valor2banco2($b14);
	$b15=valor2banco2($b15);
	$b16=valor2banco2($b16);
	$b17=valor2banco2($b17);
	$b18=valor2banco2($b18);
	$b19=valor2banco2($b19);
	$b110=valor2banco2($b110);
	$b21=valor2banco2($b21);
	$b22=valor2banco2($b22);
	$b23=valor2banco2($b23);
	$b24=valor2banco2($b24);
	$b25=valor2banco2($b25);
	$b26=valor2banco2($b26);
	$b27=valor2banco2($b27);
	$b28=valor2banco2($b28);
	$b29=valor2banco2($b29);
	$b210=valor2banco2($b210);
	$b31=valor2banco2($b31);
	$b32=valor2banco2($b32);
	$b33=valor2banco2($b33);
	$b34=valor2banco2($b34);
	$b35=valor2banco2($b35);
	$b36=valor2banco2($b36);
	$b37=valor2banco2($b37);
	$b38=valor2banco2($b38);
	$b39=valor2banco2($b39);
	$b310=valor2banco2($b310);
	$c11=valor2banco2($c11);
	$c12=valor2banco2($c12);
	$c13=valor2banco2($c13);
	$c14=valor2banco2($c14);
	$c15=valor2banco2($c15);
	$c16=valor2banco2($c16);
	$c17=valor2banco2($c17);
	$c18=valor2banco2($c18);
	$c19=valor2banco2($c19);
	$c110=valor2banco2($c110);
	$c21=valor2banco2($c21);
	$c22=valor2banco2($c22);
	$c23=valor2banco2($c23);
	$c24=valor2banco2($c24);
	$c25=valor2banco2($c25);
	$c26=valor2banco2($c26);
	$c27=valor2banco2($c27);
	$c28=valor2banco2($c28);
	$c29=valor2banco2($c29);
	$c210=valor2banco2($c210);
	$c31=valor2banco2($c31);
	$c32=valor2banco2($c32);
	$c33=valor2banco2($c33);
	$c34=valor2banco2($c34);
	$c35=valor2banco2($c35);
	$c36=valor2banco2($c36);
	$c37=valor2banco2($c37);
	$c38=valor2banco2($c38);
	$c39=valor2banco2($c39);
	$c310=valor2banco2($c310);
	$npc1=$_REQUEST["npc"];
	//calculo
	if($ncic==2){ $xa1=($a11+$a21)/2; }else{ $xa1=($a11+$a21+$a31)/3; }
	if($ncic==2){ $xa2=($a12+$a22)/2; }else{ $xa2=($a12+$a22+$a32)/3; }
	if($ncic==2){ $xa3=($a13+$a23)/2; }else{ $xa3=($a13+$a23+$a33)/3; }
	if($ncic==2){ $xa4=($a14+$a24)/2; }else{ $xa4=($a14+$a24+$a34)/3; }
	if($ncic==2){ $xa5=($a15+$a25)/2; }else{ $xa5=($a15+$a25+$a35)/3; }
	if($ncic==2){ $xa6=($a16+$a26)/2; }else{ $xa6=($a16+$a26+$a36)/3; }
	if($ncic==2){ $xa7=($a17+$a27)/2; }else{ $xa7=($a17+$a27+$a37)/3; }
	if($ncic==2){ $xa8=($a18+$a28)/2; }else{ $xa8=($a18+$a28+$a38)/3; }
	if($ncic==2){ $xa9=($a19+$a29)/2; }else{ $xa9=($a19+$a29+$a39)/3; }
	if($ncic==2){ $xa10=($a110+$a210)/2; }else{ $xa10=($a110+$a210+$a310)/3; }

	if($ncic==2){ $xb1=($b11+$b21)/2; }else{ $xb1=($b11+$b21+$b31)/3; }
	if($ncic==2){ $xb2=($b12+$b22)/2; }else{ $xb2=($b12+$b22+$b32)/3; }
	if($ncic==2){ $xb3=($b13+$b23)/2; }else{ $xb3=($b13+$b23+$b33)/3; }
	if($ncic==2){ $xb4=($b14+$b24)/2; }else{ $xb4=($b14+$b24+$b34)/3; }
	if($ncic==2){ $xb5=($b15+$b25)/2; }else{ $xb5=($b15+$b25+$b35)/3; }
	if($ncic==2){ $xb6=($b16+$b26)/2; }else{ $xb6=($b16+$b26+$b36)/3; }
	if($ncic==2){ $xb7=($b17+$b27)/2; }else{ $xb7=($b17+$b27+$b37)/3; }
	if($ncic==2){ $xb8=($b18+$b28)/2; }else{ $xb8=($b18+$b28+$b38)/3; }
	if($ncic==2){ $xb9=($b19+$b29)/2; }else{ $xb9=($b19+$b29+$b39)/3; }
	if($ncic==2){ $xb10=($b110+$b210)/2; }else{ $xb10=($b110+$b210+$b310)/3; }
	
	if($ncic==2){ $xc1=($c11+$c21)/2; }else{ $xc1=($c11+$c21+$c31)/3; }
	if($ncic==2){ $xc2=($c12+$c22)/2; }else{ $xc2=($c12+$c22+$c32)/3; }
	if($ncic==2){ $xc3=($c13+$c23)/2; }else{ $xc3=($c13+$c23+$c33)/3; }
	if($ncic==2){ $xc4=($c14+$c24)/2; }else{ $xc4=($c14+$c24+$c34)/3; }
	if($ncic==2){ $xc5=($c15+$c25)/2; }else{ $xc5=($c15+$c25+$c35)/3; }
	if($ncic==2){ $xc6=($c16+$c26)/2; }else{ $xc6=($c16+$c26+$c36)/3; }
	if($ncic==2){ $xc7=($c17+$c27)/2; }else{ $xc7=($c17+$c27+$c37)/3; }
	if($ncic==2){ $xc8=($c18+$c28)/2; }else{ $xc8=($c18+$c28+$c38)/3; }
	if($ncic==2){ $xc9=($c19+$c29)/2; }else{ $xc9=($c19+$c29+$c39)/3; }
	if($ncic==2){ $xc10=($c110+$c210)/2; }else{ $xc10=($c110+$c210+$c310)/3; }
	
	if($ncic==2){ $ra1=max($a11,$a21) - min($a11,$a21); }else{ $ra1=max($a11,$a21,$a31) - min($a11,$a21,$a31); }
	if($ncic==2){ $ra2=max($a12,$a22) - min($a12,$a22); }else{ $ra2=max($a12,$a22,$a32) - min($a12,$a22,$a32); }
	if($ncic==2){ $ra3=max($a13,$a23) - min($a13,$a23); }else{ $ra3=max($a13,$a23,$a33) - min($a13,$a23,$a33); }
	if($ncic==2){ $ra4=max($a14,$a24) - min($a14,$a24); }else{ $ra4=max($a14,$a24,$a34) - min($a14,$a24,$a34); }
	if($ncic==2){ $ra5=max($a15,$a25) - min($a15,$a25); }else{ $ra5=max($a15,$a25,$a35) - min($a15,$a25,$a35); }
	if($ncic==2){ $ra6=max($a16,$a26) - min($a16,$a26); }else{ $ra6=max($a16,$a26,$a36) - min($a16,$a26,$a36); }
	if($ncic==2){ $ra7=max($a17,$a27) - min($a17,$a27); }else{ $ra7=max($a17,$a27,$a37) - min($a17,$a27,$a37); }
	if($ncic==2){ $ra8=max($a18,$a28) - min($a18,$a28); }else{ $ra8=max($a18,$a28,$a38) - min($a18,$a28,$a38); }
	if($ncic==2){ $ra9=max($a19,$a29) - min($a19,$a29); }else{ $ra9=max($a19,$a29,$a39) - min($a19,$a29,$a39); }
	if($ncic==2){ $ra10=max($a110,$a210) - min($a110,$a210); }else{ $ra10=max($a110,$a210,$a310) - min($a110,$a210,$a310); }

	if($ncic==2){ $rb1=max($b11,$b21) - min($b11,$b21); }else{ $rb1=max($b11,$b21,$b31) - min($b11,$b21,$b31); }
	if($ncic==2){ $rb2=max($b12,$b22) - min($b12,$b22); }else{ $rb2=max($b12,$b22,$b32) - min($b12,$b22,$b32); }
	if($ncic==2){ $rb3=max($b13,$b23) - min($b13,$b23); }else{ $rb3=max($b13,$b23,$b33) - min($b13,$b23,$b33); }
	if($ncic==2){ $rb4=max($b14,$b24) - min($b14,$b24); }else{ $rb4=max($b14,$b24,$b34) - min($b14,$b24,$b34); }
	if($ncic==2){ $rb5=max($b15,$b25) - min($b15,$b25); }else{ $rb5=max($b15,$b25,$b35) - min($b15,$b25,$b35); }
	if($ncic==2){ $rb6=max($b16,$b26) - min($b16,$b26); }else{ $rb6=max($b16,$b26,$b36) - min($b16,$b26,$b36); }
	if($ncic==2){ $rb7=max($b17,$b27) - min($b17,$b27); }else{ $rb7=max($b17,$b27,$b37) - min($b17,$b27,$b37); }
	if($ncic==2){ $rb8=max($b18,$b28) - min($b18,$b28); }else{ $rb8=max($b18,$b28,$b38) - min($b18,$b28,$b38); }
	if($ncic==2){ $rb9=max($b19,$b29) - min($b19,$b29); }else{ $rb9=max($b19,$b29,$b39) - min($b19,$b29,$b39); }
	if($ncic==2){ $rb10=max($b110,$b210) - min($b110,$b210); }else{ $rb10=max($b110,$b210,$b310) - min($b110,$b210,$b310); }

	if($ncic==2){ $rc1=max($c11,$c21) - min($c11,$c21); }else{ $rc1=max($c11,$c21,$c31) - min($c11,$c21,$c31); }
	if($ncic==2){ $rc2=max($c12,$c22) - min($c12,$c22); }else{ $rc2=max($c12,$c22,$c32) - min($c12,$c22,$c32); }
	if($ncic==2){ $rc3=max($c13,$c23) - min($c13,$c23); }else{ $rc3=max($c13,$c23,$c33) - min($c13,$c23,$c33); }
	if($ncic==2){ $rc4=max($c14,$c24) - min($c14,$c24); }else{ $rc4=max($c14,$c24,$c34) - min($c14,$c24,$c34); }
	if($ncic==2){ $rc5=max($c15,$c25) - min($c15,$c25); }else{ $rc5=max($c15,$c25,$c35) - min($c15,$c25,$c35); }
	if($ncic==2){ $rc6=max($c16,$c26) - min($c16,$c26); }else{ $rc6=max($c16,$c26,$c36) - min($c16,$c26,$c36); }
	if($ncic==2){ $rc7=max($c17,$c27) - min($c17,$c27); }else{ $rc7=max($c17,$c27,$c37) - min($c17,$c27,$c37); }
	if($ncic==2){ $rc8=max($c18,$c28) - min($c18,$c28); }else{ $rc8=max($c18,$c28,$c38) - min($c18,$c28,$c38); }
	if($ncic==2){ $rc9=max($c19,$c29) - min($c19,$c29); }else{ $rc9=max($c19,$c29,$c39) - min($c19,$c29,$c39); }
	if($ncic==2){ $rc10=max($c110,$c210) - min($c110,$c210); }else{ $rc10=max($c110,$c210,$c310) - min($c110,$c210,$c310); }

	if($npc1==1){
		$xa11=$xa1;
		$xb11=$xb1;
		$xc11=$xc1;
		$ra11=$ra1;
		$rb11=$rb1;
		$rc11=$rc1;
	}elseif($npc1==2){
		$xa11=($xa1+$xa2)/2;
		$xb11=($xb1+$xb2)/2;
		$xc11=($xc1+$xc2)/2;
		$ra11=($ra1+$ra2)/2;
		$rb11=($rb1+$rb2)/2;
		$rc11=($rc1+$rc2)/2;	
	}elseif($npc1==3){
		$xa11=($xa1+$xa2+$xa3)/3;
		$xb11=($xb1+$xb2+$xb3)/3;
		$xc11=($xc1+$xc2+$xc3)/3;
		$ra11=($ra1+$ra2+$ra3)/3;
		$rb11=($rb1+$rb2+$rb3)/3;
		$rc11=($rc1+$rc2+$rc3)/3;
	}elseif($npc1==4){
		$xa11=($xa1+$xa2+$xa3+$xa4)/4;
		$xb11=($xb1+$xb2+$xb3+$xb4)/4;
		$xc11=($xc1+$xc2+$xc3+$xc4)/4;
		$ra11=($ra1+$ra2+$ra3+$ra4)/4;
		$rb11=($rb1+$rb2+$rb3+$rb4)/4;
		$rc11=($rc1+$rc2+$rc3+$rc4)/4;
	}elseif($npc1==5){
		$xa11=($xa1+$xa2+$xa3+$xa4+$xa5)/5;
		$xb11=($xb1+$xb2+$xb3+$xb4+$xb5)/5;
		$xc11=($xc1+$xc2+$xc3+$xc4+$xc5)/5;
		$ra11=($ra1+$ra2+$ra3+$ra4+$ra5)/5;
		$rb11=($rb1+$rb2+$rb3+$rb4+$rb5)/5;
		$rc11=($rc1+$rc2+$rc3+$rc4+$rc5)/5;
	}elseif($npc1==6){
		$xa11=($xa1+$xa2+$xa3+$xa4+$xa5+$xa6)/6;
		$xb11=($xb1+$xb2+$xb3+$xb4+$xb5+$xb6)/6;
		$xc11=($xc1+$xc2+$xc3+$xc4+$xc5+$xc6)/6;
		$ra11=($ra1+$ra2+$ra3+$ra4+$ra5+$ra6)/6;
		$rb11=($rb1+$rb2+$rb3+$rb4+$rb5+$rb6)/6;
		$rc11=($rc1+$rc2+$rc3+$rc4+$rc5+$rc6)/6;
	}elseif($npc1==7){
		$xa11=($xa1+$xa2+$xa3+$xa4+$xa5+$xa6+$xa7)/7;
		$xb11=($xb1+$xb2+$xb3+$xb4+$xb5+$xb6+$xb7)/7;
		$xc11=($xc1+$xc2+$xc3+$xc4+$xc5+$xc6+$xc7)/7;
		$ra11=($ra1+$ra2+$ra3+$ra4+$ra5+$ra6+$ra7)/7;
		$rb11=($rb1+$rb2+$rb3+$rb4+$rb5+$rb6+$rb7)/7;
		$rc11=($rc1+$rc2+$rc3+$rc4+$rc5+$rc6+$rc7)/7;
	}elseif($npc1==8){
		$xa11=($xa1+$xa2+$xa3+$xa4+$xa5+$xa6+$xa7+$xa8)/8;
		$xb11=($xb1+$xb2+$xb3+$xb4+$xb5+$xb6+$xb7+$xb8)/8;
		$xc11=($xc1+$xc2+$xc3+$xc4+$xc5+$xc6+$xc7+$xc8)/8;
		$ra11=($ra1+$ra2+$ra3+$ra4+$ra5+$ra6+$ra7+$ra8)/8;
		$rb11=($rb1+$rb2+$rb3+$rb4+$rb5+$rb6+$rb7+$rb8)/8;
		$rc11=($rc1+$rc2+$rc3+$rc4+$rc5+$rc6+$rc7+$rc8)/8;
	}elseif($npc1==9){
		$xa11=($xa1+$xa2+$xa3+$xa4+$xa5+$xa6+$xa7+$xa8+$xa9)/9;
		$xb11=($xb1+$xb2+$xb3+$xb4+$xb5+$xb6+$xb7+$xb8+$xb9)/9;
		$xc11=($xc1+$xc2+$xc3+$xc4+$xc5+$xc6+$xc7+$xc8+$xc9)/9;
		$ra11=($ra1+$ra2+$ra3+$ra4+$ra5+$ra6+$ra7+$ra8+$ra9)/9;
		$rb11=($rb1+$rb2+$rb3+$rb4+$rb5+$rb6+$rb7+$rb8+$rb9)/9;
		$rc11=($rc1+$rc2+$rc3+$rc4+$rc5+$rc6+$rc7+$rc8+$rc9)/9;
	}elseif($npc1==10){
		$xa11=($xa1+$xa2+$xa3+$xa4+$xa5+$xa6+$xa7+$xa8+$xa9+$xa10)/10;
		$xb11=($xb1+$xb2+$xb3+$xb4+$xb5+$xb6+$xb7+$xb8+$xb9+$xb10)/10;
		$xc11=($xc1+$xc2+$xc3+$xc4+$xc5+$xc6+$xc7+$xc8+$xc9+$xc10)/10;
		$ra11=($ra1+$ra2+$ra3+$ra4+$ra5+$ra6+$ra7+$ra8+$ra9+$ra10)/10;
		$rb11=($rb1+$rb2+$rb3+$rb4+$rb5+$rb6+$rb7+$rb8+$rb9+$rb10)/10;
		$rc11=($rc1+$rc2+$rc3+$rc4+$rc5+$rc6+$rc7+$rc8+$rc9+$rc10)/10;
	}
		//xp table
	if($nop==2){ $xp1=($xa1+$xb1)/2; }else{ $xp1=($xa1+$xb1+$xc1)/3; }
	if($nop==2){ $xp2=($xa2+$xb2)/2; }else{ $xp2=($xa2+$xb2+$xc2)/3; }
	if($nop==2){ $xp3=($xa3+$xb3)/2; }else{ $xp3=($xa3+$xb3+$xc3)/3; }
	if($nop==2){ $xp4=($xa4+$xb4)/2; }else{ $xp4=($xa4+$xb4+$xc4)/3; }
	if($nop==2){ $xp5=($xa5+$xb5)/2; }else{ $xp5=($xa5+$xb5+$xc5)/3; }
	if($nop==2){ $xp6=($xa6+$xb6)/2; }else{ $xp6=($xa6+$xb6+$xc6)/3; }
	if($nop==2){ $xp7=($xa7+$xb7)/2; }else{ $xp7=($xa7+$xb7+$xc7)/3; }
	if($nop==2){ $xp8=($xa8+$xb8)/2; }else{ $xp8=($xa8+$xb8+$xc8)/3; }
	if($nop==2){ $xp9=($xa9+$xb9)/2; }else{ $xp9=($xa9+$xb9+$xc9)/3; }
	if($nop==2){ $xp10=($xa10+$xb10)/2; }else{ $xp10=($xa10+$xb10+$xc10)/3; }
	if($nop==2){ $xp11=($xa11+$xb11)/2; }else{ $xp11=($xa11+$xb11+$xc11)/3; }
		//average(xbar)
	if($nop==2){ $average=($xa11+$xb11)/2; }else{ $average=($xa11+$xb11+$xc11)/3; }
		//rbar
	if($nop==2){ $rbar=($ra11+$rb11)/2; }else{ $rbar=($ra11+$rb11+$rc11)/3; }
		//lcl(xbar)
	if($ncic==2){ $lcl=$average-$rbar*1.88; }else{ $lcl=$average-$rbar*1.023; }	
		//ucl(xbar)
	if($ncic==2){ $uclx=$average+$rbar*1.88; }else{ $uclx=$average+$rbar*1.023; }	
		//ucl(rbar)
	if($ncic==2){ $uclr=$rbar*3.27; }else{ $uclr=$rbar*2.58; }	
		//v4
	$v4=max($xp1,$xp2,$xp3,$xp4,$xp5,$xp6,$xp7,$xp8,$xp9,$xp10)-min($xp1,$xp2,$xp3,$xp4,$xp5,$xp6,$xp7,$xp8,$xp9,$xp10);
		//v5
	if($nop==2){
		$v5=max($xa11,$xb11)-min($xa11,$xb11);
	}else{
		$v5=max($xa11,$xb11,$xc11)-min($xa11,$xb11,$xc11);
	}
		//v6
	if($ncic==2){ $v6=$ed/1.128; }else{ $v6=$ed/1.693; }	
		//v7
	if($nop==2){ $v7=3.65; }else{ $v7=2.7; }	
		//w8
	if($npc1==7){ $w8=1.82; 
	}elseif($npc1==8){ $w8=1.74; 
	}elseif($npc1==9){ $w8=1.67; 
	}elseif($npc1==10){ $w8=1.62; }	
		//v8
	if($npc1==2){ $v8=3.65; 
	}elseif($npc1==3){ $v8=2.7; 
	}elseif($npc1==4){ $v8=2.3; 
	}elseif($npc1==5){ $v8=2.08; 
	}elseif($npc1==6){ $v8=1.93;
	}elseif($npc1==7){ $v8=1.82;
	}elseif($npc1==8){ $v8=1.74;
	}elseif($npc1==9){ $v8=1.67;
	}elseif($npc1==10){ $v8=1.62; }	
	//A PF
	$apf=0;
	for($e=1;$e<=3;$e++){
		for($i=1;$i<=10;$i++){
			if($e==1) $lbl="a";
			if($e==2) $lbl="b";
			if($e==3) $lbl="c";
				eval("\$v=\$r$lbl$i;");
					if(($v>$uclr) or ($v<0)){
						$apf++;
					}
		}
	}
	//M PF
	$mpf=0;
	for($e=1;$e<=3;$e++){
		for($i=1;$i<=10;$i++){
			if($e==1) $lbl="a";
			if($e==2) $lbl="b";
			if($e==3) $lbl="c";
				eval("\$v=\$x$lbl$i;");
					if(($v>$lcl) and ($v<$uclx)){
						$mpf++;
					}
		}
	}
			$bs=20-$mpf;
			$mpf=(100*$bs)/20;
		//EV
	$ev=$v6*$rbar;
		//OV
	if((pow(($v5*$v7),2)-(pow($ev,2)/$npc1/$ncic))<0){
		$ov=0;
	}else{
		$ov=sqrt(pow(($v5*$v7),2)-(pow($ev,2)/$npc1/$ncic));
	}
		//R&R
	$rr=pow(pow($ev,2)+pow($ov,2),0.5);
		//PV
	$pv=$v4*$v8;
		//TV
	$tv=pow(pow($rr,2)+pow($pv,2),0.5);
		//%EV
	$pev=$ev/$tv*100;
		//%OV
	$pov=$ov/$tv*100;
		//%R&R
	$prr=$rr/$tv*100;
		//%PV
	$ppv=$pv/$tv*100;
	//calculo
/*
	print "
	xp1=$xp1<br>
	xp2=$xp2<br>
	xp3=$xp3<br>
	xp4=$xp4<br>
	xp5=$xp5<br>
	xp6=$xp6<br>
	xp7=$xp7<br>
	xp8=$xp8<br>
	xp9=$xp9<br>
	xp10=$xp10<br>
	average=$average<br>
	rbar=$rbar<br>
	lcl=$lcl<br>
	uclx=$uclx<br>
	uclr=$uclr<br>
	v4=$v4<br>
	v5=$v5<br>
	v6=$v6<br>
	v7=$v7<br>
	v8=$v8<br>
	w8=$w8<br>
	v5=$v5<br>
	ev=$ev<br>
	ov=$ov<br>
	rr=$rr<br>
	pv=$pv<br>
	tv=$tv<br>
	";
	exit;
*/
	$sql=mysql_query("UPDATE apqp_rr SET dispno='$dispno',dispnu='$dispnu',por='$por',dtpor='$dtpor',obs='$obs',nop='$nop',ncic='$ncic',npc='$npc1',apf='$apf',mpf='$mpf'
	,a11='$a11',a21='$a21',a31='$a31'
	,a12='$a12',a22='$a22',a32='$a32'
	,a13='$a13',a23='$a23',a33='$a33'
	,a14='$a14',a24='$a24',a34='$a34'
	,a15='$a15',a25='$a25',a35='$a35'
	,a16='$a16',a26='$a26',a36='$a36'
	,a17='$a17',a27='$a27',a37='$a37'
	,a18='$a18',a28='$a28',a38='$a38'
	,a19='$a19',a29='$a29',a39='$a39'
	,a110='$a110',a210='$a210',a310='$a310'
	,b11='$b11',b21='$b21',b31='$b31'
	,b12='$b12',b22='$b22',b32='$b32'
	,b13='$b13',b23='$b23',b33='$b33'
	,b14='$b14',b24='$b24',b34='$b34'
	,b15='$b15',b25='$b25',b35='$b35'
	,b16='$b16',b26='$b26',b36='$b36'
	,b17='$b17',b27='$b27',b37='$b37'
	,b18='$b18',b28='$b28',b38='$b38'
	,b19='$b19',b29='$b29',b39='$b39'
	,b110='$b110',b210='$b210',b310='$b310'
	,c11='$c11',c21='$c21',c31='$c31'
	,c12='$c12',c22='$c22',c32='$c32'
	,c13='$c13',c23='$c23',c33='$c33'
	,c14='$c14',c24='$c24',c34='$c34'
	,c15='$c15',c25='$c25',c35='$c35'
	,c16='$c16',c26='$c26',c36='$c36'
	,c17='$c17',c27='$c27',c37='$c37'
	,c18='$c18',c28='$c28',c38='$c38'
	,c19='$c19',c29='$c29',c39='$c39'
	,c110='$c110',c210='$c210',c310='$c310'
	,xa1='$xa1',xa2='$xa2',xa3='$xa3',xa4='$xa4',xa5='$xa5',xa6='$xa6',xa7='$xa7',xa8='$xa8',xa9='$xa9',xa10='$xa10'
	,xb1='$xb1',xb2='$xb2',xb3='$xb3',xb4='$xb4',xb5='$xb5',xb6='$xb6',xb7='$xb7',xb8='$xb8',xb9='$xb9',xb10='$xb10'
	,xc1='$xc1',xc2='$xc2',xc3='$xc3',xc4='$xc4',xc5='$xc5',xc6='$xc6',xc7='$xc7',xc8='$xc8',xc9='$xc9',xc10='$xc10'
	,ra1='$ra1',ra2='$ra2',ra3='$ra3',ra4='$ra4',ra5='$ra5',ra6='$ra6',ra7='$ra7',ra8='$ra8',ra9='$ra9',ra10='$ra10'
	,rb1='$rb1',rb2='$rb2',rb3='$rb3',rb4='$rb4',rb5='$rb5',rb6='$rb6',rb7='$rb7',rb8='$rb8',rb9='$rb9',rb10='$rb10'
	,rc1='$rc1',rc2='$rc2',rc3='$rc3',rc4='$rc4',rc5='$rc5',rc6='$rc6',rc7='$rc7',rc8='$rc8',rc9='$rc9',rc10='$rc10'
	,ev='$ev',ov='$ov',rr='$rr',pv='$pv',tv='$tv'
	,pev='$pev',pov='$pov',prr='$prr',ppv='$ppv'
	,average='$average',lcl='$lcl',uclx='$uclx',rbar='$rbar',uclr='$uclr',ed='$ed'
	WHERE id='$id'");
	$sql=mysql_query("UPDATE apqp_car SET disp='0',quem='', dtquem='' WHERE id='$car'");
	if($sql){
		$_SESSION["mensagem"]="Alterações salvas com sucesso";
		// cria followup caso salve o conteudo do Estudo de R&R
			$sql_sal=mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Salvando alterações do Estudo de R&R da peça $npc.','O usuário $quem salvou as alterações do Estudo de R&R da peça $npc.','$user')");
		//	
	}else{
		$_SESSION["mensagem"]="As alterações não puderam ser salvas";
	}	
	header("location:apqp_rr3.php?car=$car");
}elseif($acao=="rr3"){
	if(isset($apro)){
		//finalizar tarefa!!! - - - - - - - 
		$apqp->agenda("Estudos de R&R");
		// - - - - - - - -  - - - - - - - - 
		if(empty($tap123)){
			$tap123=$quem;
		}
		$sql=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Plano de Controle'");
		if(!mysql_num_rows($sql)){
			$_SESSION["mensagem"]="Não pode ser aprovado pois existem relatórios anteriores abertos!!";
			header("Location:apqp_rr3.php?car=$car");
			exit;
		}
		$sql=mysql_query("UPDATE apqp_cron SET resp='$tap123',fim=NOW(),perc='100' WHERE ativ='Estudos de R&R' AND peca='$pc'");
			$_SESSION["mensagem"]="Aprovado com Sucesso!";
			// cria followup caso aprove o conteudo do Estudo de R&R 
				$sql_ap=mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Aprovação do Estudo de R&R da peça $npc.','O usuário $quem aprovou o Estudo de R&R da peça $npc.','$user')");
			header("Location:apqp_rr3.php?car=$car");
			exit;
	}	
	if(isset($lim)){
			$sql=mysql_query("UPDATE apqp_cron SET resp='$tap123',fim=NOW(),perc='95' WHERE ativ='Estudos de R&R' AND peca='$pc'");
			// cria followup caso remova a aprovação do R&R e mude o status
				mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Removendo a aprovação R&R da peça $npc.','O usuário $quem removeu a aprovação da peça $npc devido a remoção da aprovação do Estudo de R&R.','$user')");
			// EMAIL	
				$apqp->set_email("Remoção da aprovação da peça $npc.","O usuário $quem removeu a aprovação da peça $this->npc devido a remoção da aprovação do Estudo de R&R.");
				$apqp->email();
			$_SESSION["mensagem"]="Aprovação excluída com sucesso!";
			// cria followup caso remove a aprovação do Estudo de R&R 
			mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Removendo aprovação da Característica no R&R da peça $npc.','O usuário $quem removeu a aprovação do Estudo de R&R da peça $npc.','$user')");	
		
		//$sql=mysql_query("UPDATE apqp_cron SET resp='',fim='',perc='95' WHERE ativ='Estudos de R&R' AND peca='$pc'");
		$sql=mysql_query("UPDATE apqp_car SET disp='0',quem='', dtquem='' WHERE id='$car'");
		header("Location:apqp_rr3.php?car=$car");
		exit;
	}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	if(isset($rep)){
		$sql=mysql_query("UPDATE apqp_rr SET sit=2 WHERE id='$id'");
		$sql=mysql_query("UPDATE apqp_car SET disp='2',quem='$tap123',dtquem=NOW() WHERE id='$car'");
		$_SESSION["mensagem"]="Reprovado com Sucesso!";
		// cria followup caso reprove o conteudo do Estudo de R&R 
			$sql_ap=mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Reprovação da Característica no R&R da peça $npc.','O usuário $quem reprovou o Estudo da Característica no R&R peça $npc.','$user')");
		//	
		header("Location:apqp_rr3.php?car=$car");
		exit;
	}
	if(isset($lap2)){
		if(empty($tap123)){
			$tap123=$quem;
		}
		$sql=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Plano de Controle'");
		if(!mysql_num_rows($sql)){
			$_SESSION["mensagem"]="Não pode ser aprovado pois existem relatórios anteriores abertos!!";
			header("Location:apqp_rr3.php?car=$car");
			exit;
		}
		//$sql=mysql_query("UPDATE apqp_cron SET resp='$tap123',fim=NOW(),perc='100' WHERE ativ='Estudos de R&R' AND peca='$pc'");
			$sql=mysql_query("UPDATE apqp_car SET disp='1',quem='$tap123', dtquem=NOW() WHERE id='$car'");
			$sql=mysql_query("UPDATE apqp_rr SET sit=2 WHERE id='$id'");
			$_SESSION["mensagem"]="Aprovado com Sucesso!";
			// cria followup caso aprove o conteudo do Estudo de R&R 
				$sql_ap=mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Aprovação da Característica no R&R da peça $npc.','O usuário $quem aprovou o Estudo de R&R da peça $npc.','$user')");
			header("Location:apqp_rr3.php?car=$car");
			exit;
	}	
	if(isset($lpt)){
			// cria followup caso remova a aprovação do R&R e mude o status
				mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Removendo a aprovação da Característica no R&R da peça $npc.','O usuário $quem removeu a aprovação da peça $npc devido a remoção da aprovação da Característica no R&R','$user')");
			// EMAIL	
				$apqp->set_email("Remoção da aprovação da peça $npc.","O usuário $quem removeu a aprovação da peça $this->npc devido a remoção da aprovação da Característica no R&R");
				$apqp->email();
			$_SESSION["mensagem"]="Aprovação excluída com sucesso!";
			// cria followup caso remove a aprovação do Estudo de R&R 
			mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Removendo aprovação da Característica no R&R da peça $npc.','O usuário $quem removeu a aprovação da Característica no R&R da peça $npc.','$user')");	
		
		//$sql=mysql_query("UPDATE apqp_cron SET resp='',fim='',perc='95' WHERE ativ='Estudos de R&R' AND peca='$pc'");
		$sql=mysql_query("UPDATE apqp_rr SET sit=0 WHERE id='$id'");
		$sql=mysql_query("UPDATE apqp_car SET disp='0',quem='', dtquem='' WHERE id='$car'");
		header("Location:apqp_rr3.php?car=$car");
		exit;
	}
	header("location:apqp_rr3.php?car=$car");
}
?>
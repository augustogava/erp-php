<?php
include("conecta.php");
include("seguranca.php");
?>
<html>
<head>
<title>Calendário</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script language="JavaScript">

// posiciona a janela popup 
<?php	switch ($window_position){
		case "metr_instr_cad": ?>
			windowWidth=530;
			windowHeight=270;
<?php			break;
		case "apqp_pc_inc_1":  ?>
			windowWidth=-173;
			windowHeight=633;			
<?php			break;	
		case "apqp_pc_inc_2":	?>
			windowWidth=-173;
			windowHeight=261;
<?php			break;	
		case "apqp_pc2_1":	?>
			windowWidth=-173;
			windowHeight=633;		
<?php			break;	
		case "apqp_pc2_2":	?>						
			windowWidth=-173;
			windowHeight=261;
<?php			break;	
		case "apqp_pc2_3":	?>						
			windowWidth=-173;
			windowHeight=231;
<?php			break;	
		case "apqp_fmeaprojc_1":	?>						
			windowWidth=455;
			windowHeight=545;
<?php			break;	
		case "apqp_fmeaprojc_2":	?>						
			windowWidth=-30;
			windowHeight=545;
<?php			break;	
		case "apqp_fmeaprojc_3":	?>						
			windowWidth=-465;
			windowHeight=545;
<?php			break;	
		case "apqp_viabilidade3":	?>						
			windowWidth=555;
			windowHeight=355;
<?php			break;	
		case "apqp_fmeaprocc_1":	?>						
			windowWidth=520;
			windowHeight=530;
<?php			break;	
		case "apqp_fmeaprocc_2":	?>						
			windowWidth=100;
			windowHeight=530;
<?php			break;	
		case "apqp_fmeaprocc_3":	?>						
			windowWidth=-270;
			windowHeight=530;
<?php			break;	
		case "apqp_planoc_1":	?>						
			windowWidth=340;
			windowHeight=525;
<?php			break;	
		case "apqp_planoc_2":	?>						
			windowWidth=-270;
			windowHeight=525;
<?php			break;	
		case "apqp_inst1_1":	?>						
			windowWidth=-275;
			windowHeight=450;
<?php			break;	
		case "apqp_inst1_2":	?>						
			windowWidth=-275;
			windowHeight=400;
<?php			break;	
		case "apqp_rr2":	?>						
			windowWidth=-280;
			windowHeight=450;
<?php			break;	
		case "apqp_cap2":	?>						
			windowWidth=-230;
			windowHeight=380;
<?php			break;	
		case "apqp_aproc":	?>						
			windowWidth=-250;
			windowHeight=550;
<?php			break;	
		case "apqp_sub1_1":	?>						
			windowWidth=-320;
			windowHeight=250;
<?php			break;	
		case "apqp_sub1_2":	?>						
			windowWidth=-320;
			windowHeight=200;
<?php			break;	
		case "apqp_sub1_3":	?>						
			windowWidth=-280;
			windowHeight=-150;
<?php			break;	
		case "apqp_sum1_1":	?>						
			windowWidth=610;
			windowHeight=550;
<?php			break;	
		case "apqp_sum1_2":	?>						
			windowWidth=-240;
			windowHeight=270;
<?php			break;	
		case "apqp_apro_int1":	?>						
			windowWidth=-5;
			windowHeight=180;
<?php			break;	
		case "apqp_fmeacad_inc_1":	?>						
			windowWidth=500;
			windowHeight=540;
<?php			break;	
		case "apqp_fmeacad_inc_2":	?>						
			windowWidth=-85;
			windowHeight=540;			
<?php			break;	
		case "metr_cali_inc_1":	?>						
			windowWidth=-230;
			windowHeight=445;			
<?php			break;	
		case "metr_cali_inc_2":	?>						
			windowWidth=500;
			windowHeight=-60;			
<?php			break;	
		case "insm_cad":	?>						
			windowWidth=-90;
			windowHeight=490;				
<?php			break;	
		case "metr_lab_cad":	?>						
			windowWidth=120;
			windowHeight=640;	
<?php			break;	
		case "metr_pab_cad":	?>						
			windowWidth=410;
			windowHeight=220;	
<?php			break;	
		case "vda_foc_apro_1":	?>						
			windowWidth=-190;
			windowHeight=330;	
<?php			break;	
		case "vda_foc_apro_2":	?>						
			windowWidth=-190;
			windowHeight=-70;	
<?php			break;	
		case "rec_entrega_1":	?>						
			windowWidth=710;
			windowHeight=490;	
<?php			break;	
		case "rec_entrega_2":	?>						
			windowWidth=-300;
			windowHeight=410;	
<?php			break;	
		case "rec_skip_lote1":	?>						
			windowWidth=270;
			windowHeight=405;	
<?php			break;	
		case "rec_skip_lote2":	?>						
			windowWidth=270;
			windowHeight=405;	
<?php			break;	
		case "rec_fiti_geral_1":	?>						
			windowWidth=350;
			windowHeight=450;	
<?php			break;	
		case "rec_fiti_geral_2":	?>						
			windowWidth=350;
			windowHeight=400;	
<?php			break;	
		case "rec_cad2_1":	?>						
			windowWidth=350;
			windowHeight=400;	
<?php			break;	
		case "rec_cad2_2":	?>						
			windowWidth=350;
			windowHeight=400;	
<?php			break;	
		case "rec_cad2_3":	?>						
			windowWidth=350;
			windowHeight=400;	
<?php			break;	
		case "rec_cad_1":	?>						
			windowWidth=350;
			windowHeight=400;	

<?php			break;	
	}
?>

if (parseInt(navigator.appVersion) >= 4) window.moveTo((screen.width/2)-(windowWidth/2+10),(screen.height/2)-(windowHeight/2+20));
//

<?php	switch ($window_position){
		case "metr_instr_cad": ?>
			function passa(parametro){
				opener.form1.data1.value=parametro;
				window.close();
			}
<?php			break;
		case "apqp_pc_inc_1":  ?>
			function passa(parametro){
				opener.form1.dtrev.value=parametro;
				window.close();
			}
<?php			break;	
		case "apqp_pc_inc_2":	?>
			function passa(parametro){
				opener.form1.dteng.value=parametro;
				window.close();
			}
<?php			break;
		case "apqp_pc2_1":	?>
			function passa(parametro){
				opener.form1.dtrev.value=parametro;
				window.close();
			}
<?php			break;	
		case "apqp_pc2_2":	?>						
			function passa(parametro){
				opener.form1.dteng.value=parametro;
				window.close();
			}			
<?php			break;	
		case "apqp_pc2_3":	?>						
			function passa(parametro){
				opener.form1.dtproj.value=parametro;
				window.close();
			}			
<?php			break;	
		case "apqp_fmeaprojc_1":	?>						
			function passa(parametro){
				opener.form1.ini.value=parametro;
				window.close();
			}			
<?php			break;	
		case "apqp_fmeaprojc_2":	?>						
			function passa(parametro){
				opener.form1.rev.value=parametro;
				window.close();
			}			
<?php			break;	
		case "apqp_fmeaprojc_3":	?>						
			function passa(parametro){
				opener.form1.chv.value=parametro;
				window.close();
			}			
<?php			break;	
		case "apqp_viabilidade3":	?>						
			function passa(parametro){
				opener.form1.data.value=parametro;
				window.close();
			}			
<?php			break;	
		case "apqp_fmeaprocc_1":	?>						
			function passa(parametro){
				opener.form1.ini.value=parametro;
				window.close();
			}			
<?php			break;	
		case "apqp_fmeaprocc_2":	?>						
			function passa(parametro){
				opener.form1.rev.value=parametro;
				window.close();
			}			
<?php			break;	
		case "apqp_fmeaprocc_3":	?>						
			function passa(parametro){
				opener.form1.chv.value=parametro;
				window.close();
			}			
<?php			break;	
		case "apqp_planoc_1":	?>						
			function passa(parametro){
				opener.form1.ini.value=parametro;
				window.close();
			}			
<?php			break;	
		case "apqp_planoc_2":	?>						
			function passa(parametro){
				opener.form1.rev.value=parametro;
				window.close();
			}			
<?php			break;	
		case "apqp_inst1_1":	?>						
			function passa(parametro){
				opener.form1.prep_data.value=parametro;
				window.close();
			}			
<?php			break;	
		case "apqp_inst1_2":	?>						
			function passa(parametro){
				opener.form1.rev_data.value=parametro;
				window.close();
			}			
<?php			break;	
		case "apqp_rr2":	?>						
			function passa(parametro){
				opener.form1.dtpor.value=parametro;
				window.close();
			}			
<?php			break;	
		case "apqp_cap2":	?>						
			function passa(parametro){
				opener.form1.dtpor.value=parametro;
				window.close();
			}			
<?php			break;	
		case "apqp_aproc":	?>						
			function passa(parametro){
				opener.form1.data.value=parametro;
				window.close();
			}			
<?php			break;	
		case "apqp_sub1_1":	?>						
			function passa(parametro){
				opener.form1.dteng.value=parametro;
				window.close();
			}			
<?php			break;	
		case "apqp_sub1_2":	?>						
			function passa(parametro){
				opener.form1.dtalteng.value=parametro;
				window.close();
			}			
<?php			break;	
		case "apqp_sub1_3":	?>						
			function passa(parametro){
				opener.form1.aux_data.value=parametro;
				window.close();
			}			
<?php			break;	
		case "apqp_sum1_1":	?>						
			function passa(parametro){
				opener.form1.data.value=parametro;
				window.close();
			}			
<?php			break;	
		case "apqp_sum1_2":	?>						
			function passa(parametro){
				opener.form1.pca_dt.value=parametro;
				window.close();
			}			
<?php			break;	
		case "apqp_apro_int1":	?>						
			function passa(parametro){
				opener.form1.data.value=parametro;
				window.close();
			}			
<?php			break;	
		case "apqp_fmeacad_inc_1":	?>						
			function passa(parametro){
				opener.form1.dt_inicio.value=parametro;
				window.close();
			}			
<?php			break;	
		case "apqp_fmeacad_inc_2":	?>						
			function passa(parametro){
				opener.form1.dt_revisao.value=parametro;
				window.close();
			}			
<?php			break;	
		case "metr_cali_inc_1":	?>						
			function passa(parametro){
				opener.form1.emitido.value=parametro;
				window.close();
			}			
<?php			break;	
		case "metr_cali_inc_2":	?>						
			function passa(parametro){
				opener.form1.data_usoi.value=parametro;
				window.close();
			}			
<?php			break;	
		case "insm_cad":	?>						
			function passa(parametro){
				opener.form1.data2.value=parametro;
				window.close();
			}			
<?php			break;	
		case "metr_lab_cad":	?>						
			function passa(parametro){
				opener.form1.data1.value=parametro;
				window.close();
			}			
<?php			break;	
		case "metr_pab_cad":	?>			
			function passa(parametro){
				opener.form1.datc.value=parametro;
				window.close();
			}			
<?php			break;	
		case "vda_foc_apro_1":	?>						
			function passa(parametro){
				opener.form1.fdata.value=parametro;
				window.close();
			}			
<?php			break;	
		case "vda_foc_apro_2":	?>						
			function passa(parametro){
				opener.form1.cdat.value=parametro;
				window.close();
			}			
<?php			break;	
		case "rec_entrega_1":	?>						
			function passa(parametro){
				opener.form1.data.value=parametro;
				window.close();
			}			
<?php			break;	
		case "rec_entrega_2":	?>						
			function passa(parametro){
				opener.form1.data_nf.value=parametro;
				window.close();
			}			
<?php			break;
		case "rec_skip_lote1":	?>						
			function passa(parametro){
				opener.form1.data2.value=parametro;
				window.close();
			}			
<?php			break;
		case "rec_skip_lote2":	?>						
			function passa(parametro){
				opener.form1.validade.value=parametro;
				window.close();
			}			
<?php			break;
		case "rec_fiti_geral_1":	?>						
			function passa(parametro){
				opener.form1.dvig.value=parametro;
				window.close();
			}			
<?php			break;
		case "rec_fiti_geral_2":	?>						
			function passa(parametro){
				opener.form1.ddes.value=parametro;
				window.close();
			}			
<?php			break;
		case "rec_cad2_1":	?>						
			function passa(parametro){
				opener.form1.dtent.value=parametro;
				window.close();
			}			
<?php			break;
		case "rec_cad2_2":	?>						
			function passa(parametro){
				opener.form1.validade.value=parametro;
				window.close();
			}			
<?php			break;
		case "rec_cad2_3":	?>						
			function passa(parametro){
				opener.form1.dtfisc.value=parametro;
				window.close();
			}			
<?php			break;
		case "rec_cad_1":	?>						
			function passa(parametro){
				opener.form1.dtent.value=parametro;
				window.close();
			}			
<?php			break;
	}
?>

</script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="155" border="0" cellpadding="0" cellspacing="0">
               <tr> 
                <td align="center"> 
                  <?php include("agenda_pop_cal.php"); ?>
				</td>
              </tr>
</table>
</body>
</html>
<?php include("mensagem.php"); ?>
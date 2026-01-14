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
	$loc="APQP - Capabilidade";
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
		$apqp->cliente_apro("apqp_cap.php");
		// - - - - - - - -  -
		///Tirar Aprovaçõesss
	$sql=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Estudos de Capabilidade'");
	if(mysql_num_rows($sql)){
			$sqlba=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ<>'Viabilidade' AND ativ<>'Diagrama de Fluxo' AND ativ<>'FMEA de Processo' AND ativ<>'Plano de Controle' AND ativ<>'Estudos de R&R'");
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
	}
// - - - - - - - - - - - - - - - - - - - - - -  --  - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -- - - - - - -
if($acao=="cap2"){
	
	for($i=1;$i<=125;$i++){
		$_POST["a".$i]=valor2banco2($_POST["a".$i]);
	}
	extract($_POST);
	//calculo
		for($i=1;$i<=$nli*5;$i++){
			$mm[]=$_POST["a".$i];
		}
		$maxi_=max($mm);
		$mini_=min($mm);
	//XBAR
		for($i=1;$i<=125;$i++){
			$xbar+=$_POST["a".$i];
		}
		$xbar=$xbar/($nli*5);
	//SIGMA
		for($i=1;$i<=$nli;$i++){
			unset($rbr);
			for($j=$i*5;$j>=$i*5-4;$j--){
				$rbr[]=$_POST["a".$j];
			}
			$rsig[$i]=max($rbr)-min($rbr);
		}
		$sigma=(array_reduce($rsig, 'rsum')/$nli)/2.33;
	//SIGMA 2
		for($i=1;$i<=$nli*5;$i++){
			$soma+=$_POST["a".$i]*$_POST["a".$i];
		}
		$sigma2=sqrt((($soma)-(($nli*5)*($xbar*$xbar))) / (($nli*5) -1));
		$sigma2=$sigma2;
	//MAX R
		$maxi=max($rsig);

	//MIN R
		$mini=min($rsig);

	//CP
		$sqlcar=mysql_query("SELECT * FROM apqp_car WHERE id='$car'");
		if(mysql_num_rows($sqlcar)) $rescar=mysql_fetch_array($sqlcar);
		@$cp=($rescar["lse"]-$rescar["lie"])/(6*$sigma);
	//CPK
		@$cpk=min((($rescar["lse"])-$xbar)/$sigma/3,($xbar-($rescar["lie"]))/$sigma/3);

	//CR
		$cr=(6*$sigma)/($rescar["lse"]-$rescar["lie"]);
	//PR
		$pr=(6*$sigma2)/($rescar["lse"]-$rescar["lie"]);
	//PP
		@$pp=($rescar["lse"]-$rescar["lie"])/(6*$sigma2);
	//PPK
		@$ppk=min((($rescar["lse"])-$xbar)/$sigma2/3,($xbar-($rescar["lie"]))/$sigma2/3);
	//Xbar (1 a 25)
		for($i=1;$i<=$nli;$i++){
			for($j=$i*5;$j>=$i*5-4;$j--){
				$x[$i]+=$_POST["a".$j];
			}
			$x[$i]/=5;
		}
	//Rbar (1 a 25)
		for($i=1;$i<=$nli;$i++){
			unset($rbr);
			for($j=$i*5;$j>=$i*5-4;$j--){
				$rbr[]=$_POST["a".$j];
			}
			//$rbr[]=$x[$i];
			$r[$i]=max($rbr)-min($rbr);
		}
	//Rbar
		$rbars=array_reduce($r, 'rsum')/$nli;
	//Xmax Xmin
		$xmax=max($x);
		$xmin=min($x);
	//Rmax Rmin
		$rmax=max($r);
		$rmin=min($r);
	//UCL Xbar
		for($i=1;$i<=$nli;$i++){
			$xucl+=$x[$i];
			$rucl+=$r[$i];
			$a++;
		}
		for($i=$nli+1;$i<=25;$i++){
			$xucl+=$x[$nli];
			$rucl+=$r[$nli];
			$a++;
		}
		$xucl/=25;
		$rucl/=25;
		$uclx=$xbar+(3*$sigma);
	//UCL R
		$uclr=2.114*$rucl;
	//LCL Xbar
		$lcl=$xbar-(3*$sigma);
	//Pontos Fora -pf
		$pf=0;
		$apf=0;
		$mpf=0;
		for($i=1;$i<=$nli*5;$i++){
			if(($_POST["a".$i]>$rescar["lse"]) or ($_POST["a".$i]<$rescar["lsi"])){
				$pf++;
			}
		}
	//MPF
			foreach($x as $idx2=>$valorr){
				if(($valorr>$uclx) or ($valorr<$lcl)){
					 $mpf++;
				}
			}
	//APF
			foreach($r as $idr2=>$val2){
				if(($val2>$uclr) or ($val2<0)){
					$apf++;
				}
			}
	//Xbar OK High
		if(max($x)>$uclx){
			$xokh="Out";
		}else{
			$xokh="OK";
		}
	//Xbar OK Low
		if(min($x)<$lcl){
			$xokl="Out";
		}else{
			$xokl="OK";
		}
	//R OK High
		if(max($r)>$uclr){
			$rokh="Out";
		}else{
			$rokh="OK";
		}
//Histrograma começa aqui -------------------// -----------------
for($i=1;$i<=$nli*5;$i++){
	$tot[]=$_POST["a".$i];
}
// Minimo e maximo
$maximo=max($tot);
$minimo=min($tot);

//Auto = valor para calculos
$auto=($maximo-$minimo)/7;

//Achar os valores das colunas
$col1_1=$minimo-$auto;
$col1_2=$minimo+$auto;
$col2_1=$col1_2;
$col2_2=$col2_1+$auto;
$col3_1=$col2_2;
$col3_2=$col3_1+$auto;
$col4_1=$col3_2;
$col4_2=$col4_1+$auto;
$col5_1=$col4_2;
$col5_2=$col5_1+$auto;
$col6_1=$col5_2;
$col6_2=$col6_1+$auto;
$col7_1=$col6_2;
$col7_2=$col7_1+$auto;
$col7_2=$col7_2+0.1;
//achar valor das colunas
for($j=1;$j<=$nli*5;$j++){
		$a=$_POST["a".$j];
		if($a>=$col1_1 and $a<=$col1_2){
			$bar1++;
			$a="";
		}
		if($a>=$col2_1 and $a<=$col2_2){
			$bar2++;
			$a="";
		}
		if($a>=$col3_1 and $a<=$col3_2){
			$bar3++;
			$a="";
		}
		if($a>=$col4_1 and $a<=$col4_2){
			$bar4++;
			$a="";
		}
		if($a>=$col5_1 and $a<=$col5_2){
			$bar5++;
			$a="";
		}
		if($a>=$col6_1 and $a<=$col6_2){
			$bar6++;
			$a="";
		}
		if($a>=$col7_1 and $a<=$col7_2){
			$bar7++;
			$a="";
		}
}
$i=0;
$linhas=$nli*5;
for($i=1;$i<=7;$i++){
	$ii=$i-1;
	eval("\$por$i=number_format((\$bar$i/$linhas)*100+\$por$ii);");
}
////Histrograma termina aqui ---------------- // -----------------


	/*print "
	Xbar=$xbar<br>
	Rbar=$rbar<br>
	sigma=$sigma<br>
	max=$maxi<br>
	min=$mini<br>
	-tol=$rescar[tol]<br>
	+tol=$rescar[tol]<br>
	cp=$cp<br>
	cpk=$cpk<br>
	UCL Xbar=$uclx<br>
	LCL Xbar=$lcl<br>
	UCL R=$uclr<br>
	Xbar OK High=$xokh<br>
	Xbar OK Low=$xokl<br>
	R OK High=$rokh<br>
	Xmax=$xmax<br>
	Xmin=$xmin<br>
	Rmax=$rmax<br>
	Rmin=$rmin<br>
	x1=$x[1]<br>
	x2=$x[2]<br>
	x3=$x[3]<br>
	x4=$x[4]<br>
	x5=$x[5]<br>
	x6=$x[6]<br>
	x7=$x[7]<br>
	x8=$x[8]<br>
	x9=$x[9]<br>
	x10=$x[10]<br>
	x11=$x[11]<br>
	x12=$x[12]<br>
	x13=$x[13]<br>
	x14=$x[14]<br>
	x15=$x[15]<br>
	x16=$x[16]<br>
	x17=$x[17]<br>
	x18=$x[18]<br>
	x19=$x[19]<br>
	x20=$x[20]<br>
	x21=$x[21]<br>
	x22=$x[22]<br>
	x23=$x[23]<br>
	x24=$x[24]<br>
	x25=$x[25]<br>
	r1=$r[1]<br>
	r2=$r[2]<br>
	r3=$r[3]<br>
	r4=$r[4]<br>
	r5=$r[5]<br>
	r6=$r[6]<br>
	r7=$r[7]<br>
	r8=$r[8]<br>
	r9=$r[9]<br>
	r10=$r[10]<br>
	r11=$r[11]<br>
	r12=$r[12]<br>
	r13=$r[13]<br>
	r14=$r[14]<br>
	r15=$r[15]<br>
	r16=$r[16]<br>
	r17=$r[17]<br>
	r18=$r[18]<br>
	r19=$r[19]<br>
	r20=$r[20]<br>
	r21=$r[21]<br>
	r22=$r[22]<br>
	r23=$r[23]<br>
	r24=$r[24]<br>
	r25=$r[25]<br>
	"; exit;*/
	//calculo
	$dtpor=data2banco($dtpor);
	$quer="UPDATE apqp_cap SET por='$por',dtpor='$dtpor',obs='$obs',nli='$nli',digitos='$ndi',ope='$wop',pf='$pf',apf='$apf',mpf='$mpf',numerodisp='$numerodisp',nomedisp='$nomedisp'";
	for($i=1;$i<=125;$i++){
		$quer.=",a$i='".$_POST["a".$i]."'\n";
	}
	$quer.=",xbar='$xbar',rbar='$rbars',sigma='$sigma',sigma2='$sigma2',max='$maxi_',min='$mini_',cp='$cp',cpk='$cpk',cr='$cr',pr='$pr',pp='$pp',ppk='$ppk',uclx='$uclx',lcl='$lcl',uclr='$uclr',xokh='$xokh',xokl='$xokl',rokh='$rokh',xmax='$xmax',xmin='$xmin',rmax='$rmax',rmin='$rmin',h1='$bar1',h2='$bar2',h3='$bar3',h4='$bar4',h5='$bar5',h6='$bar6',h7='$bar7',hp1='$por1',hp2='$por2',hp3='$por3',hp4='$por4',hp5='$por5',hp6='$por6',hp7='$por7'\n";
	for($i=1;$i<=25;$i++){
		$quer.=",x$i='".$x[$i]."'\n";
		$quer.=",r$i='".$r[$i]."'\n";
		$quer.=",media$i='".$_POST["media".$i]."'\n";
		$quer.=",amplitude$i='".$_POST["amplitude".$i]."'\n";
	}
	$quer.=" WHERE id='$id'";
	$sql=mysql_query($quer);
//print $quer;
	$sql=mysql_query("UPDATE apqp_car SET disp_cap='0',quem_cap='', dtquem_cap='' WHERE id='$car'");
	if($sql){
		$_SESSION["mensagem"]="Alterações salvas com sucesso";
		// cria followup caso salve o conteudo da capabilidade
			$sql_sal=mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Salvando alterações da Capabilidade da peça $npc.','O usuário $quem salvou as alterações da Capabilidade da peça $npc.','$user')");
		//	
	}else{
		$_SESSION["mensagem"]="As alterações não puderam ser salvas";
	}
	header("location:apqp_cap3.php?car=$car");
	exit;
}elseif($acao=="cap3"){
	if(isset($apro)){
		//finalizar tarefa!!! - - - - - - - 
		$apqp->agenda("Estudos de Capabilidade");
		// - - - - - - - -  - - - - - - - - 
		if(empty($tap12)){
			$tap12=$quem;
		}
		$sql=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Estudos de R&R'");
		if(!mysql_num_rows($sql)){
			$_SESSION["mensagem"]="Não pode ser aprovado pois existem relatórios anteriores abertos!!";
			header("Location:apqp_cap3.php?car=$car");
			exit;
		}
		$sql=mysql_query("UPDATE apqp_cron SET fim=NOW(), perc='100',resp='$tap12' WHERE ativ='Estudos de Capabilidade' AND peca='$pc'");
			$_SESSION["mensagem"]="Aprovado com Sucesso!";
			// cria followup caso aprove o conteudo do Estudo de R&R 
				$sql_ap=mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Aprovação do estudo de Capabilidade da peça $npc.','O usuário $quem aprovou o estudo de Capabilidade da peça $npc.','$user')");
			header("Location:apqp_cap3.php?car=$car");
			exit;
	}	
	if(isset($lim)){
			$sql=mysql_query("UPDATE apqp_cron SET resp='$tap12',fim=NOW(),perc='95' WHERE ativ='Estudos de Capabilidade' AND peca='$pc'");
			// cria followup caso remova a aprovação do R&R e mude o status
				mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Removendo a aprovação do estudo de Capabilidade da peça $npc.','O usuário $quem removeu a aprovação da peça $npc devido a remoção da aprovação estudo de Capabilidade.','$user')");
			// EMAIL	
				$apqp->set_email("Remoção da aprovação da peça $npc.","O usuário $quem removeu a aprovação da peça $this->npc devido a remoção da aprovação doestudo de Capabilidade.");
				$apqp->email();
			$_SESSION["mensagem"]="Aprovação excluída com sucesso!";
			// cria followup caso remove a aprovação do Estudo de R&R 
			mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Removendo aprovação da Característica no estudo de Capabilidade da peça $npc.','O usuário $quem removeu a aprovação do estudo de Capabilidade da peça $npc.','$user')");	
		
		//$sql=mysql_query("UPDATE apqp_cron SET resp='',fim='',perc='95' WHERE ativ='Estudos de R&R' AND peca='$pc'");
		$sql=mysql_query("UPDATE apqp_car SET disp_cap='0',quem_cap='', dtquem_cap='' WHERE id='$car'");
		header("Location:apqp_cap3.php?car=$car");
		exit;
	}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	if(isset($ap)){
		if(empty($tap12)){
			$tap12=$quem;
		}
		$sql=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Estudos de R&R'");
		if(!mysql_num_rows($sql)){
			$_SESSION["mensagem"]="Não pode ser aprovado pois existem relatórios anteriores abertos!!";
			header("Location:apqp_cap3.php?car=$car");
			exit;
		}
			$sql=mysql_query("UPDATE apqp_cap SET sit=1 WHERE id='$id'") or erp_db_fail();
			$sql=mysql_query("UPDATE apqp_car SET disp_cap='1',quem_cap='$tap12', dtquem_cap=NOW() WHERE id='$car'");
				$_SESSION["mensagem"]="Aprovação concluída com sucesso"; 
				// cria followup caso aprove o conteudo da Capabilidade
					$sql_ap=mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Aprovação da Característica da Capabilidade na peça $npc.','O usuário $quem aprovou a Característica da Capabilidade na peça $npc.','$user')");
				//	
	}
	if(isset($rep)){
	if(empty($tap12)){
		$tap12=$quem;
	}
		$sql=mysql_query("UPDATE apqp_cap SET sit=2 WHERE id='$id'");
		$sql=mysql_query("UPDATE apqp_car SET disp_cap='2',quem_cap='$tap12',dtquem_cap=NOW() WHERE id='$car'");

		$_SESSION["mensagem"]="Reprovação concluída com sucesso";
		// cria followup caso aprove o conteudo da Capabilidade
			$sql_ap=mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Reprovação a Característica da Capabilidade na peça $npc.','O usuário $quem reprovou a Característica da Capabilidade na peça $npc.','$user')");		
	}
	if(isset($lap)){
			mysql_query("UPDATE apqp_pc SET status='1' WHERE id='$pc'");
			// cria followup caso remova a aprovação do R&R e mude o status
				mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Removendo a aprovação do Estudo de Capabilidade da peça $npc.','O usuário $quem removeu a aprovação da peça $npc devido a remoção da aprovação do Estudo de Capabilidade.','$user')");
				$apqp->set_email("Remoção da aprovação da peça $npc.","O usuário $quem removeu a aprovação da peça $this->npc devido a remoção da aprovação do Estudo Capabilidade.");
				$apqp->email();
		// cria followup caso remove a aprovação da Capabilidade
		mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Removendo aprovação da Capabilidade da peça $npc.','O usuário $quem removeu a aprovação da Capabilidade da peça $npc.','$user')");
		$sql=mysql_query("UPDATE apqp_cap SET sit=0 WHERE id='$id'");
		$sql=mysql_query("UPDATE apqp_car SET disp_cap='0',quem_cap='', dtquem_cap='' WHERE id='$car'");
		$_SESSION["mensagem"]="Aprovação excluída com sucesso";
	}
	header("location:apqp_cap3.php?car=$car");
	exit;
}
?>
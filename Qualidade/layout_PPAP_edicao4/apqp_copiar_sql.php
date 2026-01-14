<?php
include("conecta.php");
include("seguranca.php");
if(empty($acao)) exit;
$hj=date("Y-m-d");
if($acao=="copiar"){
//Copiar Peça------->>>>
	$sql=mysql_query("SELECT * FROM apqp_pc WHERE numero='$numero_para' AND rev='$rev_para'");
	if(mysql_num_rows($sql)){
		$_SESSION["mensagem"]="Essa revisão para essa Peça já existe!";
		header("Location:apqp_copiar.php?pc=$pc");
		exit;
	}else{
		$sql=mysql_query("SELECT * FROM apqp_pc WHERE id='$pc'");
		$res=mysql_fetch_array($sql);
		$sql=mysql_query("INSERT INTO apqp_pc (numero,rev,dtrev,nome,cliente,desenhoi,desenhoc,pecacli,aplicacao,niveleng,dteng,historico,idioma,nivel,sit,crono_ger,crono_apro,crono_quem,crono_dtquem,alteng,dtalteng,peso,isrg,ncompra,aux_num,aux_nivel,aux_data,nppap,status,comprador) VALUES('$numero_para','$rev_para','$hj','$res[nome]','$cliente_para','$res[desenhoi]','$res[desenhoc]','$pcli_para','$res[aplicacao]','$res[niveleng]','$res[dteng]','$res[historico]','$res[idioma]','$res[nivel]','$res[sit]','$res[crono_ger]','$res[crono_apro]','$res[crono_quem]','$res[crono_dtquem]','$res[alteng]','$res[dtalteng]','$res[peso]','$res[isrg]','$res[ncompra]','$res[aux_num]','$res[aux_nivel]','$res[aux_data]','$res[nppap]','1','$res[comprador]')") or erp_db_fail();
		$sql=mysql_query("SELECT MAX(id) as pc FROM apqp_pc");
		$res=mysql_fetch_array($sql); $pcn=$res["pc"];
	}
//Cabo Peçaa---<<<< e comeca os bartos
			$sql=mysql_query("SELECT * FROM apqp_car WHERE peca='$pc'") or erp_db_fail(); 
			while($res=mysql_fetch_array($sql)){
				$sql4=mysql_query("INSERT INTO apqp_car (peca,car,descricao,espec,numero,pc,simbolo,tipo,lie,lse,tol,nominal) VALUES('$pcn','$res[id]','$res[descricao]','$res[espec]','$res[numero]','$res[pc]','$res[simbolo]','$res[tipo]','$res[lie]','$res[lse]','$res[tol]','$res[nominal]')") or erp_db_fail();
			}

			$sql=mysql_query("SELECT * FROM apqp_op WHERE peca='$pc'") or erp_db_fail(); 
			while($res=mysql_fetch_array($sql)){
				$sql4=mysql_query("INSERT INTO apqp_op (peca,fmea,op,descricao,obs,macloc,numero,tipo) VALUES('$pcn','$res[fmea]','$res[id]','$res[descricao]','$res[obs]','$res[macloc]','$res[numero]','$res[tipo]')") or erp_db_fail();
			}
	foreach($cp as $tbl){
		switch($tbl){
			case "apqp_fluxo":
				$fluxo=mysql_query("SELECT * FROM apqp_fluxo WHERE peca='$pc'");
				while($res=mysql_fetch_array($fluxo)){
								//operacaooo
								$item="";
								$sql3=mysql_query("SELECT * FROM apqp_op WHERE id='$res[op]'") or erp_db_fail(); 
								$res3=mysql_fetch_array($sql3);

								$sql4=mysql_query("SELECT * FROM apqp_op WHERE op='$res[op]' and peca='$pcn'") or erp_db_fail();
								if(mysql_num_rows($sql4)){
									$res4=mysql_fetch_array($sql4);
									$item=$res4["id"];
								}else{
									if(!empty($res["op"])){
										$sql4=mysql_query("INSERT INTO apqp_op (peca,fmea,op,descricao,obs,macloc,numero,tipo) VALUES('$pcn','$res3[fmea]','$res[op]','$res3[descricao]','$res3[obs]','$res3[macloc]','$res3[numero]','$res3[tipo]')") or erp_db_fail();
										$sql4=mysql_query("SELECT MAX(id) as id from apqp_op") or erp_db_fail(); 
										$res4=mysql_fetch_array($sql4);
										$item=$res4["id"];
									}
								}
								//Caboo operacaoo		
						if(!empty($item)){
							$sql=mysql_query("INSERT INTO apqp_fluxo (peca,fluxo1,fluxo2,op,ordem) VALUES('$pcn','$res[fluxo1]','$res[fluxo2]','$item','$res[ordem]')") or erp_db_fail();
						}
				}
				break;
			case "apqp_fmeaproj":
				$pro=mysql_query("SELECT * FROM apqp_fmeaproj WHERE peca='$pc'");
				while($res=mysql_fetch_array($pro)){
					$sql=mysql_query("INSERT INTO apqp_fmeaproj (peca,prep,resp,equipe,obs,ini,rev,chv,numero,sit,op) VALUES('$pcn','$res[prep]','$res[resp]','$res[equipe]','$res[obs]','$res[ini]','$res[rev]','$res[chv]','$res[numero]','$res[sit]','$res[op]')") or erp_db_fail();
						$sql2=mysql_query("SELECT MAX(id) as id FROM apqp_fmeaproj"); $res2=mysql_fetch_array($sql2); $fmea=$res2["id"];
							$sql=mysql_query("SELECT * FROM apqp_fmeaproji WHERE fmea='$res[id]'") or erp_db_fail();
							while($res2=mysql_fetch_array($sql)){
								//operacaooo
								$sql3=mysql_query("SELECT * FROM apqp_op WHERE id='$res2[item]'") or erp_db_fail(); 
								$res3=mysql_fetch_array($sql3);

								$sql4=mysql_query("SELECT * FROM apqp_op WHERE op='$res2[item]' and peca='$pcn'") or erp_db_fail();
								if(mysql_num_rows($sql4)){
									$res4=mysql_fetch_array($sql4);
									$item=$res4["id"];
								}else{
									if(!empty($res2["item"])){
										$sql4=mysql_query("INSERT INTO apqp_op (peca,fmea,op,descricao,obs,macloc,numero,tipo) VALUES('$pcn','$res3[fmea]','$res2[item]','$res3[descricao]','$res3[obs]','$res3[macloc]','$res3[numero]','$res3[tipo]')") or erp_db_fail();
										$sql4=mysql_query("SELECT MAX(id) as id from apqp_op") or erp_db_fail(); 
										$res4=mysql_fetch_array($sql4);
										$item=$res4["id"];
									}
								}
								//Caboo operacaoo								
								
								$sql3=mysql_query("INSERT INTO apqp_fmeaproji (fmea,item,modo,efeitos,sev,icone,causa,ocor,controle,controle2,det,npr,ar,resp,prazo,at,sev2,ocor2,det2,npr2) VALUES('$fmea','$item','$res2[modo]','$res2[efeitos]','$res2[sev]','$res2[icone]','$res2[causa]','$res2[ocor]','$res2[controle]','$res2[controle2]','$res2[det]','$res2[npr]','$res2[ar]','$res2[resp]','$res2[prazo]','$res2[at]','$res2[sev2]','$res2[ocor2]','$res2[det2]','$res2[npr2]')") or erp_db_fail();
							}
				}
				break;
			case "apqp_fmeaproc":
				$pro=mysql_query("SELECT * FROM apqp_fmeaproc WHERE peca='$pc'");
				while($res=mysql_fetch_array($pro)){
					$sql=mysql_query("INSERT INTO apqp_fmeaproc (peca,prep,resp,equipe,obs,ini,rev,chv,numero,sit,op) VALUES('$pcn','$res[prep]','$res[resp]','$res[equipe]','$res[obs]','$res[ini]','$res[rev]','$res[chv]','$res[numero]','$res[sit]','$res[op]')") or erp_db_fail();
						$sql2=mysql_query("SELECT MAX(id) as id FROM apqp_fmeaproc"); $res2=mysql_fetch_array($sql2); $fmea=$res2["id"];
							$sql=mysql_query("SELECT * FROM apqp_fmeaproci WHERE fmea='$res[id]'");
							while($res2=mysql_fetch_array($sql)){
								//operacaooo
								$sql3=mysql_query("SELECT * FROM apqp_op WHERE id='$res2[item]'") or erp_db_fail(); 
								$res3=mysql_fetch_array($sql3);

								$sql4=mysql_query("SELECT * FROM apqp_op WHERE op='$res2[item]' and peca='$pcn'") or erp_db_fail();
								if(mysql_num_rows($sql4)){
									$res4=mysql_fetch_array($sql4);
									$item=$res4["id"];
								}else{
									if(!empty($res2["item"])){
										$sql4=mysql_query("INSERT INTO apqp_op (peca,fmea,op,descricao,obs,macloc,numero,tipo) VALUES('$pcn','$res3[fmea]','$res2[item]','$res3[descricao]','$res3[obs]','$res3[macloc]','$res3[numero]','$res3[tipo]')") or erp_db_fail();
										$sql4=mysql_query("SELECT MAX(id) as id from apqp_op") or erp_db_fail(); 
										$res4=mysql_fetch_array($sql4);
										$item=$res4["id"];
									}
								}
								//Caboo operacaoo		
								$respo=str_replace("\\","",$res2[resp]);
$ar=str_replace("\\","",$res2[ar]);
								$sql3=mysql_query("INSERT INTO apqp_fmeaproci (fmea,item,modo,efeitos,sev,icone,causa,ocor,controle,controle2,det,npr,ar,resp,prazo,at,sev2,ocor2,det2,npr2) VALUES('$fmea','$item','$res2[modo]','$res2[efeitos]','$res2[sev]','$res2[icone]','$res2[causa]','$res2[ocor]','$res2[controle]','$res2[controle2]','$res2[det]','$res2[npr]','$ar','','$res2[prazo]','$res2[at]','$res2[sev2]','$res2[ocor2]','$res2[det2]','$res2[npr2]')") or erp_db_fail();
							}
				}
				break;
			case "apqp_rr":
				$rr=mysql_query("SELECT * FROM apqp_rr WHERE peca='$pc'");
				while($res=mysql_fetch_array($rr)){
								//operacaooo
								$sql3=mysql_query("SELECT * FROM apqp_car WHERE id='$res[car]'") or erp_db_fail(); 
								$res3=mysql_fetch_array($sql3);

								$sql4=mysql_query("SELECT * FROM apqp_car WHERE car='$res[car]' and peca='$pcn'") or erp_db_fail();
								if(mysql_num_rows($sql4)){
									$res4=mysql_fetch_array($sql4);
									$item=$res4["id"];
								}else{
									if(!empty($res["car"])){
										$sql4=mysql_query("INSERT INTO apqp_car (peca,car,descricao,espec,numero,pc,simbolo,tipo,lie,lse,tol,nominal) VALUES('$pcn','$res[car]','$res3[descricao]','$res3[espec]','$res3[numero]','$res3[pc]','$res3[simbolo]','$res3[tipo]','$res3[lie]','$res3[lse]','$res3[tol]','$res3[nominal]')") or erp_db_fail();
										$sql4=mysql_query("SELECT MAX(id) as id from apqp_car") or erp_db_fail(); 
										$res4=mysql_fetch_array($sql4);
										$item=$res4["id"];
									}
								}
								//Caboo operacaoo		
					$sql=mysql_query("INSERT INTO apqp_rr (peca,car,dispnu,dispno,por,dtpor,obs,calc,nop,ncic,npc,a11,a12,a13,a14,a15,a16,a17,a18,a19,a110,a21,a22,a23,a24,a25,a26,a27,a28,a29,a210,a31,a32,a33,a34,a35,a36,a37,a38,a39,a310,b11,b12,b13,b14,b15,b16,b17,b18,b19,b110,b21,b22,b23,b24,b25,b26,b27,b28,b29,b210,b31,b32,b33,b34,b35,b36,b37,b38,b39,b310,c11,c12,c13,c14,c15,c16,c17,c18,c19,c110,c21,c22,c23,c24,c25,c26,c27,c28,c29,c210,c31,c32,c33,c34,c35,c36,c37,c38,c39,c310,sit,ev,ov,rr,pv,tv,pev,pov,prr,ppv,average,lcl,uclx,rbar,uclr,xa1,xa2,xa3,xa4,xa5,xa6,xa7,xa8,xa9,xa10,xb1,xb2,xb3,xb4,xb5,xb6,xb7,xb8,xb9,xb10,xc1,xc2,xc3,xc4,xc5,xc6,xc7,xc8,xc9,xc10,ra1,ra2,ra3,ra4,ra5,ra6,ra7,ra8,ra9,ra10,rb1,rb2,rb3,rb4,rb5,rb6,rb7,rb8,rb9,rb10,rc1,rc2,rc3,rc4,rc5,rc6,rc7,rc8,rc9,rc10) VALUES('$pcn','$item','$res[dispnu]','$res[dispno]','$res[por]','$res[dtpor]','$res[obs]','$res[calc]','$res[nop]','$res[ncic]','$res[npc]','$res[a11]','$res[a12]','$res[a13]','$res[a14]','$res[a15]','$res[a16]','$res[a17]','$res[a18]','$res[a19]','$res[a110]','$res[a21]','$res[a22]','$res[a23]','$res[a24]','$res[a25]','$res[a26]','$res[a27]','$res[a28]','$res[a29]','$res[a210]','$res[a31]','$res[a32]','$res[a33]','$res[a34]','$res[a35]','$res[a36]','$res[a37]','$res[a38]','$res[a39]','$res[a310]','$res[b11]','$res[b12]','$res[b13]','$res[b14]','$res[b15]','$res[b16]','$res[b17]','$res[b18]','$res[b19]','$res[b110]','$res[b21]','$res[b22]','$res[b23]','$res[b24]','$res[b25]','$res[b26]','$res[b27]','$res[b28]','$res[b29]','$res[b210]','$res[b31]','$res[b32]','$res[b33]','$res[b34]','$res[b35]','$res[b36]','$res[b37]','$res[b38]','$res[b39]','$res[b310]','$res[c11]','$res[c12]','$res[c13]','$res[c14]','$res[c15]','$res[c16]','$res[c17]','$res[c18]','$res[c19]','$res[c110]','$res[c21]','$res[c22]','$res[c23]','$res[c24]','$res[c25]','$res[c26]','$res[c27]','$res[c28]','$res[c29]','$res[c210]','$res[c31]','$res[c32]','$res[c33]','$res[c34]','$res[c35]','$res[c36]','$res[c37]','$res[c38]','$res[c39]','$res[c310]','$res[sit]','$res[ev]','$res[ov]','$res[rr]','$res[pv]','$res[tv]','$res[pev]','$res[pov]','$res[prr]','$res[ppv]','$res[average]','$res[lcl]','$res[uclx]','$res[rbar]','$res[uclr]','$res[xa1]','$res[xa2]','$res[xa3]','$res[xa4]','$res[xa5]','$res[xa6]','$res[xa7]','$res[xa8]','$res[xa9]','$res[xa10]','$res[xb1]','$res[xb2]','$res[xb3]','$res[xb4]','$res[xb5]','$res[xb6]','$res[xb7]','$res[xb8]','$res[xb9]','$res[xb10]','$res[xc1]','$res[xc2]','$res[xc3]','$res[xc4]','$res[xc5]','$res[xc6]','$res[xc7]','$res[xc8]','$res[xc9]','$res[xc10]','$res[ra1]','$res[ra2]','$res[ra3]','$res[ra4]','$res[ra5]','$res[ra6]','$res[ra7]','$res[ra8]','$res[ra9]','$res[ra10]','$res[rb1]','$res[rb2]','$res[rb3]','$res[rb4]','$res[rb5]','$res[rb6]','$res[rb7]','$res[rb8]','$res[rb9]','$res[rb10]','$res[rc1]','$res[rc2]','$res[rc3]','$res[rc4]','$res[rc5]','$res[rc6]','$res[rc7]','$res[rc8]','$res[rc9]','$res[rc10]')") or erp_db_fail();
				}
				break;
			case "apqp_cap":
				$cap=mysql_query("SELECT * FROM apqp_cap WHERE peca='$pc'");
				while($res=mysql_fetch_array($cap)){
								//operacaooo
								$sql3=mysql_query("SELECT * FROM apqp_car WHERE id='$res[car]'") or erp_db_fail(); 
								$res3=mysql_fetch_array($sql3);

								$sql4=mysql_query("SELECT * FROM apqp_car WHERE car='$res[car]' and peca='$pcn'") or erp_db_fail();
								if(mysql_num_rows($sql4)){
									$res4=mysql_fetch_array($sql4);
									$item=$res4["id"];
								}else{
									if(!empty($res["car"])){
										$sql4=mysql_query("INSERT INTO apqp_car (peca,car,descricao,espec,numero,pc,simbolo,tipo,lie,lse,tol,nominal) VALUES('$pcn','$res[car]','$res3[descricao]','$res3[espec]','$res3[numero]','$res3[pc]','$res3[simbolo]','$res3[tipo]','$res3[lie]','$res3[lse]','$res3[tol]','$res3[nominal]')") or erp_db_fail();
										$sql4=mysql_query("SELECT MAX(id) as id from apqp_car") or erp_db_fail(); 
										$res4=mysql_fetch_array($sql4);
										$item=$res4["id"];
									}
								}
								//Caboo operacaoo		
					$sql=mysql_query("INSERT INTO `apqp_cap` (`peca`,`car`,`por`,`dtpor`,`obs`,`nli`,`digitos`,`a1`,`a2`,`a3`,`a4`,`a5`,`a6`,`a7`,`a8`,`a9`,`a10`,`a11`,`a12`,`a13`,`a14`,`a15`,`a16`,`a17`,`a18`,`a19`,`a20`,`a21`,`a22`,`a23`,`a24`,`a25`,`a26`,`a27`,`a28`,`a29`,`a30`,`a31`,`a32`,`a33`,`a34`,`a35`,`a36`,`a37`,`a38`,`a39`,`a40`,`a41`,`a42`,`a43`,`a44`,`a45`,`a46`,`a47`,`a48`,`a49`,`a50`,`a51`,`a52`,`a53`,`a54`,`a55`,`a56`,`a57`,`a58`,`a59`,`a60`,`a61`,`a62`,`a63`,`a64`,`a65`,`a66`,`a67`,`a68`,`a69`,`a70`,`a71`,`a72`,`a73`,`a74`,`a75`,`a76`,`a77`,`a78`,`a79`,`a80`,`a81`,`a82`,`a83`,`a84`,`a85`,`a86`,`a87`,`a88`,`a89`,`a90`,`a91`,`a92`,`a93`,`a94`,`a95`,`a96`,`a97`,`a98`,`a99`,`a100`,`a101`,`a102`,`a103`,`a104`,`a105`,`a106`,`a107`,`a108`,`a109`,`a110`,`a111`,`a112`,`a113`,`a114`,`a115`,`a116`,`a117`,`a118`,`a119`,`a120`,`a121`,`a122`,`a123`,`a124`,`a125`,`xbar`,`rbar`,`sigma`,`max`,`min`,`cp`,`cpk`,`uclx`,`lcl`,`uclr`,`xokh`,`xokl`,`rokh`,`xmax`,`xmin`,`rmax`,`rmin`,`x1`,`x2`,`x3`,`x4`,`x5`,`x6`,`x7`,`x8`,`x9`,`x10`,`x11`,`x12`,`x13`,`x14`,`x15`,`x16`,`x17`,`x18`,`x19`,`x20`,`x21`,`x22`,`x23`,`x24`,`x25`,`r1`,`r2`,`r3`,`r4`,`r5`,`r6`,`r7`,`r8`,`r9`,`r10`,`r11`,`r12`,`r13`,`r14`,`r15`,`r16`,`r17`,`r18`,`r19`,`r20`,`r21`,`r22`,`r23`,`r24`,`r25`,`h1`,`h2`,`h3`,`h4`,`h5`,`h6`,`h7`,`hp1`,`hp2`,`hp3`,`hp4`,`hp5`,`hp6`,`hp7`,`sit`,`quem`,`dtquem`,`ope`) VALUES('$pcn','$item','$res[por]','$res[dtpor]','$res[obs]','$res[nli]','$res[digitos]','$res[a1]','$res[a2]','$res[a3]','$res[a4]','$res[a5]','$res[a6]','$res[a7]','$res[a8]','$res[a9]','$res[a10]','$res[a11]','$res[a12]','$res[a13]','$res[a14]','$res[a15]','$res[a16]','$res[a17]','$res[a18]','$res[a19]','$res[a20]','$res[a21]','$res[a22]','$res[a23]','$res[a24]','$res[a25]','$res[a26]','$res[a27]','$res[a28]','$res[a29]','$res[a30]','$res[a31]','$res[a32]','$res[a33]','$res[a34]','$res[a35]','$res[a36]','$res[a37]','$res[a38]','$res[a39]','$res[a40]','$res[a41]','$res[a42]','$res[a43]','$res[a44]','$res[a45]','$res[a46]','$res[a47]','$res[a48]','$res[a49]','$res[a50]','$res[a51]','$res[a52]','$res[a53]','$res[a54]','$res[a55]','$res[a56]','$res[a57]','$res[a58]','$res[a59]','$res[a60]','$res[a61]','$res[a62]','$res[a63]','$res[a64]','$res[a65]','$res[a66]','$res[a67]','$res[a68]','$res[a69]','$res[a70]','$res[a71]','$res[a72]','$res[a73]','$res[a74]','$res[a75]','$res[a76]','$res[a77]','$res[a78]','$res[a79]','$res[a80]','$res[a81]','$res[a82]','$res[a83]','$res[a84]','$res[a85]','$res[a86]','$res[a87]','$res[a88]','$res[a89]','$res[a90]','$res[a91]','$res[a92]','$res[a93]','$res[a94]','$res[a95]','$res[a96]','$res[a97]','$res[a98]','$res[a99]','$res[a100]','$res[a101]','$res[a102]','$res[a103]','$res[a104]','$res[a105]','$res[a106]','$res[a107]','$res[a108]','$res[a109]','$res[a110]','$res[a111]','$res[a112]','$res[a113]','$res[a114]','$res[a115]','$res[a116]','$res[a117]','$res[a118]','$res[a119]','$res[a120]','$res[a121]','$res[a122]','$res[a123]','$res[a124]','$res[a125]','$res[xbar]','$res[rbar]','$res[sigma]','$res[max]','$res[min]','$res[cp]','$res[cpk]','$res[uclx]','$res[lcl]','$res[uclr]','$res[xokh]','$res[xokl]','$res[rokh]','$res[xmax]','$res[xmin]','$res[rmax]','$res[rmin]','$res[x1]','$res[x2]','$res[x3]','$res[x4]','$res[x5]','$res[x6]','$res[x7]','$res[x8]','$res[x9]','$res[x10]','$res[x11]','$res[x12]','$res[x13]','$res[x14]','$res[x15]','$res[x16]','$res[x17]','$res[x18]','$res[x19]','$res[x20]','$res[x21]','$res[x22]','$res[x23]','$res[x24]','$res[x25]','$res[r1]','$res[r2]','$res[r3]','$res[r4]','$res[r5]','$res[r6]','$res[r7]','$res[r8]','$res[r9]','$res[r10]','$res[r11]','$res[r12]','$res[r13]','$res[r14]','$res[r15]','$res[r16]','$res[r17]','$res[r18]','$res[r19]','$res[r20]','$res[r21]','$res[r22]','$res[r23]','$res[r24]','$res[r25]','$res[h1]','$res[h2]','$res[h3]','$res[h4]','$res[h5]','$res[h6]','$res[h7]','$res[hp1]','$res[hp2]','$res[hp3]','$res[hp4]','$res[hp5]','$res[hp6]','$res[hp7]','$res[sit]','$res[quem]','$res[dtquem]','$res[ope]')") or erp_db_fail();
				}
				break;
			case "apqp_doc":
				$doc=mysql_query("SELECT * FROM apqp_doc WHERE peca='$pc'");
				while($res=mysql_fetch_array($doc)){	
							$sql=mysql_query("INSERT INTO apqp_doc (peca,descr,forma,original,atual,tipo,resp,origem,obs) VALUES('$pcn','$res[descr]','$res[forma]','$res[original]','$res[atual]','$res[tipo]','$res[resp]','$res[origem]','$res[obs]')") or erp_db_fail();
				}
				break;
			case "apqp_endi":
				$end=mysql_query("SELECT * FROM apqp_endi WHERE peca='$pc'");
				while($res=mysql_fetch_array($end)){
					$sql=mysql_query("INSERT INTO apqp_endi (peca,local,sit,rep,dtrep) VALUES('$pcn','$res[local]','$res[sit]','$res[rep]','$res[dtrep]')") or erp_db_fail();
						$sql2=mysql_query("SELECT MAX(id) as id FROM apqp_endi"); $res2=mysql_fetch_array($sql2); $ens=$res2["id"];
							$sql=mysql_query("SELECT * FROM apqp_endil WHERE ensaio='$res[id]'") or erp_db_fail();
							while($res2=mysql_fetch_array($sql)){
								//operacaooo
								$sql3=mysql_query("SELECT * FROM apqp_car WHERE id='$res2[car]'") or erp_db_fail(); 
								$res3=mysql_fetch_array($sql3);

								$sql4=mysql_query("SELECT * FROM apqp_car WHERE car='$res2[car]' and peca='$pcn'") or erp_db_fail();
								if(mysql_num_rows($sql4)){
									$res4=mysql_fetch_array($sql4);
									$item=$res4["id"];
								}else{
									if(!empty($res2["item"])){
										$sql4=mysql_query("INSERT INTO apqp_car (peca,car,descricao,espec,numero,pc,simbolo,tipo,lie,lse,tol,nominal) VALUES('$pcn','$res2[car]','$res3[descricao]','$res3[espec]','$res3[numero]','$res3[pc]','$res3[simbolo]','$res3[tipo]','$res3[lie]','$res3[lse]','$res3[tol]','$res3[nominal]')") or erp_db_fail();
										$sql4=mysql_query("SELECT MAX(id) as id from apqp_op") or erp_db_fail(); 
										$res4=mysql_fetch_array($sql4);
										$item=$res4["id"];
									}
								}
								//Caboo operacaoo								
								$sql3=mysql_query("INSERT INTO apqp_endil (ensaio,car,forn,cli,ok) VALUES('$ens','$item','$res2[forn]','$res2[cli]','$res2[ok]')") or erp_db_fail();
							}
				}
				break;
			case "apqp_enma":
				$end=mysql_query("SELECT * FROM apqp_enma WHERE peca='$pc'");
				while($res=mysql_fetch_array($end)){
					$sql=mysql_query("INSERT INTO apqp_enma (peca,local,sit,rep,dtrep) VALUES('$pcn','$res[local]','$res[sit]','$res[rep]','$res[dtrep]')") or erp_db_fail();
						$sql2=mysql_query("SELECT MAX(id) as id FROM apqp_enma"); $res2=mysql_fetch_array($sql2); $ens=$res2["id"];
							$sql=mysql_query("SELECT * FROM apqp_enmal WHERE ensaio='$res[id]'") or erp_db_fail();
							while($res2=mysql_fetch_array($sql)){
								//operacaooo
								$sql3=mysql_query("SELECT * FROM apqp_car WHERE id='$res2[car]'") or erp_db_fail(); 
								$res3=mysql_fetch_array($sql3);

								$sql4=mysql_query("SELECT * FROM apqp_car WHERE car='$res2[car]' and peca='$pcn'") or erp_db_fail();
								if(mysql_num_rows($sql4)){
									$res4=mysql_fetch_array($sql4);
									$item=$res4["id"];
								}else{
									if(!empty($res2["item"])){
										$sql4=mysql_query("INSERT INTO apqp_car (peca,car,descricao,espec,numero,pc,simbolo,tipo,lie,lse,tol,nominal) VALUES('$pcn','$res2[car]','$res3[descricao]','$res3[espec]','$res3[numero]','$res3[pc]','$res3[simbolo]','$res3[tipo]','$res3[lie]','$res3[lse]','$res3[tol]','$res3[nominal]')") or erp_db_fail();
										$sql4=mysql_query("SELECT MAX(id) as id from apqp_op") or erp_db_fail(); 
										$res4=mysql_fetch_array($sql4);
										$item=$res4["id"];
									}
								}
								//Caboo operacaoo								
								$sql3=mysql_query("INSERT INTO apqp_enmal (ensaio,car,forn,cli,ok) VALUES('$ens','$item','$res2[forn]','$res2[cli]','$res2[ok]')") or erp_db_fail();
							}
				}
				break;
			case "apqp_ende":
				$end=mysql_query("SELECT * FROM apqp_ende WHERE peca='$pc'");
				while($res=mysql_fetch_array($end)){
					$sql=mysql_query("INSERT INTO apqp_ende (peca,local,sit,rep,dtrep) VALUES('$pcn','$res[local]','$res[sit]','$res[rep]','$res[dtrep]')") or erp_db_fail();
						$sql2=mysql_query("SELECT MAX(id) as id FROM apqp_ende"); $res2=mysql_fetch_array($sql2); $ens=$res2["id"];
							$sql=mysql_query("SELECT * FROM apqp_endel WHERE ensaio='$res[id]'") or erp_db_fail();
							while($res2=mysql_fetch_array($sql)){
								//operacaooo
								$sql3=mysql_query("SELECT * FROM apqp_car WHERE id='$res2[car]'") or erp_db_fail(); 
								$res3=mysql_fetch_array($sql3);

								$sql4=mysql_query("SELECT * FROM apqp_car WHERE car='$res2[car]' and peca='$pcn'") or erp_db_fail();
								if(mysql_num_rows($sql4)){
									$res4=mysql_fetch_array($sql4);
									$item=$res4["id"];
								}else{
									if(!empty($res2["item"])){
										$sql4=mysql_query("INSERT INTO apqp_car (peca,car,descricao,espec,numero,pc,simbolo,tipo,lie,lse,tol,nominal) VALUES('$pcn','$res2[car]','$res3[descricao]','$res3[espec]','$res3[numero]','$res3[pc]','$res3[simbolo]','$res3[tipo]','$res3[lie]','$res3[lse]','$res3[tol]','$res3[nominal]')") or erp_db_fail();
										$sql4=mysql_query("SELECT MAX(id) as id from apqp_op") or erp_db_fail(); 
										$res4=mysql_fetch_array($sql4);
										$item=$res4["id"];
									}
								}
								//Caboo operacaoo								
								$sql3=mysql_query("INSERT INTO apqp_endel (ensaio,car,ref,freq,qtd,forn,cli,ok) VALUES('$ens','$item','$res2[ref]','$res2[freq]','$res2[qtd]','$res2[forn]','$res2[cli]','$res2[ok]')") or erp_db_fail();
							}
				}
				break;
			case "apqp_sub":
				$doc=mysql_query("SELECT * FROM apqp_sub WHERE peca='$pc'");
				while($res=mysql_fetch_array($doc)){	
							$sql=mysql_query("INSERT INTO apqp_sub (peca,nota1,nota2,req1,req2,req3,razao,razao_esp,nivel,res1,res2,res3,res4,atende,atende_pq,taxa,coments,sit,disp,disp_pq) VALUES('$pcn','$res[nota1]','$res[nota2]','$res[req1]','$res[req2]','$res[req3]','$res[razao]','$res[razao_esp]','$res[nivel]','$res[res1]','$res[res2]','$res[res3]','$res[res4]','$res[atende]','$res[atende_pq]','$res[taxa]','$res[coments]','$res[sit]','$res[disp]','$res[disp_pq]')") or erp_db_fail();
				}
				break;
			case "apqp_apro":
				$end=mysql_query("SELECT * FROM apqp_apro WHERE peca='$pc'");
				while($res=mysql_fetch_array($end)){
					$sql=mysql_query("INSERT INTO apqp_apro (peca,local,comprador,data,razao1,razao2,aval,coments,sit) VALUES('$pcn','$res[local]','$res[comprador]','$res[data]','$res[razao1]','$res[razao2]','$res[aval]','$res[coments]','$res[sit]')") or erp_db_fail();
						$sql2=mysql_query("SELECT MAX(id) as id FROM apqp_apro"); $res2=mysql_fetch_array($sql2); $apr=$res2["id"];
							$sql=mysql_query("SELECT * FROM apqp_aprol WHERE apro='$res[id]'") or erp_db_fail();
							while($res2=mysql_fetch_array($sql)){							
								$sql3=mysql_query("INSERT INTO apqp_aprol (apro,suf,dl,da,db,de,cmc,num,data,tipo,fonte,ent) VALUES('$apr','$res2[suf]','$res2[dl]','$res2[da]','$res2[db]','$res2[de]','$res2[cmc]','$res2[num]','$res2[data]','$res2[tipo]','$res2[fonte]','$res2[ent]')") or erp_db_fail();
							}
				}
				break;
			case "apqp_inst":
				$pro=mysql_query("SELECT * FROM apqp_inst WHERE peca='$pc'");
				while($res=mysql_fetch_array($pro)){
							//operacaooo
								$sql3=mysql_query("SELECT * FROM apqp_op WHERE id='$res[op]'") or erp_db_fail(); 
								$res3=mysql_fetch_array($sql3);

								$sql4=mysql_query("SELECT * FROM apqp_op WHERE op='$res[op]' and peca='$pcn'") or erp_db_fail();
								if(mysql_num_rows($sql4)){
									$res4=mysql_fetch_array($sql4);
									$item=$res4["id"];
								}else{
									if(!empty($res2["item"])){
										$sql4=mysql_query("INSERT INTO apqp_op (peca,fmea,op,descricao,obs,macloc,numero,tipo) VALUES('$pcn','$res3[fmea]','$res2[item]','$res3[descricao]','$res3[obs]','$res3[macloc]','$res3[numero]','$res3[tipo]')") or erp_db_fail();
										$sql4=mysql_query("SELECT MAX(id) as id from apqp_op") or erp_db_fail(); 
										$res4=mysql_fetch_array($sql4);
										$item=$res4["id"];
									}
								}
								//Caboo operacaoo		
							$sql=mysql_query("INSERT INTO apqp_inst (peca,op,nome,numero,prep,prep_data,obs,rev,rev_data,rev_alt,sit,desenho) VALUES('$pcn','$item','$res[nome]','$res[numero]','$res[prep]','$res[prep_data]','$res[obs]','$res[rev]','$res[rev_data]','$res[rev_alt]','$res[sit]','$res[desenho]')") or erp_db_fail();
								$sql2=mysql_query("SELECT MAX(id) as id FROM apqp_inst"); $res2=mysql_fetch_array($sql2); $ins=$res2["id"];
							
							$sql=mysql_query("SELECT * FROM apqp_instp WHERE inst='$res[id]'");
							while($res2=mysql_fetch_array($sql)){
								$sql3=mysql_query("INSERT INTO apqp_instp (inst,tipo,texto) VALUES('$ins','$res2[tipo]','$res2[texto]')") or erp_db_fail();
							}

							$sql=mysql_query("SELECT * FROM apqp_instc WHERE inst='$res[id]'");
							while($res2=mysql_fetch_array($sql)){
								//operacaooo
								$sql3=mysql_query("SELECT * FROM apqp_car WHERE id='$res2[car]'") or erp_db_fail(); 
								$res3=mysql_fetch_array($sql3);

								$sql4=mysql_query("SELECT * FROM apqp_car WHERE car='$res2[car]' and peca='$pcn'") or erp_db_fail();
								if(mysql_num_rows($sql4)){
									$res4=mysql_fetch_array($sql4);
									$item=$res4["id"];
								}else{
									if(!empty($res["car"])){
										$sql4=mysql_query("INSERT INTO apqp_car (peca,car,descricao,espec,numero,pc,simbolo,tipo,lie,lse,tol,nominal) VALUES('$pcn','$res2[car]','$res3[descricao]','$res3[espec]','$res3[numero]','$res3[pc]','$res3[simbolo]','$res3[tipo]','$res3[lie]','$res3[lse]','$res3[tol]','$res3[nominal]')") or erp_db_fail();
										$sql4=mysql_query("SELECT MAX(id) as id from apqp_car") or erp_db_fail(); 
										$res4=mysql_fetch_array($sql4);
										$item=$res4["id"];
									}
								}
								//Caboo operacaoo		
								$sql3=mysql_query("INSERT INTO apqp_instc (inst,car,tecnicas,tamanho,freq,metodo,reacao) VALUES('$ins','$item','$res2[tecnicas]','$res2[tamanho]','$res2[freq]','$res2[metodo]','$res2[reacao]')") or erp_db_fail();
							}
				}
				break;
			case "apqp_plano":
				$end=mysql_query("SELECT * FROM apqp_plano WHERE peca='$pc'");
				while($res=mysql_fetch_array($end)){
					$sql=mysql_query("INSERT INTO apqp_plano (peca,fase,contato,equipe,ini,rev,numero,apro1,apro1_data,apro2,apro2_data,apro3,apro3_data,apro4,apro4_data,sit) VALUES('$pcn','$res[fase]','$res[contato]','$res[equipe]','$res[ini]','$res[rev]','$res[numero]','$res[apro1]','$res[apro1_data]','$res[apro2]','$res[apro2_data]','$res[apro3]','$res[apro3_data]','$res[apro4]','$res[apro4_data]','$res[sit]')") or erp_db_fail();
						$sql2=mysql_query("SELECT MAX(id) as id FROM apqp_plano"); $res2=mysql_fetch_array($sql2); $pla=$res2["id"];
							$sql=mysql_query("SELECT * FROM apqp_planoi WHERE plano='$res[id]'") or erp_db_fail();
							while($res2=mysql_fetch_array($sql)){
								//Caracteristicas
								$sql3=mysql_query("SELECT * FROM apqp_car WHERE id='$res2[car]'") or erp_db_fail(); 
								$res3=mysql_fetch_array($sql3);

								$sql4=mysql_query("SELECT * FROM apqp_car WHERE car='$res2[car]' and peca='$pcn'") or erp_db_fail();
								if(mysql_num_rows($sql4)){
									$res4=mysql_fetch_array($sql4);
									$item=$res4["id"];
								}else{
									if(!empty($res2["item"])){
										$sql4=mysql_query("INSERT INTO apqp_car (peca,car,descricao,espec,numero,pc,simbolo,tipo,lie,lse,tol,nominal) VALUES('$pcn','$res2[car]','$res3[descricao]','$res3[espec]','$res3[numero]','$res3[pc]','$res3[simbolo]','$res3[tipo]','$res3[lie]','$res3[lse]','$res3[tol]','$res3[nominal]')") or erp_db_fail();
										$sql4=mysql_query("SELECT MAX(id) as id from apqp_op") or erp_db_fail(); 
										$res4=mysql_fetch_array($sql4);
										$item=$res4["id"];
									}
								}
								//Caboo Cara e comeco Opera				
								$sql3=mysql_query("SELECT * FROM apqp_op WHERE id='$res2[op]'") or erp_db_fail(); 
								$res3=mysql_fetch_array($sql3);

								$sql4=mysql_query("SELECT * FROM apqp_op WHERE op='$res2[op]' and peca='$pcn'") or erp_db_fail();
								if(mysql_num_rows($sql4)){
									$res4=mysql_fetch_array($sql4);
									$op=$res4["id"];
								}else{
									if(!empty($res2["item"])){
										$sql4=mysql_query("INSERT INTO apqp_op (peca,fmea,op,descricao,obs,macloc,numero,tipo) VALUES('$pcn','$res3[fmea]','$res2[op]','$res3[descricao]','$res3[obs]','$res3[macloc]','$res3[numero]','$res3[tipo]')") or erp_db_fail();
										$sql4=mysql_query("SELECT MAX(id) as id from apqp_op") or erp_db_fail(); 
										$res4=mysql_fetch_array($sql4);
										$op=$res4["id"];
									}
								}
								//Cabo Operacao
								$sql3=mysql_query("INSERT INTO apqp_planoi (plano,op,car,tecnicas,tamanho,freq,metodo,reacao) VALUES('$pla','$op','$item','$res2[tecnicas]','$res2[tamanho]','$res2[freq]','$res2[metodo]','$res2[reacao]')") or erp_db_fail();
							}
				}
				break;
			case "apqp_cron":
				$doc=mysql_query("SELECT * FROM apqp_cron WHERE peca='$pc'");
				while($res=mysql_fetch_array($doc)){	
					$sql=mysql_query("INSERT INTO apqp_cron (peca,ativ,cod,ini,prazo,fim,perc,resp,obs,pos) VALUES('$pcn','$res[ativ]','$res[cod]','$res[ini]','$res[prazo]','$res[fim]','$res[perc]','$res[resp]','$res[obs]','$res[pos]')") or erp_db_fail();
				}
				break;
			case "apqp_viabilidade":
				$doc=mysql_query("SELECT * FROM apqp_viabilidade WHERE peca='$pc'");
				while($res=mysql_fetch_array($doc)){	
					$sql=mysql_query("INSERT INTO apqp_viabilidade (peca,sn1,sn2,sn3,sn4,sn5,sn6,sn7,sn8,sn9,sn10,sn11,sn12,sn13,obs,data,conclusao,ap1,ap2,ap3,ap4,ap5,ap6,dt1,dt2,dt3,dt4,dt5,dt6) VALUES('$pcn','$res[sn1]','$res[sn2]','$res[sn3]','$res[sn4]','$res[sn5]','$res[sn6]','$res[sn7]','$res[sn8]','$res[sn9]','$res[sn10]','$res[sn11]','$res[sn12]','$res[sn13]','$res[obs]','$res[data]','$res[conclusao]','$res[ap1]','$res[ap2]','$res[ap3]','$res[ap4]','$res[ap5]','$res[ap6]','$res[dt1]','$res[dt2]','$res[dt3]','$res[dt4]','$res[dt5]','$res[dt6]')") or erp_db_fail();
				}
				break;
			case "apqp_des":
				$doc=mysql_query("SELECT * FROM apqp_des WHERE peca='$pc'");
				while($res=mysql_fetch_array($doc)){	
					$sql=mysql_query("INSERT INTO apqp_des (peca,descr,obs,original,atual) VALUES('$pcn','$res[descr]','$res[obs]','$res[original]','$res[atual]')") or erp_db_fail();
				}
				break;
			case "apqp_granel":
				$doc=mysql_query("SELECT * FROM apqp_granel WHERE peca='$pc'");
				while($res=mysql_fetch_array($doc)){	
					$sql=mysql_query("INSERT INTO apqp_granel (peca,ap1,ap2,ap3,dap1,dap2,dap3) VALUES('$pcn','$res[ap1]','$res[ap2]','$res[ap3]','$res[dap1]','$res[dap2]','$res[dap3]')") or erp_db_fail();
				}
				$doc=mysql_query("SELECT * FROM apqp_granel2 WHERE peca='$pc'");
				while($res=mysql_fetch_array($doc)){	
					$sql=mysql_query("INSERT INTO apqp_granel2 (peca,prazo,rcli,rfor,coments,por,titulo,nome) VALUES('$pcn','$res[prazo]','$res[rcli]','$res[rfor]','$res[coments]','$res[por]','$res[titulo]','$res[nome]')") or erp_db_fail();
				}
				break;
			case "apqp_sum":
				$doc=mysql_query("SELECT * FROM apqp_sum WHERE peca='$pc'");
				while($res=mysql_fetch_array($doc)){	
					$sql=mysql_query("INSERT INTO apqp_sum (peca,data,ppk_req,ppk_ace,ppk_pen,pca,pca_dt,dim_amo,dim_car,dim_ace,dim_pen,vis_amo,vis_car,vis_ace,vis_pen,lab_amo,lab_car,lab_ace,lab_pen,des_amo,des_car,des_ace,des_pen,care_req,care_ace,care_pen,instm_req,instm_ace,instm_pen,folha_req,folha_ace,folha_pen,instv_req,instv_ace,instv_pen,apro_req,apro_ace,apro_pen,teste_req,teste_ace,teste_pen,plano) VALUES('$pcn','$res[descr]','$res[ppk_req]','$res[ppk_ace]','$res[ppk_pen]','$res[pca]','$res[pca_dt]','$res[dim_amo]','$res[dim_car]','$res[dim_ace]','$res[dim_pen]','$res[vis_amo]','$res[vis_car]','$res[vis_ace]','$res[vis_pen]','$res[lab_amo]','$res[lab_car]','$res[lab_ace]','$res[lab_pen]','$res[des_amo]','$res[des_car]','$res[des_ace]','$res[des_pen]','$res[care_req]','$res[care_ace]','$res[care_pen]','$res[instm_req]','$res[instm_ace]','$res[instm_pen]','$res[folha_req]','$res[folha_ace]','$res[folha_pen]','$res[instv_req]','$res[instv_ace]','$res[instv_pen]','$res[apro_req]','$res[apro_ace]','$res[apro_pen]','$res[teste_req]','$res[teste_ace]','$res[teste_pen]','$res[plano]')") or erp_db_fail();
				}
				break;
			case "apqp_chk":
/*
				$doc=mysql_query("SELECT * FROM apqp_chk WHERE peca='$pc'");
				while($res=mysql_fetch_array($doc)){	
					$sql=mysql_query("INSERT INTO apqp_chk (peca,sit) VALUES('$pcn','$res[sit]')") or erp_db_fail();
				}
				$doc=mysql_query("SELECT * FROM apqp_chk2 WHERE peca='$pc'");
				while($res=mysql_fetch_array($doc)){	
					$nome=$res["nome"];
					$nome=str_replace("'"," ",$nome);
					$sql=mysql_query("INSERT INTO apqp_chk2 (peca,titulo,num,nome,ok,coments,resp,data,anexo) VALUES('$pcn','$res[titulo]','$res[num]','$nome','$res[ok]','$res[coments]','$res[resp]','$res[data]','$res[anexo]')") or erp_db_fail();
				}
*/
				break;
		}
	}
}
header("Location:apqp_menu.php?pc=$pcn&menu=S&num=$numero_para&rev=$rev_para");
?>
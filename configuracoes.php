<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT);
if (session_status() == PHP_SESSION_NONE) {
    session_cache_expire(86400);
    session_start();
}

$wonline = true;
$docker = getenv('DB_HOST') ? true : false;

if($docker){
	$host = getenv('DB_HOST') ?: 'db';
	$user = getenv('DB_USER') ?: 'erp_user';
	$pwd = getenv('DB_PASS') ?: 'erp_password';
	$bd = getenv('DB_NAME') ?: 'erp_db';
}elseif($wonline){
	$host = "localhost";
	$user = "erp_user";
	$pwd = "erp_password";
	$bd = "erp_db";
}else{
	$host = "localhost";
	$user = "root";
	$pwd = "";
	$bd = "erp_db";
}
$wpaginacao=10;
$caminho=preg_replace("/\\\\/","/",__FILE__);
$caminho = dirname($caminho);
$permi=$_SESSION["permissao"];
$patch=$caminho;
function cortinas($largura,$altura){
	$tri=$largura;
	$qtdpe=ceil(($largura * 100) / 15.3);
	$mpvc=ceil($qtdpe*$altura);
	$arre=ceil($qtdpe*4);
	$parafu=ceil(4*$largura);
	$buchas=$parafu;
	$cont=array("trilho"=>$tri,"pvc"=>$mpvc,"arrebites"=>$arre,"parafusos"=>$parafu,"buchas"=>$buchas,"penduralg"=>$qtdpe,"penduralp"=>$qtdpe,"$qtdpe");
	return $cont;
}
function cortina_not($largura,$idco){
	$spc=mysql_query("SELECT * FROM cortinas_not WHERE id='$idco'"); $rpc=mysql_fetch_array($spc);
	$spc1=mysql_query("SELECT cs as pv FROM prodserv WHERE id='$rpc[tubo]'"); $rpc1=mysql_fetch_array($spc1);
		$spc2=mysql_query("SELECT cs as pv FROM prodserv WHERE id='$rpc[perfil1]'"); $rpc2=mysql_fetch_array($spc2);
			$spc3=mysql_query("SELECT cs as pv FROM prodserv WHERE id='$rpc[perfil2]'"); $rpc3=mysql_fetch_array($spc3);
			
	$pre=($rpc1["pv"]*$largura)+($rpc2["pv"]*$largura);
	if(!empty($rpc["perfil2"])){
		$pre+=($rpc3["pv"]*$largura);
	}
	return $pre;
}
function cortinasp($idc,$tr,$pv,$ar,$pa,$bu,$peg,$pep){
	$spc=mysql_query("SELECT * FROM cortinas WHERE id='$idc'"); $rpc=mysql_fetch_array($spc);
	$spc1=mysql_query("SELECT cs as pv FROM prodserv WHERE id='$rpc[trilho]'"); $rpc1=mysql_fetch_array($spc1);
		$spc2=mysql_query("SELECT cs as pv FROM prodserv WHERE id='$rpc[pvc]'"); $rpc2=mysql_fetch_array($spc2);
			$spc3=mysql_query("SELECT cs as pv FROM prodserv WHERE id='$rpc[arrebites]'"); $rpc3=mysql_fetch_array($spc3);
				$spc4=mysql_query("SELECT cs as pv FROM prodserv WHERE id='$rpc[parafusos]'"); $rpc4=mysql_fetch_array($spc4);
					$spc5=mysql_query("SELECT cs as pv FROM prodserv WHERE id='$rpc[buchas]'"); $rpc5=mysql_fetch_array($spc5);
						$spc6=mysql_query("SELECT cs as pv FROM prodserv WHERE id='$rpc[penduralg]'"); $rpc6=mysql_fetch_array($spc6);
							$spc7=mysql_query("SELECT cs as pv FROM prodserv WHERE id='$rpc[penduralp]'"); $rpc7=mysql_fetch_array($spc7);
	
	$trp=$rpc1["pv"]; $pvp=$rpc2["pv"]; $arp=$rpc3["pv"]; $pap=$rpc4["pv"];  $bup=$rpc5["pv"]; $pegp=$rpc6["pv"];  $pepp=$rpc7["pv"];
	$tri=$tr*$trp; $pvc=$pv*$pvp; $arr=$arp*$ar; $par=$pa*$pap; $buc=$bu*$bup; $peng=$peg*$pegp; $penp=$pep*$pepp;
	$totac=$tri+$pvc+$arr+$par+$buc+$peng+$penp;
	return $totac;
}
function perfilp($idpe,$qu){
	$sqlma=mysql_query("SELECT * FROM perfil WHERE id='$idpe'"); $resma=mysql_fetch_array($sqlma);
	
	$sqlma2=mysql_query("SELECT * FROM prodserv WHERE id='$resma[perfil]'"); $resma2=mysql_fetch_array($sqlma2);
	$perf=$resma2["cs"]*$qu;
	return $perf;
}
function perfil($perfilid,$largura,$altura){
	$sqlpo=mysql_query("SELECT * FROM perfil WHERE id='$perfilid'"); $respo=mysql_fetch_array($sqlpo);
	//PVC CRIStal
	if(!empty($respo["b1"])){
		if($respo["b1"]=="1"){
			$la=$largura-0.12;
		}else if($respo["b1"]=="2"){
			$la=($largura-0.24)/2;
		}
		//Altura
		$la=(2*$respo["b1"])*$la;
		//Largura
		$al=$altura-0.16;
		$al=(2*$respo["b1"])*$al;
		//FInal
		$perf=$al+$la;
	}
	return $perf;
}
function pvcp($tp,$pvid,$qu){
	$sqlma=mysql_query("SELECT * FROM portasp WHERE id='$pvid'"); $resma=mysql_fetch_array($sqlma);
	if($tp=="ci"){
		$sqlma2=mysql_query("SELECT * FROM prodserv WHERE id='$resma[pvc_inferior]'"); $resma2=mysql_fetch_array($sqlma2);
		$precoc=$resma2["cs"]*$qu;
	}else if($tp=="cs"){
		$sqlma3=mysql_query("SELECT * FROM prodserv WHERE id='$resma[pvc_superior]'"); $resma3=mysql_fetch_array($sqlma3);
		$precoc=$resma3["cs"]*$qu;
	}else if($tp=="cr"){
		$sqlma4=mysql_query("SELECT * FROM prodserv WHERE id='$resma[pvc_cristal]'"); $resma4=mysql_fetch_array($sqlma4);
		$precoc=$resma4["cs"]*$qu;
	}	
	return $precoc;
}
function pvccs($pvcid,$largura,$altura){
	$sqlpo=mysql_query("SELECT * FROM portasp WHERE id='$pvcid'"); $respo=mysql_fetch_array($sqlpo);
	//PVC CINZA SUperior
	if(!empty($respo["b1"])){
		if($respo["b1"]=="1"){
			$cs=$largura-0.01;
		}else if($respo["b1"]=="2"){
			$cs=($largura+0.08)/2;
		}
		$cs=$respo["b1"]*$cs*$respo["co1"];
	}
	return $cs;
}
function pvcci($pvcid,$largura,$altura){
	$sqlpo=mysql_query("SELECT * FROM portasp WHERE id='$pvcid'"); $respo=mysql_fetch_array($sqlpo);
	//PVC CInza INFERIOR
	if(!empty($respo["b2"])){
		if($respo["b2"]=="1"){
			$ci=$largura-0.01;
		}else if($respo["b2"]=="2"){
			$ci=($largura+0.08)/2;
		}
		$ci=$respo["b2"]*$ci*$respo["co2"];
	}
	return $ci;
}
function pvccr($pvcid,$largura,$altura){
	$sqlpo=mysql_query("SELECT * FROM portasp WHERE id='$pvcid'"); $respo=mysql_fetch_array($sqlpo);
	//PVC CRIStal
	if(!empty($respo["b3"])){
		$corte=$altura-$respo["co1"]-$respo["co2"];
		if($respo["b3"]=="1"){
			$cr=$largura-0.01;
		}else if($respo["b3"]=="2"){
			$cr=($largura+0.08)/2;
		}
		$cr=$respo["b3"]*$cr*$corte;
	}
	return $cr;
}
function prazoc($com,$dta){
	$sqlpra=mysql_query("SELECT MAX(prodserv.prazo_entrega) as prazo FROM prodserv,e_itens WHERE e_itens.compra='$com' AND e_itens.produto_id=prodserv.id");
	$respra=mysql_fetch_array($sqlpra);
	$prazu=$respra["prazo"];
	$dt=explode("-",$dta);
	$prazod=date("d/m/Y",mktime(0,0,0,$dt[1],$dt[2]+$prazu,$dt[0]));
	if(empty($dta)){ return $prazu; }else{ return $prazod; }
}
function CalculaCpf($CampoNumero)
{
$RecebeCPF=$CampoNumero;
$s="";
for ($x=1; $x<=strlen($RecebeCPF); $x=$x+1)
{
$ch=substr($RecebeCPF,$x-1,1);
if (ord($ch)>=48 && ord($ch)<=57)
{
$s=$s.$ch;
}
}
$RecebeCPF=$s;

if (strlen($RecebeCPF)!=11)
{
return 0;
}
else
if ($RecebeCPF=="00000000000")
{
$then;
return 0;
}
else
{
$Numero[1]=intval(substr($RecebeCPF,1-1,1));
$Numero[2]=intval(substr($RecebeCPF,2-1,1));
$Numero[3]=intval(substr($RecebeCPF,3-1,1));
$Numero[4]=intval(substr($RecebeCPF,4-1,1));
$Numero[5]=intval(substr($RecebeCPF,5-1,1));
$Numero[6]=intval(substr($RecebeCPF,6-1,1));
$Numero[7]=intval(substr($RecebeCPF,7-1,1));
$Numero[8]=intval(substr($RecebeCPF,8-1,1));
$Numero[9]=intval(substr($RecebeCPF,9-1,1));
$Numero[10]=intval(substr($RecebeCPF,10-1,1));
$Numero[11]=intval(substr($RecebeCPF,11-1,1));

$soma=10*$Numero[1]+9*$Numero[2]+8*$Numero[3]+7*$Numero[4]+6*
$Numero[5]+5*$Numero[6]+4*$Numero[7]+3*$Numero[8]+2*$Numero[9];
$soma=$soma-(11*(intval($soma/11)));

if ($soma==0 || $soma==1)
{
$resultado1=0;
}
else
{
$resultado1=11-$soma;
}

if ($resultado1==$Numero[10])
{
$soma=$Numero[1]*11+$Numero[2]*10+$Numero[3]*9+$Numero[4]*
8+$Numero[5]*7+$Numero[6]*6+$Numero[7]*5+$Numero[8]*
4+$Numero[9]*3+$Numero[10]*2;
$soma=$soma-(11*(intval($soma/11)));
if ($soma==0 || $soma==1)
{
$resultado2=0;
}
else
{

$resultado2=11-$soma;
}
if ($resultado2==$Numero[11])
{
return 1; //echo "<h1>CPF V�lido</h1>";
}
else
{
return 0;
}
}
else
{
return 0;
}
}
}
//Fun��o que calcula CNPJ

  function CalculaCNPJ($CampoNumero)
  {
   $RecebeCNPJ=${"CampoNumero"};

   $s="";
   for ($x=1; $x<=strlen($RecebeCNPJ); $x=$x+1)
   {
    $ch=substr($RecebeCNPJ,$x-1,1);
    if (ord($ch)>=48 && ord($ch)<=57)
    {
     $s=$s.$ch;
    }
   }

   $RecebeCNPJ=$s;
   if (strlen($RecebeCNPJ)!=14)
   {
     return 0;
   }
   else
    if ($RecebeCNPJ=="00000000000000")
    {
     $then;
     echo "<h1>CNPJ Inv&aacute;lido</h1>";
   }
   else
   {
    $Numero[1]=intval(substr($RecebeCNPJ,1-1,1));
    $Numero[2]=intval(substr($RecebeCNPJ,2-1,1));
    $Numero[3]=intval(substr($RecebeCNPJ,3-1,1));
    $Numero[4]=intval(substr($RecebeCNPJ,4-1,1));
    $Numero[5]=intval(substr($RecebeCNPJ,5-1,1));
    $Numero[6]=intval(substr($RecebeCNPJ,6-1,1));
    $Numero[7]=intval(substr($RecebeCNPJ,7-1,1));
    $Numero[8]=intval(substr($RecebeCNPJ,8-1,1));
    $Numero[9]=intval(substr($RecebeCNPJ,9-1,1));
    $Numero[10]=intval(substr($RecebeCNPJ,10-1,1));
    $Numero[11]=intval(substr($RecebeCNPJ,11-1,1));
    $Numero[12]=intval(substr($RecebeCNPJ,12-1,1));
    $Numero[13]=intval(substr($RecebeCNPJ,13-1,1));
    $Numero[14]=intval(substr($RecebeCNPJ,14-1,1));

    $soma=$Numero[1]*5+$Numero[2]*4+$Numero[3]*3+$Numero[4]*2+$Numero[5]*9+$Numero[6]*8+$Numero[7]*7+
    $Numero[8]*6+$Numero[9]*5+$Numero[10]*4+$Numero[11]*3+$Numero[12]*2;

    $soma=$soma-(11*(intval($soma/11)));

   if ($soma==0 || $soma==1)
   {
     $resultado1=0;
   }
   else
   {
    $resultado1=11-$soma;
   }
   if ($resultado1==$Numero[13])
   {
    $soma=$Numero[1]*6+$Numero[2]*5+$Numero[3]*4+$Numero[4]*3+$Numero[5]*2+$Numero[6]*9+
    $Numero[7]*8+$Numero[8]*7+$Numero[9]*6+$Numero[10]*5+$Numero[11]*4+$Numero[12]*3+$Numero[13]*2;
    $soma=$soma-(11*(intval($soma/11)));
    if ($soma==0 || $soma==1)
    {
     $resultado2=0;
    }
   else
   {
   $resultado2=11-$soma;
   }
   if ($resultado2==$Numero[14])
   {
    return 1;
   }
   else
   {
    return 0;
   }
  }
  else
  {
    return 0;
  }
 }
}
//Fim do Calcula CNPJ
function cortar($campo,$palavras){
$pal=explode(" ",$campo); 
$qua=$palavras; 
	for($i=0; $i<$qua; $i++){
	$text.=$pal[$i]." ";
	}
	return $text;
}
function dimi($num,$casas){
	$dois=explode(".",$num);
	$pal=substr($dois[1],0,$casas);
	$fin=$dois[0].".".$pal;
	return $fin;
}
function verifi($valor,$ac){

	if($ac=="exc"){
		if($valor=="4" or $valor=="2"){
			$acao=$ac;
		}else{
			print "<script>window.alert('Voc� n�o tem permiss�o para isso, entre em contato com administrador');window.location='javascript:history.go(-1)';</script>";
			$acao="";
		}
	}else if($ac=="incluir" or $ac=="inc" or $ac=="ordeminc"){
		if($valor=="4" or $valor=="3"){
			$acao=$ac;
		}else{
			print "<script>window.alert('Voc� n�o tem permiss�o para isso, entre em contato com administrador');window.location='javascript:history.go(-1)';</script>";
			$acao="";
		}
	}else if($ac=="alterar" or $ac=="v1" or $ac=="v2" or $ac=="v3" or $ac=="v4" or $ac=="rr2" or $ac=="rr3" or $ac=="cap2" or $ac=="cap3" or $ac=="s1" or $ac=="s2" or $ac=="s3" or $ac=="s4" or $ac=="i0" or $ac=="i1" or $ac=="altp" or $ac=="g2" or $ac=="venda" or $ac=="custo" or $ac=="ordemcan" or $ac=="ordemalt" or $ac=="ecom" or $ac=="ordemver" or $ac=="em" or $ac=="sm" or $ac=="ee" or $ac=="es"){
		if($valor=="4" or $valor=="3"){
			$acao=$ac;
		}else{
			print "<script>window.alert('Voc� n�o tem permiss�o para isso, entre em contato com administrador');window.location='javascript:history.go(-1)';</script>";
			$acao="";
		}
	}else{
		$acao=$ac;
	}
	return $acao;	
}
function data2banco ($d2b) { 
	if(!empty($d2b)){
		$d2b_ano=substr($d2b,6,4);
		$d2b_mes=substr($d2b,3,2);
		$d2b_dia=substr($d2b,0,2);		
		$d2b="$d2b_ano-$d2b_mes-$d2b_dia";
	}
	return $d2b; 
} 
function banco2data($b2d) { 
	if($b2d=="0000-00-00" or empty($b2d)){
		$b2d="";
		return $b2d;
	}else{
		$b2d_ano=substr($b2d,0,4);
		$b2d_mes=substr($b2d,5,2);
		$b2d_dia=substr($b2d,8,2);		
		$b2d=$b2d_dia.'/'.$b2d_mes.'/'.$b2d_ano;
		return $b2d; 
	}
}
function segundos($hs){
	$dado=explode(":",$hs);
	$hs=$dado[0];
	$mins=$dado[1];
	$segs=$dado[2];
	if($hs>0){
		$mins+=$hs*60;
	}
	if($mins>0){
		$segs+=$mins*60;
	}
	return $segs;
}
function hora(){
	$hr= date("H:i:s");
	return $hr;
}
function valor2banco($vl){
	$vl=str_replace(".","",$vl);
	return str_replace(",",".",$vl);
}
function banco2valor($vl){
	return number_format($vl,2,",",".");
}
function banco2valor3($vl){
	return number_format($vl,3,",",".");
}
function completa($vl,$cs){
	return str_pad($vl, $cs, "0", STR_PAD_LEFT);
}
function email($demail,$denome,$paramail,$paranome,$wassunto,$wmsg){
	if(empty($denome)) $denome=$demail;
	if(empty($paranome)) $paranome=$paramail;
	if($wonline){
		mail("$paranome<$paramail>",$wassunto,$wmsg,"From: $denome<$demail>\nContent-type: text/html\n");
	}else{
		mail($paramail,$wassunto,$wmsg,"From: $demail\nContent-type: text/html\n");
	}
}
function extensao($warq){
	if(substr($warq,strlen($warq)-4,1)=="."){
		$wext=substr($warq,strlen($warq)-3,3);
	}elseif(substr($warq,strlen($warq)-5,1)=="."){
		$wext=substr($warq,strlen($warq)-4,4);
	}
	return $wext;
}
function bytes($bt){
	if($bt<1024){
		$bt=$bt." b";
	}else if($bt>1024 and $bt<1048576){
		$bt=intval($bt/1024)." Kb";
	}else{
		$bt= number_format($bt/1024/1024,2,",",".")." Mb";
	}				
	return $bt;
}
//classe OOP para bancos
class bd_c {
/*
 	  $bd->list_add("id","C�digo"); 
	  $bd->list_add("pentacode","PentaCode");
  	  $bd->list_add("nome","Nome");
	  $bd->list_add("marca","Marca");
	  $bd->set_wid("500");
	  $bd->set_align("center");
	  $bd->set_campo("id");
	  $bd->set_ord("DESC");
	  $bd->list_bd("ope_penta_itens","Itens");
 */
	var $campo=array();
	var $align="left";
	var $widtht;
	var $orde="id";
	var $ordem="DESC";
	function pega_nome_bd($tabela,$campo,$idv,$idc="id"){
		$sqlpdb=mysql_query("SELECT $campo FROM $tabela WHERE $idc='$idv'");
		if(mysql_num_rows($sqlpdb)){
			$respdb=mysql_fetch_array($sqlpdb);
			print $respdb["$campo"];
		}else{
			print "N�o Localizado";
		}
	}
	function pega_ultimo_bd($tabela,$campo){
		$sqlpdb=mysql_query("SELECT MAX($campo) as $campo FROM $tabela");
		if(mysql_num_rows($sqlpdb)){
			$respdb=mysql_fetch_array($sqlpdb);
			return $respdb["$campo"];
		}else{
			return 0;
		}
	}
	function pega_nome_bd2($tabela,$campo,$idv,$idc="id"){
		$sqlpdb=mysql_query("SELECT $campo FROM $tabela WHERE $idc='$idv'");
		if(mysql_num_rows($sqlpdb)){
			$respdb=mysql_fetch_array($sqlpdb);
			return $respdb["$campo"];
		}else{
			return "N�o Localizado";
		}
	}
	//	$bd->list_bd("ope_setor","SETOR");
	function list_bd($tabela,$ide){
		print "<table width=\"$this->widtht\" border=\"0\" align=\"$this->align\" cellpadding=\"0\" cellspacing=\"1\" bgcolor=\"#003366\">
        <tr class=\"textoboldbranco\">";
		foreach($this->campo as $key=>$valor){
        	print "<td>$valor</td>";
		}
		print "<td width=\"25\" align=\"center\">&nbsp;</td>
          <td width=\"26\" align=\"center\">&nbsp;</td>
        </tr>";
			  $sqla=mysql_query("SELECT * FROM $tabela ORDER BY $this->orde $this->ordem");
			  if(mysql_num_rows($sqla)==0){
				print "	<tr bgcolor=\"#FFFFFF\"> 
					  <td colspan=\"3\" align=\"center\" class=\"textobold\">NENHUM $ide CADASTRADO</td>
					</tr>";
			  }else{
			 	 	while($resa=mysql_fetch_array($sqla)){
			 		print "<tr bgcolor=\"#FFFFFF\" class=\"texto\" onMouseover=\"changeto('#CCCCCC')\" onMouseout=\"changeback('#FFFFFF')\">";
					foreach($this->campo as $key=>$valor){
						print "<td>&nbsp;$resa[$key]</td>";
					}
					print "<td width=\"25\" align=\"center\"><a href=\"$_SERVER[PHP_SELF]?acao=alt&id=$resa[id]\"><img src=\"imagens/icon14_alterar.gif\" alt=\"Alterar\" width=\"14\" height=\"14\" border=\"0\"></a></td>
					  <td width=\"26\" align=\"center\"><a href=\"#\" onClick=\"return pergunta('Deseja excluir este Setor?','$_SERVER[PHP_SELF]?acao=exc&id=$resa[id]')\"><img src=\"imagens/icon14_lixeira.gif\" alt=\"Excluir\" width=\"14\" height=\"14\" border=\"0\"></a></td>
					</tr>";
			  		}
			  }
			  
     	print "</table>";
	}
}
class set_bd extends bd_c{
	function list_add($campo,$campo_nome){
		$this->campo[$campo]="$campo_nome";
	}
	function set_wid($tamanho){
		$this->widtht=$tamanho;
	}
	function set_align($alin){
		$this->align=$alin;
	}
	function set_campo($campo){
		$this->orde=$campo;
	}
	function set_ord($campo1){
		$this->ordem=$campo1;
	}
	function list_exi(){
		foreach($this->campo as $key=>$valor){
			print "$key e $valor <br>";
		}
	}
}
?>
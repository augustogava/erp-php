<?php
session_start();
session_cache_expire(86400);
$wonline="qualitest";

switch ($wonline) {
case "protesuper":
	$host = ("localhost");
	$user = ("protesup_cyber");
	$pwd = ("1478963");
	$bd = ("protesup_protodb");
	break;
case "quality":
	$host = ("localhost");
	$user = ("qualitym_cyber");
	$pwd = ("1478963");
	$bd = ("qualitym_db");
	break;
case "local":
	$host = ("weblocal");
	$user = ("root");
	$pwd = ("");
	$bd = ("v4_0_db");
	break;
case "qualitest":
	$host = ("localhost");
	$user = ("qualitym_test");
	$pwd = ("1478963");
	$bd = ("qualitym_testq");
	break;
case "v4_0":
	$host = ("weblocal");
	$user = ("root");
	$pwd = ("");
	$bd = ("v4_0_db");
	break;
case "feeder":
	$host = ("localhost");
	$user = ("root");
	$pwd = ("jke852");
	$bd = ("feederd_test_db");
	break;
}
$wenvmenda="compras@molasfeeder.com.br";
$wpaginacao=10; // numero de links da paginacao E´s do FEEEEEDER
$caminho=ereg_replace("\\\\","/",__FILE__);
$caminho = dirname ($caminho);
$patch=$caminho;

/**
 * Centralized DB failure handler (Qualidade module).
 * Avoids leaking raw SQL errors to users while still logging for debugging.
 */
function erp_db_fail(string $userMessage = "Erro no banco de dados. Tente novamente ou contate o administrador."): void {
	$err = function_exists('mysql_error') ? mysql_error() : '';
	if (!empty($err)) {
		error_log("DB_ERROR: " . $err);
	}
	die($userMessage);
}
$emailt=explode(",",$_SESSION["e_mail_t"]);
$iduser=$_SESSION["login_codigo"];
$permi=$_SESSION["permissao"];
$aprov=$_SESSION["aprovar"];
$endcomp="http://www.feeder.com.br/cybermanager";
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
return 1; //echo "<h1>CPF Válido</h1>";
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
//Função que calcula CNPJ

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
	$hr=segundos($hr);
	//$hr=$hr+(3600*3); //mudar 3600*2 para 3600*3 quando em horario de verao
	$ret=date("H:i:s", mktime(0,0,$hr));
	return $ret;
}
function valor2banco($vl){
	$vl=str_replace(".","",$vl);
	return str_replace(",",".",$vl);
}
function valor2banco2($vl){
	$vl=str_replace(".",".",$vl);
	return str_replace(",",".",$vl);
}
function banco2valor($vl){
	return number_format($vl,2,",",".");
}
function banco2valor2($vl){
	return number_format($vl,3,",",".");
}
function banco2valor3($vl){
	return number_format($vl,5,",",".");
}
function banco2valor4($vl){
	return number_format($vl,4,",",".");
}
function completa($vl,$cs){
	while(strlen($vl)<$cs){
		$vl="0".$vl;
	}
	return $vl;
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
function verifi($valor,$ac){
	if($ac=="exc"){
		if($valor=="4" or $valor=="2"){
			$acao=$ac;
		}else{
			print "<script>window.alert('Você não tem permissão para isso, entre em contato com administrador');window.location='javascript:history.go(-1)';</script>";
			$acao="";
		}
	}else if($ac=="incluir" or $ac=="inc"){
		if($valor=="4" or $valor=="3"){
			$acao=$ac;
		}else{
			print "<script>window.alert('Você não tem permissão para isso, entre em contato com administrador');window.location='javascript:history.go(-1)';</script>";
			$acao="";
		}
	}else if($ac=="salvar" or $ac=="sel" or $ac=="alterar" or $ac=="alt" or $ac=="altc" or $ac=="altt" or $ac=="v1" or $ac=="v2" or $ac=="v3" or $ac=="v4" or $ac=="rr2" or $ac=="rr3" or $ac=="cap2" or $ac=="cap3" or $ac=="s1" or $ac=="s2" or $ac=="s3" or $ac=="s4" or $ac=="i0" or $ac=="i1" or $ac=="altp" or $ac=="g2"){
		if($valor=="4" or $valor=="3"){
			$acao=$ac;
		}else{
			print "<script>window.alert('Você não tem permissão para isso, entre em contato com administrador');window.location='javascript:history.go(-1)';</script>";
			$acao="";
		}
	}else{
		$acao=$ac;
	}
	return $acao;	
}
function gensym($prefix = "_gensym") {
    $i = 0;
    while (isset($GLOBALS[$prefix . $i]))
        $i++;
    return $prefix . $i;
}
function rsum($a, $b) {
    $a += $b;
	return $a;
}
function rsum2($a, $b) {
	global $sigmedia;
	$a += pow($b-$sigmedia,2);
	return $a;
}
function mean(&$hits, $total = false) {
    $n = count($hits);
    if (!$total)
        $total = array_reduce($hits, 'rsum');
    return (float) $total / ($n * 1.0);
}
function desvio($arr){
	global $sigmedia;
	$sigmedia=mean($arr);
	$som=array_reduce($arr, 'rsum2');
	$n = count($arr);
	return sqrt($som/($n));
}
function qlinha($ql){
	for($g=1;$g<=$ql;$g++){
		$str.="\n ";
	}
	return $str;
}
function crip($nvar){
	$nvar=base64_encode(urlencode($nvar));
	return $nvar;
}
function dcrip($nvar){
	$nvar=urldecode(base64_decode($nvar));
	return $nvar;
}
function flinha($texto,$lm){
	//separando as palavras
	$ltr=explode(" ", $texto);
	//contando numero de palavras
	$np=count($ltr);
	//contato numero de letras em cada palavra
	for($x=0;$x<=$np;$x++){
		if($x==$np){
			$nlp[$x]=strlen($ltr[$x]);
		}else{
			$nlp[$x]=strlen($ltr[$x])+1;
		}
	}
/*
	foreach($nlp as $key=>$valor){
		$tot+=$valor;
		print " $valor <br> ";
	}
		print $tot;
*/
	//inserindo as quebras de linha no texto
	$linha=1;
	//print "palavras= $np ";
	for($y=0;$y<=$np;$y++){
		$la+=$nlp[$y];
		if($la>($lm)){
			//$resultado.=" \n ".$ltr[$y]." ";
			$la=0;
			$la+=$nlp[$y];
			$linha++;
		}elseif($la==($lm)){
			$la=0;
			$linha++;
		}
	}
	//return $resultado;
	return $linha;
}

class apqp {
	var $user;
	var	$pc;
	var	$npc;
	var $nivel;
	var $titulo;
	var $msg;
	//construtora
	function apqp(){
		$this->user=$_SESSION["login_codigo"];
		$this->pc=$_SESSION["mpc"];
		$this->npc=$_SESSION["npc"];
		$this->nivel=$_SESSION["login_nivel"];
	}
	function email(){
		// enviar e-mail para a gerência
		$query = mysql_query("SELECT * FROM emails");
		$sql4=mysql_query("SELECT * FROM funcionarios WHERE id='$this->user'");	
		$res4=mysql_fetch_array($sql4);
		$res_para=mysql_fetch_array($query);
		$i = 0;
		
		while ($i < mysql_num_fields($query)) {
				$campo = mysql_fetch_field($query,$i);
				$from="From: $quem<$res4[email]>";
				$email=$res_para[$campo->name];
				mail("$email","$this->titulo","$this->msg","$from");
				$i++;
		}
	}
	function cliente_apro($pag){
	// Cliente Aprovou? se simmm se fudeu
		$sqlv=mysql_query("SELECT * FROM apqp_pc WHERE id='$this->pc'");
		$resv=mysql_fetch_array($sqlv);
		if($resv["status"]>2){
			$_SESSION["mensagem"]="Não pode ser alterado pois o cliente já aprovou!!";
			header("Location:$pag");
			exit;
		}
	//Se está aprovado Sub - - - - - - - - - - - - - - - - - - -  - - - - - - - - -
		$sqlb=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$this->pc' AND ativ='Certificado de Submissão'");
		//print "SELECT * FROM apqp_cron WHERE perc='100' AND peca='$this->pc' AND ativ='Certificado de Submissão'";
		//exit;
		if(mysql_num_rows($sqlb)){
				$sqlb=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$this->pc'");
				while($resb=mysql_fetch_array($sqlb)){
					//todos
					$sqlc=mysql_query("UPDATE apqp_cron SET resp='',perc='95',fim='' WHERE peca='$this->pc' AND ativ='$resb[ativ]'");
				}	
					//Sub
					$sql=mysql_query("UPDATE apqp_sub SET sit='N', quem='', dtquem='0000-00-00' WHERE peca='$this->pc'");
					//Sumario
					$sql=mysql_query("UPDATE apqp_sum SET ap1='',ap2='',ap3='',ap4='',ap5='',ap6='', dap1='0000-00-00', dap2='0000-00-00', dap3='0000-00-00', dap4='0000-00-00', dap5='0000-00-00', dap6='0000-00-00' WHERE peca='$this->pc'");
					//Proocesso
					$sql=mysql_query("UPDATE apqp_fmeaproc SET quem='', dtquem='' WHERE peca='$this->pc'");
					//Desempenho
					$sql=mysql_query("UPDATE apqp_ende SET sit='N', quem='', dtquem='0000-00-00' WHERE peca='$this->pc'");
					//Dimensional
					$sql=mysql_query("UPDATE apqp_endi SET sit='N', quem='', dtquem='0000-00-00' WHERE peca='$this->pc'");
					//material
					$sql=mysql_query("UPDATE apqp_enma SET sit='N', quem='', dtquem='0000-00-00' WHERE peca='$this->pc'");
					//CAP
					$sqlh=mysql_query("UPDATE apqp_cap SET sit=0,quem='',dtquem='' WHERE peca='$this->pc'");
					//RR
					$sqlg=mysql_query("UPDATE apqp_rr SET sit=0,quem='', dtquem='' WHERE peca='$this->pc'");
					//plano
					$sqlf=mysql_query("UPDATE apqp_plano SET sit='N', quem='', dtquem='' WHERE peca='$this->pc'");
					//Viabilidade
					$sqld=mysql_query("UPDATE apqp_viabilidade SET ap1='',ap2='',ap3='',ap4='',ap5='',ap6='', dt1='0000-00-00',dt2='0000-00-00',dt3='0000-00-00',dt4='0000-00-00',dt5='0000-00-00',dt6='0000-00-00' WHERE peca='$this->pc'");
		}
		$sqlv=mysql_query("UPDATE apqp_pc SET status='1' WHERE id='$this->pc'");
	}
	function agenda_p($est,$page){
		switch($est){
			case "Estudos de RR":
				$esta="Estudos de R&R";
				break;
				default:
				$esta=$est;
		}
		
		$sqla=mysql_query("SELECT * FROM agenda WHERE pc='$this->pc' AND estudo='$esta' AND sit='N'");
		$resa=mysql_fetch_array($sqla);
			if($resa["nome"]==$_SESSION["login_nome"] or $this->nivel==1){
				$tarefa="return pergunta('Você já realizou este compromisso?','apqp_agendaf.php?conf=$resa[numero]&pc=$this->pc&es=$est&pag=$page');";
			}else{
				$tarefa="return mensagem('Este compromisso não foi agendado para você');";
			}
		if(mysql_num_rows($sqla)){
			print "<input name=\"finaliza_\" type=\"submit\" class=\"microtxt\" value=\"Finalizar Tarefa\" onClick=\"$tarefa\">";
		}
	}
	function agenda($es){
		//selecionar número
		$sqla=mysql_query("SELECT * FROM agenda WHERE pc='$this->pc' AND estudo='$es' AND sit='N'");
		$resa=mysql_fetch_array($sqla);
		$conf=$resa["numero"];
		
		$sql=mysql_query("UPDATE agenda SET sit='S',reagendada='N' WHERE numero='$conf'");
	
		$sql_agenda=mysql_query("SELECT * FROM agenda WHERE numero='$conf'");
		$res_agenda=mysql_fetch_array($sql_agenda);
		
		$now=hora();
		$tit=$res_agenda["titulo"];
		$ray1=explode("-",$tit);
		
		mysql_query("INSERT INTO postit (quem,titulo,msg,data,hora,de,denum) VALUES ('$res_agenda[user_apro]', '$ray1[0]', 'O usuário $login_nome já finalizou o estudo $ray1[0] e está aguardando a sua aprovação.', '$data', '$now', '$login_nome', '$codigo')");
		// e-mail para o responsável do cronograma
		//pegar usuario responsavel aprovaçao
			$sql3=mysql_query("SELECT * FROM agenda WHERE numero='$conf'");	
			$res3=mysql_fetch_array($sql3);
			$sql4=mysql_query("SELECT * FROM funcionarios WHERE id='$res3[user_apro]'");	
			$res4=mysql_fetch_array($sql4);
		//pegar resp responsável pelo estudo
			$sql5=mysql_query("SELECT id FROM funcionarios WHERE nome='$login_nome'");	
			$res5=mysql_fetch_array($sql5);
			$sql6=mysql_query("SELECT * FROM funcionarios WHERE id='$res5[id]'");	
			$res6=mysql_fetch_array($sql6);
			
			$inicio=banco2data($res3[ini]);
			$prazo=banco2data($res3[prazo]);
			$mensagem="$res4[nome], o $res6[nome] já finalizou o estudo $ray1[0] da peça $ray1[1]-$ray1[2].";
			$from="From: $login_nome<$res4[email]>";
			mail($res4["email"],$ray1[0],$mensagem,$from);
		//
		
		// cria followup
			
			$sql_emp=mysql_query("SELECT fantasia FROM empresa");
			$res_emp=mysql_fetch_array($sql_emp);
			mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao) VALUES ('$res_emp[fantasia]','$data','$now','Finalização da $ray1[0]$ray1[1]-$ray1[2].','O usuário $login_nome finalizou a atividade $ray1[0]$ray1[1]-$ray1[2].')");
		//
	}
	
}
class set_apqp extends apqp {
	function set_email($tit_e,$msg_e){
		$this->titulo=$tit_e;
		$this->msg=$msg_e;
	}
}
?>
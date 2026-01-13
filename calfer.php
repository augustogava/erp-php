<? 
if(empty($cal_dia))$cal_dia=date("d");	
if(empty($cal_mes))$cal_mes=date("m");
if(empty($cal_ano))$cal_ano=date("Y");
$cal_dia++;
$cal_dia--;
$cal_mes++;
$cal_mes--;
$dataini=$cal_ano."-".$cal_mes."-01";
$datafim=$cal_ano."-".$cal_mes."-31";
$hj="$cal_ano-$cal_mes-$cal_dia";
$diames=$cal_dia.$cal_mes;
$sql=mysql_query("SELECT * FROM feriados WHERE (dia<='$datafim' AND dia>='$dataini') OR anual='S'");
if(mysql_num_rows($sql)!=0){
	while($res=mysql_fetch_array($sql)){
		$i=substr($res['dia'],8,2);
		$i++;
		$i--;
		if($res["anual"]=="N"){
			$marca[$i]="S";
		}else{
			if($cal_mes < 10) $cal_mes2="0$cal_mes";
			$diames=substr($res['dia'],8,2).$cal_mes2;
			if($diames==$res["diames"]){
				$marca[$i]="S";
			}
		}
	}
}
$img_esq="imagens/l.gif";
$img_dir="imagens/r.gif";
$PageName="feriados.php";
$fontsize = 1;
$cellcolor = "ffffff";
$headcellcolor = "003366";
$headtextcolor = "ffffff";
$edgecolor = "000000";
$topcolor = "ffffff";
$headfontcolor = "000000";
$dia_ativo = "003366";
$corferiado = "00FFFF";
$cornaoutil = "FFCC99";
$diascolor = "003366";
$dia_ativo = "cccccc";
$ExtraURI ="";
function ver_mes($mes1){
	switch($mes1){
		case 1:
			$mes2 = 'Janeiro';
			break;
		case 2:
			$mes2 = 'Fevereiro';
			break;
		case 3:
			$mes2 = 'Março';
			break;
		case 4:
			$mes2 = 'Abril';
			break;
		case 5:
			$mes2 = 'Maio';
			break;
		case 6:
			$mes2 = 'Junho';
			break;
		case 7:
			$mes2 = 'Julho';
			break;
		case 8:
			$mes2 = 'Agosto';
			break;
		case 9:
			$mes2 = 'Setembro';
			break;
		case 10:
			$mes2 = 'Outubro';
			break;
		case 11:
			$mes2 = 'Novembro';
			break;
		case 12:
			$mes2 = 'Dezembro';
			break;
	}
	return $mes2;
}
$mes_ativo = $cal_mes;
$ano_ativo = $cal_ano;
$ultimo_dia = date ("d", mktime (0,0,0,$mes_ativo+1,0,$ano_ativo));		// Laatste dag van deze maand (0 van volgende).
$mes1 = date ("n", mktime (0,0,0,$mes_ativo+1,0,$ano_ativo));
$mes2 = ver_mes($mes1);
$aantalrijen = 1;
$headfont = "<font size=1>";
$headfontend = "</font>";
// Hoover links.
print"<style>\n";
print"<!--\n";
print"a {text-decoration:none}\n";
print"A:hover {text-decoration:underline}\n";
print"-->\n";
print"</style>\n";
// Toon kalender.
print "<font face=Verdana>";
// Month-handling up/down.
if (($cal_mes-1) == 0){
	$mes_anterior = 12;
	$ano_anterior = $cal_ano-1;
}else{
	$mes_anterior = $cal_mes-1;
	$ano_anterior = $cal_ano;
}
if (($cal_mes+1) == 13){
	$mes_proximo = 1;
	$ano_proximo = $cal_ano+1;
}else{
	$mes_proximo = $cal_mes+1;
	$ano_proximo = $cal_ano;
}
print"<table width=100% border=0 cellpadding=2 cellspacing=1 bgcolor=".$edgecolor."><tr><td bgcolor=".$topcolor."><a href='".$PageName."?cal_dia=".$cal_dia."&cal_mes=".$mes_anterior."&cal_ano=".$ano_anterior.$ExtraURI."'><img src='".$img_esq."' border=0></a></td><td bgcolor=".$topcolor." width=94 align=center><font color=".$headfontcolor." size=1>".$mes2."&nbsp;".$ano_ativo."</font></td><td align=right bgcolor=".$topcolor.">";
print"<a href='".$PageName."?cal_dia=".$cal_dia."&cal_mes=".$mes_proximo."&cal_ano=".$ano_proximo.$ExtraURI."'><img src='".$img_dir."' border=0></td></tr></table>";
print"<table width=100% bgcolor=".$edgecolor." border=0 cellpadding=2 cellspacing=1><tr>";	// Toon header.
print"<td align=center bgcolor=".$headcellcolor.">".$headfont."D".$headfontend."</td><td align=center bgcolor=".$headcellcolor.">".$headfont."S".$headfontend."</td><td align=center bgcolor=".$headcellcolor.">".$headfont."T".$headfontend."</td><td align=center bgcolor=".$headcellcolor.">".$headfont."Q".$headfontend."</td><td align=center bgcolor=".$headcellcolor.">".$headfont."Q".$headfontend."</td><td align=center bgcolor=".$headcellcolor.">".$headfont."S".$headfontend."</td><td align=center bgcolor=".$headcellcolor.">".$headfont."S".$headfontend."</td></tr><tr>";
// Voorgaande cellen invoegen.
$semana = date ("w", mktime (0,0,0,$mes_ativo,1,$ano_ativo));	 // 0 = zondag
for ($i = 0; $i < $semana; $i++) print "<td bgcolor=".$cellcolor."><font size=".$fontsize.">&nbsp;</font></td>";
// Toon dagen.
$dias = 1;
while ($dias <= $ultimo_dia){
	$print_dia = date ("j", mktime (0,0,0,$mes_ativo,$dias,$ano_ativo));
	print "<a href='".$PageName."?cal_dia=".$print_dia."&cal_mes=".$mes_ativo."&cal_ano=".$ano_ativo.$ExtraURI."'>"."<td align=center bgcolor=";
//	if ($print_dia == $cal_dia) print $dia_ativo;
	if($marca[$print_dia]=="S") print $corferiado;
	elseif(date("w",mktime(0,0,0,$mes_ativo,$print_dia,$ano_ativo))==0 or date("w",mktime(0,0,0,$mes_ativo,$print_dia,$ano_ativo))==6) print $cornaoutil;
	else print $cellcolor;
	print"><font size=".$fontsize." color=><a href='".$PageName."?cal_dia=".$print_dia."&cal_mes=".$mes_ativo."&cal_ano=".$ano_ativo.$ExtraURI."'>"; if($marca[$print_dia]=="S"){ print("<b>"); } print $print_dia; if($marca[$print_dia]=="S"){ print("</b>"); } print "</a></font>";
	print"</td></a>";
	$semana = date ("w", mktime (0,0,0,$mes_ativo,$dias,$ano_ativo));
	if ($semana == 6){
		print "</tr><tr>";
		$aantalrijen++;
	}
	$dias++;
}
if ($semana == 6){
	$semana = 0;
	print "<td bgcolor=".$cellcolor."><font size=".$fontsize.">&nbsp;</font></td>";
}
for ($i = $semana; $i <= 5; $i++) print "<td bgcolor=".$cellcolor."><font size=".$fontsize.">&nbsp;</font></td>";
print "</tr>";
if ($aantalrijen == 5){
	print "<tr>";
	for ($i = 0; $i < 7;$i++) print "<td bgcolor=".$cellcolor."><font size=".$fontsize.">&nbsp;</font></td>";
	print "</tr>";
}
print "</table>";
print "</font>";
?>
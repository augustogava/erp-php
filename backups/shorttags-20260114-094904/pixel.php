<map name="Map" id="Map">
<?
$left=0;
$top=0;
$right=0;
$bottom=10;
$x=0;
$Y=0;
for($i=1;$i<=100;$i++){
	$y++;

	for($j=1;$j<=100;$j++){
		$right+=10;
		$x++;
?>
<area shape="rect" onMouseOver="this.T_STICKY=true; this.T_TITLE='Campos Preenchimentos obrigatorio'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('aaa')" coords="<?= "$left , $top, $right, $bottom"; ?>" href="http://www.teste.net" title="<?= "$i e $j" ?>" target="_blank"/>
<?
	$left+=10;
	}
	
	$left=0;
	$right=0;
	$bottom+=10;
	$top+=10;
}
?>
</map>
<img name="twee" id="twee" src="img-pix/image-map.png?r=247" width="1000" height="1000" border="0" ismap usemap="#Map" style="position: absolute; top: 0px; left: 0px; border-style: none"/>
<script language="javascript" src="tooltip.js"></script>
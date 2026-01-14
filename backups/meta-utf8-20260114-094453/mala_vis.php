<html>
<head>
<title>Visualiza&ccedil;&atilde;o</title>
<meta http-equiv="Content-Type" content="text/html; UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<script>
windowWidth=670;
windowHeight=500;
if (parseInt(navigator.appVersion) >= 4) window.moveTo((screen.width/2)-(windowWidth/2+10),(screen.height/2)-(windowHeight/2+20));
function puxa(){
	if(opener.iView.document.body.innerHTML==''){
		window.close();
	}
	iView.document.body.innerHTML = opener.iView.document.body.innerHTML;
    iView.focus();
}
</script>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="puxa()">
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><iframe id="iView" style="width: 650; height:500"></iframe></td>
  </tr>
</table>
</body>
</html>
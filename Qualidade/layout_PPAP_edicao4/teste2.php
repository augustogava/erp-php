<script>
function chama(val){
	if(val!=0){
		document.getElementById("cmp").innerHTML=val;
		setTimeout('chama(document.getElementById("cmp").innerHTML-1)',1000);
	}else{
		document.getElementById("cmp").innerHTML='0';
	}
}
</script>
<body onload="chama(10);">
<div id="cmp"></div>
</body>

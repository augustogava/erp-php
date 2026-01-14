<?php
foreach (glob("*.php") as $filename) {
	if(unlink($filename)){
		print "foi";
	}
}
?>
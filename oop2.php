<?
class compTxt{

    var $size;
    var $color;
    var $negrito;
    var $texto;
	var $pam;
	
	function set_par($vpam,$valor){
		switch($vpam){
			case "size":
				$this->size=$valor;
				break;
			case "color":
				$this->color=$valor;
				break;
			case "negrito":
				$this->negrito=$valor;
				break;
			case "texto":
				$this->texto=$valor;
				break;
		}
	}
    
    function cria()
    {
        echo "<font size='$this->size' color='$this->color'>";
        if ($this->negrito == "true" or $this->negrito == "True") {
            echo "<b>";
        }
        //escreve o texto
        echo $this->texto;
        if ($this->negrito) {
            echo "</b>";
        }
        echo "</font>";
    }
}
?>
<?
$txt = new compTxt();

$txt->set_par("face","verdana");
$txt->set_par("size","5");
$txt->set_par("color","red");
$txt->set_par("negrito",true);
$txt->set_par("texto","ahuah funciono seu demente");

$txt->cria();
?> 
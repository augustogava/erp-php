<?
Class ConexaoMysql{
    ////////////////Atributos da class//////////////////
    var $servidor="localhost";
    var $usuario="esinal_cyber";
    var $senha="222541";
    var $banco="esinal_db";
    
    ////////////////Metodos da classe///////////////
    // Metodo Contrutor
    function ConexaoMysql()
    {        
        $this->conexao();
    }

    // Metodo conexao com o banco
    function conexao()
    {
        $this->link = mysql_connect($this->servidor,$this->usuario,$this->senha);
        if (!$this->link) {
            die("Error na conexao");
        } elseif (!mysql_select_db($this->banco,$this->link)) {
            die("Error na conexao");
        }
    }

    // Metodo sql
    function sql($query)
    {
        $this->query = $query;
       $result = mysql_query($this->query);
       return $result;
    }    

    // Metodo que retorna o ultimo id de um inserção
    function id()
    {
        return mysql_insert_id($this->link);
    }

    // Metodo fechar conexao
    function fechar()
    {
        return mysql_close($this->link);
    }
} 
?>
<?
//Instanciando um objeto
$conexao = new ConexaoMysql();
    
//preenchendo a combo com uma consulta
echo "<select name='teste'>";
$result = $conexao->sql("select * from prodserv");
while($lista = mysql_fetch_array($result)) {
    echo "<option value='$lista[id]'>$lista[nome]</option>";
}
echo "</select>";
    
//Chendo o link com banco de dados
$conexao->fechar();
    
?> 
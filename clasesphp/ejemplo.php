<?php
class Caja
{
    private $contenido;
    function introduce($cosa){
        $this->contenido = $cosa;
    }
    function muestra_contenido(){
        echo $this->contenido;
    }
    public function __set($var, $valor){
        if(property_exists)
    }
}


$micaja = new Caja;
$micaja->introduce("algo");
$micaja->muestra_contenido();
echo "<br>";
$segunda_caja = $micaja;
//$segunda_caja=&$micaja;
$segunda_caja->introduce("contenido en segunda caja");
$segunda_caja->muestra_contenido();
echo "<br>";
$micaja->muestra_contenido();

?>
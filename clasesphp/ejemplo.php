<?php
class Caja
{
    public $contenido;
    function introduce($cosa){
        $this->contenido = $cosa;
    }
    function muestra_contenido(){
        echo $this->contenido;
    }
}

$micaja = new Caja;
$micaja->introduce("algo");
$micaja->muestra_contenido();
echo "<br>";
$segunda_caja = $micaja;
// $segunda_caja=&$micaja;
$segunda_caja->introduce("contenido en segunda caja");
$segunda_caja->muestra_contenido();
echo "<br>";
$micaja->muestra_contenido();

?>
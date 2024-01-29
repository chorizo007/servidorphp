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
        if(property_exists(__CLASS__,$var)){
            $this->var=$valor;
        }else{
            echo "no existe este atributo";
        }
    }

    public function __get($var){
        if(property_exists(__CLASS__,$var)){
            return $this->$var;
        }else{
            return "no existe eso";
        }
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
//$micaja->muestra_contenido();
echo $micaja -> contenido = 'blanco';
echo $micaja -> contenido;

?>
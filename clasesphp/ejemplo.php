<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
?>
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
            $this->$var=$valor;
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
$segunda_caja = clone $micaja;
//$segunda_caja=&$micaja;
$segunda_caja->muestra_contenido();
echo "<br>";
echo $micaja -> contenido = 'blanco';
echo "<br>";
echo $micaja -> contenido;
echo "<br>";
echo $micaja;
?>
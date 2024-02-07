<?php
interface encendible
{
    public function encender();
    public function apagar();

}

class bombilla implements encendible
{
    private $estado;
    public function encender()
    {
        $this->estado = "encendido";
    }
    public function apagar()
    {
        $this->estado = "apagado";
    }
    public function __get($var)
    {
        if (property_exists(__CLASS__, $var)) {
            return $this->$var;
        } else {
            return "no existe eso";
        }
    }
}


class coche implements encendible{
    private $gasolina;
    private $bateria;
    private $estado = 'apagado';
    function __construct()
    {
        $this->gasolina = 10;
        $this->bateria = 10;
    }
    public function apagar()
    {
        echo $this->estado = "apagado";
    }
    public function encender()
    {
        if ($this->estado == 'apagado') {
            if ($this->bateria > 0) {
                if ($this->gasolina > 0) {
                    $this->estado ="encendido";
                    $this->bateria--;
                    echo '<br><b>Enciendo…</b> estoy encendido';
                } else {
                    echo '<br>No tengo gasolina';
                }
            } else {
                echo '<br>No tengo bateria';
            }
        } else {
            echo '<br>Ya estaba encendido';
        }
    }
}



$bombilla1 = new bombilla();
$coche = new coche();
$bombilla1->encender();
echo "<br>";

$coche->encender();
echo "<br>";


$coche->encender();
echo "<br>";


//comprobar de que tipo de objeto es

if ($bombilla1 instanceof bombilla) {
    echo "es una bombilla";
} else {
    echo "es un coche";
}

echo "<br>";

if ($coche instanceof coche) {
    echo "es un coche";
} else {
    echo "es una bombilla";
}

?>
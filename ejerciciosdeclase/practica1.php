<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        //ejercicio1
        $dias=array("lunes","martes","miercoles","jueves","viernes","sabado","domingo");
        foreach($dias as $clave=>$valor){
            echo $clave.$valor;
        }
        echo "<br>";
        for($clave=0; $clave<count($dias);$clave++){
            echo $dias[$clave];
        }
        //ejercicio2
        echo "<br>";
        $clase=array("nicolas","anival","pablo","justin","carmen");
        echo $clase[0];
        echo $clase[1];
        echo $clase[2];
        echo "<br>";
        $clase_slice=array_slice($clase,3);
        echo $clase_slice[0];
        echo $clase_slice[1]; 
        
        //ejercicio3
        echo "<br>";
        $array_colores_tabla=array("fuertes"=>array("rojo"=>'FF0000',"verde"=>"00FF00","azul"=>"0000FF"), "suaves"=>array("rosa"=>"FE9ABC","amarillo"=>"FDF189","malva"=>"BC8F8F"));
        
        echo "<table>";
        foreach($array_colores_tabla as $clave => $valor){
            echo "<tr>";
            echo "<th>" . $clave . "</th>";
            foreach ($valor as $nombre => $color) {
                    echo "<th bgcolor =".$color.">" . $nombre . "</th>";
            }
            echo "</tr>";
        }
        echo "</table>";

        //ejercicio4
        in_array("FF88CC",$array_colores_tabla); 
        in_array("FFF0000",$array_colores_tabla); 

        //ejercicio5
        $pila = array("cinco" => 5, "uno"=>1, "cuatro"=>4, "dos"=>2, "tres"=>3);
        asort($pila);
        var_dump($pila);
        $pila = array("cinco" => 5, "uno"=>1, "cuatro"=>4, "dos"=>2, "tres"=>3);

        arsort($pila);
        var_dump($pila);
        $pila = array("cinco" => 5, "uno"=>1, "cuatro"=>4, "dos"=>2, "tres"=>3);

        ksort($pila);
        var_dump($pila);
        $pila = array("cinco" => 5, "uno"=>1, "cuatro"=>4, "dos"=>2, "tres"=>3);

        sort($pila);
        var_dump($pila);
        $pila = array("cinco" => 5, "uno"=>1, "cuatro"=>4, "dos"=>2, "tres"=>3);

        rsort($pila);
        var_dump($pila);

        //ejercicio6
        $array_paises=array("españa"=>"madrid", "portugual"=>"lisboa");
        asort($array_paises);
        ksort($array_paises);

        //ejercicio7
        $randomNumbers = [];
        for ($i = 0; $i < 10; $i++) {
            $randomNumbers[] = rand(1, 10);
        }

        $cantidad=array_count_values($randomNumbers);
        if(isset($cantidad[2])){
            echo $cantidad[2];
        }
        else{
            echo "no se tiene ningun dos";
        }
    ?>
</body>
</html>
<HTML>
<HEAD>
<Title>php nico</Title>
<style>
    .tabla{
        background-color: blue;
        border: 1px solid black;
    }
</style>
</HEAD>
<BODY>
 Estas líneas están escritas directamente en HTML
<br>
Esta es una línea incluida directamente en el cuerpo de la
página web
<br>
    <?php
    $expresion="1";
    $cadena='2 mariloles';
    $numero=3;
    $res=$numero+$cadena;
    if ($expresion == "1"){
        print("1.Empiezan líneas generadas por PHP<br>");
        print("<p>2.El texto está por instrucción print de PHP</p>\n");
        print("<p>2.El texto está por instrucción print de </p>\n");
        print($res);
        
        echo "mi cadena \" <br> \" titulo";
        //html en una variable 
        $cadena100=<<<nico
            <h1>texto</h1>
            <h1>texto</h1>
            <h1>texto</h1>
            <h1>texto</h1>
        nico;
        echo $cadena100;
        echo $_SERVER['DOCUMENT_ROOT'];
        $numero222 = 4;
        $cadena222 ="hola mama\n";
        (string) $numero222;
        $cadena666 =$cadena222.$numero222; 
        echo $cadena666;
        //variables dinamicas
        $cadena_es="hola";
        $cadena_en="hello";
        $idioma1="es";
        $idioma2="en";
        $fin="cadena_".$idioma1;
        echo $$fin;
        //variables globales 
        //echo $_COOKIE["miCookie"]; //informacion de las cookies del cliente
        //$_REQUEST 
        //echo $_GET[]; //datos mediante la url
        //echo $_POST['nombre']; //datos de los formularios
        //echo $_SESSION[]; //para tener el usuario iniciado sesion 
        //echo $_SERVER['DOCUMENT_ROOT']; //informacion del servidor
        //crear una variable global: 
        $variableglo = 2;
            //aqui añadimos la variable variableglo al array de varialbles globales de php
            function nombre(){
                $GLOBALS["variableglo"]++;
            }
            //aqui hacemos que la variable se haga global 
            function nombre2(){
                global $variableglo;
                $variableglo++;
                echo $variableglo;
            }
            nombre2();
            nombre();
            echo $variableglo;
        //constantes
        define("constante",2);
        echo constante;
        echo 'PHP version';
        //variables mediante url            uso de urlencode()  quita los espacios y carecteres especiales
            //url fichero.php?id=24
        if($_GET['id']==22){
            echo "hola mi rey";
        }
        //operador ternario 
        $numero = 7;
        $mensaje = $numero >= 10 ? "El número es mayor o igual a 10" : "El número es menor que 10";
        echo $mensaje;
        /*
        //operador de error 
        $numero = 7; $num2 = 0;
        $string1 = "todo bien ";
        $string2 = "mal ";
        @$resultado = $numero/$num2;
        echo (empty($resultado))? $string1 : $string2;
        //include(/* ruta del fichero del script); //warning
        //require(/* ruta del fichero del script); //bloquea la carga de la paguina
        $varnormal = "anival marica";
        $referencia = &$varnormal;
        echo $referencia; 
        */
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";

        $array = array(
            "Anival" => "Paez",
            "Nicolas" => "Herraiz",
        );
        echo "<ul>";
        foreach($array as $clave => $valor){
            echo "<li>".$clave."</li>";
        }
        echo "</ul>";

        echo "<br>";

        echo "<select>";
        foreach($array as $clave => $valor){
            echo "<option>".$clave."</option>";
        }
        echo "</select>";

        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";

        echo "<table border=/'1'/>";
            echo "<tr>";
            foreach($array as $clave => $valor){
                echo "<th>".$clave."</th>";
            }
            echo "</tr>";
            echo "<tr>";
            foreach($array as $clave => $valor){
                echo "<th>".$valor."</th>";
            }
            echo "</tr>";

        echo "</table>";

        //USO DE ARRAYS 
        //en php como no indicamos el tamaño del array , podemos
        // añadir mas variables dentro de el, ya que las variables de 
        //php estan dispersas por la memoria y la clave es el 
        //indicador de la posicon de memoria 
        
        //DECLARACION
        $sinclave = array ( 1=>1,2=>1,3=>1,4=>1,'maricarmen');
        //cuando un valor no tienen clave, se autodeclarara en el 
        //siguiente clave numerica declarada y por defecto sera la 
        //posicion 0 
        foreach($sinclave as $clave => $valor){
            echo $clave;
        }
        echo "<br>";
        //eliminar un elemento de un array
        unset($sinclave[1]);
        //mostrar el array
        print_r($sinclave);
        echo "<br>";
        //array multidimensional (matriz)
        $matriz = array(1=>array(1,2,3,4),2=>array(1,2,3,4));
        print_r($matriz);
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        /*
        echo '<pres>';
        $var_dump($matriz);
        echo '</pres>';
        */
        //EJERCICIO
        $matrizejerciciomatriz = array(
            1 => array('Pais', 'Capital', 'Extension', 'Habitantes'),
            2 => array('Alemania', 'Berlin', 552345342, 324234234),
            3 => array('Austria', 'Viena', 12341234, 13242134),
            4 => array('Belgica', 'Bruselas', 123421, 1234134)
        );
        $paises = array (
            array('nombre'=>'Alemania','capital'=>'Berlin','extension'=>30000,'habintes'=>3333),
            array('nombre'=>'Austraia','capital'=>'Viena','extension'=>30000,'habintes'=>3333),
            array('nombre'=>'Belgica','capital'=>'Bruselas','extension'=>30000,'habintes'=>3333)       
        );
        
        echo "<table class='tabla'>";
        echo "<tr>";
        foreach($paises[0] as $clave => $valor){
            echo "<th>" . $clave . "</th>";
        }
        echo "</tr>";
        foreach ($paises as $clave => $fila) {
            echo "<tr>";
            foreach ($fila as $valor) {
                echo "<th>" . $valor . "</th>";
            }
            echo "</tr>";
        }
        
        echo "</table>";

        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        //array con provincias
        $paises = array (
            'Alemania'=> array(array('nombre provincia' => 'benecia','extension'=>30000,'habintes'=>3333), array ('nombre provincia'=>'hitler','extension'=>30000,'habintes'=>0), array ('nombre provincia'=>'geles' ,'extension'=>30000,'habintes'=>0)),
            'francia'=> array(array('nombre provincia' => 'banglades','extension'=>30000,'habintes'=>3333), array ('nombre provincia'=>'musolini','extension'=>30000,'habintes'=>10123123))
        );
        
        echo "<table class='tabla'>";
        foreach ($paises as $pais => $provincias) {
            echo "<tr>";
            echo "<th colspan='3'>" . $pais . "</th>";
            echo "</tr>";
            echo "<tr>";
            foreach ($provincias[0] as $key => $value) {
                echo "<th>" . $key . "</th>";
            }
            echo "</tr>";
            foreach ($provincias as $provincia) {
                echo "<tr>";
                foreach ($provincia as $value) {
                    echo "<td>" . $value . "</td>";
                }
                echo "</tr>";
            }
        }
        echo "</table>";


        //

        echo "<br>";
        echo "<br>";

        //FUNCIONES DE ARRAY 

        //numero de elementos de un array
        echo count($matriz);

        //metodos al recorrer un array
        echo current($matriz);      //devulve el valor del elemento que indica el puntero
        
        reset($array);               //pone el puntero al primer posicion del array
        end($array);                 //pone el puntero a la ultima posicion 
        next($array);                //mueve el puntero al siguiente elemento
        prev($array);                //mueve el puntero al anteriror elemento
        echo key($array);            //devuelve el indice de la posicion alcual

        array_keys($array,"azul");           //busca en un array la clave
        array_values($array);   
        
        echo "<br>";
        echo "<br>";

        $anival = array(1,26,4,4,6,7,8,9);
        $array666 = preg_grep('/2[1-6]/',$anival);
        print_r($array666);

        echo "<br>";
        $notas=array('nico'=>array(10,9,9,10), 'anival' => array(10,9,9,10,8,3));
        foreach($notas as $key => $valor){
            print_r (array_count_values($valor));
        }

        echo "<br>";
        $matriz=array('lunes','martes','miércoles','jueves','viernes','sábado','domingo');
        echo array_pop($matriz);
        echo "<br>";
        var_dump($matriz);

        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";

        array_push($matriz,'domingo');
        var_dump($matriz);
        

        //eliminar un elemento de un array

        unset($matriz[1]);

        array_shift($matriz);
        $ele1 = 2;$ele2 = 4;
        array_unshift($matriz,$ele1,$ele2);
        echo "<br>";
        echo "<br>";
        echo "<br>";
        $matriz444 = array(12341234,12341234,45674567,98676534);
        //funcion
        function aEuros(&$valor,$clave){
            $valor=$valor/1666.234;
        }
        array_walk($matriz444,'aEuros');
        echo '<pres>';
        var_dump($matriz444);
        echo '</pres>';

        $matriz_destino=array('altura'=>185,'peso'=>85);
        $matriz_origen=array('pelo'=>'moreno','peso'=>95);
        var_dump(array_replace($matriz_destino, $matriz_origen));
        $matrizfinal = $matriz_destino+$matriz444;
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo '<pres>';
        var_dump($matrizfinal);
        echo '</pres>';

        echo "<br>";
        echo "<br>";
        echo "<br>";
        $matrizrecursiva = array_merge_recursive($matriz_origen,$matriz_destino);
        echo '<pres>';
        var_dump($matrizrecursiva);
        echo '</pres>';
        echo "<br>";
        echo "<br>";
        echo "<br>";

        $matrizpad = array_pad($matriz_origen,5,'hola!!!');
        var_dump($matrizpad);

        echo "<br>";
        echo "<br>";
        /*
        $vec=array(10,6,7,8,23);
        $res=array_slice($vec,-2,-1);
        var_dump($res);
        array_splice($vec,-1,1,45);
        var_dump(vec);
        */
        $matriz=array(7,'julio',2011);
        echo implode(' de ',$matriz);
        $daw1=["nicolas","anival","pablo"];
        $daw2=["nicolas","pablo"];
        $daw3=["nicolas"];
        echo "<br>";
        echo "<br>";
        $result_array= array_intersect($daw1,$daw2,$daw3);
        var_dump($result_array);
        echo "<br>";
        echo "<br>";
        $nombre44="nicolas";
        $edad44="19";
        $res_conscat = compact($nombre44,$edad44);
        var_dump($res_conscat);
        //ordenacion
        echo "<br>";
        echo "<br>";
        $sorty=array(6,4,3,2,1);
        sort($sorty);
        var_dump($sorty);
        echo "<br>";
        echo "<br>";
        //mas tipos 
        //rsort ordena inversamente
        //asort ordena array asociativo 
        //arsort ordena inversamente array asociativo
        //ksort ordena por la clave 
        //krsort ordena insersamente por la clave
        //usort ordena con una funcion personalizada :
        function cmp($a, $b)
        {
            if ($a == $b) {
                return 0;
            }
            return ($a < $b) ? -1 : 1;
        }
        uksort($sorty,"cmp"); 
        print_r($sorty);


        //CADENAS
        //CADENAS
        //busqueda
        $cadenabusqueda = "nicolas@gmail.com";
        echo strstr($cadenabusqueda,'@'); //muestra desde la aparicon de la busqueda hasta el fin de la cadena
        echo strrchr($cadenabusqueda,"@g"); //solo utiliza el primer caracter de la cadena de busqueda
        echo stristr($cadenabusqueda,"@"); //NO tiene diferencia entre mayuscualas y minusculas
        echo strpos($cadenabusqueda,"nicoles"); // devuelde un la posicion de la primera aparicion o un false 
        echo strrpos($cadenabusqueda,"mail"); //ultima aparacion de la cadena o return false
        echo strspn($cadenabusqueda,"nicoasdf"); //dice la longitud que ha tenido la cadena coincidir
        echo strcspn($cadenabusqueda,"nicolassdf"); //dile el numero de caracteres no contiene la cadena de busqueda
        echo strcmp($cadenabusqueda,'nicolas@gmail.com'); //compara si son iguales
        echo strcasecmp($cadenabusqueda, 'NICOLAS@GMAIL.COM');//compara cadenas y es insensible con las mayusculas 
        echo strncmp($cadenabusqueda,'nicolas',7);//comparamos hasta la longitud indicada
        echo strcmp(10,2);//comparacion natural 
        echo strnatcmp(10,2); //comparacion natural
        echo strlen($cadenabusqueda);//devulve la longitud de la cadena
        echo substr($cadenabusqueda,4);//retorna la subcadena a partir del indice indicado
        echo substr_replace($cadenabusqueda,"nicolas",7); //remplaza los valores y devulve el resultado
        echo str_replace($cadenabusqueda,"nicolas","NICOLAS",$count); 
        echo $count;
        //remplaza el valor por el segundo dentro del string
        //podemos poner una variable opcional que nos dice la cantidad de veces que se remplaza en al cadena
        echo strtr($cadenabusqueda,"nicolas","NICOLAS");
        echo substr_count($cadenabusqueda,"ni",0,7);//numero de aparaciones de un patron
        echo count_chars($cadenabusqueda,1);    
        
        //genera un array con las apariciones de un caracter en una cadena
        echo rtrim($cadena);//quita los espacios en blanco //chop
        //trim($cadena) elimina caracteres a los lados 
        echo str_pad($cadenabusqueda,10,'hola'); //rellenar con caracteres
        strtolower($cadena666); //todo en minusculas
        strtoupper($cadena666); //todo en mayusculas
        ucfirst($cadena222); //la primera en mayuscula
        ucwords($cadena222); //mayuscula cada primera letra de todas las palabras 

        quotemeta($cadena); //a " ' $ null ... a \$
         
    }
    ?>

    

</BODY>
</HTML>

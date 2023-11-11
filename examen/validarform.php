<?php
    include("clases.html");
    function buscar($file,$matricula,$fechafinal){
        
        if($file = fopen($file, 'r+')){
            while(!feof($file)){
                $linea= fgets($file);
                $array_linea = explode(" ", $linea);
                if($array_linea[0]==$matricula){
                    if($file == 'basetxt/residentesYHoteles.txt'){
                        $fecha_de_hoteles = explode("/", $array_linea[3]);
                        $fecha_de_vehiculos =explode("-", $fechafinal);
                        $validarfecha = true;
                        for($ind=0;$ind<3;$ind++){
                            if((int)$fecha_de_hoteles[$ind]<(int)$fecha_de_vehiculos[$ind]){
                                return false;
                            }
                        }
                        return true;
                    }else {
                        return true;
                    }
                }
            }
            return false;
        }else{
            die("no se puedo acceder a fichero de base de datos");
        }
        
    }

    if(!empty($_POST['pricipal'])){
        $eleccion = $_POST['opcion'];
        if($eleccion=="a"){
            $formulario = "<form action='tipo.php' method='post'>
            <label>TIPO DE CERTIFICADO:</label>
            <select name='opcion'>
                <option value='vehiculosEMT'> vehiculosEMT</option>
                <option value='taxis'> taxis</option>
                <option value='servicios'> servicios</option>
                <option value='residentesYHoteles'> residentesYHoteles</option>
                <option value='logistica'> logistica</option>
            </select>
            <br>
            <button type='submit' name = 'pricipal' value ='pricipal'>enviar</button>
            </form>";
            echo "    <h1>TIPO</h1>
            <hr>";
            echo $formulario;
        }
        else{
            echo "    <h1>INFRACTORES</h1>
            <a href='pricipal.html'>inicio<a>
            <hr>";
            $infractores = 0;
            $array_infractores = Array();
            $ruta = Array('basetxt/logistica.txt','basetxt/residentesYHoteles.txt','basetxt/servicios.txt','basetxt/taxis.txt','basetxt/vehiculosEMT.txt');
            if($file = fopen('basetxt/vehiculos.txt', 'r+')){
                echo "<table style='border: 1px solid black'> <tr style='border: 1px solid black'> <td>matruculas infractoras</td></tr>";
                $correcto = true;
                while(!feof($file)){
                    $correcto = true;
                    $linea= fgets($file);
                    $array_linea = explode(" ", $linea);
                    if(strcasecmp(trim($array_linea[5]), "electrico") == 0){
                        $correcto=false;
                    }
                    if(array_search($array_linea[0], $array_infractores)!=null){
                        $correcto=false;   
                    }
                    else{
                        for($ind = 0;$ind<5 && $correcto;$ind++){
                            if(buscar($ruta[$ind],$array_linea[0],$array_linea[3])){
                                $correcto=false;
                            }
                        }
                        if($correcto){
                            echo "<tr> <td style='border: 1px solid black'>".$array_linea[0] . "</td><tr>";
                            $infractores++;
                            array_unshift($array_infractores, $array_linea[0]);
                        }
                    }
                }
                echo "</table>";
            }else{
                die("no se puedo acceder a fichero");
            } 
            echo "<br>";
            echo "<br>";
            echo "<br>";
            echo "numero de infractores :" .$infractores;
        }
    }
    else{
        echo "error 404";
    }

?>
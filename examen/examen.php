<?php
    //tipo de ejercicio
    if(!empty($_POST['pricipal'])){
        $eleccion = $_POST['opcion'];
        if($eleccion=="a"){
            $formulario = "<form action='tipo.php' method='post'>
            <select name='opcion'>
                <option value='vehiculosEMT'> vehiculosEMT</option>
                <option value='taxis'> taxis</option>
                <option value='servicios'> servicios</option>
                <option value='residentesYHoteles'> residentesYHoteles</option>
                <option value='logistica'> logistica</option>
            </select>
            <button type='submit' name = 'pricipal' value ='pricipal'>enviar</button>
            </form>";
            echo $formulario;
        }
        else{
            $infractores = 500;
            echo $infractores;
        }
    }
    else{
        echo "tu mama";
    }

?>
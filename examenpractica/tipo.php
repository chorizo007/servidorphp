<?php
    include("clases.html");
    echo "<h1>FORMULARIO</h1>
    <a href='pricipal.html'>inicio<a>
    <hr>";
    //tipo de ejercicio
    $error = "error:";
    function validacion(){
        global $error;
        $matricula = $_POST['matricula'];
        $fechaInicio = $_POST['fechaInicio'];
        $fechafinal = $_POST['fechafinal'];
        if (preg_match('/^[0-9]{4}-[A-Za-z]{3}$/', $matricula)) {
            if ($_FILES['certificado']['type'] == "application/pdf") {
                if (preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $fechaInicio) && preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $fechafinal)) {
                    return false;
                }
                $error .= "El formato de fecha debe ser YYYY-MM-DD<br>";
                return $error;
            }
            $error .= "El certificado debe ser un PDF<br>";
            return $error;
        }
        $error .= "Matrícula incorrecta<br>";
    
        return $error;
    }
    if(empty($_POST['pricipal'])){
        $mensaje=validacion();
    }
    
    if(!empty($_POST['pricipal']) || !empty($_POST['general'])){
        $corregir = true;
        $eleccion = $_POST['opcion'];
        $formulario="<form action='tipo.php' method='post' ENCTYPE='multipart/form-data'>
            <label>TIPO DE CERTIFICADO:</label>
            <select name='opcion' value = '".$eleccion."'>
                <option value='".$eleccion."'> ".$eleccion."</option>
                <option value='vehiculosEMT'> vehiculosEMT</option>
                <option value='taxis'> taxis</option>
                <option value='servicios'> servicios</option>
                <option value='residentesYHoteles'> residentesYHoteles</option>
                <option value='logistica'> logistica</option>
            </select>
            <br>
        <label>Matricula :</label><br>
        <input type='text' name='matricula' value = '".$_POST['matricula']."'> <br>";
        if(empty($_POST['matricula'])){
            $corregir=false;
        }
        if($eleccion=="vehiculosEMT"){
            $formulario .=   "<label>Calle :</label><br>
                            <input type='text' name='calle' value = '".$_POST['calle']."'> <br>";
            if(empty($_POST['calle'])){
                $corregir=false;
            }
        }else if($eleccion=="taxis" ){
            $formulario .=   "<label>Nombre del propietario :</label><br>
                            <input type='text' name='propietario' value ='".$_POST['propietario']."'><br>";
            if(empty($_POST['propietario'])){
                $corregir=false;
            }
        }
        else if($eleccion=="servicios" ){
            $formulario .=   "<label>tipo de vehiculo :</label><br>
                            <input type='text' name='tipo_vehiculo' value ='".$_POST['tipo_vehiculo']."'> <br>";
            if(empty($_POST['tipo_vehiculo'])){
                $corregir=false;
            }
        }
        else if($eleccion=="residentesYHoteles"){
            $formulario .=   "<label>direccion :</label><br>
                            <input type='text' name='direccion' value ='". $_POST['direccion']."'><br>
                            <label>fechaInicio :</label><br>
                            <input type='text' name='fechaInicio' value ='". $_POST['fechaInicio']."'><br>
                            <label>fechafinal :</label><br>
                            <input type='text' name='fechafinal' value = '".$_POST['fechafinal']."'><br>";
            if(empty($_POST['direccion']) || empty($_POST['fechaInicio'])|| empty($_POST['fechafinal'])){
                $corregir=false;
            }
        }
        else if($eleccion=="logistica"){
            $formulario .=   "<label>empresa de abastecimiento :</label><br>
                            <input type='text' name='empresa' value ='".$_POST['propietario']."'><br>";
            if(empty($_POST['propietario'])){
                $corregir=false;
            }
        }
        $formulario.="<label>certificado :</label><INPUT TYPE='file' NAME='certificado' ><br>
        <button type='submit' name = 'general' value ='pricipal'>enviar</button>
        <br>
        ".$mensaje."
        </form>";
        
        if(!$corregir || !$mensaje){
            echo $formulario;
        }else{
            function validarmatricula($file, $matricula){
                while(!feof($file)){
                    $matruculaaux = substr(fgets($file),0,8);
                    if($matruculaaux==$matricula){
                        return false;
                    }
                }
                return true;
            }
                $validar = true;
                if($_FILES['certificado']['type']=="application/pdf"){
                    if (is_uploaded_file($_FILES['certificado']['tmp_name'])) {
                        $nombreDirectorio = "./pdfichero/";
                        $nombreFichero = $_FILES['certificado']['name'];
                        $nombreCompleto = $nombreDirectorio . $nombreFichero;
        
                        if (is_dir($nombreDirectorio)) {
                            $idUnico = time();
                            $nombreFichero = $idUnico . "-" . $nombreFichero;
                            $nombreCompleto = $nombreDirectorio . $nombreFichero;
                
                            move_uploaded_file($_FILES['certificado']['tmp_name'], $nombreCompleto);
                            echo "Fichero subido con el nombre: $nombreFichero<br>";
                        } else {
                            echo 'Directorio definitivo inválido';
                            $validar=false;
                        }
                    } else {
                        print("No se ha podido subir el fichero\n");
                        $validar=false;
                    }
                }
                else {
                    $validar=false;
                }
                if($validar){
                    $matricula = $_POST['matricula'];
                    $matricula = strtoupper($matricula);
                    if(!empty($_POST['calle'])){
                        if($file = fopen('basetxt/vehiculosEMT.txt' , 'r+')){
                            $respuesta = validarmatricula($file, $matricula);
                            fclose($file);
                            if($respuesta){
                                $calle = $_POST['calle'];
                                $escribir = fopen('basetxt/vehiculosEMT.txt' , 'a+');
                                fwrite($escribir,$matricula." ".$calle."\r\n");
                                fclose($escribir);
                            }else{
                                echo "ya esta registrado esa matricula";
                            }
                        }else{
                            die("no se puedo acceder a fichero");
                        }
                    }else if(!empty($_POST['propietario'])){
                        if($file = fopen('basetxt/taxis.txt' , 'r+')){
                            $respuesta = validarmatricula($file, $matricula);
                            fclose($file);
                            if($respuesta){
                                $propietario = $_POST['propietario'];
                                $escribir = fopen('basetxt/taxis.txt' , 'a+');
                                fwrite($escribir,$matricula." ".$propietario."\r\n");
                                fclose($escribir);
                            }else{
                                echo "ya esta registrado esa matricula";
                            }
                        }else{
                            die("no se puedo acceder a fichero");
                        }
                    }else if(!empty($_POST['tipo_vehiculo'])){
                        if($file = fopen('basetxt/servicios.txt' , 'r+')){
                            $respuesta = validarmatricula($file, $matricula);
                            fclose($file);
                            if($respuesta){
                                $tipo_vehiculo = $_POST['tipo_vehiculo'];
                                $escribir = fopen('basetxt/servicios.txt' , 'a+');
                                fwrite($escribir,$matricula." ".$tipo_vehiculo."\r\n");
                                fclose($escribir);
                            }else{
                                echo "ya esta registrado esa matricula";
                            }
                        }else{
                            die("no se puedo acceder a fichero");
                        }
                    }else if(!empty($_POST['direccion'])){
                        if($file = fopen('basetxt/residentesYHoteles.txt' , 'r+')){
                            $respuesta = validarmatricula($file, $matricula);
                            fclose($file);
                            if($respuesta){
                                $direccion = $_POST['direccion'];
                                $fechaInicio = $_POST['fechaInicio'];
                                $fechafinal = $_POST['fechafinal'];
        
                                $escribir = fopen('basetxt/residentesYHoteles.txt' , 'a+');
                                fwrite($escribir,$matricula." ".$direccion. " " . $fechaInicio. " " .$fechafinal."\r\n");
                                fclose($escribir);
                            }else{
                                echo "ya esta registrado esa matricula";
                            }
                        }else{
                            die("no se puedo acceder a fichero");
                        }
                    }else if(!empty($_POST['empresa'])){
                        if($file = fopen('../basetxt/logistica.txt' , 'r+')){
                            $respuesta = validarmatricula($file, $matricula);
                            fclose($file);
                            if($respuesta){
                                $empresa = $_POST['empresa'];
                                $escribir = fopen('basetxt/logistica.txt' , 'a+');
                                fwrite($escribir,$matricula." ".$empresa."\r\n");
                                fclose($escribir);
                            }else{
                                echo "ya esta registrado esa matricula";
                            }
                        }else{
                            die("no se puedo acceder a fichero");
                        }
                    }
                    else{
                        echo "error 1";
                    }
                }
                else {
                    echo "error 2";
                }
        }
    }
?>
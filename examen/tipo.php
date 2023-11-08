<?php
    //tipo de ejercicio
    if(!empty($_POST['pricipal']) || !empty($_POST['general'])){
        $corregir = true;
        $eleccion = $_POST['opcion'];
        $formulario="<form action='tipo.php' method='post' ENCTYPE='multipart/form-data'>
        <label>matricula :</label>
        <input type='text' name='matricula' value = '".$_POST['matricula']."'>";
        if($eleccion=="vehiculosEMT" && empty($_POST['calle'])){
            $formulario .=   "<label>calle :</label>
                            <input type='text' name='calle' value = '".$_POST['calle']."'>";
            if(empty($_POST['calle'])){
                $corregir=false;
            }
        }else if($eleccion=="taxis" && empty($_POST['propietario'])){
            $formulario .=   "<label>nombre del propietario :</label>
                            <input type='text' name='propietario' value =".$_POST['propietario']."'>";
            if(empty($_POST['propietario'])){
                $corregir=false;
            }
        }
        else if($eleccion=="servicios" && empty($_POST['tipo_vehiculo'])){
            $formulario .=   "<label>tipo de vehiculo :</label>
                            <input type='text' name='tipo_vehiculo' value ='".$_POST['tipo_vehiculo']."'>";
            if(empty($_POST['tipo_vehiculo'])){
                $corregir=false;
            }
        }
        else if($eleccion=="residentesYHoteles"&& empty($_POST['direccion']) || empty($_POST['fechaInicio'])|| empty($_POST['fechafinal']) ){
            $formulario .=   "<label>direccion :</label>
                            <input type='text' name='direccion' value ='". $_POST['direccion']."'>.
                            <label>fechaInicio :</label>
                            <input type='text' name='fechaInicio' value ='". $_POST['fechaInicio']."'>.
                            <label>fechafinal :</label>
                            <input type='text' name='fechafinal' value = '".$_POST['fechafinal']."'>";
            if(empty($_POST['direccion']) || empty($_POST['fechaInicio'])|| empty($_POST['fechafinal'])){
                $corregir=false;
            }
        }
        else if($eleccion=="logistica" && empty($_POST['propietario'])){
            $formulario .=   "<label>empresa de abastecimiento :</label>
                            <input type='text' name='empresa' value ='".$_POST['propietario']."'>";
            if(empty($_POST['propietario'])){
                $corregir=false;
            }
        }
        $formulario.="<label>certificado :</label><INPUT TYPE='file' NAME='certificado'>
        <button type='submit' name = 'general' value ='pricipal'>enviar</button>
        </form>";
        if(!$corregir){
            echo $formulario;
        }else{
            function validarmatricula($file, $matricula){
                while(!feof($file)){
                    $matruculaaux = substr(fgets($file),0,8);
                    if($matruculaaux==$matricula){
                        return false;
                    }
                    echo $matruculaaux;
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
                    if(validar($_POST['matricula'])){
                        
                    }
                }
                if($validar){
                    $matricula = $_POST['matricula'];
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
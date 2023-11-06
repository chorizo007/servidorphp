<?php
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
    //tipo de ejercicio
    if(!empty($_POST['pricipal'])){
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
    else{
        echo "error 3";
    }

?>
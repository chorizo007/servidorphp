<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        #formulario {
            background-color: rgba(219, 220, 222, 255);
            border-radius: 0.3em;
            padding: 1em;
        }

        #titulo {
            background-color: rgba(219, 220, 222, 255);
            border-radius: 0.3em;
            margin-top: 2em;
            padding: 0.3em;
        }

        #centrar {
            display: flex;

        }

        * {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        }

        #fondo {
            background-color: rgba(219, 220, 222, 255);
        }

        .boton {
            background-color: white;
            border: 2px solid rgba(50, 55, 56, 0.839);
            border-radius: 10px;
            margin: 5px;
            padding: 8px;
            padding-left: 25px;
            padding-right: 25px;
        }
        .error{
            color: red;
        }
    </style>
</head>
<body>
<?php



        $servidor = "localhost"; // Nombre del servidor de MySQL
        $usuario = "tu_usuario"; // Usuario de MySQL
        $contrasena = "tu_contraseña"; // Contraseña de MySQL
        $base_datos = "tu_base_de_datos"; // Nombre de la base de datos

        // Conectar a la base de datos
        $conexion = new mysqli($servidor, $usuario, $contrasena, $base_datos);

        // Verificar la conexión
        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        // Realizar consultas aquí

        // Cerrar la conexión
        $conexion->close();


    function generaBotonesRadio($nombreControl, $valores, $etiquetas, $valorSeleccionado) {
        $html = ''; // Inicializamos la cadena de HTML vacía

        // Verificamos que los arreglos tengan la misma cantidad de elementos
        if (count($valores) != count($etiquetas)) {
            return 'Error: Los arreglos de valores y etiquetas no tienen la misma cantidad de elementos.';
        }
    
        // Iteramos a través de los valores y etiquetas para generar los botones de radio
        for ($i = 0; $i < count($valores); $i++) {
            $html .= '<input type="radio" name="' . $nombreControl . '" value="' . $valores[$i] . '"';
    
            // Verificamos si este es el valor seleccionado
            if ($valores[$i] == $valorSeleccionado) {
                $html .= ' checked';
            }
    
            $html .= '> ' . $etiquetas[$i] . '<br>';
        }
    
        return $html; // Devolvemos el código HTML generado
    }

    function generaCajasVerificacion($nombreControl, $valoresEtiquetas, $valoresSeleccionados = []) {
        $html = ''; // Inicializamos la cadena de HTML vacía
    
        foreach ($valoresEtiquetas as $valor => $etiqueta) {
            $html .= '<input type="checkbox" name="' . $nombreControl . '[]" value="' . $valor . '"';
    
            // Verificamos si este valor está seleccionado
            if (in_array($valor, $valoresSeleccionados)) {
                $html .= ' checked';
            }
    
            $html .= '> ' . $etiqueta . '<br>';
        }
    
        return $html; // Devolvemos el código HTML generado
    }
    
    function generaSelectSimple($nombreControl, $opciones, $valorPorDefecto = null) {
        $html = '<select name="' . $nombreControl . '">';
        
        foreach ($opciones as $valor => $etiqueta) {
            $selected = ($valor == $valorPorDefecto) ? ' selected' : '';
            $html .= '<option value="' . $valor . '"' . $selected . '>' . $etiqueta . '</option>';
        }
        
        $html .= '</select>';
        
        return $html;
    }

    function generaSelectMultiple($nombreControl, $opciones, $valoresPorDefecto = []) {
        $html = '<select name="' . $nombreControl . '[]" multiple>';
        
        foreach ($opciones as $valor => $etiqueta) {
            $selected = (in_array($valor, $valoresPorDefecto)) ? ' selected' : '';
            $html .= '<option value="' . $valor . '"' . $selected . '>' . $etiqueta . '</option>';
        }
        
        $html .= '</select>';
        
        return $html;
    }
    /*ejemplos de las funciones 
    $nombreControl = 'opciones';
    $valoresEtiquetas = [
        'opcion1' => 'Opción 1',
        'opcion2' => 'Opción 2',
        'opcion3' => 'Opción 3'
    ];

    // Generar cajas de verificación
    $cajasVerificacionHTML = generaCajasVerificacion($nombreControl, $valoresEtiquetas, ['opcion1', 'opcion3']);

    // Generar elemento de selección simple
    $opcionesSelectSimple = [
        'valor1' => 'Opción 1',
        'valor2' => 'Opción 2',
        'valor3' => 'Opción 3'
    ];

    $selectSimpleHTML = generaSelectSimple('seleccionSimple', $opcionesSelectSimple, 'valor2');

    // Generar elemento de selección múltiple
    $opcionesSelectMultiple = [
        'valorA' => 'Opción A',
        'valorB' => 'Opción B',
        'valorC' => 'Opción C'
    ];

    $selectMultipleHTML = generaSelectMultiple('seleccionMultiple', $opcionesSelectMultiple, ['valorA', 'valorC']);




    */
    //validar si el envio del formulario 


    //funciones de validacion de cada campo = 
    function validarcontra($contra){
        if(empty($contra)){
            return true;
        }
        if(strlen($contra)>6 && strlen($contra)<12){
            return false;
        }
        return true;
    }
    function validargenero($genero){
        if($genero!='M' && $genero!='F'){
            return true;
        }
        return false;
    }
    function validarFecha($fecha){
        $fecha = trim($fecha);
        if (is_numeric($valor) && $valor > 18) {
            return true;
        }
        return false;
    }
    function validarpais($pais){
        switch($pais){
            case 'ingles': return false;
            case 'frances': return false;
            case 'aleman': return false;
            case 'holandes': return false; 
            default: return true;
        }
    }
    


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // insertar todo el html include('hoja12.html');
        $formulario = array ($_POST['nombre'],$_POST['contrasenia'],$_POST['genero'],$_POST['fechaNacimiento'],$_POST['pais'],$_POST['acepto'],$_POST['comentario']);
        $formulariopintar = "<div class='container'>
        <form action='hoja12.php' method='post' id='formulario' ENCTYPE='multipart/form-data'>
            <h2>formulario con funciones </h2>
            <div class='form-row mx-auto'>
                <div class='col-md-6 mb-2'>
                    <label>nombre :</label>
                    ";
                    if(empty($formulario[0])){
                        $formulariopintar.="<INPUT TYPE='text' NAME='nombre' required><span class='error'> nombre incorrecto</span>" ;
                    }else{
                        $formulariopintar.="<INPUT TYPE='text' NAME='nombre' value='".$formulario[0]."'required >" ;
                    }
                $formulariopintar.="</div>
                <div class='col-md-6 mb-2'>
                    <label>contraseña :</label>";
                    if(validarcontra($formulario[1])){
                        $formulariopintar.="<INPUT TYPE='password' NAME='contrasenia' required> <span class='error'> contraseña incorrecto</span>" ;
                    }else{
                        $formulariopintar.="<INPUT TYPE='password' NAME='contrasenia' value='".$formulario[1]."'required >" ;
                    }
                $formulariopintar.="</div>
                <div class='col-md-6 mb-2'>
                    <label>genero</label>
                    <SELECT NAME='genero'>
                            <OPTION VALUE='M' SELECTED>M</OPTION> 
                            <OPTION VALUE='F'>F</OPTION> 
                            </SELECT>";
                    if(validargenero($formulario[2])){
                        $formulariopintar.="<span class='error'> genero incorrecto</span>" ;
                    }else{  
                        $formulariopintar.=" ";
                    }
                $formulariopintar.="</div>
                <div class='col-md-6 mb-2'>
                    <label>fechaNacimiento :</label>";
                    if(validarFecha($formulario[3])){
                        $formulariopintar.="<INPUT TYPE='text' NAME='fechaNacimiento' required> <span class='error'> fecha incorrecto</span>" ;
                    }else{
                        $formulariopintar.="<INPUT TYPE='text' NAME='fechaNacimiento' value='".$formulario[3]."'required >" ;
                    }

                $formulariopintar.="</div>
                <div class='col-md-6 mb-2'>
                    <label>indioma</label>
                    <SELECT NAME='pais'>
                        <OPTION VALUE='ingles' SELECTED>ingles</OPTION> 
                        <OPTION VALUE='Spain'>Spain</OPTION> 
                        <OPTION VALUE='aleman'>aleman</OPTION> 
                        <OPTION VALUE='holandes'>holandes</OPTION> 
                        </SELECT>";
                    if(validarpais($formulario[4])){
                        $formulariopintar.="
                        <span class='error'> escoje un indioma</span>" ;
                    }else{  
                        $formulariopintar.=" ";
                    }

                $formulariopintar.="</div>
                <div class='col-md-6 mb-2'>";
                if(empty($formulario[5])){
                    $formulariopintar.="<INPUT TYPE='radio' NAME='acepto' VALUE='acepto' required> <span class='error'> NO HAS ACEPTADO LOS TERMINOS Y CONDICIONES</span>" ;
                }else{  
                    $formulariopintar.="<INPUT TYPE='radio' NAME='acepto' VALUE='acepto' checked> acepto los terminos y condiciones";
                }
                $formulariopintar.="</div>
                <div class='col-md-6 mb-2'>";
                    if(empty($formulario[6])){
                        $formulariopintar.="<TEXTAREA COLS='50' ROWS='4' NAME='comentario'>
                        INTRODUCE UN COMENTARIO ...
                        </TEXTAREA>";
                        
                    }else{  
                        $formulariopintar.="<TEXTAREA COLS='50' ROWS='4' NAME='comentario'>"
                            .$formulario[6]." 
                        </TEXTAREA>";
                    }
                $formulariopintar.="</div>
                <div class='col-md-6 mb-2'>
                <label>imagen :</label>";
                    if (isset($_FILES['ficheronoticia']) && $_FILES['ficheronoticia']['error'] === UPLOAD_ERR_OK) {
                        $tamanoMaximo = 4 * 1024 * 1024; 
                        if ($_FILES["size"] > $tamanoMaximo) {
                            $formulariopintar.= "El archivo es demasiado grande. Tamaño máximo permitido: 2 MB.";
                        }else{
                            // Validar la extensión (por ejemplo, solo permitir archivos JPEG)
                            $extensionesPermitidas = array("jpg", "jpeg");
                            $nombreArchivo = $archivo["name"];
                            $extension = pathinfo($nombreArchivo, PATHINFO_EXTENSION);

                            if (in_array(strtolower($extension), $extensionesPermitidas)) {
                                $rutaAbsoluta =  $_SERVER['DOCUMENT_ROOT'].'/ej1/img/';
                                $nombreFichero = $_FILES['ficheronoticia']['name'];
                                $nombreCompleto = $rutaAbsoluta . $nombreFichero; 
                            
                                if (move_uploaded_file($_FILES['ficheronoticia']['tmp_name'], $nombreCompleto)) {
                                    $formulariopintar.="<span class='error'>Fichero subido con éxito a la ruta absoluta: $nombreCompleto</span>" ;
                                } else {
                                    $formulariopintar.="<span class='error'>No se pudo mover el fichero a la ruta absoluta.</span>" ;
                                }
                            } else {
                                $formulariopintar.= "<span class='error'>La extensión del archivo no es válida. Extensiones permitidas: jpg, jpeg.</span><br>";
                            }
                        }
                    } else {
                        $formulariopintar.="<span class='error'>Error al subir el archivo.</span>" ;
                    }
                    
                    $formulariopintar.= "<INPUT TYPE='file' NAME='ficheronoticia'>
                </div>

            </div> 

            <button type='submit' class='boton'> enviar</button>
        </form>
    </div>";

    echo $formulariopintar;
    foreach($formulario as $valor){
        if(!empty($valor)){
            echo $valor;
            echo "<br>";    
        }
    }
    } else {
        // El formulario no se ha enviado a través de POST, puedes mostrar un mensaje o redirigir a la página del formulario.
    }
    
    //validacion de datos 

    //mostrar el formulario


?>

</body>
</html>
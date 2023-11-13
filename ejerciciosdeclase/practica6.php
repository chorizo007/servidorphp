<?php
    $cadena = $_POST['cadena'];
    $radio = $_POST['radio'];
    $genero = $_POST['genero'];
    $extras = $_POST['extras'];
    foreach ($extras as $extra){
        echo "$extra<BR>\n";
    }
    echo $cadena . " ";
    echo $radio . " ";
    echo $genero;

    $clave = $_POST['clave'];
    echo $clave;

    If ( ! empty($_POST['idiomas'])){
    $idiomas = $_POST['idiomas'];
    foreach ($idiomas as $idioma)
    echo "$idioma<BR>\n";
    }

    $comentario = $_POST['comentario'];
    echo $comentario;

    echo "<br>";
    //array de files  SUBIDA DE UN FICHERO $_files[]['ficheronoticia'];


    $ficheroaux = $_FILES['ficheronoticia']['name'];
    echo $_FILES['ficheronoticia']['name'];
    echo "<br>";
    echo $_FILES['ficheronoticia']['type'];
    echo "<br>";
    echo $_FILES['ficheronoticia']['size'];
    echo "<br>";
    echo $_FILES['ficheronoticia']['tmp_name'];
    echo "<br>";
    echo $_FILES['ficheronoticia']['error'];
    


    if (isset($_FILES['ficheronoticia']) && $_FILES['ficheronoticia']['error'] === UPLOAD_ERR_OK) {
        $rutaAbsoluta =  $_SERVER['DOCUMENT_ROOT'].'/ej1/img/';
        $nombreFichero = $_FILES['ficheronoticia']['name'];
        $nombreCompleto = $rutaAbsoluta . $nombreFichero; 
    
        if (move_uploaded_file($_FILES['ficheronoticia']['tmp_name'], $nombreCompleto)) {
            echo "Fichero subido con éxito a la ruta absoluta: $nombreCompleto";
        } else {
            echo "No se pudo mover el fichero a la ruta absoluta.";
        }
    } else {
        echo "Error al subir el archivo.";
    }

    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<ul>";
        echo "<li> Titulo : ".$_POST['titulonoticia']."</li>";  
        echo "<li> Texto : ".$_POST['textonoticia']."</li>";
        echo "<li categoria : >".$_POST['categorianoticia']."</li>";
        echo "<li imagen >".$_FILES['ficheronoticia']['name']."</li>";
    echo "</ul>";
    $rutaimgnoticia = "./img/".$_FILES['ficheronoticia']['name'];
    echo "<img src='" . $rutaimgnoticia . "' alt='imagen noticia' width: 100px height= 100px/>";

    //validar si el envio del formulario 

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // El formulario se ha enviado a través de POST
        // Puedes realizar las acciones de procesamiento aquí
    } else {
        // El formulario no se ha enviado a través de POST, puedes mostrar un mensaje o redirigir a la página del formulario.
    }
    
    //validacion de datos 

    //mostrar el formulario


?>
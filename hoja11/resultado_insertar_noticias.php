<h2>Gestions de noticias</h2>
<?php
session_start();
include('comprobar_user.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST["titulo"];
    $texto = $_POST["texto"];
    $categoria = $_POST["categoria"];
    $fecha = $_POST["fecha"];
    $imagen = null;
    if (empty($titulo) || empty($texto) || empty($categoria)) {
        header("Location: insertar_noticias.php");
    }

    if (isset($_FILES['ficheronoticia']) && $_FILES['ficheronoticia']['error'] === UPLOAD_ERR_OK) {
        $rutaAbsoluta = $_SERVER['DOCUMENT_ROOT'] . '/github/servidorphp/hoja11/noticiasfile/';
        $nombreFichero = $_FILES['ficheronoticia']['name'];
        $nombreCompleto = $rutaAbsoluta . $nombreFichero;

        if (move_uploaded_file($_FILES['ficheronoticia']['tmp_name'], $nombreCompleto)) {
            echo "Fichero subido con éxito a la ruta absoluta: $nombreCompleto";
            $imagen = $nombreFichero;
            // Conexión a la base de datos utilizando funciones
            $conexion = mysqli_connect('localhost', 'web', 'web', 'inmobiliaria');
            if (!$conexion) {
                die('Error de conexión: ' . mysqli_connect_error());
            }

            $query = "INSERT INTO noticias (TITULO, TEXTO, CATEGORIA, FECHA, IMAGEN) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conexion, $query);
            mysqli_stmt_bind_param($stmt, "sssss", $titulo, $texto, $categoria, $fecha, $imagen);

            if (mysqli_stmt_execute($stmt)) {
                echo "la noticia ha sido recibida correctamente";
                echo "<ul>";
                echo "<li>titulo: ".$titulo."</li>";
                echo "<li>texto : ".$texto."</li>";
                echo "<li>categoria : ".$categoria."</li>";
                echo "<li>fecha : ".$fecha."</li>";
                echo "<li>Nombre de la imagen : ".$imagen."</li>";
                echo "<a href='insertar_noticias.php'>insertar otra notica</a>";
            } else {
                echo "Error al insertar la noticia: " . mysqli_stmt_error($stmt);
            }
            mysqli_stmt_close($stmt);
            mysqli_close($conexion);
        } else {
            echo "No se pudo mover el fichero a la ruta absoluta.";
        }
    } else {
        echo "Error al subir el archivo.";
    }

    
}
?>
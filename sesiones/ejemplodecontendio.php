<?php
session_start();

// Verificar si la sesión "tipo_contenido" está configurada
if (isset($_SESSION['tipo_contenido'])) {
    $tipoContenido = $_SESSION['tipo_contenido'];
} else {
    // Si no está configurada, establecer un valor predeterminado
    $tipoContenido = 'A';
}

// Cambiar el tipo de contenido en cada clic (esto es solo un ejemplo, puedes ajustarlo según tus necesidades)
if (isset($_GET['cambiar_contenido'])) {
    $tipoContenido = ($_GET['cambiar_contenido'] === 'A') ? 'A' : 'B';
    $_SESSION['tipo_contenido'] = $tipoContenido;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contenido Dinámico</title>
</head>
<body>
    <h1>Contenido Dinámico</h1>

    <?php
    // Mostrar contenido según el tipo
    if ($tipoContenido === 'A') {
        echo '<p>Estás viendo el Contenido A</p>';
    } else {
        echo '<p>Estás viendo el Contenido B</p>';
    }
    ?>

    <p><a href="?cambiar_contenido=A">Cambiar a Contenido A</a></p>
    <p><a href="?cambiar_contenido=B">Cambiar a Contenido B</a></p>
</body>
</html>

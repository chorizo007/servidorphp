<?php
    session_start();

    if (isset($_SESSION['admin'])) {
        $botonadmin = "<button><a href='admin.php'>ADMINISTRAR</a></button>";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        *{
            font-family: 'Arial', sans-serif;
        }
        table{
            border: 1px solid black;
        }
        table tr:first-child {
            background-color: #92c7f3; /* Cambia el color de fondo según tus preferencias */
            font-weight: bold; /* Puedes cambiar el estilo de la fuente, por ejemplo, hacerla negrita */
        }

        /* Estilo para el resto de las filas, si lo deseas */
        table tr:not(:first-child) {
            background-color: #572efc; /* Cambia el color de fondo según tus preferencias */
        }
        h1{
            color: blue;
        }
        form{
            border: black 1px dashed;
            margin: 5px;
            padding: 15px;
        }
        form label{
            margin: 35px;
        }
        .nav{
            display: flex;
            background-color: #92c7f3;
            padding: 15px;
            justify-content: space-between;
            overflow: none;
        }
    </style>
</head>
<body>
    <div class="nav">
        <?php
            echo $botonadmin;
        ?>
        <button><a href="cursosabi.php">cursos abiertos</a></button>
        <button><a href="login.php">login</a></button>
        <button><a href="registro.php">registro</a></button>
        <button><a href="logout.php">Cerrar Sesión</a></button>
    </div>
</body>
</html>
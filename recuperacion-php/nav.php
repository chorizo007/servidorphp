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
        .nav button{
            background-color:white;
            border:2px solid rgba(50, 55, 56, 0.839);
            border-radius: 10px;
            margin: 5px;
            padding: 8px;
            padding-left: 25px;
            padding-right: 25px;
            text-decoration: none;
            color: black;
        }
        .nav button:hover{
            background-color: rgba(50, 55, 56, 0.839);
            color: white;
            border: 2px solid white;       
        }
        a{
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="nav">
        <button><a href=".php"></a></button>
        <?php
            if (isset($_SESSION['admin'])) {
                echo "<button><a href=''>ADMINISTRAR</a></button>";
            }
            if(isset($_SESSION['email'])){
                echo "BIENVENIDO!!! :".$_SESSION['email'];
                echo "<button><a href='logout.php'>Cerrar Sesión</a></button>";
            }else{
                echo "<button><a href='login.php'>Login</a></button>";
                echo "<button><a href='registro.php'>Registro</a></button>";
            }
        ?>
    </div>
</body>
</html>
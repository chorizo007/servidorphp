
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
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
        <button><a href="formres.php">reservar</a></button>
        <button><a href="verresahora.php">ver las meses ahora</a></button> 
        <?php
            if (isset($_SESSION['admin'])) {
                echo "<button><a href='formres.php'>ADMINISTRAR</a></button>";
            }
            if(isset($_SESSION['email'])){
                echo "BIENVENIDO!!! :".$_SESSION['email'];
                echo "<button><a href='logout.php'>Cerrar Sesión</a></button>";
            }else{
                echo "<button><a href='inicio.php'>Login</a></button>";
                echo "<button><a href='registro.php'>Registro</a></button>";
            }
        ?>
    </div>
</body>
</html>
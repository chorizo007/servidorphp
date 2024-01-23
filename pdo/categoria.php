<?php
    if(empty($_GET['errorcorreo'])){
        $errores = "";
        if(empty($_POST['body'])){
            $errores = "Introduce un body para el correo<br><br>";
        }
        if(empty($_POST['cabecera'])){
            $errores .= "Introduce una cabecera para el correo<br><br>"; 
        }
        if(empty($_POST['categorias'])){
            $errores .= "Elige una categoría<br><br>"; 
        }
        if($errores){
            $url = "formulario.php?error=".$errores;
            header("Location: " . $url);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar Foto</title>
    <link rel="stylesheet" type="text/css" href="categoria.css">
</head>
<body>
    <form action="correo.php" method="post">

        <h1>Elige una foto</h1>

        <?php
            
            if(empty($_GET['categorias'])){
                echo "<input type='hidden' name='categorias' value='".$_POST['categorias']."'>";
                echo "<input type='hidden' name='body' value='".$_POST['body']."'>";
                echo "<input type='hidden' name='cabecera' value='".$_POST['cabecera']."'>";
            }else{
                echo "<input type='hidden' name='categorias' value='".$_GET['categorias']."'>";
                echo "<input type='hidden' name='body' value='".$_GET['body']."'>";
                echo "<input type='hidden' name='cabecera' value='".$_GET['cabecera']."'>";
            }
            

            $servername = "127.0.0.1";
            $username = "mail";
            $password = "mail";
            $dbname = "mail";
            
            try {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
                // Ejemplo de consulta SELECT
                $query = "SELECT * FROM clientes";
                $stmt = $conn->prepare($query);
                $stmt->execute();
            
                echo "<table>";
                echo "<tr><th>Nombre Cliente</th><th>Seleccionar</th></tr>";
                while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . $result['nombre_cliente'] . "</td>";
                    echo "<td><input type='checkbox' name='mail[]' value='" . $result['email'] . "'></td>";
                    echo "</tr>";
                }
                echo "</table>";

            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            
            $conn = null;
            if(empty($_GET['categorias'])){
                $directorio = './categorias/'.$_POST['categorias'];
            }else{  
                $directorio = './categorias/'.$_GET['categorias'];
            }

            $contenidoDirectorio = scandir($directorio);
            $carpetas = array_filter($contenidoDirectorio, function ($elemento) use ($directorio) {
                return $elemento != '.' && $elemento != '..';
            });

            foreach ($carpetas as $carpeta) {
                echo "<img src='" . $directorio . "/". $carpeta . "' width='100'>";
                echo "<input type='radio' name ='foto' value=" . $directorio . "/" . $carpeta . ">";
            }
        ?>
        <br>
        <?php
            echo $_GET['errorcorreo'];
        ?>
        <input type="submit" name="enviar" value="Enviar">
    </form>
</body>
</html>

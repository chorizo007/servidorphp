
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="correo.php" method="post">

        <h1>Elige una foto</h1>

        <?php
            echo "<input type='hidden' name='body' value='".$_POST['body']."'>";
            echo "<input type='hidden' name='cabecera' value='".$_POST['cabecera']."'>";
            echo "<input type='hidden' name='categorias' value='".$_POST['categorias']."'>";

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


            $directorio = './categorias/'.$_POST['categorias'];
            $contenidoDirectorio = scandir($directorio);
            $carpetas = array_filter($contenidoDirectorio, function ($elemento) use ($directorio) {
                return $elemento != '.' && $elemento != '..';
            });

            foreach ($carpetas as $carpeta) {
                echo "<img src='" . $directorio . "/". $carpeta . "' width='100'>";
                echo "<input type='radio' name ='foto' value=" . $directorio . "/" . $carpeta . ">";
            }
        ?>
        <input type="submit" name="enviar" value="enviar">
    </form>
</body>
</html>
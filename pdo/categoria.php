<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar Foto</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        form {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #4caf50;
            color: white;
        }

        img {
            margin: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px;
            width: 100px;
            height: auto;
            display: inline-block;
        }

        input[type="radio"] {
            margin: 5px;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
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
        <br>
        <input type="submit" name="enviar" value="Enviar">
    </form>
</body>
</html>

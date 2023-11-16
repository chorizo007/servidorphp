<?php
    $nombre = $_POST['nombre'];
    $contraseña = $_POST['contraseña'];
    $fecha = $_POST['fecha'];

    $correcto = false;  // Establecer a falso por defecto

    // Validar fecha
    $fechadate = new DateTime($fecha);

    if ($horario = fopen("horario.txt", "r")) {
        while (!feof($horario)) {
            $linea = fgets($horario);
            $horas = explode(";", $linea);

            // Crear objetos DateTime para las horas
            $horaInicio = new DateTime(trim($horas[0]));
            $horaFin = new DateTime(trim($horas[1]));

            $diferencia = $fechadate->diff($horaInicio);
            $diferenciaFin = $fechadate->diff($horaFin);

            if ($diferencia->invert == 0 && $diferenciaFin->invert == 1) {
                // La fecha está en el rango de horas
                $correcto = true;
                break;
            }
        }

        fclose($horario);  // Cerrar el archivo después de usarlo

        if ($correcto) {
            if ($usuarios = fopen("usuarios.txt", "r")) {
                while (!feof($usuarios)) {
                    $lineauser = fgets($usuarios);
                    $user = explode(";", $lineauser);
                    if ($user[0] == $nombre && $user[1] == $contraseña) {
                        echo "Todo está perfecto y has iniciado sesión.";
                        $correcto = true;
                        break;
                    }
                }

                fclose($usuarios);  // Cerrar el archivo después de usarlo
            } else {
                echo "Error al abrir el archivo usuarios.txt";
            }
        }
    } else {
        echo "Error al abrir el archivo horario.txt";
    }

    if (!$correcto) {
        echo "No estás en hora o las credenciales son incorrectas.";
    }
?>

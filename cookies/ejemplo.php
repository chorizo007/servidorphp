<?php
    <?php
    if (isset($_COOKIE['nombre_cookie'])) {
        $cookieValue = $_COOKIE['nombre_cookie'];
        echo "El valor de la cookie es: " . $cookieValue;
    } else {
        // Nombre de la cookie
        $nombre_cookie = "usuario";

        // Valor de la cookie
        $valor_cookie = "Juan";

        // Duración de la cookie (en segundos), por ejemplo, 1 hora
        $tiempo_expiracion = time() + 3600;

        // Ruta para la cual la cookie está disponible (puede ser '/' para todo el dominio)
        $ruta_cookie = "/";

        // Dominio al que pertenece la cookie (ajústalo según tu dominio)
        $dominio_cookie = "tudominio.com";

        // Establecer la cookie
        setcookie($nombre_cookie, $valor_cookie, $tiempo_expiracion, $ruta_cookie, $dominio_cookie);

        echo "Cookie establecida correctamente.";
    }

?>
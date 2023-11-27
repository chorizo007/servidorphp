<?php
session_start();

if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    echo "Bienvenido de nuevo, $usuario! <br>";
    echo '<a href="cerrar_sesion.php">Cerrar Sesión</a>';
} else {
    if (isset($_POST['submit'])) {
        $usuario = $_POST['usuario'];
        $password = $_POST['password'];

        if ($usuario == 'nico' && $password == '123') {
            $_SESSION['usuario'] = $usuario;

            setcookie('usuario', $usuario, time() + 3600);

            echo "Inicio de sesión exitoso, bienvenido $usuario! <br>";
            echo '<a href="cerrar_sesion.php">Cerrar Sesión</a>';
        } else {
            echo "Credenciales incorrectas. Intenta de nuevo.";
        }
    } else {
        echo '
            <form method="post" action="">
                Usuario: <input type="text" name="usuario" required><br>
                Contraseña: <input type="password" name="password" required><br>
                <input type="submit" name="submit" value="Iniciar Sesión">
            </form>
        ';
    }
}
?>

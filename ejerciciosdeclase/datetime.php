<?php
    //apuntes de php    link con todos las fechas compatibles : https://www.php.net/manual/es/timezones.php
    date_default_timezone_set('Indian/Kerguelen');
    $nuevaFecha = new DateTime('now'); //coge la fecha del sistema
    echo date_default_timezone_get();   //coger la fecha del sistema

    echo '<br>';
    $fechaconformato = new DateTime('2023-09-28'); //declaracion
    echo $fechaconformato->format('Y-m-d H:i:s'); //darle formato para poder mostralo 
    echo '<br>';
    echo $nuevaFecha->format('Y-m-d H:i:s');
    echo '<br>';
    $nuevaFecha->add(new DateInterval('P10D'));     //para poder añadir dias a un datetime tienes que hacerlo con dateinterval
    echo $nuevaFecha->format('Y-m-d H:i:s');

    
    echo '<br>';

    $nuevaFecha->sub(new DateInterval('P9Y'));    //para quitar tiempo a un datetime es con un dateinterval
    echo $nuevaFecha->format('Y-m-d H:i:s');
    echo '<br>';

    //delaclaracion del DateInterval

    $perioso = new DateInterval('P2YT5M'); //para IDENTIFICAR si es un mes o un minuto se usa el T para poder identificarlo


    /* Y años
    M meses
    D días
    W semanas. Éstas se convierten a días, por lo que
    no se puede combinar con D.
    H horas
    M minutos
    S segundos */
    echo '<br>';
    echo '<br>';
    echo '<br>';

    $d1 = new DateTime('now');
    $d2 = new DateTime('2023-10-30');
    /* $d2->add(new DateInterval('P10D')); */
    $periodo = $d2->diff($d1); //resta el objeto al parametro 
    echo $periodo ->format('%r%h horas %a dias');    //mostrar los intervalos 

    /* 
    %                   Literal %       lo que hace es comvertir todo el intervalo en un solo 
    Y, y                Anios, numérico, al menos 2 dígitos empezando con 0
    M,m                 Meses, numérico, al menos 2 dígitos empezando con 0
    D,d                 Días, numérico, al menos 2 dígitos empezando con 0
    H,h                 Horas,numérico, al menos 2 dígitos empezando con 0
    I, i                Minutos, numérico, al menos 2 dígitos empezando con 0
    S,s                 Segundos, numérico, al menos 2 dígitos empezando con 0
    R                   Signo "-" cuando es negatvo, "+" cuando es positvo
    r                   Signo "-" cuando es negatvo, vacío cuando es positvo 
    
    las mayusculas se utilizar para poner un 0 delante de los numeros que tengan menos de 2 digitos, ejemplo:
    mayusculas:
    01  02
    minusculas: 
    1   2
    */




    //modify
    $fechaActual = new DateTime('now');
    $fechaActual->modify('+3 days +2 hours');

    $nuevaFecha = new DateTime("2012-02-28");
    $nuevaFecha->modify("+1 day");
    echo "\n". $nuevaFecha->format("Y-m-d"); 


    

?>
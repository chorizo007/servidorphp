<?php
    echo "<h1>Hoja 10</h1>";

    echo "<br>";echo "<br>";echo "<br>";

    echo "<h3>Ejercicio 1</h3>";
    echo "Fecha actual";
    $actual = new DateTime('now');
    echo "<br>";
    echo $actual->format('Y-m-d');

    echo "<br>";

    echo " Fecha dentro de una semana";
    $semana_siguiente = new DateTime('now');
    $semana_siguiente -> add(new DateInterval('P7D'));
    echo "<br>";
    echo $semana_siguiente->format('Y-m-d');

    setlocale(LC_TIME, 'es_ES');

    $semana_siguiente = new DateTime('now');
    $semana_siguiente->add(new DateInterval('P7D'));
    echo "<br>";
    echo strftime('%A %e de %B de %Y %H:%M:%S %p', $semana_siguiente->getTimestamp());

    echo "<br>";echo "<br>";echo "<br>";

    echo "<h3>Ejercicio 2</h3>";
    echo "Fecha actual";
    echo "<br>";
    $actual = new DateTime('now');
    echo $actual -> format('l');
    echo "<br>";
    echo $actual -> format('l jS \of F Y h:i:s A');
    echo "<br>";
    setlocale(LC_TIME, 'es_ES');
    echo strftime('%A %e de %B de %Y %H:%M:%S %p', $actual->getTimestamp());
    echo "<br>";
    echo $actual -> format('F, j, Y h:i:s A');
    echo "<br>";
    echo $actual -> format('m.d.Y');
    echo "<br>";
    echo $actual -> format('m,d,Y');
    echo "<br>";
    echo $actual -> format('Ymd');
    echo "<br>";
    echo "It is the ".$actual -> format(' jS')." day";
    echo "<br>";
    echo $actual -> format('D M j G:i:s T Y');
    echo "<br>";
    echo $actual -> format('H:m:s \m \e\s\ \m\e\s');
    echo "<br>";
    echo $actual -> format('H:i:s');

    echo "<br>";echo "<br>";echo "<br>";echo "<br>";

    echo "<h3>Ejercicio 3</h3>";
    
?>
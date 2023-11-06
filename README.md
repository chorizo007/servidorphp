## en produccion

1. rutas
2. apuntes   
...


TIPOS DE VARIABLES 

is_array(), is_bool(), is_float(), is_integer(), is_null(), is_numeric(),
is_object(), is_resource(), is_scalar(),is_string()

constantes
define("constante",2);

operador ternario 
$numero = 7;
$mensaje = $numero >= 10 ? "El número es mayor o igual a 10" : "El número es menor que 10";
echo $mensaje;

archivo obligatorio
require ("conecta.php");

referencia 
$cadena="Tipo de dato cadena";
$ref=&$cadena;
$cadena="nueva asignación";
echo $ref;


ARRAYS 

recorrer
	current() - devuelve el valor del elemento que indica el puntero
	pos() - realiza la misma función que current
	reset() - mueve el puntero al primer elemento de<l array
	end() - mueve el puntero al último elemento del array
	next()- mueve el puntero al elemento siguiente
	prev() - mueve el puntero al elemento anterior
	count() - devuelve el número de elementos de un array
	key() – devuelve el índice de la posición actual

ejemplo de recorrer un array: 

		echo "<br>";
        $array_colores_tabla=array("fuertes"=>array("rojo"=>'FF0000',"verde"=>"00FF00","azul"=>"0000FF"), "suaves"=>array("rosa"=>"FE9ABC","amarillo"=>"FDF189","malva"=>"BC8F8F"));
        
        echo "<table>";
        foreach($array_colores_tabla as $clave => $valor){
            echo "<tr>";
            echo "<th>" . $clave . "</th>";
            foreach ($valor as $nombre => $color) {
                    echo "<th bgcolor =".$color.">" . $nombre . "</th>";
            }
            echo "</tr>";
        }
        echo "</table>";

recorer con un for: 
		for($clave=0; $clave<count($dias);$clave++){
            echo $dias[$clave];
        }

numero aleatorio
$randomNumbers = [];
for ($i = 0; $i < 10; $i++) {
    $randomNumbers[] = rand(1, 10);
}
$cantidad=array_count_values($randomNumbers);
if(isset($cantidad[2])){
    echo $cantidad[2];
}



asignar clave
	list($var1, $var2)= array("Lunes", "Martes");
	$var1="Lunes", $var2="Martes"

mostrar contenido 
	print_r($array);
	var_dump($matriz);

$	semana = array("lunes", "martes");		//mostrar el codigo y valor del codigo y valor 
	foreach ($semana as $k=>$v){
	echo "<pre>";
	print_r(each($semana));
	echo "</pre>";}

arrays de las claves (se puede BUSCAR CLAVE)
	array_keys ($unarray ,"clave")

array con los valores (clave numerica)
	array_values ($unarray)

buscar un patron en un array 
	$fl_array = preg_grep("/^(\d+)?\.\d+$/", $array);

buscar un valor en un array 
	array_search("valor",$unarray);		//retorna null y si lo encuentra SU POSICON 
	in_array(valor, $matriz, true);		//retorna true o false

apariciones en un array
	array_count_values($matriz); 		//retorna un array con las claves es el valor y el valor es el numero de apariciones

eliminar el ultimo valor del array
	$fruit = array_pop($stack);

eliminar el priner valor del array
	$fruit = array_shift($stack);

añadir al principio 
	array_unshift($queue, "apple", "raspberry");

funcion de arrays personalizada 
	array_walk

unir arrays 
	var_dump(array_replace($matriz_destino, $matriz_origen); //(los que coinciden en índice se sobrescriben, y los que no se añaden)
	array_merge($mat1, $mat2, $mat3) 
	array_merge_recursive($mat1,$mat2,$mat3) //sin perder elementos




rellenar un array
	array_pad

recortar arrays 
	array array_slice

de array a string 
	var_dump(implode(",", $array)); 


ordenar 
	invertido 
		array_reverse ( $array, true) //true para que las claves no cambien 
	desordenar aleatoriamente 
		shuffle($números);
	Ordena un array de menor a mayor
		bool sort ()
	Ordena un array en orden inverso (de mayor a menor)
		bool rsort ()
	Ordena un array manteniendo la correlación de los índices con los elementos asociados.
		bool asort ()
	Ordena un array en orden inverso, manteniendo la correlación de los índices con los elementos asociados.
		bool arsort ()
	Ordena un array por clave, manteniendo la correlación entre la clave y los datos.
		bool ksort ()
	Ordena un array por clave en orden inverso, manteniendo la correlación entre la clave y los datos.
		bool krsort ()
	Ordena un array usando una función de comparación definida por el usuario. Se asignan nuevas claves a los elementos ordenados.
		bool usort ()
	Ordena las claves de un array usando una función de comparación proporcionada por el usuario.
		bool uksort ()


crear un array con un rango 
	range(0, 100, 10)


crear un array con variables 
	compact("ciudad”,"edad");



arrays predefinicos 
$_GET, $_POST, $_COOKIE, $_REQUEST, $_ENV,
$_SERVER y $_SESSION



expresiones regulares: 



CADENA 

buscar caracteres

	buscar y retornar desde ese caracter hasta el final
		strstr 
	buscar la aparicion de un solo caracter 
		strrchr
	buscar y retornar la primera aparicion
		strpos
	buscar y retornar la ultima aparicion
		strrpos
	buscar la cantidad de caracteres iguales en el string 
		strspn ("Este espacio es muy bonito","Estela"); // 4
	buscar la cantidad de caracteres distintos en el string 
		strcspn 
	buscar un patron 
		substr_count($cad,"as");

comparar cadenas 	strcasecmp para que te den igual las mayusculas 
	strcmp	
compara hasta x 	strncasecmp mayusculas ""
	strncmp

longitud de cadena 
	strlen

recortar cadena 
	substr

recortar y añadir 
	 substr_replace

remplazar texto
	str_replace ($cadBusq,$cadReempl,$texto)

sustituir caracter a caracter 
	strtr (cadena, cadBus, cadRee)

informacion de los caracteres 
	count_chars

eliminar espacios en blanco 
	rtrim

eliminar a los lados 
	trim

rellenar una cadena 
	str_pad

mayusculas/minusculas 
	strtolower $cad) / strtoupper $cad)

	poner en mayuscula el primer caracter 
		ucfrst
	poner en mayusula el primer caracter de cada palabra de la cadena
		ucwords

quitar los caracteres " ' (/)
	addslashes
	
	escapar los carateres que yo quiera
		addcslashes

quitar los / de la cadena 
	stripslashes

	quitar los / de los espacificados 
		stripcslashes

colocar / en los caracteres especiales 
	quotemeta

cambiar los elementos html 
	htmlspecialchars

dividir una cadena por token 
	strtok
	
hacer una array con x cantidad de carateres por cada valor 
	str_split($str, 3);
 
partir una cadena y hacerla array
	explode

de array a cadena 
	implode	

de saltos de linea a br
	nl2br

poner caracteres
	chunk_split

validaciones

FILTER_VALIDATE_EMAIL: Valida emails según RFC 822
FILTER_VALIDATE_FLOAT: Valida números reales
FILTER_VALIDATE_IP : Valida IP’s
FILTER_VALIDATE_URL : Valida URL’s según RFC 2396



FUNCIONES

function nombreFunción (param1,param2){
	instrucción1;
	return valor_de_retorno;
}

info en una funcion 

func_num_args() → número de argumentos pasados a la función.
func_get_args() → array con los argumentos pasados a la función
func_get_arg(num) → el argumento que está en la posición num en la lista de argumentos. La primera posición es la 0



clausula 
$saludo = function($nombre){
 printf("Hola %s\r\n", $nombre);};


comprobar si se ha creado la funcion : 

	if (function_exists('imap_open')) {
 		echo "Las funciones de IMAP están disponibles.<br />\n";
 	} else {
 		echo "Las funciones de IMAP no están disponibles.<br />\n";
 	}


DATE

configurar la zona horaria del servidor: 
date.timezone = Europa/Madrid

configurar en espacifico un php para que este en otro horario 
date_default_timezone_set('Europe/London');

zona horaria en un datetime 
$zona = new DateTimeZone('Pacifc/Auckland');
$fecha = new DateTime(NULL, $zona);

DateTime declaracion 

$fecha = new DateTime('2023-11-05 18:45:30');

format datetime

Y	Año (4 dígitos)			2023
y	Año (2 dígitos)			23
m	Mes (con ceros iniciales)	01 a 12
n	Mes (sin ceros iniciales)	1 a 12
F	Nombre completo del mes		enero
M	Nombre abreviado del mes	ene
d	Día del mes (con ceros)		01 a 31
j	Día del mes (sin ceros)		1 a 31
D	Día de la semana (abreviado)	lun
l	Día de la semana (completo)	lunes
G	Hora (formato 24 horas)		0 a 23
H	Hora (con ceros iniciales)	00 a 23
i	Minutos (con ceros)		00 a 59
s	Segundos (con ceros)		00 a 59
A	AM o PM (mayúsculas)		AM o PM
a	AM o PM (minúsculas)		am o pm

echo $fecha->format('j \de F \del Y');


DateInterval declaracion

P	Indica un período de tiempo	P (obligatorio)
Y	Años				P1Y (1 año)
M	Meses				P2M (2 meses)
D	Días				P3D (3 días)
W	Semanas				P4W (4 semanas)
H	Horas				PT6H (6 horas)
M	Minutos				PT10M (10 minutos)
S	Segundos			PT30S (30 segundos)

$intervalo = new DateInterval('P1Y2M3DT4H5M6S');

mostrar un dateinterval

%Y	Número total de años
%M	Número total de meses
%D	Número total de días
%H	Número total de horas
%I	Número total de minutos
%S	Número total de segundos
%R 	Signo "-" cuando es negatvo, "+" cuando es positvo
%r	Signo "-" cuando es negatvo, vacío cuando es positvo
%y	Años
%m	Meses
%d	Días
%h	Horas
%i	Minutos
%s	Segundos
%a	Días en formato numérico

echo $diferencia->format('%m meses, %d días, %h horas');


datetime add +tiempo

$nuevaFecha = new DateTime('2011-01-25');
$nuevaFecha->add(new DateInterval('P10D'));


datetime sub -tiempo

$nuevaFecha = new DateTime('2011-01-25');
$nuevaFecha->sub(new DateInterval('P10D'));


datetime modify 

$fecha = new DateTime('2023-11-05');
$fecha->modify('+2 weeks'); // Suma 2 semanas a la fecha

+n days				Suma n días a la fecha actual				"+3 days"
-n days				Resta n días a la fecha actual				"-1 week"
+n months			Suma n meses a la fecha actual				"+2 months"
-n months			Resta n meses a la fecha actual				"-6 months"
+n years			Suma n años a la fecha actual				"+1 year"
-n years			Resta n años a la fecha actual				"-3 years"
first day of next month		Primer día del próximo mes				"first day of next month"
last day of this month		Último día del mes actual				"last day of this month"
next Tuesday			Próximo martes a partir de la fecha actual		"next Tuesday"
last Thursday			Último jueves anterior a la fecha actual		"last Thursday"
first day of January +5 years	Primer día de enero dentro de 5 años			"first day of January +5 years"


datetime diff

$fecha1 = new DateTime('2023-11-05');
$fecha2 = new DateTime('2023-12-25');

$diferencia = $fecha1->diff($fecha2);

echo $diferencia->format('%m meses, %d días, %h horas');




DatePeriod


declaracion:

$periodo = new DatePeriod($fechaInicio, $intervalo, $fechaFin);

recorrer el periodo 

foreach ($periodo as $fecha) {
    echo $fecha->format('Y-m-d') . "\n";
}



FORMULARIOS

forma de generar un enlace por get
echo "<a href=\"proces.php?user=".urlencode($user)."&uid=".urlencode($uid)."\">";

configuracion del php.ini

file_uploads = On
upload_max_filesize = 2M
post_max_size = 8M



HTML

<form action="dos.php" method="POST" ENCTYPE="multipart/form-data">

 	Edad: <input type="text" name="edad" VALUE="valor por defecto">

	<INPUT TYPE="radio" NAME="sexo" VALUE="M" CHECKED>Mujer
	<INPUT TYPE="radio" NAME="sexo" VALUE="H">Hombre

	Contraseña: <INPUT TYPE="password" NAME="clave">

	<SELECT NAME="color">
		<OPTION VALUE="rojo" SELECTED>Rojo</OPTION>
		<OPTION VALUE="verde">Verde</OPTION>
		<OPTION VALUE="azul">Azul</OPTION>
	</SELECT>
	

	<SELECT MULTIPLE SIZE="3" NAME="idiomas[]">
		<OPTION VALUE="ingles" SELECTED>Inglés</OPTION>
		<OPTION VALUE="frances">Francés</OPTION>
		<OPTION VALUE="aleman">Alemán</OPTION>
		<OPTION VALUE="holandes">Holandés</OPTION>
	</SELECT>


	<INPUT TYPE="checkbox" NAME="extras[ ]" VALUE="garaje" CHECKED>Garaje
	<INPUT TYPE="checkbox" NAME="extras[ ]" VALUE="piscina">Piscina
	<INPUT TYPE="checkbox" NAME="extras[ ]" VALUE="jardin">Jardín


	<INPUT TYPE="file" NAME="fichero">


	<TEXTAREA COLS="50" ROWS="4" NAME="comentario">
		Este libro me parece ...
	</TEXTAREA>

 	<INPUT TYPE="submit" NAME="enviar" VALUE="Enviar datos">
	<INPUT TYPE="reset" NAME=“borrar" VALUE=“Limpiar datos">

</form>



file php

$_FILES['imagen']['name']
$_FILES['imagen']['type']
$_FILES['imagen']['size']
$_FILES['imagen']['tmp_name']
$_FILES['imagen']['error']


manejo del fichero

    echo "name: " . $_FILES['imagen']['name'] . "\n";
    echo "tmp_name: " . $_FILES['imagen']['tmp_name'] . "\n";
    echo "size: " . $_FILES['imagen']['size'] . "\n";
    echo "type: " . $_FILES['imagen']['type'] . "\n";

    if (is_uploaded_file($_FILES['imagen']['tmp_name'])) {
        $nombreDirectorio = "img/";
        $nombreFichero = $_FILES['imagen']['name'];
        $nombreCompleto = $nombreDirectorio . $nombreFichero;

        // Verificar y crear el directorio si no existe
        if (!is_dir($nombreDirectorio)) {
            mkdir($nombreDirectorio, 0755, true);
        }

        if (is_dir($nombreDirectorio)) {
            $idUnico = time();
            $nombreFichero = $idUnico . "-" . $nombreFichero;
            $nombreCompleto = $nombreDirectorio . $nombreFichero;

            move_uploaded_file($_FILES['imagen']['tmp_name'], $nombreCompleto);
            echo "Fichero subido con el nombre: $nombreFichero<br>";
        } else {
            echo 'Directorio definitivo inválido';
        }
    } else {
        print("No se ha podido subir el fichero\n");
    }

headers:

Extraer cabeceras HTTP del cliente en PHP

var_dump(apache_request_headers());

Redirigir al cliente a otra dirección.
header ('Location: acceso_no_autorizado.php');

Mostrar un mensaje y redirigir al cliente a otra dirección.
header ('Refresh: 5; url=http://www.google.es');
echo 'Lo que busca no existe, le redirigiremos a Google en 5 segundos'

ocultar la version del interprete 
header( 'X-Powered-By: adivina-adivinanza' );


ofrecer hacer la descarga de un fichero

header('Content-type: application/pdf');
header('Content-Disposition: attachment;filename="downloaded.pdf"')
readfile('original.pdf'));


visualizarlo en el html con la propiedad inline
header("Content-type:image/jpeg");
header("Content-Disposition:inline ; filename=captcha.jpg");





LEER FICHEROS

if (!$fichero = @fopen("datos.txt", 'r');{
	die("ERROR: no se ha podido abrir el fichero de datos");
}
fclose($fichero)

modos del fopen 
‘r’ 		Sólo lectura. Puntero al inicio.
‘r+’ 		Lectura/escritura. Puntero al inicio.
‘w’ 		Sólo escritura. Puntero al inicio. Si existe el fchero borra lo que había, sino lo intenta crear.
‘w+’ 		Lectura/escritura. Puntero al principio. Si existe el fchero borra lo que había, sino lo intenta crear.
‘a’		Sólo escritura. Puntero al fnal. Si no existe lo intenta crear.
‘a+’ 		Lectura/escritura. Puntero al fnal.
‘x’, ‘x+’ 	Igual que w, w+ pero eiitando la creación si el fchero existe.
‘c’, ‘c+’ 	Igual que w , w+ pero sin truncar el fchero cuando ya existe.

abrir el fichero y devolver un array 
file (nombre_fichero)

todo el fichero en una linea 
file_get_contents (nombre_fichero)



leer un fichero linea a linea 

	$a = fopen('datos.txt', 'r');
	while(!feof($a)){
		echo fgets($a) . '<br>';
	}
	fclose($a);

	colocar el fichero al principio del fichero 
		rewind( identicador);

determinar si un fichero existe 
file_exists()


escribir en un fichero
fwrite($fichero, cadena, longitud)


copiar un fichero
	copy (origen, destno)

mover un fichero
	rename (nombre_original, nombre_final)

borrar 
	unlink(fichero)

truca el archivo a la longitud en bytes dada
	 fruncate (descriptor, longitud)

tamaño del fichero
	filesize(path) 

cuando se modifico el fichero
	 filemtime(path) 

otras operaciones: 

 chgrp : Cambia el grupo de un archivo.
 chmod : Cambia permisos de un archivo
 chown : Cambia el propietario de un archivo
 is_executable : Indica si el archivo es ejecutable
 is_file :Indica si el archivo es un archiio regular
 is_link : Indica si el archivo es un enlace simbólico
 is_readable : Indica si es posible leer el archiio
 is_uploaded_file Indica si un archivo fue cargado a través de HTTP POST
 is_writable : Indica si el nombre de archivo es escribible
 is_writeable : Alias de is_writable
 filetype(path) : Devuelve el tipo de un archivo.




MANEJO DE DIRECTORIOS
is_dir( directorio): Determina si existe y es un directorio
opendir( directorio): Abre directorio y deiuelie un descriptor
readdir($descriptor):
	Devuelve el nombre del siguiente fchero en el directorio.
	Los nombres de archiio son deiueltos en el orden en que están en el sistema de archiios. ¡Ojo! los primeros “.” y “..”
closedir( $descriptor)


recorrer un directorio 
	$dir = opendir('.'); //abre el directorio actual
	If ($descriptor = opendir($dir)){
		while(false !== ($fichero = readdir($descriptor))){
			echo "$fichero: " .filesize($dir. $fichero).'bytes <br>';
		}
	closedir($dir);
	}



añadir mas contenido a otro fichero
include 'vars.php';






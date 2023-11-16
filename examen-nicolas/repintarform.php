<?php
    include 'cabecera.html';
    //recoger valores del formulario: 
    $edad = $_POST['edad'];
    $sexo = $_POST['sexo'];
    $color = $_POST['color'];
    $clave = $_POST['clave'];
    $idiomas = $_POST['idiomas'];
    $extras = $_POST['extras'];
    $fichero = $_FILES['comentario'];
    $enviar = $_POST['enviar'];

    if($enviar=="Enviar"){
        //validaciones
        $repintar = false;
        include("cabecera.html");
        $formulario .="<form action='repintarform.php' method='POST' ENCTYPE='multipart/form-data'>
        Edad:  <input type='text' name='edad' value='".$edad."'><br>";
        if(empty($edad)) $formulario .= "<p>error en la edad</p><br>";
        $formulario .="<br>";

        if($sexo=="Mujer") $formulario.="<input type='radio' name='sexo' value='Mujer' checked> Mujer";
        else $formulario.="<input type='radio' name='sexo' value='Mujer'> Mujer";
        if($sexo=="Hombre") $formulario.="<input type='radio' name='sexo' value='Hombre' checked> Hombre";
        else $formulario.="<input type='radio' name='sexo' value='Hombre'> Hombre";
        if(empty($sexo)) $formulario .= "<p>error en la sexo</p><br>";
        $formulario .="<br>";
        

        $formulario .= "Contraseña: <INPUT type='password' name='clave'>";
        if(empty($clave)) $formulario .= "<p>error en la contraseña</p><br>";
        $formulario .="<br>";

        $formulario .= "<SELECT NAME='color'>
            <OPTION value='rojo'>Rojo</OPTION>
            <OPTION value='verde'>Verde</OPTION>
            <OPTION value='azul'>Azul</OPTION>
        </SELECT> <br>"; 
        if(empty($color)) $formulario .= "<p>error en la en el color</p><br>";
        $formulario .="<br>";


        $array_idiomas = array('ingles','frances','aleman','holandes');
        $formulario .= "<SELECT MULTIPLE SIZE='3' NAME='idiomas[]'>";
        if($idiomas===null){
            $formulario .="<option value='ingles'>Inglés</option>
           <option value='frances'>Francés</option>
           <option value='aleman'>Alemán</option>
           <option value='holandes'>Holandés</option>
           </select>";
           $formulario .= "<p>error en los idiomas</p><br>";
        }else{
            foreach($idiomas as $idioma){
                $formulario .= "<OPTION value='".$idioma."' selected>".$idioma."</option>";
            }
    
            foreach($array_idiomas as $idioma_buscar){
                if(array_search($idioma_buscar,$idiomas)===false){
                    $formulario .= "<option value='".$idioma_buscar."'>".$idioma_buscar."</option>";
                }       
            }
        }

        $formulario .="<br>";

        $extras_todos = array('garaje','piscina','jardin');
        if($extras===null){
            $formulario .="<input TYPE='checkbox' NAME='extras[]' value='garaje' >Garaje
            <input TYPE='checkbox' NAME='extras[]' value='piscina'>Piscina
            <input TYPE='checkbox' NAME='extras[]' value='jardin'>Jardín";
            $formulario .= "<p>error en los extras</p><br>";
        }else{
            foreach($extras as $extra){
                $formulario .= "<input type='checkbox' name='extras[]' value='".$extra."' checked> $extra";
            }
            foreach($extras_todos as $extras_buscar){
                if(array_search($extras_buscar,$extras)===false){
                    $formulario .= "<input type='checkbox' name='extras[]' value='".$extras_buscar."'> $extra";
                }            
            }
        }

        echo "hola";
        $formulario.="<TEXTAREA COLS='50' ROWS='4' NAME='comentario' value = '".$comentario."'> 
        </TEXTAREA>";
        if(empty($comentario)) $formulario .= "<p>error en en comentario</p><br>";
        
        //validar fichero
        /*
        $_FILES['imagen']['name']
        $_FILES['imagen']['type']
        $_FILES['imagen']['size']
        $_FILES['imagen']['tmp_name']
        $_FILES['imagen']['error']
        */
        $formulario .= "<input TYPE='file' NAME='fichero'>";
        if($fichero['type'] != "application/pdf" || empty($fichero)){
            $formulario .= "<p>error en los fichero</p><br>";
        }
    }
    echo $formulario
    //repintar o mensaje de correcto o redirigir (include)
?>

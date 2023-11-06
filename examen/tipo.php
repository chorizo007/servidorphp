<?php
    //tipo de ejercicio
    if(!empty($_POST['pricipal'])){
        $eleccion = $_POST['opcion'];
        $formulario="<form action='validarform.php' method='post' ENCTYPE='multipart/form-data'>
        <label>matricula :</label>
        <input type='text' name='matricula'>";
        if($eleccion=="vehiculosEMT"){
            $formulario .=   "<label>calle :</label>
                            <input type='text' name='calle'>";
        }else if($eleccion=="taxis"){
            $formulario .=   "<label>nombre del propietario :</label>
                            <input type='text' name='propietario'>";
        }
        else if($eleccion=="servicios"){
            $formulario .=   "<label>tipo de vehiculo :</label>
                            <input type='text' name='tipo_vehiculo'>";
        }
        else if($eleccion=="residentesYHoteles"){
            $formulario .=   "<label>direccion :</label>
                            <input type='text' name='direccion'>
                            <label>fechaInicio :</label>
                            <input type='text' name='fechaInicio'>
                            <label>fechafinal :</label>
                            <input type='text' name='fechafinal'>";
        }
        else if($eleccion=="logistica"){
            $formulario .=   "<label>empresa de abastecimiento :</label>
                            <input type='text' name='empresa'>"; 
        }
        else{
            echo "error ";
        }
        $formulario.="<label>certificado :</label><INPUT TYPE='file' NAME='certificado'>
        <button type='submit' name = 'pricipal' value ='pricipal'>enviar</button>
        </form>";
        echo $formulario;
    }
    else{
        echo "error ";
    }

?>
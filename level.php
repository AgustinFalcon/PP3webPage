<?php

if($_POST['level-form'] == 'add'){
    $name = $_POST['name'];

    try{
        include_once "config/db.php";
        $stmt = $conn -> prepare ("INSERT INTO level (level_name) VALUES (?);");
        $stmt -> bind_param('s', $name);
        $stmt -> execute();
        
        $id_insertado = $stmt -> insert_id;
        $errno = $stmt -> errno;

        if($stmt -> affected_rows && $errno === 0){
            $respuesta = array(
                'respuesta' => 'existoso',
                'id' => $id_insertado 
            );
        } elseif($errno === 1406){
            $respuesta = array(
                'respuesta' => 'exitoso',
                'errno' => $errno,
                'errno' => $stmt -> error
            );
        } elseif($errno === 1062){
            $respuesta = array(
                'respuesta' => 'exitoso',
                'errno' => $errno,
                'errno' => $stmt -> error
            );
        }

        $stmt -> close();
        $conn -> close();

    } catch (Exception $e){
        echo "Error: " . $e -> getMessage();
    }

    die(json_encode($respuesta));

}


?>
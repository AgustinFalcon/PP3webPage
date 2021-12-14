<?php

if($_POST['matter-form'] == 'add'){
    $name = $_POST['name'];
    $id_nivelacion = $_POST['nivelacion'];
    try{
        include_once 'config/db.php';
        $stmt = $conn->prepare("INSERT INTO matters (matter_name) VALUES (?)");
        $stmt->bind_param('s', $name);
        $stmt->execute();

        $id_insertado = $stmt->insert_id;
        $errno = $stmt->errno;

        $stmt = $conn->prepare("INSERT INTO nivelacion_and_matter (nivelacion_id_nivelacion, matters_id_matters) VALUES (?, ?)");
        $stmt->bind_param('ii', $id_nivelacion, $id_insertado);
        $stmt->execute();

        if($stmt->affected_rows && $errno === 0){
            $respuesta = array(
                'respuesta' => 'exitoso',
                'id' => $id_insertado
            );
        } elseif($errno === 1406) {
            $respuesta = array(
                'respuesta' => 'error',
                'errno' => $errno,
                'error' => $stmt->error,
            );
        } elseif($errno === 1062) {
            $respuesta = array(
                'respuesta' => 'error',
                'errno' => $errno,
                'error' => $stmt->error,
            );
        }
        $stmt->close();
        $conn->close();




    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
    die(json_encode($respuesta));
}

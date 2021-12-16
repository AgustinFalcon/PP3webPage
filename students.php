<?php

if($_POST['student-form'] == 'add'){
    $name = $_POST['name'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $dni = $_POST['dni'];
    $pass = $_POST['pass'];
    $nivelacion = $_POST['nivelacion'];
    $fechaCreate = date('Y-m-d H:i:s');
    $fechaUdate = date('Y-m-d H:i:s');
    $role = $_POST['role'];
    $telefono = $_POST['telefono'];
    


    // if(!is_dir($directorio)){
    //     mkdir($directorio, 0755, true);
    // }
    // if ($_FILES['avatar']['type']=='image/png') {
    //     $ext='.png';
    // } elseif ($_FILES['avatar']['type']=='image/jpeg') {
    //     $ext='.jpeg';
    // } elseif ($_FILES['avatar']['type']=='image/gif') {
    //     $ext='.gif';
    // }
    // if(move_uploaded_file($_FILES['avatar']['tmp_name'], $directorio . $name . $ext)) {
    //     $avatar_url = $name.$ext;
    //     $programa_resultado = "Se subió correctamente";
    // } else {
    //     $respuesta = array(
    //         'respuesta' => error_get_last()
    //     );
    // }

    $password = password_hash($pass, PASSWORD_DEFAULT, ['cost' => 12]);


    try{
        include_once 'config/db.php';
        $stmt = $conn->prepare("INSERT INTO user (user_name, lastname, user_dni, user_email, user_pass, create_time, update_time, roles_id_roles) VALUES (?, ?, ?, ?, ?, ?, ?, ?);");
        $stmt->bind_param('ssissssi', $name, $lastname, $dni, $email, $password, $fechaCreate, $fechaUdate, $role);
        $stmt->execute();

        $id_insertado = $stmt->insert_id;
        $errno = $stmt->errno;

        $stmt = $conn->prepare("INSERT INTO students (user_id_user) VALUES (?)");
        $stmt->bind_param('i', $id_insertado);
        $stmt->execute();
        $id_student = $stmt->insert_id;
        $errno = $stmt->errno;

        $stmt = $conn->prepare("INSERT INTO student_and_nivelacion (students_id_student, nivelacion_id_nivelacion) VALUES (?,?)");
        $stmt->bind_param('ii', $id_student, $nivelacion);
        $stmt->execute();
        /*
        foreach($matters as $matter) {
             $stmt = $conn->prepare("INSERT INTO student_and_matter (matters_id_matters, students_id_student) VALUES (?, ?)");
             $stmt->bind_param('ii', $matter, $id_student);
             $stmt->execute();
        }*/

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
    //die(json_encode($respuesta));
}

/* elseif ($_POST['student-form'] == 'edit') {
    $id_user = $_POST['id_user'];
    $name = $_POST['name'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $dni = $_POST['dni'];
    $fechaupdate = date('Y-m-d H:i:s');
    $telefono = $_POST['telefono'];

    //die(var_dump($_FILES['avatar']));

     if (!empty($_FILES['avatar']['name'])) {
        if ($_FILES['avatar']['type']=='image/png') {
            $ext='.png';
        } elseif ($_FILES['avatar']['type']=='image/jpeg') {
            $ext='.jpeg';
        } elseif ($_FILES['avatar']['type']=='image/gif') {
            $ext='.gif';
        } 
        

        if(!is_dir($directorio)){
            mkdir($directorio, 0755, true);
        }
        unlink("$directorio$name$ext");
        if(move_uploaded_file($_FILES['avatar']['tmp_name'], $directorio . $name . $ext)) {
            $avatar_url = $name.$ext;
            $programa_resultado = "Se subió correctamente";
        } else {
            $respuesta = array(
                'respuesta' => error_get_last()
            );
        }
        try{
            include_once 'config/db.php';
            $stmt = $conn->prepare("UPDATE users SET avatar = ? WHERE id_users = ?;");
            $stmt->bind_param('si', $avatar_url, $id_user);
            $stmt->execute();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
     
    

    if (!empty($_POST['pass'])) {
        $pass = $_POST['pass'];
        $password = password_hash($pass, PASSWORD_DEFAULT, ['cost' => 12]);
        //die(var_dump($password, $id_user));
        try{
            include_once 'config/db.php';
            $stmt = $conn->prepare("UPDATE user SET pass = ? WHERE id_user = ?;");
            $stmt->bind_param('si', $password, $id_user);
            $stmt->execute();
            $errno = $stmt->errno;
            $error = $stmt->error;

        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    try{
        include_once 'config/db.php';
        $stmt = $conn->prepare("UPDATE user SET user_name = ?, user_lastname = ?, user_dni = ?, user_email = ?, update_time = ? WHERE id_user = ?;");
        $stmt->bind_param('ssissi', $name, $lastname, $dni, $email, $fechaupdate, $id_user);
        $stmt->execute();

        $errno = $stmt->errno;

        if($stmt->affected_rows && $errno === 0){
            $respuesta = array(
                'respuesta' => 'exitoso'
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
} if ($_POST['student-form'] == 'delete') {
    $id_user = $_POST['id'];

    try {
        include_once 'config/db.php';
        $stmt = $conn->prepare('DELETE FROM user WHERE id_user = ? ');
        $stmt->bind_param('i', $id_user);
        $stmt->execute();
        if($stmt->affected_rows) {
            $respuesta = array(
                'respuesta' => 'exito',
                'id_eliminado' => $id_user
            );
        } else {
            $respuesta = array(
                'respuesta' => 'error'
            );
        }
    } catch (Exception $e) {
        $respuesta = array(
            'respuesta' => $e->getMessage()
        );
    }
    die(json_encode($respuesta));
}*/

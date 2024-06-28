<?php

include("../config.php");


// =========== Crear o Editar =========== //
if(!empty($_POST['action']) && $_POST['action'] == 'sendData') {

    $form_data = json_decode($_POST['form_data'], true);
    $carreras = json_decode($_POST['carreras'], true);
    $id = $form_data[0]['value'];
    $fecha_publicacion = $form_data[1]['value'];
    $descripcion = $form_data[2]['value'];
    $fecha_evento = $form_data[3]['value'];
    if ($form_data[4]['value'] !== '') {
        $image = $form_data[4]['value'];
    } else {
        $image = 0;
    }
    
    $usuario = 6;

    if ($_POST['type'] == 'Crear') {

        $sql = "INSERT INTO publicaciones (publicaciones_id, pub_descripcion, pub_image, pub_fecha_evento, usuarios_id) VALUES (?,  ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([ $id, $descripcion, $image, $fecha_evento, $usuario ]);

        for ($i=0; $i < count($carreras); $i++) { 
            $sql = "INSERT INTO publicaciones_carreras (publicaciones_id, carreras_id) VALUES (?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([ $id, $carreras[$i][0] ]);

            $sql = "SELECT publicaciones_carreras_id FROM publicaciones_carreras ORDER BY publicaciones_carreras_id DESC LIMIT 1";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $last_publicaciones_carreras_id = $stmt->fetchAll(PDO::FETCH_ASSOC)[0]['publicaciones_carreras_id'];

            for ($x=0; $x < count($carreras[$i][1]); $x++) { 
                $sql = "INSERT INTO publicaciones_carreras_anios (publicaciones_carreras_id, pubcarani_anio, publicaciones_id) VALUES (?,?,?)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([ $last_publicaciones_carreras_id, $carreras[$i][1][$x][0], $id ]);
            }
        }

        die("Publicado correctamente!");


    } else if ($_POST['type'] == 'Editar') {

        delete_publicacion_data($id, $conn);

        $sql = "INSERT INTO publicaciones (publicaciones_id, pub_descripcion, pub_image, pub_fecha_evento, pub_fecha_publicacion, usuarios_id) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([ $id, $descripcion, $image, $fecha_evento, $fecha_publicacion, $usuario ]);

        for ($i=0; $i < count($carreras); $i++) { 
            $sql = "INSERT INTO publicaciones_carreras (publicaciones_id, carreras_id) VALUES (?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([ $id, $carreras[$i][0] ]);

            $sql = "SELECT publicaciones_carreras_id FROM publicaciones_carreras ORDER BY publicaciones_carreras_id DESC LIMIT 1";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $last_publicaciones_carreras_id = $stmt->fetchAll(PDO::FETCH_ASSOC)[0]['publicaciones_carreras_id'];

            for ($x=0; $x < count($carreras[$i][1]); $x++) { 
                $sql = "INSERT INTO publicaciones_carreras_anios (publicaciones_carreras_id, pubcarani_anio, publicaciones_id) VALUES (?,?,?)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([ $last_publicaciones_carreras_id, $carreras[$i][1][$x][0], $id ]);
            }
        }

        die("Editado correctamente!");
    }

}


// =========== Cargar 1 solo registro =========== //
if(!empty($_POST['action']) && $_POST['action'] == 'callData') {

    $sql = "SELECT * FROM publicaciones WHERE publicaciones_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$_POST['id']]);
    $publicaciones = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];

    $sql = "SELECT P.*, C.car_duracion, C.car_nombre FROM publicaciones_carreras P
        LEFT JOIN carreras C
        ON P.carreras_id = C.carreras_id
        WHERE P.publicaciones_id = ?
    ";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$_POST['id']]);
    $publicaciones_carreras = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sql = "SELECT * FROM publicaciones_carreras_anios WHERE publicaciones_id = ? ORDER BY pubcarani_anio ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$_POST['id']]);
    $publicaciones_carreras_anios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sql = "SELECT * FROM carreras WHERE car_activo = 'A'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $listcar = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([$publicaciones, $publicaciones_carreras, $publicaciones_carreras_anios, $listcar]);
}


// =========== Cargar 1 para modal de eliminación =========== //
if(!empty($_POST['action']) && $_POST['action'] == 'callDataToDelete') {

    $sql = "SELECT * FROM publicaciones WHERE publicaciones_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$_POST['id']]);
    $publicaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($publicaciones);
}


// =========== Cargar lista de registros =========== //
if(!empty($_POST['action']) && $_POST['action'] == 'loadData') {
    $sql = "SELECT * FROM publicaciones ORDER BY publicaciones_id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($data);
}


// =========== Llamar última id utilizada =========== //
if(!empty($_POST['action']) && $_POST['action'] == 'callLastID') {
    $sql = "SELECT publicaciones_id FROM publicaciones ORDER BY publicaciones_id DESC LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (empty($data)) {
        $data[0]['publicaciones_id'] = 0;
    }
    echo json_encode($data);
}


// =========== Eliminar registro =========== //
if(!empty($_POST['action']) && $_POST['action'] == 'deleteData') {
    delete_publicacion_data($_POST['id'], $conn);
    die("La publicación ha sido eliminada correctamente!");
}


// =========== Eliminar registro de todas las tablas =========== //
function delete_publicacion_data($publicacion_id, $conn){
    $sql = "DELETE FROM publicaciones WHERE publicaciones_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$publicacion_id]);

    $sql = "DELETE FROM publicaciones_carreras WHERE publicaciones_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$publicacion_id]);

    $sql = "DELETE FROM publicaciones_carreras_anios WHERE publicaciones_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$publicacion_id]);
}


// =========== Cargar lista de carreras =========== //
if(!empty($_POST['action']) && $_POST['action'] == 'loadCarreraSelection') {
    $sql = "SELECT * FROM carreras WHERE car_activo = 'A'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($data);
}


// =========== Cargar lista de años =========== //
if(!empty($_POST['action']) && $_POST['action'] == 'loadCarreraAnio') {
    $sql = "SELECT * FROM carreras WHERE carreras_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$_POST['id']]);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC)[0]['car_duracion'];
    echo json_encode($data);
}


// =========== Subir imagen =========== //
if( isset($_FILES['pdf_documents']) ) { 

    $file_path = $_FILES['pdf_documents']['tmp_name'][0];
    $file_name = '../../images/'.$_FILES['pdf_documents']['name'][0];
    move_uploaded_file($file_path, $file_name);
    $file_image = $_FILES['pdf_documents']['name'][0];
    
    $sql = "UPDATE publicaciones SET pub_image = ? WHERE publicaciones_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([ $file_image, $_POST['id'] ]);

    echo true;
}


?>
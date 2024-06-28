<?php

include("../config.php");


// =========== Crear o Editar =========== //
if(!empty($_POST['action']) && $_POST['action'] == 'sendData') {

    $form_data = json_decode($_POST['form_data'], true);
    $carrera = $form_data[0]['value'];
    $duracion = $form_data[1]['value'];
    $type = $form_data[2]['value'];
    $status = $form_data[3]['value'];
    $id = $form_data[4]['value'];

    if ($_POST['type'] == 'Crear') {
        $sql = "INSERT INTO carreras (car_nombre, car_duracion, car_tipo, car_activo) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([ $carrera, $duracion, $type, $status ]);
        die("La carrera ha sido creada correctamente!");

    } else if ($_POST['type'] == 'Editar') {
        $sql = "UPDATE carreras SET car_nombre = ?, car_duracion = ?, car_tipo = ?, car_activo = ? WHERE carreras_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([ $carrera, $duracion, $type, $status, $id ]);
        die("La carrera ha sido editada correctamente!");
    }

}


// =========== Cargar lista de registros =========== //
if(!empty($_POST['action']) && $_POST['action'] == 'loadData') {
    $sql = "SELECT * FROM carreras ORDER BY carreras_id ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($data);
}


// =========== Cargar 1 solo registro =========== //
if(!empty($_POST['action']) && $_POST['action'] == 'callData') {
    $sql = "SELECT * FROM carreras WHERE carreras_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$_POST['id']]);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
    echo json_encode($data);
}


// =========== Eliminar registro =========== //
if(!empty($_POST['action']) && $_POST['action'] == 'deleteData') {
    $sql = "DELETE FROM carreras WHERE carreras_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$_POST['id']]);
    die("La carrera ha sido eliminada correctamente!");
}

?>
<?php

include("../config.php");


// =========== Crear o Editar =========== //
if(!empty($_POST['action']) && $_POST['action'] == 'sendData') {

    $form_data = json_decode($_POST['form_data'], true);
    $usuario = $form_data[0]['value'];
    $password = $form_data[1]['value'];
    $type = $form_data[2]['value'];
    $status = $form_data[3]['value'];
    $id = $form_data[4]['value'];

    if ($_POST['type'] == 'Crear') {
        $sql = "INSERT INTO usuarios (usu_nombre, usu_contraseña, usu_tipo, usu_activo) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([ $usuario, $password, $type, $status ]);
        die("El usuario ha sido creado correctamente!");

    } else if ($_POST['type'] == 'Editar') {
        $sql = "UPDATE usuarios SET usu_nombre = ?, usu_contraseña = ?, usu_tipo = ?, usu_activo = ? WHERE usuarios_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([ $usuario, $password, $type, $status, $id ]);
        die("El usuario ha sido editado correctamente!");
    }

}


// =========== Cargar lista de registros =========== //
if(!empty($_POST['action']) && $_POST['action'] == 'loadData') {
    $sql = "SELECT * FROM usuarios ORDER BY usuarios_id ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($data);
}


// =========== Cargar 1 solo registro =========== //
if(!empty($_POST['action']) && $_POST['action'] == 'callData') {
    $sql = "SELECT * FROM usuarios WHERE usuarios_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$_POST['id']]);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
    echo json_encode($data);
}


// =========== Eliminar registro =========== //
if(!empty($_POST['action']) && $_POST['action'] == 'deleteData') {
    $sql = "DELETE FROM usuarios WHERE usuarios_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$_POST['id']]);
    die("El usuario ha sido eliminado correctamente!");
}

?>
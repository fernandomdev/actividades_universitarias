<?php

include("../admin/config.php");


// registrar usuario
if(!empty($_POST['action']) && $_POST['action'] == 'register') {

    $form_data = json_decode($_POST['form_data'], true);
    $l_usuario = $form_data[1]['value'];
    $l_password = $form_data[2]['value'];
    
    $r_usuario = $form_data[3]['value'];
    $r_password = $form_data[4]['value'];
    $r_cpassword = $form_data[5]['value'];
    $r_carrera = $form_data[6]['value'];

    $sql = "SELECT * FROM usuarios WHERE usu_nombre = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$r_usuario]);
    $usuario = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($usuario)) {
        echo json_encode(['alert', 'El usuario ya existe']);
        die();
    }

    $sql = "INSERT INTO usuarios (usu_nombre, usu_contraseña, usu_tipo, usu_activo) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([ $r_usuario, $r_password, $r_carrera, 'A' ]);

    $_SESSION['usu_nombre'] = $r_usuario;
    $_SESSION['usu_tipo'] = $r_carrera;
    $_SESSION['usuarios_id'] = null;
    

    echo json_encode(['success', true]);
    die();
    
}


// acceder como usuario ya registrado
if(!empty($_POST['action']) && $_POST['action'] == 'login') {

    $form_data = json_decode($_POST['form_data'], true);
    $l_usuario = $form_data[1]['value'];
    $l_password = $form_data[2]['value'];
    
    $r_usuario = $form_data[3]['value'];
    $r_password = $form_data[4]['value'];
    $r_cpassword = $form_data[5]['value'];
    $r_carrera = $form_data[6]['value'];

    $sql = "SELECT * FROM usuarios WHERE usu_nombre = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$l_usuario]);
    $usuario = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($usuario)) {
        echo json_encode(['alert', 'El usuario no existe']);
        die();
    }

    if ($l_password !== $usuario[0]['usu_contraseña']) {
        echo json_encode(['alert', 'Contraseña incorrecta']);
        die();
    }

    if ($l_password == $usuario[0]['usu_contraseña'] && $l_usuario == $usuario[0]['usu_nombre']) {

        $_SESSION['usu_nombre'] = $l_usuario;
        $_SESSION['usu_tipo'] = $usuario[0]['usu_tipo'];
        $_SESSION['usuarios_id'] = $usuario[0]['usuarios_id'];
        
        echo json_encode(['success', true]);
        die();
    }
    
}

?>
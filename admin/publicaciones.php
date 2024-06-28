<?php 
include('config.php');

// comprobar que es administrador
if (($_SESSION['usu_tipo'] != 9999)) {
    header('Location: ../acceder.php');
}

// css y titulo de la página
$css1 = "admin.css";
$title = "Publicaciones | Panel de Control";
// llamar al archivo de vista (todo lo que ve el usuario)
include('views/publicaciones.view.php');
?>
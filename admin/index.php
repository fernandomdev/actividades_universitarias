<?php 
// en caso de crear un index para admin, está disponible este archivo 
include('config.php');

// comprobar que es administrador
if (($_SESSION['usu_tipo'] != 9999)) {
    header('Location: ../acceder.php');
}
// redirecciona a la pestaña de publicaciones del panel de admin
header('Location: publicaciones.php');

// css y titulo de la página
$css1 = "admin.css";
$title = "Inicio | Panel de Control";
// llamar al archivo de vista (todo lo que ve el usuario)
include('views/index.view.php');
?>
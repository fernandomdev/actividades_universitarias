<?php 
// llamado al archivo de configuración general
include('admin/config.php');

// para el listado de carreras
$sql = "SELECT * FROM carreras WHERE car_activo = 'A'";
$stmt = $conn->prepare($sql);
$stmt->execute();
$carreras = $stmt->fetchAll(PDO::FETCH_ASSOC);

// estilo custom y titulo custom de la página
$css1 = "acceder.css";
$title = "Acceder";

// conexión con la vista
include('views/acceder.view.php');
?>
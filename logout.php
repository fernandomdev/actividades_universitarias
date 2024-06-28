<?php 
// archivo al que se accede cuando se quiere cerrar la sesión
include('admin/config.php');
session_unset();
header('Location: acceder.php');

<!-- aqui se almacenan las conexiones con librerias externas, así como también estilos (css), fuentes de letra y el titulo de la página en una variable -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- titulo de la página -->
    <title><?php echo $title ?></title>

    <!-- estilos custom -->
    <?php 
        if (isset($css1)) {
            echo '<link rel="stylesheet" href="'.RUTA.'/css/'.$css1.'">';
        }
        if (isset($css2)) {
            echo '<link rel="stylesheet" href="'.RUTA.'/css/'.$css2.'">';
        }
    ?>

    <!-- estilos -->
    <link rel="shortcut icon" href="<?php echo RUTA ?>/media/icono.png" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo RUTA ?>/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

    <!-- librerias js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="<?php echo RUTA ?>/ajax/functions.js"></script>

</head>
<body>
    <!-- alert() custom -->
    <div class='customAlert'>
        <p class='message'></p>
        <input type='button' class='confirmButton' value='Ok'>
    </div>
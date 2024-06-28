<!-- toda la vista de la página principal (lo que ve el usuario) -->
<?php include('views/header.php') ?>

<main>

    <nav>
        <div class="nav_container">

            <?php if($_SESSION['usu_tipo'] == 9999) { ?>
                <a href="<?php echo RUTA ?>/admin/index.php">
                    <i class="fa-solid fa-bars-progress"></i>
                </a>
            <?php } else { ?>
                <a href="<?php echo RUTA ?>/notifications.php">
                    <span><i class="fa-regular fa-bell"></i></span>
                </a>
            <?php } ?>

            <a href="<?php echo RUTA ?>">
                <span class="page_title">AmeriEventos</span>
            </a>

            <a href="<?php echo RUTA ?>/logout.php">
                <i class="fa-solid fa-right-from-bracket"></i>
            </a>

        </div>
    </nav>

    <div id="filter_container">
        <?php 
            foreach ($carreras as $key) {
                if (isset($_GET['carrera']) && $key['carreras_id'] == $_GET['carrera']) {
                    echo '<a href="'.RUTA.'" class="active">'.$key['car_nombre'].'</a>';
                } else {
                    // if ($key['carreras_id'] == $_SESSION['usu_tipo']) {
                    //     echo '<a href="'.RUTA.'/index.php?carrera='.$key['carreras_id'].'" class="active">'.$key['car_nombre'].'</a>';
                    // } else {
                        echo '<a href="'.RUTA.'/index.php?carrera='.$key['carreras_id'].'">'.$key['car_nombre'].'</a>';
                    // }
                    
                }
            }
        ?>
    </div>
    
    <div id="post_container">
        <?php 
            foreach ($data as $key) {
                echo '
                    <div class="post">
                        <div class="post_img">
                            <img src="'.RUTA.'/images/'.$key['pub_image'].'" alt="">
                        </div>
                        <div class="post_txt">
                            <p>'.$key['pub_descripcion'].'</p>
                        </div>
                        <div class="post_footer">
                            <div class="post_user">
                                <div class="post_user_image">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                                <div class="post_user_info">
                                    <b>'.$key['usu_nombre'].'</b>
                                    <span>'.$key['pub_fecha_publicacion'].'</span>
                                </div>
                            </div>
                            <div class="post_buttons">
                                <div class="post_button share" data-link="'.RUTA.'/publicacion.php?id='.$key['publicaciones_id'].'">
                                    <a>Compartir</a>
                                    <i class="fa-regular fa-share-from-square"></i>
                                </div>
                                <div class="post_button assist" data-id="'.$key['publicaciones_id'].'">
                                    <button>Asistiré</button>
                                    <i class="fa-regular fa-heart"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                ';
            }
        ?>
    </div>

    <?php if(count($data) > 0){
        echo '<span id="end">Llegaste al final :)</span>';
    } else {
        echo '<span id="end">No se encontraron publicaciones :(</span>';
    }
    ?>
    

</main>
<!-- conexion con el js -->
<script src="<?php echo RUTA ?>/ajax/index.ajax.js"></script>
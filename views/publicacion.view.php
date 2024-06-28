<!-- toda la vista de una publicación única (lo que ve el usuario) -->
<?php include('views/header.php') ?>

<main>

    <nav>
        <div class="nav_container">
            <a href="<?php echo RUTA ?>/login.php">
                <span><i class="fa-solid fa-right-to-bracket"></i></span>
            </a>
            <a href="<?php echo RUTA ?>">
                <span class="page_title">AmeriEventos</span>
            </a>
            <a href="<?php echo RUTA ?>/notifications.php">
                <span><i class="fa-regular fa-bell"></i></span>
            </a>
        </div>
    </nav>
    
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
                                    <!-- <i class="fa-solid fa-heart"></i> -->
                                </div>
                            </div>
                        </div>
                    </div>
                ';
            }
        ?>
    </div>

    <?php if(!isset($_GET['id'])) :?>
        <span id="end">Llegaste al final :)</span>
    <?php endif ?>

</main>
<!-- conexion con el js -->
<script src="<?php echo RUTA ?>/ajax/index.ajax.js"></script>
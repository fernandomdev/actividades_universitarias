<!-- todo lo visual (html) de las publicaciones -->
<?php include('../views/header.php') ?>


<!-- al dar click derecho a la tabla, se muestra este menú de acciones -->
<div id="context-menu" style="display:none">
    <button data-modal-trigger="main_form" data-modal-type="Editar">
        <i class="fa-solid fa-pen-to-square"></i>
        <span>Editar</span>
    </button>
    <button data-modal-trigger="delele_form">
        <i class="fa-solid fa-pen-to-square"></i>
        <span>Eliminar</span>
    </button>
</div>


<!-- tabla de contenidos -->
<main>
    <?php include('views/admin_sidebar.php') ?>

    <div id="content">

        <div id="title_container">
            <h4>Publicaciones</h4>
            <button class="button_success" data-modal-trigger="main_form" data-modal-type="Crear">Crear</button>
        </div>
        <div id="table_container">
            <table>
                <thead>
                    <tr>
                        <th style="width:64px">ID</th>
                        <th>Titulo</th>
                        <th>Publicación</th>
                        <th>Fecha del Evento</th>
                        <th>Link</th>
                    </tr>
                </thead>
                <tbody id="main_table"></tbody>
            </table>
        </div>
    </div>
</main>


<!-- formulario de creación o edición de registro -->
<div class="modal" data-modal-name="main_form" style="display:none">
    <div class="modal_bg"></div>
    <div class="modal_container">

        <div class="modal_title">
            <h4>Publicaciones</h4>
            <button data-modal-trigger="main_form"><i class="fa-solid fa-x"></i></button>
        </div>

        <div class="modal_form">
            <form>
                <input type="hidden" name="id">
                <input type="hidden" name="fecha_publicacion">
                <div class="form_item">
                    <span>Titulo</span>
                    <input type="text" name="titulo" placeholder="Favor ingrese un titulo" autocomplete="off">
                </div>
                <div class="form_item">
                    <span>Fecha del Evento</span>
                    <input type="date" name="fecha_evento">
                </div>
                <input type="hidden" name="tmp_edit_image">
                <div class="form_item" id="form_img_container">
                    <div class="drop-zone">
                        <span class="drop-zone__prompt">Arrastre su publicación aquí</span>
                        <input type="file" name="imagen" class="drop-zone__input" id="drop-zone__input">
                    </div>
                </div>
                <div class="form_item">
                    <span>Carrera</span>
                    <div class="carrera_container"></div>
                </div>
            </form>
        </div>

        <div class="modal_buttons">
            <button data-modal-trigger="main_form" class="cancel">
                <span>Cancelar</span>
            </button>
            <button class="success">
                <span>Crear</span>
            </button>
        </div>
        
    </div>
</div>


<!-- formulario de eliminación de registro -->
<div class="modal" data-modal-name="delele_form" style="display:none">
    <div class="modal_bg"></div>
    <div class="modal_container">

        <div class="modal_title">
            <h4>Publicaciones</h4>
            <button data-modal-trigger="delele_form"><i class="fa-solid fa-x"></i></button>
        </div>

        <div class="modal_text">
            <span></span>
        </div>

        <div class="modal_buttons">
            <button data-modal-trigger="delele_form" class="cancel">
                <span>Cancelar</span>
            </button>
            <button data-modal-trigger="delele_form" class="success">
                <span>Eliminar</span>
            </button>
        </div>
        
    </div>
</div>

<?php include('../views/footer.php') ?>
<script src="<?php echo RUTA ?>/admin/ajax/publicaciones.ajax.js"></script>
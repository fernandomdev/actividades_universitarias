<!-- todo lo visual (html) de las carreras -->
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
            <h4>Carreras</h4>
            <button class="button_success" data-modal-trigger="main_form" data-modal-type="Crear">Crear</button>
        </div>
        <div id="table_container">
            <table>
                <thead>
                    <tr>
                        <th style="width:64px">#</th>
                        <th>Carrera</th>
                        <th>Duración</th>
                        <th>Tipo</th>
                        <th style="width:120px">Activo</th>
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
            <h4>Carreras</h4>
            <button data-modal-trigger="main_form"><i class="fa-solid fa-x"></i></button>
        </div>

        <div class="modal_form">
            <form>
                <div class="form_item">
                    <span>Carrera</span>
                    <input type="text" name="carrera" placeholder="Favor ingrese el nombre de la carrera" autocomplete="off">
                </div>
                <div class="form_item">
                    <span>Duración (años)</span>
                    <input type="number" name="duracion" placeholder="Favor ingrese una duración" autocomplete="off">
                </div>
                <div class="form_item">
                    <span>Tipo de Carrera</span>
                    <select name="type">
                        <option value="G">Grado</option>
                        <option value="P">Postgrado</option>
                    </select>
                </div>
                <div class="form_item">
                    <span>Estado</span>
                    <select name="status">
                        <option value="A">Activo</option>
                        <option value="I">Inactivo</option>
                    </select>
                </div>
                <input type="hidden" name="id">
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
            <h4>Carreras</h4>
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
<script src="<?php echo RUTA ?>/admin/ajax/carreras.ajax.js"></script>
<!-- todo lo visual (html) de los usuarios -->
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
            <h4>Usuarios</h4>
            <button class="button_success" data-modal-trigger="main_form" data-modal-type="Crear">Crear</button>
        </div>
        <div id="table_container">
            <table>
                <thead>
                    <tr>
                        <th style="width:64px">ID</th>
                        <th>Nombre</th>
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
            <h4>Usuarios</h4>
            <button data-modal-trigger="main_form"><i class="fa-solid fa-x"></i></button>
        </div>

        <div class="modal_form">
            <form>
                <div class="form_item">
                    <span>Usuario</span>
                    <input type="text" name="usuario" placeholder="Favor ingrese un texto" autocomplete="off">
                </div>
                <div class="form_item">
                    <span>Contraseña</span>
                    <input type="text" name="password" placeholder="Favor ingrese un texto" autocomplete="off">
                </div>
                <div class="form_item">
                    <span>Tipo de Usuario</span>
                    <input type="text" name="password" placeholder="Ingrese 9999 para fijar como administrador" autocomplete="off">
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
            <h4>Usuarios</h4>
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
<script src="<?php echo RUTA ?>/admin/ajax/usuarios.ajax.js"></script>
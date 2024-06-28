<!-- toda la vista del login y register (lo que ve el usuario) -->
<?php include('views/header.php') ?>

<main>
    
    <div id="title">
        <h2>Actividades Universitarias</h2>
    </div>
    <form>
        <div id="login">
            <input type="hidden" name="form_type" value="login">
            <div class="field">
                <span>Usuario</span>
                <input name="luser" type="text" placeholder="Ingrese su Usuario">
            </div>
            <div class="field">
                <span>Contraseña</span>
                <input name="lpass" type="password" placeholder="Ingrese su Contraseña">
            </div>
        </div>
        <div id="register" style="display:none">
            <div class="field">
                <span>Usuario</span>
                <input name="ruser" type="text" placeholder="Ingrese su Usuario">
            </div>
            <div class="field">
                <span>Contraseña</span>
                <input name="rpass" type="password" placeholder="Ingrese su Contraseña">
            </div>
            <div class="field">
                <span>Confirme su Contraseña</span>
                <input name="rcpass" type="password" placeholder="Ingrese su Contraseña">
            </div>
            <div class="field">
                <span>Seleccione su Carrera</span>
                <select name="rcarrera">
                    <?php foreach($carreras as $key){ 
                        echo '<option value="'.$key['carreras_id'].'">'.$key['car_nombre'].'</option>';
                    }?>
                </select>
            </div>
        </div>
        <span id="message"></span>
        <button>Iniciar Sesión</button>
        <div id="toggle">
            <span>¿No tienes una cuenta?</span>
            <button>Ingresa aquí</button>
        </div>
    </form>

</main>
<!-- conexion con el js -->
<script src="<?php echo RUTA ?>/ajax/acceder.ajax.js"></script>
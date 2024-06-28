
// Compartir publicación
$(document).on("click", "#toggle button", function(e){
    e.preventDefault();
    $('#login').toggle();
    $('#register').toggle();
    if ($("input[name='form_type']").val() == 'login') {
        $("input[name='form_type']").val('register');
        $("#toggle span").html('Ya tienes una cuenta?');
        $("form > button").html("Registrate");
    } else {
        $("input[name='form_type']").val('login');
        $("#toggle span").html('¿No tienes una cuenta?');
        $("form > button").html("Iniciar Sesión");
    }
});
$(document).on("click", "form > button", function(e){
    e.preventDefault();
    $("#message").html('');
    let form_data = $("form").serializeArray();

    //-----------registrarse-----------
    if ($("input[name='form_type']").val() == 'register') {
        if ($("input[name='ruser']").val() == "") {
            $("#message").html('Favor ingrese un usuario para continuar');
            return false;
        }
        if ($("input[name='rpass']").val() == "") {
            $("#message").html('Favor ingrese una contraseña para continuar');
            return false;
        }
        if ($("input[name='rpass']").val() !== $("input[name='rcpass']").val()) {
            $("#message").html('Las contraseñas no coinciden');
            return false;
        }
        if ($("input[name='rpass']").val().length <= 4) {
            $("#message").html('Contraseña muy corta');
            return false;
        }
        
        $.ajax({
            type: "POST",
            url: "ajax/acceder.ajax.php",
            data: {
                action: 'register',
                form_data: JSON.stringify(form_data)
            },
            async: false,
            error: function(xhr, status, error) {
                alert(xhr.responseText);
            },
            dataType: 'json',
            success: function(response){
                console.log(response);
                if (response[0] == 'alert') {
                    $("#message").html(response[1]); // el usuario ya existe
                } else if (response[0] == 'success') {
                    alert("Cuenta registrada completamente. Ingresando...")
                    window.location.href = "http://localhost/actividades_universitarias/"; 
                }
            }
        });
    }

    //-----------login -----------
    else {
        if ($("input[name='luser']").val() == "") {
            $("#message").html('Favor ingrese su usuario para continuar');
            return false;
        }
        if ($("input[name='lpass']").val() == "") {
            $("#message").html('Favor ingrese su contraseña para continuar');
            return false;
        }
        
        $.ajax({
            type: "POST",
            url: "ajax/acceder.ajax.php",
            data: {
                action: 'login',
                form_data: JSON.stringify(form_data)
            },
            async: false,
            error: function(xhr, status, error) {
                alert(xhr.responseText);
            },
            dataType: 'json',
            success: function(response){
                console.log(response);
                if (response[0] == 'alert') {
                    $("#message").html(response[1]); // Usuario no existe - Contraseña Incorrecta
                } else if (response[0] == 'success') {
                    alert("Cuenta identificada. Ingresando...")
                    window.location.href = "http://localhost/actividades_universitarias/"; 
                }
            }
        });
    }


});
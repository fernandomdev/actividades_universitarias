
$(document).ready(function() {
    loadData();
});

// =========== Crear o Editar =========== //
$(document).on("click", "[data-modal-name='main_form'] .success", function(){

    // Validación de datos
    if ( $(".modal input[name='usuario']").val() == '' ) {
        alert('Favor ingrese el usuario para continuar');
        return false;
    }
    if ( $(".modal input[name='password']").val() == '' ) {
        alert('Favor ingrese la contraseña para continuar');
        return false;
    }

    // Envío de datos al php
    let form_data = $("[data-modal-name='main_form'] form").serializeArray();
    let type = $(this).closest('.modal').attr('data-modal-type');
    
    $.ajax({
        type: "POST",
        url: "ajax/usuarios.ajax.php",
        data: {
            action: 'sendData',
            type: type,
            form_data: JSON.stringify(form_data)
        },
        async: false,
        error: function(xhr, status, error) {
            alert(xhr.responseText);
        },
        dataType: 'text',
        success: function(response){
            loadData();
            alert(response);
        }
    });

    $("[data-modal-name='main_form'] form").trigger('reset');
    $(this).closest('.modal').hide();
})



// =========== Llamar Datos para el Formulario =========== //
$(document).on("click", "#context-menu [data-modal-type='Editar']", function(){
    let id = $(this).closest('#context-menu').attr('data-id');
    
    $.ajax({
        type: "POST",
        url: "ajax/usuarios.ajax.php",
        data: {
            action: 'callData',
            id: id
        },
        async: false,
        error: function(xhr, status, error) {
            alert(xhr.responseText);
        },
        dataType: 'json',
        success: function(response){
            $("form [name='usuario']").val(response['usu_nombre']);
            $("form [name='password']").val(response['usu_contraseña']);
            $("form [name='type']").val(response['usu_tipo']);
            $("form [name='status']").val(response['usu_activo']);
            $("form [name='id']").val(response['usuarios_id']);
        }
    });
})


// =========== Llamar datos para eliminar =========== //
$(document).on("click", "#context-menu [data-modal-trigger='delele_form']", function(){
    let id = $(this).closest('#context-menu').attr('data-id');
    $("[data-modal-name='delele_form'] .success").attr('data-id', id);
    
    $.ajax({
        type: "POST",
        url: "ajax/usuarios.ajax.php",
        data: {
            action: 'callData',
            id: id
        },
        async: false,
        error: function(xhr, status, error) {
            alert(xhr.responseText);
        },
        dataType: 'json',
        success: function(response){
            $("[data-modal-name='delele_form'] .modal_text span").html(`¿Está seguro de que desea eliminar el usuario ${response['usu_nombre']}?`);
        }
    });
})

// =========== Eliminar =========== //
$(document).on("click", "[data-modal-name='delele_form'] .success", function(){
    let id = $(this).attr('data-id');
    
    $.ajax({
        type: "POST",
        url: "ajax/usuarios.ajax.php",
        data: {
            action: 'deleteData',
            id: id
        },
        async: false,
        error: function(xhr, status, error) {
            alert(xhr.responseText);
        },
        dataType: 'json',
        success: function(response){
            alert(response);
        }
    });

    loadData();
})


// =========== Cargar los Datos para la Tabla Principal =========== //
function loadData(){
    $.ajax({
        type: "POST",
        url: "ajax/usuarios.ajax.php",
        data: {
            action: 'loadData'
        },
        async: false,
        error: function(xhr, status, error) {
            alert(xhr.responseText);
        },
        dataType: 'json',
        success: function(response){
            var data = '';
            for (var i = 0; i < response.length; i++) {
                let tipo = (response[i]['usu_tipo'] == 9999) ? 'Administrador' : 'Normal';
                let activo = (response[i]['usu_activo'] == 'A') ? 'Activo' : 'Inactivo';
                data += `
                    <tr data-id="${response[i]['usuarios_id']}">
                        <td>${response[i]['usuarios_id']}</td>
                        <td>${response[i]['usu_nombre']}</td>
                        <td>${tipo}</td>
                        <td>${activo}</td>
                    </tr>
                `;
            }
            $('#main_table').html(data);
        }
    });
}



$(document).ready(function() {
    loadData();
});

// =========== Crear o Editar =========== //
$(document).on("click", "[data-modal-name='main_form'] .success", function(){

    // Validación de datos
    if ( $(".modal input[name='carrera']").val() == '' ) {
        alert('Favor ingrese el nombre de la carrera para continuar');
        return false;
    }
    if ( $(".modal input[name='duracion']").val() == '' ) {
        alert('Favor ingrese la duración de la carrera para continuar');
        return false;
    }

    // Envío de datos al php
    let form_data = $("[data-modal-name='main_form'] form").serializeArray();
    let type = $(this).closest('.modal').attr('data-modal-type');
    
    $.ajax({
        type: "POST",
        url: "ajax/carreras.ajax.php",
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
        url: "ajax/carreras.ajax.php",
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
            $("form [name='carrera']").val(response['car_nombre']);
            $("form [name='duracion']").val(response['car_duracion']);
            $("form [name='type']").val(response['car_tipo']);
            $("form [name='status']").val(response['car_activo']);
            $("form [name='id']").val(response['carreras_id']);
        }
    });
})


// =========== Llamar datos para eliminar =========== //
$(document).on("click", "#context-menu [data-modal-trigger='delele_form']", function(){
    let id = $(this).closest('#context-menu').attr('data-id');
    $("[data-modal-name='delele_form'] .success").attr('data-id', id);
    
    $.ajax({
        type: "POST",
        url: "ajax/carreras.ajax.php",
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
            $("[data-modal-name='delele_form'] .modal_text span").html(`¿Está seguro de que desea eliminar la carrera ${response['car_nombre']}?`);
        }
    });
})

// =========== Eliminar =========== //
$(document).on("click", "[data-modal-name='delele_form'] .success", function(){
    let id = $(this).attr('data-id');
    
    $.ajax({
        type: "POST",
        url: "ajax/carreras.ajax.php",
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
        url: "ajax/carreras.ajax.php",
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
                let tipo = (response[i]['car_tipo'] == 'G') ? 'Grado' : 'Postgrado';
                let activo = (response[i]['car_activo'] == 'A') ? 'Activo' : 'Inactivo';
                data += `
                    <tr data-id="${response[i]['carreras_id']}">
                        <td>${response[i]['carreras_id']}</td>
                        <td>${response[i]['car_nombre']}</td>
                        <td>${response[i]['car_duracion']} años</td>
                        <td>${tipo}</td>
                        <td>${activo}</td>
                    </tr>
                `;
            }
            $('#main_table').html(data);
        }
    });
}


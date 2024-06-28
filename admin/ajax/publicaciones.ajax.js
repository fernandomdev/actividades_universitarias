
$(document).ready(function() {
    loadData();
    loadCarreraSelection();
});

// =========== Llamar ID a la hora de crear un registro =========== //
$(document).on("click", "#title_container .button_success", function(){
    $("#form_img_container").show();
    $.ajax({
        type: "POST",
        url: "ajax/publicaciones.ajax.php",
        data: {
            action: 'callLastID'
        },
        async: false,
        error: function(xhr, status, error) {
            alert(xhr.responseText);
        },
        dataType: 'json',
        success: function(response){
            $("form [name='id']").val(parseInt(response[0]['publicaciones_id'])+1);
        }
    });
})


// =========== Llamar Datos para el Formulario =========== //
$(document).on("click", "#context-menu [data-modal-type='Editar']", function(){
    let id = $(this).closest('#context-menu').attr('data-id');
    $("#form_img_container").hide();
    
    $.ajax({
        type: "POST",
        url: "ajax/publicaciones.ajax.php",
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

            let form = response[0];
            $("form [name='id']").val(form['publicaciones_id']);
            $("form [name='titulo']").val(form['pub_descripcion']);
            $("form [name='tmp_edit_image']").val(form['pub_image']);
            $("form [name='fecha_publicacion']").val(form['pub_fecha_publicacion']);
            form['pub_fecha_evento'] = form['pub_fecha_evento'].slice(0, 10);
            $("form [name='fecha_evento']").val(form['pub_fecha_evento']);

            let carr = response[1];
            let years = response[2];
            let listcar = response[3];
            var carreras = '';
            for (var i = 0; i < carr.length; i++) {

                let anios = '';
                let lista_activos = [];
                for (let y = 0; y < carr[i]['car_duracion']; y++) { // 5 veces = 5 años
                    for (let z = 0; z < years.length; z++) { // todos los years llamados
                        if (years[z]['publicaciones_carreras_id'] == carr[i]['publicaciones_carreras_id']) { // si el year coincide con la carrera actual
                            lista_activos.push(years[z]['pubcarani_anio']);
                        }
                    }
                    lista_activos.push('asfdsdfa');
                }
                let tmp = 0;
                for (let z = 1; z <= carr[i]['car_duracion']; z++) {
                    let active = '';
                    if (lista_activos[tmp] == z) {
                        active = 'active';
                        tmp++;
                    }
                    anios += `<span class="${active}">${z}</span>`;
                }

                let options = '';
                for (var z = 0; z < listcar.length; z++) {
                    let selected = (listcar[z]['carreras_id'] == carr[i]['carreras_id']) ? 'selected' : '';
                    options += `
                        <option value="${listcar[z]['carreras_id']}" ${selected}>
                            ${listcar[z]['car_nombre']}
                        </option>
                    `;
                }

                carreras += `
                    <div class="carrera_selector">
                        <select name="carrera">${options}</select>
                        <div class="anio_selector">${anios}</div>
                        <div class="carrera_remove_trigger">
                            <i class="fa-solid fa-trash-can"></i>
                        </div>
                        <div class="carrera_add_trigger">
                            <i class="fa-solid fa-plus"></i>
                        </div>
                    </div>
                `;
            }
            $('.carrera_container').html(carreras);
        }
    });
})


// =========== Llamar datos para eliminar =========== //
$(document).on("click", "#context-menu [data-modal-trigger='delele_form']", function(){
    let id = $(this).closest('#context-menu').attr('data-id');
    $("[data-modal-name='delele_form'] .success").attr('data-id', id);
    
    $.ajax({
        type: "POST",
        url: "ajax/publicaciones.ajax.php",
        data: {
            action: 'callDataToDelete',
            id: id
        },
        async: false,
        error: function(xhr, status, error) {
            alert(xhr.responseText);
        },
        dataType: 'json',
        success: function(response){
            $("[data-modal-name='delele_form'] .modal_text span").html(`¿Está seguro de que desea eliminar la publicación con id ${response[0]['publicaciones_id']}?`);
        }
    });
})

// =========== Eliminar =========== //
$(document).on("click", "[data-modal-name='delele_form'] .success", function(){
    let id = $(this).attr('data-id');
    
    $.ajax({
        type: "POST",
        url: "ajax/publicaciones.ajax.php",
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

// =========== Crear o Editar =========== //
$(document).on("click", "[data-modal-name='main_form'] .success", function(){

    debugger;
    // Validación de datos
    if ( $(".modal input[name='carrera']").val() == '' ) {
        alert('Favor ingrese un título para continuar');
        return false;
    }
    if ( $(".modal input[name='fecha_evento']").val() == '' ) {
        alert('Favor ingrese la fecha del evento para continuar');
        return false;
    } else if ( $(".modal input[name='fecha_evento']").val().length !== 10 ){
        alert('Favor asegurese de cargar la fecha del evento correctamente para continuar');
        return false;
    }
    if ( $(".modal .carrera_container").html() == '' ) {
        alert('Favor ingrese una carrera para continuar');
        return false;
    }
    let type = $(this).closest('.modal').attr('data-modal-type');
    if (type !== 'Editar') { 
        if ( $(".modal input[name='imagen']").val() == '' ) {
            alert('Favor ingrese una imagen para continuar');
            return false;
        }
    }

    // Envío de datos al php
    let form_data = $("[data-modal-name='main_form'] form").serializeArray();
    let carreras = [];
    $(".carrera_container .carrera_selector").each((index, element) => {
        let anios = [];
        $(element).find('.anio_selector .active').each((i, e)=>{
            anios.push([ $(e).html() ]);
        })
        carreras.push([ $(element).find('select').val(), anios ]);
    });

    //img
    if (type !== 'Editar') { 
        var formData = new FormData();
        let id = $("form [name='id']").val();
        formData.append("id", id);
    }
    
    $.ajax({
        type: "POST",
        url: "ajax/publicaciones.ajax.php",
        data: {
            action: 'sendData',
            type: type,
            form_data: JSON.stringify(form_data),
            carreras: JSON.stringify(carreras)
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

    if (type !== 'Editar') {
        $.ajax({
            type: "POST",
            url: "ajax/publicaciones.ajax.php",
            data: formData,
            cache:false,
            contentType: false,
            processData: false,
            error: function(xhr, status, error) {
                alert(xhr.responseText);
            }
        });
    }

    $("[data-modal-name='main_form'] form").trigger('reset');
    $('.carrera_container').html(CarreraSelection);
    $('#form_img_container .drop-zone').append('<span class="drop-zone__prompt">Arrastre su publicación aquí</span>');
    $('.drop-zone__thumb').remove();
    $(this).closest('.modal').hide();
})




// =========== Cargar los Datos para la Tabla Principal =========== //
function loadData(){
    $.ajax({
        type: "POST",
        url: "ajax/publicaciones.ajax.php",
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
                data += `
                    <tr data-id="${response[i]['publicaciones_id']}">
                        <td>${response[i]['publicaciones_id']}</td>
                        <td>${response[i]['pub_descripcion']}</td>
                        <td>${response[i]['pub_fecha_publicacion']}</td>
                        <td>${response[i]['pub_fecha_evento']}</td>
                        <td>
                            <a href="http://localhost/actividades_universitarias/publicacion.php?id=${response[i]['publicaciones_id']}" target="_BLANK"><i class="fa-solid fa-up-right-from-square"></i></a>
                        </td>
                    </tr>
                `;
            }
            $('#main_table').html(data);
        }
    });
}

// =========== Carrera Selection =========== //
let CarreraSelection = '';
function loadCarreraSelection(){
    
    $.ajax({
        type: "POST",
        url: "ajax/publicaciones.ajax.php",
        data: {
            action: 'loadCarreraSelection'
        },
        async: false,
        error: function(xhr, status, error) {
            alert(xhr.responseText);
        },
        dataType: 'json',
        success: function(response){
            let options = '';
            for (var i = 0; i < response.length; i++) {
                options += `<option value="${response[i]['carreras_id']}">${response[i]['car_nombre']}</option>`;
            }
            let anios = '';
            for (var i = 1; i <= response[0]['car_duracion']; i++) {
                anios += `<span>${i}</span>`;
            }
            CarreraSelection = `
                <div class="carrera_selector">
                    <select name="carrera">${options}</select>
                    <div class="anio_selector">${anios}</div>
                    <div class="carrera_remove_trigger">
                        <i class="fa-solid fa-trash-can"></i>
                    </div>
                    <div class="carrera_add_trigger">
                        <i class="fa-solid fa-plus"></i>
                    </div>
                </div>
            `;
            $('.carrera_container').html(CarreraSelection);
        }
    });
}
// añadir
$(document).on("click", ".carrera_add_trigger", function(){
    $(this).closest('.carrera_container').append(CarreraSelection);
});
// eliminar
$(document).on("click", ".carrera_remove_trigger", function(){
    $(this).closest('.carrera_selector').remove();
});
// seleccionar años
$(document).on("click", ".anio_selector span", function(){
    if ($(this).hasClass('active')) {
        $(this).removeClass('active');
    } else {
        $(this).addClass('active');
    }
});
// on change select de carreras, traeme los años que tiene
$(document).on("change", ".carrera_selector > select", function(){
    let anio_container = $(this).closest('.carrera_selector').find('.anio_selector');
    let carreras_id = $(this).val();
    $.ajax({
        type: "POST",
        url: "ajax/publicaciones.ajax.php",
        data: {
            action: 'loadCarreraAnio',
            id: carreras_id
        },
        async: false,
        error: function(xhr, status, error) {
            alert(xhr.responseText);
        },
        dataType: 'json',
        success: function(response){
            let anios = '';
            for (var i = 1; i <= response; i++) {
                anios += `<span>${i}</span>`;
            }
            anio_container.html(anios);
        }
    });
});


// =========== Drag and Drop Image =========== //
document.querySelectorAll(".drop-zone__input").forEach((inputElement) => {
    const dropZoneElement = inputElement.closest(".drop-zone");

    dropZoneElement.addEventListener("click", (e) => {
        inputElement.click();
    });

    inputElement.addEventListener("change", (e) => {
        if (inputElement.files.length) {
            updateThumbnail(dropZoneElement, inputElement.files[0]);
        }
    });

    dropZoneElement.addEventListener("dragover", (e) => {
        e.preventDefault();
        dropZoneElement.classList.add("drop-zone--over");
    });

    ["dragleave", "dragend"].forEach((type) => {
        dropZoneElement.addEventListener(type, (e) => {
            dropZoneElement.classList.remove("drop-zone--over");
        });
    });

    dropZoneElement.addEventListener("drop", (e) => {
        e.preventDefault();

        if (e.dataTransfer.files.length) {
            inputElement.files = e.dataTransfer.files;
            updateThumbnail(dropZoneElement, e.dataTransfer.files[0]);
        }

        dropZoneElement.classList.remove("drop-zone--over");
    });
});

/**
 * Updates the thumbnail on a drop zone element.
 *
 * @param {HTMLElement} dropZoneElement
 * @param {File} file
 */
function updateThumbnail(dropZoneElement, file) {
    let thumbnailElement = dropZoneElement.querySelector(".drop-zone__thumb");

    // First time - remove the prompt
    if (dropZoneElement.querySelector(".drop-zone__prompt")) {
        dropZoneElement.querySelector(".drop-zone__prompt").remove();
    }

    // First time - there is no thumbnail element, so lets create it
    if (!thumbnailElement) {
        thumbnailElement = document.createElement("div");
        thumbnailElement.classList.add("drop-zone__thumb");
        dropZoneElement.appendChild(thumbnailElement);
    }

    thumbnailElement.dataset.label = file.name;

    // Show thumbnail for image files
    if (file.type.startsWith("image/")) {
        const reader = new FileReader();

        reader.readAsDataURL(file);
        reader.onload = () => {
            thumbnailElement.style.backgroundImage = `url('${reader.result}')`;
        };
    } else {
        thumbnailElement.style.backgroundImage = null;
    }
}


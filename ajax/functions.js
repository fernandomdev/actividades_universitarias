
// =========== Trabajar con Modals =========== //
$(document).on('click', '[data-modal-trigger]', function() {
    let modal_name = $(this).attr('data-modal-trigger');
    $(`[data-modal-name="${modal_name}"]`).toggle();

    let set_modal_type = $(this).attr('data-modal-type');
    if (set_modal_type !== undefined) {
        $(`[data-modal-name="${modal_name}"]`).attr('data-modal-type', set_modal_type);
        $(`[data-modal-name="${modal_name}"]`).find('button.success').html(set_modal_type);
    }
    if (set_modal_type == 'Crear') {
        $(`[data-modal-name="${modal_name}"] form`).trigger('reset');
    }
});
$(document).on('click', '.modal_bg', function() {
    let modal_name = $(this).closest('.modal').attr('data-modal-name');
    $(`[data-modal-name="${modal_name}"]`).toggle();
});
document.onkeydown = function(e) {
    switch(e.which) {
        case 27: //esc
            if( $(".modal").is(":visible") ){
                $(".modal").hide();
            }
            if( $("#context-menu").is(":visible") ){
                $('#context-menu').css({'display':'none'});
            }
        break;
    }
};

// =========== Al darle click derecho a una tabla, se llaman estas funciones =========== //
$(document).on("contextmenu", "#context-menu", function(){
    return false;
});
$(document).on("contextmenu", "#main_table [data-id]", function(e){
    let left = e.clientX-10;
    let top = e.clientY-5;
    $('#context-menu').css({'left':left, 'top':top, 'display':'block'});
    $('#context-menu').attr( 'data-id', $(this).attr('data-id') );
    return false;
});
$(document).on("click", function(event){
    if(!$(event.target).closest("#context-menu").length){
        $('#context-menu').css({'display':'none'});
    }
});
$(document).on('click','#context-menu button', function(){
    $('#context-menu').css({'display':'none'});
});


// =========== Alertas custom o popups o como le quieras llamar =========== //
var currentCallback;

window.alert = function(msg, callback){
  $('.message').text(msg);
  $('.customAlert').css('animation', 'fadeIn 0.3s linear');
  $('.customAlert').css('display', 'inline');
  setTimeout(function(){
    $('.customAlert').css('animation', 'none');
  }, 300);
  currentCallback = callback;
}

$(function(){
    $('.confirmButton').click(function(){
        $('.customAlert').css('animation', 'fadeOut 0.3s linear');
        setTimeout(function(){
        $('.customAlert').css('animation', 'none');
            $('.customAlert').css('display', 'none');
        }, 300);
    })
    
    $('.rab').click(function(){
        alert("If you think about anything, you are actually doing a recursive function which resolves your neurons into a deep pi calculation. You are then executing about 4294 threads in your brain, which do a parallel computation.", function(){
        console.log("Callback executed");
        })
    });
});

// Compartir publicación
$(document).on("click", ".share", function(){
    let copyText = $(this).attr('data-link');
    navigator.clipboard.writeText(copyText);
    alert("Link copiado correctamente!");
});
// Animación botón de asistir
$(document).on("click", ".assist", function(){
    if ($(this).hasClass('active')) {
        $(this).removeClass('active');
        $(this).find('i').addClass('fa-regular');
        $(this).find('i').removeClass('fa-solid');
    } else {
        $(this).addClass('active');
        $(this).find('i').removeClass('fa-regular');
        $(this).find('i').addClass('fa-solid');
    }
});
function openLoading(){
    Swal.fire({
        heightAuto: false,
        title: "Cargando..."
    })
    Swal.showLoading();
}

function closeLoading(){
    Swal.close();
}

function alertaMensaje(tipo, titulo, mensaje){

    // tipos: warning, success, info, question

    Swal.fire({
        heightAuto: false,
        title: titulo,
        text: mensaje,
        icon: tipo,
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Aceptar',
    })
}

// opciones para Toast
toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": false,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "200",
    "hideDuration": "1000",
    "timeOut": "2500",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}

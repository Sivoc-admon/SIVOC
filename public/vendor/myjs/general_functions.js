//RESETEA FORMULARIO
$('[data-toggle="tooltip"]').tooltip();

function resetForm(id) {
    document.getElementById(id).reset();
}

//ALERTAS
function messageAlert(title, icon, text) {
    let texto = (text === null || text === '') ? '' : text;
    Swal.fire({
        icon: icon,
        title: title,
        text: texto,
    })
}
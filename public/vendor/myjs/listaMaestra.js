function saveFolder() {
    let idProject = $("#sltProyecto").val();

    if (idProject <= 0) {
        messageAlert("Debe seleccionar el proyecto.", "warning");
        return;
    }

    $.ajax({
        type: "POST",
        url: `listaMaestra/${idProject}/createFolder`,
        data: $("#formCreateFolder").serialize(),
        //dataType: 'json',
        success: function(data) {

            if (data.error == true) {
                messageAlert(data.msg, "error", "");
            } else {

                $("#modalCreateFolder").modal('hide');

                messageAlert("Guardado Correctamente", "success", "");
                location.reload();

            }

        },
        error: function(data) {
            console.log(data.responseJSON);
            if (data.responseJSON.message == "The given data was invalid.") {
                messageAlert("Datos incompletos.", "warning");
            } else {
                messageAlert("Ha ocurrido un problema.", "error", "");
            }
            //messageAlert("Datos incompletos", "error", `${data.responseJSON.errors.apellido_paterno}` + "\n" + `${data.responseJSON.errors.name}`);
        }
    });
}

function uploadFile() {

    let carpeta = $("#hiddenAddFilefolder").val();
    let file = $('#inputFile')[0];

    if (!carpeta) {
        messageAlert("Debe seleccionar el proyecto.", "warning");
        return;
    }
    let data = new FormData();
    data.append("carpeta", carpeta);
    data.append("tamanoFiles", file.files.length);
    for (let i = 0; i < file.files.length; i++) {
        data.append('file' + i, file.files[i]);
    }

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: `listaMaestra/${carpeta}/uploadFile`,
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(data) {

            if (data.error == true) {
                messageAlert(data.msg, "error", "");
            } else {

                $("#modalUploadFile").modal('hide');

                messageAlert("Guardado Correctamente", "success", "");

                location.reload();

            }

        },
        error: function(data) {
            console.log(data.responseJSON);
            if (data.responseJSON.message == "The given data was invalid.") {
                messageAlert("Datos incompletos.", "warning");
            } else {
                messageAlert("Ha ocurrido un problema.", "error", "");
            }
            //messageAlert("Datos incompletos", "error", `${data.responseJSON.errors.apellido_paterno}` + "\n" + `${data.responseJSON.errors.name}`);
        }
    });
}

function show(div) {
    if (div == 'divCarpetas') {
        $("#divCarpetas").show();
        $("#divListaMaestra").hide();
    } else {
        $("#divCarpetas").hide();
        $("#divListaMaestra").show();
    }

    if (div == 'divListaMaestra') {
        let proyecto = $("#hiddenAddFilefolder").val();
        $.ajax({
            type: "GET",
            url: `listaMaestra/${proyecto}`,
            //data: { "id": minute },
            dataType: 'json',
            success: function(data) {
                console.log(data);
                if (data.error == true) {
                    messageAlert(data.msg, "error", "");
                } else {
                    console.log(data.listaMateriales);
                    $("#tblListaMaestra").DataTable({
                        dom: 'Bfrtip',
                        data: data.listaMateriales,
                        buttons: [
                            'csv', 'excel', 'pdf'
                        ],
                        columns: [
                            { data: 'folio' },
                            { data: 'description' },
                            { data: 'modelo' },
                            { data: 'fabricante' },
                            { data: 'cantidad' },
                            { data: 'unidad' },

                        ],
                        responsive: {
                            details: {
                                type: 'column',
                                target: -1
                            }
                        },
                        columnDefs: [{
                            className: 'control',
                            orderable: false,
                            targets: -1
                        }]
                    });

                }

            },
            error: function(data) {
                console.log(data.responseJSON);
                if (data.responseJSON.message == "The given data was invalid.") {
                    messageAlert("Datos incompletos.", "warning");
                } else {
                    messageAlert("Ha ocurrido un problema.", "error", "");
                }
                //messageAlert("Datos incompletos", "error", `${data.responseJSON.errors.apellido_paterno}` + "\n" + `${data.responseJSON.errors.name}`);
            }
        });
    }

}
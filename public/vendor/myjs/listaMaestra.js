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

                if (data.error == true) {
                    messageAlert(data.msg, "error", "");
                } else {
                    console.log(data);
                    $("#txtProyect").val(data.project);
                    $("#dateCreacionProject").val(data.project_date);
                    let secciones = "<option value='0'>Seleccion Sección</option>";

                    for (const key in data.secciones) {
                        const element = data.secciones[key].id;
                        secciones += `<option value="${data.secciones[key].id}">${data.secciones[key].name}</option>`;
                    }
                    $("#sltSeccion").append(secciones);
                    $("#tblListaMaestra").DataTable({
                        //dom: 'Bfrtip',
                        //retrieve: true,
                        bDestroy: true,
                        pageLength: 50,
                        lengthMenu: [
                            [5, 10, 50, 100, -1],
                            [5, 10, 50, 100, "All"]
                        ],
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
                            {
                                data: 'accion',
                                render: function(data, type, row) {
                                    return `<button type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Cambiar" onClick="accion(${row.id})"><i class="fas fa-file"></i></button>`;

                                }
                            },
                            /*{ defaultContent: "<select class='form-control'><option value='0' selected>Accion</option><option value='Cambio'>Cambio</option><option value='Editar'>Editar</option> </select>" },*/

                        ],
                        createdRow: function(row, data, index) {

                            // Updated Schedule Week 1 - 07 Mar 22

                            /*if (data.id == 33) {
                                $('td:eq(4)', row).parents('tr').css('background-color', '#85B7F5'); //Original Date
                            } else if (data.id > 33) {
                                $('td:eq(4)', row).css('background-color', 'red'); // Behind of Original Date
                            } else if (data.id < 33) {
                                $('td:eq(4)', row).css('background-color', 'Green'); // Ahead of Original Date
                            } else {
                                $('td:eq(4)', row).css('background-color', 'White');
                            }*/
                        },

                        responsive: {
                            details: {
                                type: 'column',
                                target: -1
                            }
                        },
                        columnDefs: [
                            { "width": "50%", "targets": 5 }
                        ],
                        scrollX: true,

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

//Mostrar lista de materiales por seccion y las acciones correspondientes
function listaSeccion() {
    let seccion = $("#sltSeccion").val();
    $("#rowTablasDinamicas").empty();
    if (seccion <= 0) {
        return;
    }
    $.ajax({
        type: "GET",
        url: `listaMaestra/seccion/${seccion}`,
        //data: { "id": minute },
        dataType: 'json',
        success: function(data) {

            if (data.error == true) {
                messageAlert(data.msg, "error", "");
            } else {
                console.log(data);


                let tablaPrincipal = $("#tblListaMaestra").DataTable({
                    //dom: 'Bfrtip',
                    //retrieve: true,
                    bDestroy: true,
                    lengthMenu: [
                        [5, 10, 50, 100, -1],
                        [5, 10, 50, 100, "All"]
                    ],
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
                        {
                            data: 'accion',
                            render: function(data, type, row) {
                                console.log(row);
                                return `<button type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Cambiar" onClick="accion(${row.id})"><i class="fas fa-file"></i></button>`;

                            }
                        },
                        /*{ defaultContent: "<select class='form-control'><option value='0' selected>Accion</option><option value='Cambio'>Cambio</option><option value='Editar'>Editar</option> </select>" },*/

                    ],
                    createdRow: function(row, data, index) {

                        // Updated Schedule Week 1 - 07 Mar 22

                        if (data.cambio == 'Editar') {
                            $('td:eq(4)', row).parents('tr').css('background-color', '#85B7F5'); //
                        } else if (data.cambio == 'Cambiar') {
                            $('td:eq(4)', row).parents('tr').css('background-color', '#ffc107'); //
                        }

                    },
                    responsive: {
                        details: {
                            type: 'column',
                            target: -1
                        }
                    },
                    columnDefs: [
                        { "width": "50%", "targets": 5 }
                    ],
                    scrollX: true,

                });


                for (let i = 1; i <= data.totalTablas; i++) {
                    var producto = [];
                    for (const key in data.listaFinalCambios) {
                        console.log(data.listaFinalCambios[key].folio);
                        if (data.listaFinalCambios[key].tabla == i) {
                            producto.push({
                                id: data.listaFinalCambios[key].id,
                                folio: data.listaFinalCambios[key].folio,
                                description: data.listaFinalCambios[key].description,
                                modelo: data.listaFinalCambios[key].modelo,
                                fabricante: data.listaFinalCambios[key].fabricante,
                                cantidad: data.listaFinalCambios[key].cantidad,
                                unidad: data.listaFinalCambios[key].unidad,
                                cambio: data.listaFinalCambios[key].cambio,
                                tabla: data.listaFinalCambios[key].tabla,
                                idFolioPrincipal: data.listaFinalCambios[key].idFolioPrincipal,
                                folioPrincipal: data.listaFinalCambios[key].folioPrincipal,
                                fecha: data.listaFinalCambios[key].fecha,
                            });
                        }

                    }
                    let html = `<div class="col-md-12" style="text-align: center">`;
                    html += `<h5>Tabla de Cambios ${i+1}</h5>`;
                    html += `</div>`;
                    html += `<table id="tblListaMaestraCambios_${i}" class="table table-striped table-bordered display nowrap" style="width:100%; font-size: 12px;">`;
                    html += `<thead>`;
                    html += `<th>Folio</th>`;
                    html += `<th>Descripcion</th>`;
                    html += `<th>Modelo</th>`;
                    html += `<th>Fabricante</th>`;
                    html += `<th>Cantidad</th>`;
                    html += `<th>Unidad</th>`;
                    html += `<th>Accion</th>`;
                    html += `</thead>`;
                    html += `<tfoot>`;
                    html += `<th>Folio</th>`;
                    html += `<th>Descripcion</th>`;
                    html += `<th>Modelo</th>`;
                    html += `<th>Fabricante</th>`;
                    html += `<th>Cantidad</th>`;
                    html += `<th>Unidad</th>`;
                    html += `<th>Accion</th>`;
                    html += `</tfoot>`;
                    html += `</table>`;

                    $("#rowTablasDinamicas").append(html);

                    let tablasAleatorias = $(`#tblListaMaestraCambios_${i}`).DataTable({
                        //dom: 'Bfrtip',
                        //retrieve: true,
                        bDestroy: true,
                        lengthMenu: [
                            [5, 10, 50, 100, -1],
                            [5, 10, 50, 100, "All"]
                        ],
                        data: producto,
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
                            {
                                data: 'accion',
                                render: function(data, type, row) {
                                    console.log(row);
                                    return `<button type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Cambiar" onClick="accion(${row.id})"> <i class="fas fa-file"> </i></button>`;

                                }
                            },
                            /*{ defaultContent: "<select class='form-control'><option value='0' selected>Accion</option><option value='Cambio'>Cambio</option><option value='Editar'>Editar</option> </select>" },*/

                        ],
                        createdRow: function(row, data, index) {

                            // Updated Schedule Week 1 - 07 Mar 22

                            if (data.cambio == 'Editar') {
                                $('td:eq(4)', row).parents('tr').css('background-color', '#85B7F5'); //Original Date
                            } else if (data.cambio == 'Cambiar') {
                                $('td:eq(4)', row).parents('tr').css('background-color', '#ffc107'); // Behind of Original Date
                            }
                            row.setAttribute('title', `${data.folioPrincipal} con fecha: ${data.fecha}`);
                        },
                        responsive: {
                            details: {
                                type: 'column',
                                target: -1
                            }
                        },
                        columnDefs: [
                            { "width": "50%", "targets": 5 }
                        ],
                        scrollX: true,

                    });

                    tablasAleatorias.$('tr').tooltip({
                        "delay": 0,
                        "track": true,
                        "fade": 250
                    });

                }
                console.log(producto);




            }

        },
        error: function(data) {
            console.log(data.responseJSON);
            if (data.responseJSON.message == "The given data was invalid.") {
                messageAlert("Datos incompletos.", "warning");
            } else {
                messageAlert("Ha ocurrido un problema.", "error", "");
            }
            //messageAlert("Datos incompletos", "error", `

        }
    });
}

function accion(id) {
    let seccion = $("#sltSeccion").val();
    if (!seccion || seccion == 0) {
        messageAlert("Debe seleccionar una Sección.", "warning");
        return;
    }
    //CONSULTA LOS DATOS EL MATERIAL PARA EDITARLO
    $.ajax({
        type: "GET",
        url: `listaMaestra/material/${ id }`,
        //data: { "id": minute },
        dataType: 'json',
        success: function(data) {

            if (data.error == true) {
                messageAlert(data.msg, "error", "");
            } else {
                $("#sltFolioMaterial").empty();
                $("#txtDescripcionMaterial").empty();
                $("#txtModeloMaterial").val("");
                $("#txtFabricanteMaterial").val("");
                $("#txtCantidadMaterial").val("");
                $("#sltUnidadMaterial").empty();
                $("#hideFolio").val();
                let selectFolio = "<option value='0'>Seleccione Folio</option>";
                for (const key in data.materiales) {
                    selectFolio += ` < option value = '${data.materiales[key].folio}' > $ { data.materiales[key].folio } < /option>`;
                }
                let selectUnidad = "<option value='0'>Seleccione Unidad</option>";
                for (const key in data.unidades) {
                    selectUnidad += `<option value='${data.unidades[key].unidad}'>${data.unidades[key].unidad}</option>`;
                }
                $("#hideFolio").val(data.material.id);
                $("#sltFolioMaterial").append(selectFolio);
                $("#txtDescripcionMaterial").append(data.material.description);
                $("#txtModeloMaterial").val(data.material.modelo);
                $("#txtFabricanteMaterial").val(data.material.fabricante);
                $("#txtCantidadMaterial").val(data.material.cantidad);
                $("#sltUnidadMaterial").append(selectUnidad);
                console.log(data.unidades);
                $("#sltFolioMaterial option[value=" + data.material.folio + "]").attr("selected", true);
                $("#sltUnidadMaterial option[value=" + data.material.unidad + "]").attr("selected", true);
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
    $("#modalEditMaterial").modal("show");
}

function modificarMaterial() {
    let folio = $("#sltFolioMaterial").val();
    let descripcion = $("#txtDescripcionMaterial").val();
    let modelo = $("#txtModeloMaterial").val();
    let fabricante = $("#txtFabricanteMaterial").val();
    let cantidad = $("#txtCantidadMaterial").val();
    let unidad = $("#sltUnidadMaterial").val();
    let accion = $("#sltAccion").val();
    let id = $("#hideFolio").val();
    let seccion = $("#sltSeccion").val();

    if (!folio || folio == 0) {
        messageAlert("Debe seleccionar el folio.", "warning");
        return;
    }
    if (!descripcion || descripcion == "") {
        messageAlert("Debe seleccionar la descripción.", "warning");
        return;
    }
    if (!modelo || modelo == "") {
        messageAlert("Debe seleccionar el modelo.", "warning");
        return;
    }
    if (cantidad <= 0) {
        messageAlert("La cantidad debe ser igual o mayor a 1.", "warning");
        return;
    }
    if (!unidad || unidad == 0) {
        messageAlert("Debe seleccionar la unidad.", "warning");
        return;
    }
    if (!accion || accion == 0) {
        messageAlert("Debe seleccionar la acción.", "warning");
        return;
    }

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: `listaMaestra/material/${id}`,
        data: {
            "folio": folio,
            "descripcion": descripcion,
            "modelo": modelo,
            "fabricante": fabricante,
            "cantidad": cantidad,
            "unidad": unidad,
            "accion": accion,
            "seccion": seccion
        },
        dataType: 'json',
        success: function(data) {

            if (data.error == true) {
                messageAlert(data.msg, "error", "");
            } else {
                $("#modalEditMaterial").modal("hide");
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

function habilitaInput() {
    let accion = $("#sltAccion").val();
    if (accion == 0) {
        return;
    } else if (accion == 'Editar') {
        $('#sltFolioMaterial').attr("disabled", true);
        $('#txtModeloMaterial').attr("readonly", true);
        $('#txtFabricanteMaterial').attr("readonly", true);
        $('#sltUnidadMaterial').attr("disabled", true);
    } else if (accion == 'Cambiar') {
        $('#sltFolioMaterial').attr("disabled", false);
        $('#txtModeloMaterial').attr("readonly", false);
        $('#txtFabricanteMaterial').attr("readonly", false);
        $('#sltUnidadMaterial').attr("disabled", false);
    }
}

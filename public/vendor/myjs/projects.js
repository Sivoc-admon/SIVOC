function saveProject() {
    $.ajax({
        type: "POST",
        url: "projects",
        data: $("#formRegisterProject").serialize(),
        //dataType: 'json',
        success: function(data) {

            if (data.error == true) {
                messageAlert(data.msg, "error", "");
            } else {

                $("#ModalRegisterUser").modal('hide');

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

function datosTablero(id, name) {
    $("#inputProyectBoard").val(name);
    $("#inputIdProyect").val(id);
}

function saveBoard() {
    $.ajax({
        type: "POST",
        url: "projects/board/createBoard",
        data: $("#formRegisterBoard").serialize(),
        //dataType: 'json',
        success: function(data) {

            if (data.error == true) {
                messageAlert(data.msg, "error", "");
            } else {

                $("#ModalRegisterUser").modal('hide');

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

function showBoards(tablero) {
    $("#bodyProjectBoards").empty();
    $.ajax({
        type: "GET",
        url: `projects/board/showBoards/${tablero}`,
        data: { "id": tablero },
        dataType: 'json',
        success: function(data) {
            console.log(data);
            if (data.error == true) {
                messageAlert(data.msg, "error", "");
            } else {

                let table = "";
                for (const i in data) {
                    for (const j in data[i]) {
                        table += `<tr>
                            <td>${ data[i][j].id }</td>
                            <td>${ data[i][j].name }</td>
                        </tr>`;
                    }

                }

                $("#bodyProjectBoards").append(table);


                //messageAlert("Guardado Correctamente", "success", "");
                //location.reload();

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

function editProject(id) {
    $("#sltEditTypeProject").empty();
    $("#sltEditCliente").empty();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: "GET",
        url: "/projects/" + id + "/edit",
        //data: $("#formRegisterUser").serialize(),
        dataType: 'json',
        success: function(data) {
            console.log(data);

            if (data.error == true) {
                messageAlert(data.msg, "error", "");
            } else {
                let tipo = "";
                let customerOption = "";
                if (data.project.type == "PE") {
                    tipo = "<option value='PE' selected>PUESTA EN MARCHA</option>" +
                        "<option value='PO'>OPERACIONAL</option>";
                } else {
                    tipo = "<option value='PE'>PUESTA EN MARCHA</option>" +
                        "<option value='PO' selected>OPERACIONAL</option>";
                }

                for (const i in data.users) {
                    if (data.project.client == data.users[i].id) {
                        customerOption = customerOption + `<option value='${data.users[i].id}' selected>${data.users[i].name}</option>`
                    } else {
                        customerOption = customerOption + `<option value='${data.users[i].id}'>${data.users[i].name}</option>`
                    };
                }


                $("#hideIdProject").val(data.project.id);
                $("#sltEditTypeProject").append(tipo);
                $("#sltEditCliente").append(customerOption);
                $("#inputEditProyecto").val(data.project.name);
                $("#inputEditEstatus").val(data.project.status);


            }
            $("#modalEditProyect").modal("show");

            //location.reload();

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

function updateProject() {

    let id = $("#hideIdProject").val();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: "PUT",
        url: "/projects/" + id,
        data: $("#formEditProject").serialize(),
        //dataType: 'json',
        success: function(data) {
            console.log(data);

            if (data.error == true) {
                messageAlert(data.msg, "error", "");
            } else {

                $("#modalEditProyect").modal("hide");
            }

            location.reload();

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
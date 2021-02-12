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
    console.log(name);
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
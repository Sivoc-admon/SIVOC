function saveCorrectiveAction() {

    let issue = $("#inputIssiueCorrectiveAction").val();
    let action = $("#inputActionCorrectiveAction").val();
    let participant = $("#sltParticipantesInternos").val();
    let status = $("#inputStatusCorrectiveAction").val();
    let file = $('#fileCorrectiveAction')[0];

    let data = new FormData();
    data.append("issue", issue);
    data.append("action", action);
    data.append("participant", participant);
    data.append("status", status);
    data.append("tamanoFiles", file.files.length);
    for (let i = 0; i < file.files.length; i++) {
        data.append('file' + i, file.files[i]);
    }


    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: "correctiveActions",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(data) {

            if (data.error == true) {
                messageAlert(data.msg, "error", "");
            } else {

                $("#ModalRegisterCorrectiveAction").modal('hide');

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

function editCorrectiveAction(id) {
    $("#sltAreaEditUser").empty();
    $("#inputRoleEditUser").empty();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: "GET",
        url: "/users/edit/" + id,
        //data: $("#formRegisterUser").serialize(),
        dataType: 'json',
        success: function(data) {
            console.log(data.roleUser[0].id);

            if (data.error == true) {
                messageAlert(data.msg, "error", "");
            } else {

                $("#inputNameEditUser").val(data.user.name);
                $("#inputLastNameEditUser").val(data.user.last_name);
                $("#inputMotherLastNameEditUser").val(data.user.mother_last_name);
                $("#inputEmailEditUser").val(data.user.email);
                $("#idUser").val(data.user.id);

                let optionAreas = "<option value='0'>Seleccione</option>";
                let optionRoles = "<option value='0'>Seleccione</option>";
                for (const i in data.areas) {
                    if (data.user.area_id == data.areas[i].id) {
                        optionAreas += `<option value='${data.areas[i].id}' selected>${data.areas[i].name}</option>`
                    } else {
                        optionAreas += `<option value='${data.areas[i].id}'>${data.areas[i].name}</option>`;
                    }

                }


                for (const j in data.roles) {
                    if (data.roleUser[0].id == data.roles[j].id) {
                        optionRoles += `<option value='${data.roles[j].id}' selected>${data.roles[j].name}</option>`
                    } else {
                        optionRoles += `<option value='${data.roles[j].id}'>${data.roles[j].name}</option>`;
                    }

                }

                $("#sltAreaEditUser").append(optionAreas);
                $("#inputRoleEditUser").append(optionRoles);

                $("#ModalEditCorrectiveAcition").modal('show');

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

function showCorrectiveActionFile(id) {
    $("#bodyCorrectiveActionFiles").empty();
    $.ajax({
        type: "GET",
        url: `correctiveActions/showCorrectiveActionsFiles/${id}`,
        //data: { "id": minute },
        dataType: 'json',
        success: function(data) {

            console.log(data.correctiveActionfiles[1].id);

            if (data.error == true) {
                messageAlert(data.msg, "error", "");
            } else {

                let table = "";
                for (const i in data.correctiveActionfiles) {
                    table += `<tr>"
                        <td> ${data.correctiveActionfiles[i].id}</td> 
                        <td>
                            <a href="storage/Documents/Accion_Correctiva/${id}/${data.correctiveActionfiles[i].file}" target="_blank">${data.correctiveActionfiles[i].file}</a>
                        </td>"
                    </tr>`;

                }

                $("#bodyCorrectiveActionFiles").append(table);


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
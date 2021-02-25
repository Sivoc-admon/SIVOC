function saveUser() {

    /*$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });*/

    //e.preventDefault();

    $.ajax({
        type: "POST",
        url: "users",
        data: $("#formRegisterUser").serialize(),
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

function editUser(id) {
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

                $("#ModalEditUser").modal('show');

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

function updateUser() {

    /*$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });*/

    //e.preventDefault();
    let id = $("#idUser").val();
    $.ajax({
        type: "PUT",
        url: "users/" + id,
        data: $("#formEditUser").serialize(),
        //dataType: 'json',
        success: function(data) {

            if (data.error == true) {
                messageAlert(data.msg, "error", "");
            } else {

                $("#ModalEditUser").modal('hide');

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
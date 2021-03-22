function saveAsset() {

    let description = $("#inputDescriptionAsset").val();
    let costo = $("#inputCostoAsset").val();
    let buy = $("#inputBuyAsset").val();
    let check = $("#checkAsset").val();
    let dayCalibration = $("#inputCalibrationDayAsset").val();
    let calibrationFile = $('#fileAssetCalibration')[0];
    let generalFile = $('#fileAsset')[0];

    let data = new FormData();
    data.append("description", description);
    data.append("costo", costo);
    data.append("buy", buy);
    data.append("check", check);
    data.append("dayCalibration", dayCalibration);
    data.append("lengthCalibration", calibrationFile.files.length);
    data.append("lengthGeneral", generalFile.files.length);

    for (let i = 0; i < calibrationFile.files.length; i++) {
        data.append('calibrationFile' + i, calibrationFile.files[i]);
    }

    for (let j = 0; j < generalFile.files.length; j++) {
        data.append('generalFile' + j, generalFile.files[j]);
    }

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: "assets",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(data) {

            if (data.error == true) {
                messageAlert(data.msg, "error", "");
            } else {

                $("#ModalRegisterAsset").modal('hide');

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

function muestraOculta(check, div, file) {
    let calibration = $(check).val();

    if (calibration == 1) {
        $(div).show();
    } else {
        $(div).hide();
        $(file).val("");
    }
}

function editAsset(id) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: "GET",
        url: `assets/${id}/edit`,
        //data: $("#formRegisterUser").serialize(),
        dataType: 'json',
        success: function(data) {
            console.log(data);

            if (data.error == true) {
                messageAlert(data.msg, "error", "");
            } else {

                $("#inputEditDescriptionAsset").val(data.asset.description);
                $("#inputEditCostoAsset").val(data.asset.costo);
                $("#hidAsset").val(data.asset.id);
                if(data.asset.calibration == 1){
                    $('.checkEditAsset').prop('checked', true);
                    $('#divEditCalibration').show();
                }


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

function updateAsset() {

    let id = $("#hidAsset").val();
    let description = $("#inputEditDescriptionAsset").val();
    let costo = $("#inputEditCostoAsset").val();
    let buy = $("#inputEditBuyAsset").val();
    let check = $("#checkEditAsset").val();
    let dayCalibration = $("#fileEditAssetCalibration").val();
    let calibrationFile = $('#fileAssetCalibration')[0];
    let generalFile = $('#fileEditAsset')[0];

    let data = new FormData();
    data.append("description", description);
    data.append("costo", costo);
    data.append("buy", buy);
    data.append("check", check);
    data.append("dayCalibration", dayCalibration);
    data.append("lengthCalibration", calibrationFile.files.length);
    data.append("lengthGeneral", generalFile.files.length);

    for (let i = 0; i < calibrationFile.files.length; i++) {
        data.append('calibrationFile' + i, calibrationFile.files[i]);
    }

    for (let j = 0; j < generalFile.files.length; j++) {
        data.append('generalFile' + j, generalFile.files[j]);
    }
    $.ajax({
        type: "PUT",
        url: `assets/${id}`,
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        //dataType: 'json',
        success: function(data) {

            if (data.error == true) {
                messageAlert(data.msg, "error", "");
            } else {

                $("#ModalEditAsset").modal('hide');

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

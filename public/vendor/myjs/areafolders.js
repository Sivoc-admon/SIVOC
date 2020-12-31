$(function() {
    $("#inputName").keypress(function(event) {
        var inputValue = event.charCode;
        if (!(inputValue >= 65 && inputValue <= 120) && (inputValue != 32 && inputValue != 0) && !(inputValue >= 48 && inputValue <= 57)) {
            event.preventDefault();
        }
    });
});

function getFoldersAndFiles(areaId, nivel) {

    let selectTag = `#selectNivel${nivel}`;
    let selectVal = $(selectTag).val();
    let selectTagText = $(`${selectTag} option:selected`).text();
    let botonNameTag = `#btnLevel${nivel}`;
    $(botonNameTag).html(`Agregar carpeta dentro de "${selectTagText}"`);
    if (selectVal !== '') {
        $.ajax({
            type: "GET",
            url: `/folder/${areaId}/${nivel}`,
            dataType: 'json',
            success: function(data) {
                $(botonNameTag).fadeIn();
                if (data.data.length > 0) {
                    let folders = data.data;
                    let selectHTML = ``;
                    for (var k in folders) {
                        console.log(k, folders[k]);
                        let documents = folders[k].area_documents;
                        for (var j in documents) {

                            selectHTML += `
                        <select>
                            <option></option>
                        </select>
                        `;
                        }
                    }
                } else {
                    console.log("no hay mas carpetas we :(");
                }
            },
            error: function(data) {
                console.log("ERROR en la petición");
                console.log(data);
            }
        });
    } else {
        $(botonNameTag).hide();
    }
}


function newFolder(areaId, nivel) {
    $("#nivelFolder").val(nivel);
    $("#areaIdFolder").val(areaId);
    $("#ModalCreateFolder").modal('show');
}

function createFolder() {
    $("#errorFolder").html('');
    let folderName = $("#inputName").val();
    let nivel = $("#nivelFolder").val();
    let areaId = $("#areaIdFolder").val();
    let selectTag = `#selectNivel${nivel}`;
    if (folderName.trim() !== '') {
        $("#divMsge").html(`<i class="fas fa-circle-notch"></i>
        <br><label class="control-label">Creando carpeta</label>`);
        $("#formFolder").fadeOut();
        $("#divMsge").fadeIn();
        $.ajax({
            type: "POST",
            url: `/folder/create/${areaId}/${nivel}`,
            data: { "folderName": folderName, "_token": $("input[name=_token]").val(), "idFolder": $(selectTag).val() },
            dataType: 'json',
            success: function(data) {
                let msje = data.data.msje;
                $("#ModalCreateFolder").modal('hide');
                messageAlert("Guardado Correctamente", "success", msje);
            },
            error: function(data) {
                console.log("ERROR en la petición");
                console.log(data);
                messageAlert("Ha ocurrido un problema.", "error", "");
            }
        });
    } else {
        $("#errorFolder").html('Debe proporcionar el nombre de la carpeta');
    }
}
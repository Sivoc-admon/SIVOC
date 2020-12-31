$(function() {
    $("#inputName").keypress(function(event) {
        var inputValue = event.charCode;
        if (!(inputValue >= 65 && inputValue <= 122) && (inputValue != 32 && inputValue != 0) && !(inputValue >= 48 && inputValue <= 57)) {
            event.preventDefault();
        }
    });
});

function getFoldersAndFiles(areaId, nivel, idPadre) {
    let level = nivel + 1;
    let selectTag = `#selectNivel${nivel}`;
    let selectVal = $(selectTag).val();
    let selectTagText = $(`${selectTag} option:selected`).text();
    let botonNameTag = `#btnLevel${nivel}`;
    $(botonNameTag).html(`Agregar carpeta dentro de "${selectTagText}"`);
    if (selectVal !== '') {
        $.ajax({
            type: "GET",
            url: `/folder/${areaId}/${level}/${selectVal}`,
            dataType: 'json',
            success: function(data) {
                $(botonNameTag).fadeIn();
                if (data.data.length > 0) {
                    let folders = data.data;
                    let selectHTML = `<select id="selectNivel${level}" class="form-control" onchange="getFoldersAndFiles(${areaId}, ${level})">
                                        <option value="">Seleccione</option>`;
                    for (var k in folders) {
                        let documents = folders[k].area_documents;
                        selectHTML += `<option value="${folders[k].id}">${folders[k].name}</option>`;
                        for (var j in documents) {

                        }
                    }
                    selectHTML += `</select><br>
                    <button id="btnLevel${level}" type="button" class="btn btn-primary form-button" onclick="newFolder(${areaId}, ${level})"
                    style="display:none;">Agregar carpeta</button>`;
                    if ($(`#divNivel${level}`).length) {
                        $(`#divNivel${level}`).html(selectHTML);
                    } else {
                        $(`#divFolders`).append(`<br><div id="divNivel${level}"><br>${selectHTML}</div>`);
                    }
                } else {
                    if ($(`#divNivel${level}`).length) {
                        $(`#divNivel${level}`).remove();
                    }
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
    nivel++;
    $("#inputName").val('');
    $("#formFolder").fadeIn();
    $("#divMsge").html('').hide();
    $("#nivelFolder").val(nivel);
    $("#areaIdFolder").val(areaId);
    $("#ModalCreateFolder").modal('show');
}

function createFolder() {
    $("#errorFolder").html('');
    let folderName = $("#inputName").val();
    let nivel = $("#nivelFolder").val();
    let level = parseInt(nivel) - 1;
    let areaId = $("#areaIdFolder").val();
    let selectTag = `#selectNivel${nivel}`;
    let selectVal = $(selectTag).val();
    if (folderName.trim() !== '') {
        $("#divMsge").html(`<i class="fas fa-circle-notch"></i>
        <br><label class="control-label">Creando carpeta</label>`);
        $("#formFolder").fadeOut();
        $("#divMsge").fadeIn();
        $.ajax({
                    type: "POST",
                    url: `/folder/create/${areaId}/${nivel}`,
                    data: { "folderName": folderName, "_token": $("input[name=_token]").val(), "idFolder": $(`#selectNivel${level}`).val() },
                    dataType: 'json',
                    success: function(data) {
                            let msje = data.data.msje;
                            $("#ModalCreateFolder").modal('hide');
                            messageAlert("Guardado Correctamente", "success", msje);
                            $.ajax({
                                        type: "GET",
                                        url: `/folder/${areaId}/${nivel}/${$(`#selectNivel${level}`).val()}`,
                    dataType: 'json',
                    success: function(data) {
                        if (data.data.length > 0) {
                            let folders = data.data;
                            let selectHTML = `<select id="selectNivel${nivel}" class="form-control" onchange="getFoldersAndFiles(${areaId}, ${nivel})">
                                        <option value="">Seleccione</option>`;
                    for (var k in folders) {
                        let documents = folders[k].area_documents;
                        selectHTML += `<option value="${folders[k].id}">${folders[k].name}</option>`;
                        for (var j in documents) {
                            
                        }
                    }
                    selectHTML += `</select><br>
                    <button id="btnLevel${nivel}" type="button" class="btn btn-primary form-button" onclick="newFolder(${areaId}, ${nivel})"
                    style="display:none;">Agregar carpeta</button>`;
                            /*$(selectTag).empty().append('<option value="">Seleccione</option>');
                            for (var k in folders) {
                                $(selectTag).append(`<option value="${folders[k].id}">${folders[k].name}</option>`);
                                let documents = folders[k].area_documents;
                                
                                /*for (var j in documents) {
        
                                    selectHTML += `
                                <select>
                                    <option></option>
                                </select>
                                `;
                                }

                            }*/
                            if ($(`#divNivel${level}`).length) {
                                $(`#divNivel${level}`).html(selectHTML);
                            } else {
                                $(`#divFolders`).append(`<br><div id="divNivel${level}"><br>${selectHTML}</div>`);
                            }
                            $(selectTag).val(selectVal);
                        } else {
                            console.log("no hay mas carpetas we :(");
                        }
                    },
                    error: function(data) {
                        console.log("ERROR en la petición");
                        console.log(data);
                    }
                });
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
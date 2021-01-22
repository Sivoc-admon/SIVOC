$(function() {
    /*$("#inputName").keypress(function(event) {
        var inputValue = event.charCode;
        if (!(inputValue >= 65 && inputValue <= 122) && (inputValue != 32 && inputValue != 0) && !(inputValue >= 48 && inputValue <= 57)) {
            event.preventDefault();
        }
    });*/

    getFilesLevelZero(0);
});

function getFilesLevelZero(folderId) {
    let areaId = $("#hiddenAriaId").val();
    $.ajax({
        type: "GET",
        url: `/folder2/${areaId}/${folderId}`,
        dataType: 'json',
        success: function(data) {
            let tablaHTML = ``;
            console.log(data);
            for (var k in data) {
                tablaHTML += `<tr>
                <td>${data[k].name}</td>
                <td>${data[k].ruta}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger" onclick="deleteFile('${data[k].name}', ${data[k].id}, ${data[k].folder_area_id})">
                        <i class="fas fa-times"></i>
                    </button>
                    <a class="btn btn-sm btn-warning" href="/file/download/${data[k].id}/${data[k].folder_area_id}">
                        <i class="fas fa-download"></i>
                    </a>
                </td>
                </tr>`;
            }
            $("#tableFiles").empty().html(tablaHTML);
        }
    });
}

function getFoldersAndFiles(areaId, nivel) {
    let level = nivel + 1;
    let selectTag = `#selectNivel${nivel}`;
    let selectVal = $(selectTag).val();
    let selectTagText = $(`${selectTag} option:selected`).text();
    let botonNameTag = `#btnLevel${nivel}`;
    let botonFilesTag = `#files_${areaId}_${nivel}`
    let levels = recorreNiveles();
    console.log(`se borraran los siguientes niveles: ${levels}`);
    borrarDivNiveles(nivel, levels);
    $(botonNameTag).html(`Agregar carpeta dentro de "${selectTagText}"`);
    if (selectVal !== '') {
        $.ajax({
            type: "GET",
            url: `/folder/${areaId}/${level}/${selectVal}`,
            dataType: 'json',
            success: function(data) {
                getFilesLevelZero(selectVal);
                $(botonNameTag).fadeIn();
                $(botonFilesTag).fadeIn();
                if (data.data.length > 0) {
                    let folders = data.data;
                    let selectHTML = `<select id="selectNivel${level}" class="form-control" onchange="getFoldersAndFiles(${areaId}, ${level})">
                                        <option value="">Seleccione</option>`;
                    for (var k in folders) {
                        selectHTML += `<option value="${folders[k].id}">${folders[k].name}</option>`;
                    }
                    selectHTML += `</select><br>
                    <button id="btnLevel${level}" type="button" class="btn btn-primary form-button" onclick="newFolder(${areaId}, ${level})"
                    style="display:none;">Agregar carpeta</button>
                    <input type="file" class="btn btn-warning" id="files_${areaId}_${level}" onchange="newFile(${areaId}, ${level})" multiple style="display:none;"/>`;
                    if ($(`#divNivel${level}`).length) {
                        $(`#divNivel${level}`).html(selectHTML);
                    } else {
                        let pading = 10 * level;
                        $(`#divFolders`).append(`<div id="divNivel${level}" style="padding-left: ${pading}px;"><br>${selectHTML}</div>`);
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
        $(botonFilesTag).hide();
    }
}

function recorreNiveles() {
    var res = 2;
    for (let level = 2; level < 70; level++) {
        if (!$(`#divNivel${level}`).length) {
            res = level;
            break;
        }
    }
    return res;
}

function borrarDivNiveles(nivelx, nivelxx) {
    levelx = nivelx + 1;
    for (let level = levelx; level <= nivelxx; level++) {
        if ($(`#divNivel${level}`).length) {
            console.log(`se borró el nivel: ${level}`);
            $(`#divNivel${level}`).remove();
        }
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
        $("#exampleModalLabel").html('Crear nueva carpeta');
        $("#divMsge").html(`<i class="fas fa-circle-notch fa-spin"></i>
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
                            selectHTML += `<option value="${folders[k].id}">${folders[k].name}</option>`;
                        }
                        selectHTML += `</select><br>
                        <button id="btnLevel${nivel}" type="button" class="btn btn-primary form-button" onclick="newFolder(${areaId}, ${nivel})"
                        style="display:none;">Agregar carpeta</button>
                        <input type="file" class="btn btn-warning" id="files_${areaId}_${nivel}" onchange="newFile(${areaId}, ${nivel})" multiple style="display:none;"/>`;
                            if ($(`#divNivel${nivel}`).length) {
                                console.log("se hizo un html al crear la carpeta");
                                $(`#divNivel${nivel}`).html(selectHTML);
                            } else {
                                let pading = 10 * level;
                                $(`#divFolders`).append(`<div id="divNivel${nivel}" style="padding-left: ${pading}px;"><br>${selectHTML}</div>`);
                            }
                            $(selectTag).val(selectVal);
                        } else {
                            console.log("no hay mas carpetas");
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

function newFile(areaId, nivel){
    let token = $("input[name=_token]").val();
    console.log("ya cambio el input;)");
    let tagInputFiles = `#files_${areaId}_${nivel}`;
    var formData = new FormData();
    let TotalFiles = $(tagInputFiles)[0].files.length; //Total files
    let files = $(tagInputFiles)[0];
    for (let i = 0; i < TotalFiles; i++) {
        formData.append('files' + i, files.files[i]);
    }
    formData.append('TotalFiles', TotalFiles);
    formData.append('_token', token);
    for (var pair of formData.entries()) {
        console.log(pair[0]+ ', ' + pair[1]); 
    }
    let selectNivelTag = `#selectNivel${nivel}`;
    let folderId = (nivel != 0)? $(selectNivelTag).val():0;
    formData.append('folderId', folderId);
    if(TotalFiles > 0){
        $("#exampleModalLabel").html('Subida de archivos');
        $("#divMsge").html(`<i class="fas fa-circle-notch fa-spin"></i>
        <br><label class="control-label">Cargando archivos</label>`);
        $("#formFolder").hide();
        $("#divMsge").show();
        $("#ModalCreateFolder").modal('show');
        $.ajax({
            type:'POST',
            url: `/file/create/${areaId}/${nivel}`,
            data: formData,
            cache:false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: (data) => {
                getFilesLevelZero(folderId);
                $(tagInputFiles).val(null);
                $("#ModalCreateFolder").modal('hide');
                messageAlert("Operación exitosa!", "success", data.success);
            },
            error: function(data){
                console.log(data);
                $("#ModalCreateFolder").modal('hide');
                messageAlert("Ha ocurrido un problema.", "error", data.message);
            }
        });
    }
}

function deleteFile(documentName, documentId, folderId){

    Swal.fire({
        title: `¿Está seguro de eliminar "${documentName}"?`,
        text: "Esta operación ya no se podrá deshacer.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, borrar!',
        cancelButtonText: 'Cancelar',
      }).then((result) => {
          if (result) {
              let token = $("input[name=_token]").val();
              console.log(`token: ${token}`);
            $.ajax({
                type:'POST',
                url: `/file/delete`,
                data: {'_token':token, 'documentId': documentId, 'idFolder':folderId},
                dataType: 'json',
                success: (data) => {
                    getFilesLevelZero(folderId);
                    messageAlert("Operación exitosa!", "success", "Archivo eliminado correctamente");
                },
                error: function(data){
                    console.log(data);
                    messageAlert("Ha ocurrido un problema.", "error", "Ocurrió un error al eliminar eliminar el archivo, intente mas tarde.");
                }
            });
        }
      });
}
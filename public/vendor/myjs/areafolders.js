function getFoldersAndFiles(areaId, nivel) {
    let selectTag = `#selectNivel${nivel}`;
    let selectVal = $(selectTag).val();
    if (selectVal !== '') {
        $.ajax({
            type: "GET",
            url: `/folder/${areaId}/${nivel}`,
            dataType: 'json',
            success: function(data) {
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

                }
            },
            error: function(data) {
                console.log("ERROR en la petición");
                console.log(data);
            }
        });
    }
}


function newFolder(areaId, nivel) {
    console.log(`MODAL==> areaId: ${areaId}, nivel: ${nivel}`);
    $("#nivelFolder").val(nivel);
    $("#areaIdFolder").val(areaId);
    $("#ModalCreateFolder").modal('show');
}
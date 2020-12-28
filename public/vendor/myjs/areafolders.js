function getFoldersAndFiles(areaId, nivel) {
    console.log(`areaId: ${areaId}, nivel: ${nivel}`);
    let selectTag = `#selectNivel${nivel}`;
    let selectVal = $(selectTag).val();
    if (selectVal !== '') {
        $.ajax({
            type: "GET",
            url: `/folder/${areaId}/${nivel}`,
            dataType: 'json',
            success: function(data) {
                $(`#btnLevel${nivel}`).fadeIn();
                let folders = data.data;
                for (var k in folders) {
                    console.log(k, folders[k]);
                }

            },
            error: function(data) {
                console.log("ERROR en la petición");
                console.log(data);
            }
        });
    } else {
        $(`#btnLevel${nivel}`).hide();
    }
}
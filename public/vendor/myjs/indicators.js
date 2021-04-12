function saveTypeIndicator() {
    $.ajax({

        type: "POST",
        url: "/indicators/create/typeIndicator",
        data: $("#formRegisterTypeIndicador").serialize(),
        //dataType: 'json',
        success: function(data) {

            if (data.error == true) {
                messageAlert(data.msg, "error", "");
            } else {

                $("#ModalRegisterTypeIndicador").modal('hide');

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

function saveIndicator() {
    let idArea = $("#sltArea").val();
    let typeIndicator = $("#inputIndicatorType").val();
    let valorOptenido = $("#inputValue").val();
    let fechaRegistro = $("#inputreRegistrationDate").val();
    let data = new FormData();
    let file = $('#fileIndicador')[0];
    data.append("file", file.files[0]);
    data.append("idArea", idArea);
    data.append("typeIndicator", typeIndicator);
    data.append("valorOptenido", valorOptenido);
    data.append("fechaRegistro", fechaRegistro);
    console.log(data);

    //data.append("file", $('#fileIndicador')[0]);
    //$("#formRegisterIndicador").serialize()
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: "/indicators/create",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        //dataType: 'json',
        success: function(data) {

            if (data.error == true) {
                messageAlert(data.msg, "error", "");
            } else {

                $("#ModalRegisterIndicator").modal('hide');

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

function minMax() {
    let indicatorType = $("#inputIndicatorType").val();

    /*$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });*/
    console.log(indicatorType);

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: "/indicators/create/minMax",
        data: { "indicatorType": indicatorType, _token: $('meta[name="csrf-token"]').attr('content') },
        //dataType: 'json',
        success: function(data) {
            console.log(data);

            if (data.error == true) {
                messageAlert(data.msg, "error", "");
            } else {

                $("#minimo").val(data.minMax[0].min);

                $("#maximo").val(data.minMax[0].max);

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

function graficaIndicador() {
    $('#bar').html(''); //remove canvas from container
    $('#bar').html("<canvas id='chartIndicator'></canvas>");
    $.ajax({
        type: "POST",
        url: "/indicators/grafica",
        data: $("#formGraficaIndicador").serialize(),
        //dataType: 'json',
        success: function(data) {
            console.log(data);

            if (data.error == true) {
                messageAlert(data.msg, "error", "");
            } else {
                let valores = [];
                /*data.grafica.forEach(element => {
                    valores.push(element.value);
                });*/
                for (let i = 0; i < 11; i++) {
                    if (i < data.grafica.length) {
                        if (i==data.grafica[i].month-1) {
                            valores[i] = data.grafica[i].value;
                        } else {
                            valores[data.grafica[i].month-1] = data.grafica[i].value;
                            valores[i] = 0;
                            
                        }
                        
                    } else {
                        valores.push(0);
                    }
                    

                }
                console.log(valores);
                let objetivos = {
                    label: 'Valor Objetivo',
                    data: [data.minMax.max,
                        data.minMax.max,
                        data.minMax.max,
                        data.minMax.max,
                        data.minMax.max,
                        data.minMax.max,
                        data.minMax.max,
                        data.minMax.max,
                        data.minMax.max,
                        data.minMax.max,
                        data.minMax.max,
                        data.minMax.max
                    ],
                    backgroundColor: 'rgba(0, 99, 132, 0.6)',
                    borderColor: 'rgba(0, 99, 132, 1)',
                    //yAxisID: "y-axis-density"
                };
                let obtenidos = {
                    label: 'Valor Obtenido',
                    data: valores,
                    backgroundColor: 'rgba(99, 132, 0, 0.6)',
                    borderColor: 'rgba(99, 132, 0, 1)',
                    //yAxisID: "y-axis-gravity"
                };

                let indicators = {
                    labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                    datasets: [objetivos, obtenidos]
                };
                /* let chartOptions = {
                    scales: {
                        xAxes: [{
                            barPercentage: 1,
                            categoryPercentage: 0.6
                        }],
                        yAxes: [{
                            id: "y-axis-density"
                        }, {
                            id: "y-axis-gravity"
                        }]
                    }
                }; */



                $("#ModalGraficaIndicator").modal('hide');

                let ctx = document.getElementById('chartIndicator').getContext('2d');


                let grafica = new Chart(ctx, {
                    type: 'bar',
                    data: indicators,
                    //options: chartOptions
                });

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
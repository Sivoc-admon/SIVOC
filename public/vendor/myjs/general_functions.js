//RESETEA FORMULARIO
$('[data-toggle="tooltip"]').tooltip();

function resetForm(id) {
    document.getElementById(id).reset();
}

//ALERTAS
function messageAlert(title, icon, text) {
    let texto = (text === null || text === '') ? '' : text;
    Swal.fire({
        icon: icon,
        title: title,
        text: texto,
    })
}

//GRAFICAR
function grafica(data, div, tipo) {
    var ctx = document.getElementById(div).getContext('2d');
    var myChart = new Chart(ctx, {
        type: tipo,
        data: {
            labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            datasets: [{
                label: '# of Votes',
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }],
                xAxes: []
            }
        }
    });
}

//formato de tabla
function table(id) {
    $(id).DataTable({
        dom: 'Bfrtip',
        buttons: [
            'csv', 'excel', 'pdf'
        ]
    });
}
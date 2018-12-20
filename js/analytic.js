function doughnut(canvasID, data, labels, colors){

    var chart = new Chart($('#' + canvasID), { type: 'doughnut',
        data: {
            datasets: [{
                backgroundColor: colors,//randomColors(data.length),
                borderColor: $('#backgroundColor').css("background-color"),
                borderWidth: 5,
                data: data,
            }],
            labels: labels,
        },
        options: {
            legend: {
                labels: {
                    fontColor: "white",
                    fontSize: 18
                }
            },
            animation: {
                animateScale: true
            },
        },
    });
}

function recreateDoughnut(canvasID, data, labels, colors){

    var parent = $('#' + canvasID).parent();
    $('#' + canvasID).remove();
    parent.append("<canvas id='" + canvasID + "'></canvas>");
    doughnut(canvasID, data, labels, colors);
}
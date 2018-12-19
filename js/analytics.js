function doughnut(canvasID, data, labels, colors){

    var chart = new Chart($('#' + canvasID), { type: 'doughnut',
        data: {
            datasets: [{
                backgroundColor: colors,
                data: data,
            }],
            labels: labels,
        },
    });
}

function recreateDoughnut(canvasID, data, labels, colors){

    var parent = $('#' + canvasID).parent();
    $('#' + canvasID).remove();
    parent.append("<canvas id='" + canvasID + "'></canvas>");
    doughnut(canvasID, data, labels, colors);
}
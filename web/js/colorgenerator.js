// Returns random number of range min (inclusive) and max (inclusive)
function randomRange(min, max){

    return Math.floor(Math.random() * (max - min + 1) ) + min;
}

function rgb(r, g, b){

    //sd
    return "rgb(" + r + "," + g + "," + b + ")";
}

function randomRGB(){

    return rgb(randomRange(0,255), randomRange(0,255), randomRange(0,255));
}

function randomColors(count){

    var colors = [];
    for (var i = 0; i < count; i++){

        colors[i] = randomRGB();
    }
    return colors;
}

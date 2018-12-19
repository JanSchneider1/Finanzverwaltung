
function disableDates(){
    $("#date_1").prop("disabled", true);
    $("#date_2").prop("disabled", true);
}

function enableDates(){
    $("#date_1").prop("disabled", false);
    $("#date_2").prop("disabled", false);
}

$("#btn_filter").click(function(){
    enableDates();
});

$("#own").click(function(){
    enableDates();
});

$("#day").click(function(){
    var now = new Date();
    $("#date_1").val(now.toISOString().slice(0,10));
    $("#date_2").val(now.toISOString().slice(0,10));
    disableDates();
});

$("#week").click(function(){
    var curr = new Date();
    var firstday = new Date(curr.setDate(curr.getDate() - (curr.getDay() == 0 ? 6 : curr.getDay() - 1 )));
    var lastday = new Date(curr.setDate(curr.getDate() - curr.getDay()+7));
    $("#date_1").val(firstday.toISOString().slice(0,10));
    $("#date_2").val(lastday.toISOString().slice(0,10));
    disableDates();
});

function setDatesMonth(){
    var now = new Date();
    now.setDate(1);
    var next = new Date();
    next.setDate(1);
    next.setMonth(next.getMonth() +1);
    $("#date_1").val(now.toISOString().slice(0,10));
    $("#date_2").val(next.toISOString().slice(0,10));
    disableDates();
}

$("#month").click(function(){setDatesMonth()});

$("#year").click(function(){
    var now = new Date();
    now.setDate(1);
    now.setMonth(0);
    var next = new Date();
    next.setDate(1);
    next.setMonth(0);
    next.setFullYear(next.getFullYear() + 1);
    $("#date_1").val(now.toISOString().slice(0,10));
    $("#date_2").val(next.toISOString().slice(0,10));
    disableDates();
});

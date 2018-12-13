// AJAX (ADD ACCOUNTING)
function addAccounting(accountingForm) {

    var formData = new FormData(accountingForm);
    $.ajax({

        url: "../controller/AccountingController.php",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (accountingJSON) { onResponse_addAccounting(accountingJSON); }
    });
}

// Handle response from --> POST (ADD ACCOUNTING)
function onResponse_addAccounting(accountingJSON){

    var accounting = $.parseJSON(accountingJSON);
    insertAccountingAsTableRow(accounting.accountingID, accounting.date, accounting.name, accounting.categoryName, accounting.isPositive, accounting.value);
}

// Add new table row
function insertAccountingAsTableRow(id, date, name, categoyName, isPositive, value) {

    $('#list_bills').append('<tr id=' + id + '></tr>');
    $('#' + id).append('<td class="accountingDate value">' + date +'</td>');
    $('#' + id).append('<td class="accountingName value">' + name +'</td>');
    $('#' + id).append('<td class="accountingCategory value">' + categoyName +'</td>');
    $('#' + id).append('<td class="accountingValue value ' + formatIsPositive(isPositive) + '">' + formatValue(Math.abs(value), isPositive) +'</td>');
    $('#' + id).append('<td style="text-align: end" class="accountingRemoveBt"><button onclick="deleteAccounting(' + id + ')" class="btn btn-dark"><span class="fas fa-trash-alt"></span></button></td>');
}

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
    var firstday = new Date(curr.setDate(curr.getDate() - curr.getDay() + 1));
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


// Converts accounting value to formatted text (pass 0 or 1 for 'isPositive')
function formatValue(value, isPositive){

    var text = "";
    if (isPositive == 1) { text += "+ "; } else { text += "- "; }
    text += value.toFixed(2) + " €";
    return text;
}

// Formats 'isPositive' to CSS class name (pass 0 or 1 for 'isPositive') -> return 'negative' or 'positive'
function formatIsPositive(isPositive){

    if (isPositive == 1){ return 'positive'; } else return 'negative';
}

// XML-HTTP REQUEST (DELETE ACCOUNTING)
function deleteAccounting(accountingID) {

    //alert(accountingID.toString());
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {

            //Asynch. Stuff
            //alert("Success");
            $('#' + accountingID).remove();
        }
    };
    xhttp.open("DELETE", "../php%20files/AccountingController.php/?id=" + accountingID, false);
    xhttp.send();
    return false;
}
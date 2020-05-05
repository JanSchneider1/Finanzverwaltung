// AJAX (ADD ACCOUNTING)
function addAccounting(accountingForm) {

    var formData = new FormData(accountingForm);

    //default value name
    if (formData.get('addAccounting_name') === ''){

        formData.set("addAccounting_name", $('#dropdownMenu2').text());
    }

    $.ajax({

        url: "../controller/accountingController.php",
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
    location.href='#end';
}

// Add new table row
function insertAccountingAsTableRow(id, date, name, categoyName, isPositive, value) {

    $('#list_bills').append('<tr id=' + id + '></tr>');
    $('#' + id).append('<td class="accountingDate value">' + date +'</td>');
    $('#' + id).append('<td class="accountingName value">' + name +'</td>');
    $('#' + id).append('<td class="accountingCategory value">' + categoyName +'</td>');
    $('#' + id).append('<td class="accountingValue value ' + formatIsPositive(isPositive) + '">' + formatValue(Math.abs(value), isPositive) +'</td>');
    $('#' + id).append('<td style="text-align: end"><button class="btn hvr-reveal" onclick="deleteAccounting(' + id + ')"><span class="fas fa-trash-alt"></button></td>');
}

// Converts accounting value to formatted text (pass 0 or 1 for 'isPositive')
function formatValue(value, isPositive){

    var text = "";
    if (isPositive === 1) { text += "+ "; } else { text += "- "; }
    text += value.toFixed(2) + " €";
    return text;
}

// Formats 'isPositive' to CSS class name (pass 0 or 1 for 'isPositive') -> return 'negative' or 'positive'
function formatIsPositive(isPositive){

    if (isPositive === 1){ return 'positive'; } else return 'negative';
}

// XML-HTTP REQUEST (DELETE ACCOUNTING)
function deleteAccounting(accountingID) {

    //alert(accountingID.toString());
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {

            //Asynch. Stuff
            //alert("Success");
            $('#' + accountingID).remove();
        }
    };
    xhttp.open("DELETE", "../controller/accountingController.php/?id=" + accountingID, false);
    xhttp.send();
    
    return false;
}

//Enables Submit-Button to trigger 'AddAccoutning()' when enter is pressed while button focused
$(document).ready(function() {
    $('.submit_on_enter').mouseover(function(event){
        this.focus();
    });

    $('.submit_on_enter').keydown(function(event) {
        if (event.keyCode == 13) {
            addAccounting(this.form);
            return false;
        }
    });
});
// AJAX (ADD FIXUM)
function addFixum(fixumForm) {

    var formData = new FormData(fixumForm);
    $.ajax({

        url: "../controller/fixumController.php",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (fixumJSON) { onResponse_addFixum(fixumJSON); }
    });
}

// Handle response from --> POST (ADD FIXUM)
function onResponse_addFixum(fixumJSON){

    var fixum = $.parseJSON(fixumJSON);
    insertfixumAsTableRow(fixum.fixumID, fixum.startDate, fixum.lastUsedDate, fixum.name, fixum.frequency, fixum.categoryName, fixum.isPositive, fixum.value);
}

// Add new table row
function insertfixumAsTableRow(id, startDate, lastUsedDate, name, frequency, categoryName, isPositive, value) {

    $('#list_fixa').append('<tr id=' + id + '></tr>');
    $('#' + id).append('<th>' + startDate +'</th>');
    $('#' + id).append('<th>' + lastUsedDate +'</th>');
    $('#' + id).append('<th>' + name +'</th>');
    $('#' + id).append('<th>' + frequency +'</th>');
    $('#' + id).append('<th>' + categoryName +'</th>');
    $('#' + id).append('<th class="' + formatIsPositive(isPositive) + '">' + formatValue(Math.abs(value), isPositive) +'</th>');
    $('#' + id).append('<th style="text-align: end" class="fixumRemoveBt"><button onclick="deleteFixum(' + id + ')" class="btn btn-dark"><span class="fas fa-trash-alt"></span></button></th>');
}

// Converts fixum value to formatted text (pass 0 or 1 for 'isPositive')
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

// XML-HTTP REQUEST (DELETE FIXUM)
function deleteFixum(fixumID) {

    //alert(fixumID.toString());
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {

            $('#' + fixumID).remove();
        }
    };
    xhttp.open("DELETE", "../controller/fixumController.php/?id=" + fixumID, false);
    xhttp.send();
    return false;
}
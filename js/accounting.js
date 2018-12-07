//XML-HTTP REQUEST (POST ACCOUNTING)
function addAccounting(accountingForm) {

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {

           //Asynch. Stuff
             //alert("Success");
        }
    };
    xhttp.open("POST", "../php%20files/AccountingController.php", false);
    var formData = new FormData(accountingForm);
    xhttp.send(formData);
    return false;
}

//XML-HTTP REQUEST (DELETE ACCOUNTING)
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
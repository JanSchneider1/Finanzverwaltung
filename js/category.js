// AJAX (ADD CATEGORY)
function addCategory(categoryForm) {

    var formData = new FormData(categoryForm);
    $.ajax({

        url: "../controller/categoryController.php",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (categoryJSON) { onResponse_addCategory(categoryJSON); }
    });
}

// Handle response from --> POST (ADD CATEGORY)
function onResponse_addCategory(categoryJSON){

    var category = $.parseJSON(categoryJSON);
    insertCategoryAsTableRow(category.categoryID, category.name);
}

// Add new table row
function insertCategoryAsTableRow(id, name) {

    $('#list_categories').append('<tr id=' + id + '></tr>');
    $('#' + id).append('<th class="value"><input class="input-group-text" style="background: #31343b; color: white;" id="category_' + id + '" type="text" value="' + name + '"></th>');
    $('#' + id).append('<th style="text-align: end"><button class="btn btn-dark hvr-reveal" onclick="alterCategory(' + id + ')"><span class="fas fa-check"></span></button> <button class="btn btn-dark hvr-reveal" onclick="deleteCategory(' + id + ')"><span class="fas fa-trash-alt"></span></button></th>');
}

// XML-HTTP REQUEST (DELETE CATEGORY)
function deleteCategory(categoryID) {

    //alert(categoryID.toString());
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {

            $('#' + categoryID).remove();
        }
    };
    xhttp.open("DELETE", "../controller/categoryController.php/?id=" + categoryID, false);
    xhttp.send();
    return false;
}

// XML-HTTP REQUEST (UPDATE CATEGORY)
function updateCategory(categoryID) {

    var name = $('#category_' + categoryID).val();
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
        }
    };
    xhttp.open("PUT", "../controller/categoryController.php/?id=" + categoryID + "&name=" + name, false);
    xhttp.send();
    return false;
}
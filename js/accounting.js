//XML-HTTP REQUEST (BILL POST)
	function addNewBill(billForm) {
		
  		var xhttp = new XMLHttpRequest();
  		xhttp.onreadystatechange = function() {
    	if (this.readyState == 4 && this.status == 200) {
    		
      		//Clone template
      		var bill = $('#billTemplate').clone();
      		bill.toggle();
      		//Copy values from form data
      		bill.find("#billValue").text(formData.get('billValue'));
      		bill.find("#billDescription").text(formData.get('billDescription'));
      		bill.find("#billDate").text(formData.get('billDate'));
      		bill.find("#billTags").text(formData.getAll('billTags'));
      		//bill.find("#billDelete").attr("th:onclick", "");
      		//Add cloned template to add new bill (user-side)
      		$("#list_bills").append(bill);
    	}
  	};
  	xhttp.open("POST", billForm.action, false);
  	var formData = new FormData(billForm);
  	xhttp.send(formData);
  	return false;
	}
	
	/*
	function getDateAsFormat(date){
		
    	SimpleDateFormat formater = new SimpleDateFormat("EE --> dd.MMMM yyyy");
    	return formater.format(date);
	}*/
	
	function deleteBill(billId){
  		
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			
			//Remove bill from page
			$('#list_bills').children().each(function(){
				var value = $(this).attr("value");
				if (value == billId){
					$(this).remove();
				}
			});
		}
		};
		xhttp.open("DELETE", "/accountings/1", false);
		var formData = new FormData();
		formData.append("billId", billId);
		xhttp.send(formData);
		return false;
  	}
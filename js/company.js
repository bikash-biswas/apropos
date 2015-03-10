
function addCompany(){

	var dialog=$( "#addcompanydialog" ).dialog({'width':'auto','height':'auto'}).show();
	var companyName=$( "#addcompanyName" ).val("");
	
	$( "#addCompanyButton" ).bind( "click", function() {
		if(companyName==""){
			alert("No Company Name Provided");
		}else{
			//$(selector).post(URL,data,function(returndata,httpstatus,xhr),dataType)
			//data=post data
			//xhr=contains the XMLHttpRequest object
			//dataType
			//$.post
			
			
			$.post("lib/managecompany.php",
					  {
					    "companyName":"\""+companyName+"\"",
					  },
					  function(data,status){
						  if(status =="success"){
							  dialog.dialog('close');
							  var successDialog = $('<div id="SuccessDialog"><P>Company has been created Successfully in Database.</P></div>');
							  successDialog.dialog({ title: "Success Message",
				                    modal: true }).show();
						  }
				});
		}
	});
}
function editCompany(){
	$( "#editcompanyName" ).val(arguments[1]);
	$( "#editcompanydialog" ).dialog({'width':'auto','height':'auto'}).show();
}

function deleteCompany(){
	$( "#deletecompanyName" ).text(arguments[1]);
	$( "#deletecompanydialog" ).dialog({'width':'auto','height':'auto'}).show();
}


function convertToJson( valueHash){
	
}

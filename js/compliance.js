/**
* Utility functions
*/

//Send the feedback message
function sendFeedbackMessage(){
	var subject=encodeURIComponent(arguments[0]);
	var message=encodeURIComponent(arguments[1]);
	var postData = {};
	postData['subject']=subject;
	postData['message']=message;

	$.post( "lib/sendmessage.php",postData, function( jsonData ) {
			 $('<div class="nowrap" style="width:500px;">Feedback sent successfully.</div>').dialog({
					modal: true,
					title: "Success"
			 }).show();
		})
		.fail(function() {
			$('<div class="nowrap" style="width:500px;">Error happened while sending feedback. Your E-mail addeess may not be present or Unit not selected.</div>').dialog({
				modal: true,
				title: "Error"
			 }).show();
			
		});
}
/* Get the units belongs to a company using ajax call */
function getUnit(){
	var company_id=$("#company").val();
	if(company_id ==""){
		$("#unit").empty();
		$("#unit").html("<option>--Select One--</option>");
	}else {
		var companyStr="lib/unit.php?company="+company_id;
		
		$.ajax({
			url: companyStr,
		}).done(function( data ) {
				$("#unit").empty();
				var optionStr=creationOptionStr(data);
				$("#unit").html(optionStr);
		});
	}
}

function creationOptionStr(jsonStr){
	var parsedObj = jQuery.parseJSON(jsonStr);
	var optionStr="<option>--Select One--</option>";
	if	(	$.isArray(parsedObj) ){
		for	(index = 0; index < parsedObj.length; index++) {
			var unitObj=parsedObj[index];
			optionStr += "<option value=\""+unitObj.id+"\">"+unitObj.value +"</option>";
		} 
	}
	return optionStr;
}
// --------------------------------- Create an Entity through AJAX call -----------------------

/*
 * 
 *Create a Create Entity dialog
 *List of arguments
 *1) Dialog Title
 *2) URL from where componet JSON will be fetched. JSON form  [ {"id":"COMPONENT ID","LABEL":"COMPONENT LABEL"},{...}]
 *3) URL at which data is being inserted into table. POST call
 */
function createDialog() {
	var titleStr =arguments[0];
	var infoUrl=arguments[1];
	var postUrl=arguments[2];
	var callback=arguments[3];
	
	$.getJSON(infoUrl,function(components,status){
		var createDialog = $('<div class="nowrap" style="width:500px;" id="createDG"></div>');
		
		var displayString='<table>';
		displayString +='<tbody>';
		for(var counter=0;counter<components.length;counter++){
			var compId=components[counter].id;
			var complabel=components[counter].label;
			var compType=components[counter].type;
			var compValue=(components[counter].value==undefined)?"":components[counter].value;
			
			displayString +=("<tr><td style='vertical-align:top'>"+complabel+"</td><td>");
			if(compType == "input_text"){
				displayString +=('<input type="text" id="'+compId+'" name="'+compId+'" value="'+compValue+'"/>');
			}else if(compType == "input_select"){
				displayString +=('<select id="'+compId+'" name="'+compId+'">');
				compValue.forEach(function(cValue,index,array){
					displayString +=('<option value="'+cValue.op_value+'">'+cValue.op_label+'</option>');
				});				
				displayString +=('</select>');
			}else if(compType == "input_radio"){
			}else if(compType == "input_checkbox"){
			}else if(compType == "checkbox_group"){
				var checkBoxObjLen=compValue.length;
				if(checkBoxObjLen >0){
					displayString +="<table>";
					for (var chkBoxCounter=0;chkBoxCounter<checkBoxObjLen;chkBoxCounter++){
						var chkBoxObj=compValue[chkBoxCounter];
						var selectedString=chkBoxObj.checked=="true"?"checked":"";
						displayString +="<tr><td><input type='checkbox' name='"+compId+"' id='"+compId+"' value='"+chkBoxObj.value+"' "+selectedString+">"+chkBoxObj.text+"</td></tr>";
					}
					displayString +="</table>";
				}			
			}
			displayString +=("</td></tr>");
			
		}
		displayString +='</tbody>';
		displayString +="</table>";
		createDialog.append($(displayString));
		createDialog.dialog({
			title : titleStr,
			modal : true,
			width: "auto",
			buttons:[ 
				{
					text: "Create",
					click: function() {
						var jsonData = {};
						for(var counter=0;counter<components.length;counter++){
							var id=components[counter].id;
							var compIdSelector="#"+id;
							var value="";
							//Check if it is a group of check boxes
							if($(compIdSelector).is(':checkbox')){
								var checkBoxValues = $(compIdSelector+":checked").map(function(){
									return this.value;
								}).toArray();
								value=checkBoxValues;
							}else{//Single element value
								value=$(compIdSelector).val();
							}
							jsonData[id]=value;
						}
						jsonData["action"]="create";
					
						$.post( postUrl+"",jsonData, function( jsonData ) {
								createDialog.dialog('destroy').remove();
								 $('<div class="nowrap" style="width:500px;">Data inserted successfully.</div>').dialog({
								        modal: true,
								        title: "Success",
										width: "auto"
								 }).show();
								 eval (callback);
							})
							.fail(function() {
								createDialog.dialog('destroy').remove();
								 $('<div class="nowrap" style="width:500px;">Error happened while inserting data.</div>').dialog({
								        modal: true,
								        title: "Error",
										width: "auto"
								 }).show();
								
							});
						}
				},
				{
					text: "Cancel",
					click: function() {
						$( this ).dialog( "close" );
					}
				}
			]
		}).show();
		
	  }) .fail(function() {
			 $('<div class="nowrap" style="width:500px;">Error happened while fetching data.</div>').dialog({
			        modal: true,
			        title: "Error",
					width: "auto"
			 }).show();
	});
}

//--------------------------------- Update an Entity through AJAX call -----------------------


 /*
  * 
  *Update Entity dialog
  *List of arguments
  *1) Dialog Title
  *2) URL from where componet JSON will be fetched. JSON form  [ {"id":"COMPONENT ID","label":"COMPONENT LABEL","value":"COMPONENT VALUE"},{...}]
  *3) URL at which data is being inserted into table. POST call
  *4) Primary key of the Entity
  */
 function updateDialog() {
 	var titleStr =arguments[0];
 	var infoUrl=arguments[1];
 	var postUrl=arguments[2];
 	var key=arguments[3];
	var callback=arguments[4];
	
 	$.getJSON(infoUrl+"?key="+key,function(components,status){
 		var updateDialog = $('<div class="nowrap" style="width:700px;" id="updateDG"></div>');
 		
 		var displayString='<table>';
 		displayString +='<tbody>';
 		for(var counter=0;counter<components.length;counter++){
 			var compId=components[counter].id;
 			var complabel=components[counter].label;
			var compType=components[counter].type;
 			var compValue=(components[counter].value==undefined)?"":components[counter].value;
			
  			displayString +=("<tr><td style='vertical-align:top'>"+complabel+"</td><td>");
			if(compType == "input_text"){
				displayString +=('<input type="text" id="'+compId+'" name="'+compId+'" value="'+compValue+'"/>');
			}else if(compType == "input_select"){
			}else if(compType == "input_radio"){
			}else if(compType == "input_checkbox"){
			}else if(compType == "checkbox_group"){
				var checkBoxObjLen=compValue.length;
				if(checkBoxObjLen >0){
					displayString +="<table>";
					for (var chkBoxCounter=0;chkBoxCounter<checkBoxObjLen;chkBoxCounter++){
						var chkBoxObj=compValue[chkBoxCounter];
						var selectedString=chkBoxObj.checked=="true"?"checked":"";
						displayString +="<tr><td><input type='checkbox' name='"+compId+"' id='"+compId+"' value='"+chkBoxObj.value+"' "+selectedString+">"+chkBoxObj.text+"</td></tr>";
					}
					displayString +="</table>";
				}
			}
			displayString +=("</td></tr>");
 		}
 		displayString +='</tbody>';
 		displayString +="</table>";
 		updateDialog.append($(displayString));
 		updateDialog.dialog({
 			title : titleStr,
 			modal : true,
			width: "auto",
 			buttons:[ 
 				{
 					text: "Update",
 					click: function() {
 						var jsonData = {};
 						for(var counter=0;counter<components.length;counter++){
 							var id=components[counter].id;
 							var compIdSelector="#"+id;
							var value="";
							//Check if it is a group of check boxes
							if($(compIdSelector).is(':checkbox')){
								var checkBoxValues = $(compIdSelector+":checked").map(function(){
									return this.value;
								}).toArray();
								value=checkBoxValues;
							}else{//Single element value
								value=$(compIdSelector).val();
							}
  							jsonData[id]=value;
 						}
 						jsonData["key"]=key;
 						jsonData["action"]="update";
 					
 						$.post( postUrl,jsonData, function( jsonData ) {
 							updateDialog.dialog('destroy').remove();
 								 $('<div class="nowrap" style="width:500px;">Data updated successfully.</div>').dialog({
 								        modal: true,
 								        title: "Success",
										width: "auto"
 								 }).show();
 								 eval(callback);
 							})
 							.fail(function() {
 								updateDialog.dialog('destroy').remove();
 								 $('<div class="nowrap" style="width:500px;">Error happened while updating data1.</div>').dialog({
 								        modal: true,
 								        title: "Error",
										width: "auto"
 								 }).show();
 								
 							});
 						}
 				},
 				{
 					text: "Cancel",
 					click: function() {
 						$( this ).dialog( "close" );
 					}
 				}
 			]
 		}).show();
 		
 		}) .fail(function() {
 			 $('<div class="nowrap" style="width:500px;">Error happened while fetching data2.</div>').dialog({
 			        modal: true,
 			        title: "Error",
					width: "auto"
 			 }).show();
 	});
 }
 
//--------------------------------- Delete an Entity through AJAX call -----------------------


 /*
  * 
  *Delete Entity dialog
  *List of arguments
  *1) Dialog Title
  *2) URL from where componet JSON will be fetched. JSON form  [ {"id":"COMPONENT ID","label":"COMPONENT LABEL","value":"COMPONENT VALUE"},{...}]
  *3) URL at which data is being inserted into table. POST call
  *4) Primary key of the Entity
  */
 function deleteDialog() {
 	var titleStr =arguments[0];
 	var infoUrl=arguments[1];
 	var postUrl=arguments[2];
 	var key=arguments[3];
	var callback=arguments[4];
	
 	$.getJSON(infoUrl+"?key="+key,function(components,status){
 		var deleteDialog = $('<div class="nowrap" style="width:700px;" id="deleteDG"></div>');
 		
 		var displayString='<table>';
 		displayString +='<tbody>';
 		for(var counter=0;counter<components.length;counter++){
 			var compId=components[counter].id;
 			var complabel=components[counter].label;
			var compType=components[counter].type
			var compValue=(components[counter].value==undefined)?"":components[counter].value;
 			
 			displayString +=("<tr><td style='vertical-align:top'>"+complabel+"</td><td>");
			if(compType == "input_text"){
				displayString +=('<input type="text" id="'+compId+'" name="'+compId+'" value="'+compValue+'" disabled="true"/>');
			}else if(compType == "input_select"){
			}else if(compType == "input_radio"){
			}else if(compType == "input_checkbox"){
			}else if(compType == "checkbox_group"){
				var checkBoxObjLen=compValue.length;
				if(checkBoxObjLen >0){
					displayString +="<table>";
					for (var chkBoxCounter=0;chkBoxCounter<checkBoxObjLen;chkBoxCounter++){
						var chkBoxObj=compValue[chkBoxCounter];
						var selectedString=chkBoxObj.checked=="true"?"checked":"";
						displayString +="<tr><td><input type='checkbox' name='"+compId+"[]' value='"+chkBoxObj.value+"' "+selectedString+">"+chkBoxObj.text+"</td></tr>";
					}
					displayString +="</table>";
				}
			}
			displayString +=("</td></tr>");
 		}
 		displayString +='</tbody>';
 		displayString +="</table>";
 		deleteDialog.append($(displayString));
 		deleteDialog.dialog({
 			title : titleStr,
 			modal : true,
			width:"auto",
 			buttons:[ 
 				{
 					text: "Delete",
 					click: function() {
 						var jsonData = {};
 						for(var counter=0;counter<components.length;counter++){
 							var id=components[counter].id;
 							var compIdSelector="#"+id;
							var value="";
							//Check if it is a group of check boxes
							if($(compIdSelector).is(':checkbox')){
								var checkBoxValues = $(compIdSelector+":checked").map(function(){
									return this.value;
								}).toArray();
								value=checkBoxValues;
							}else{//Single element value
								value=$(compIdSelector).val();
							}
 							jsonData[id]=value;
 						}
 						jsonData["key"]=key;
 						jsonData["action"]="delete";
 					
 						$.post( postUrl,jsonData, function( jsonData ) {
	 						deleteDialog.dialog('destroy').remove();
							if(jsonData.status=="success"){
								 $('<div class="nowrap" style="width:500px;">Data deleted successfully.</div>').dialog({
								        modal: true,
								        title: "Success",
										width: "auto"
								 }).show();
								 eval (callback);
 							}else{
								 $('<div class="nowrap" style="width:500px;">Error happened while deleting data.</div>').dialog({
								        modal: true,
								        title: "Error",
										width: "auto"
								 }).show();
								
 							}
 							})
 							.fail(function() {
 								deleteDialog.dialog('destroy').remove();
 								 $('<div class="nowrap" style="width:500px;">Error happened while deleting data.</div>').dialog({
 								        modal: true,
 								        title: "Error",
										width: "auto"
 								 }).show();
 								
 							});
 						}
 				},
 				{
 					text: "Cancel",
 					click: function() {
 						$( this ).dialog( "close" );
 					}
 				}
 			]
 		}).show();
 		
 		}) .fail(function() {
 			 $('<div class="nowrap" style="width:500px;">Error happened while fetching data.</div>').dialog({
 			        modal: true,
 			        title: "Error",
					width: "auto"
 			 }).show();
 	});
 }
 function changeCompany(){
	var companyId=arguments[0];
	var postData = {};
	postData['companyid']=companyId;

	$.post( "lib/setcompany.php",postData, function( data ) {
		 var jsondata=jQuery.parseJSON(data);
		 $("#selectedCompanyName").text(jsondata.companyname);
		 $("#selectedUnitName").text("Not yet selected");
		 updateDetails();
		 $('<div class="nowrap" style="width:500px;">Company set successfully.</div>').dialog({
				modal: true,
				title: "Success",
				width: "auto"
		 }).show();
	})
	.fail(function() {
		$('<div class="nowrap" style="width:500px;">Error happened while setting Company.</div>').dialog({
			modal: true,
			title: "Error",
			width: "auto"
		 }).show();
			
	});
 }
 function changeUnit(){
 	var companyId=arguments[0];
	var unitId=arguments[1];
	var postData = {};
	postData['companyid']=companyId;
	postData['unitid']=unitId;

	$.post( "lib/setcompany.php",postData, function( data ) {
		 var jsondata=jQuery.parseJSON(data);
		 $("#selectedCompanyName").text(jsondata.companyname);
		 $("#selectedUnitName").text(jsondata.unitname);
		 updateDetails();
		 $('<div class="nowrap" style="width:500px;">Unit set successfully.</div>').dialog({
				modal: true,
				title: "Success",
				width: "auto"
		 }).show();
	})
	.fail(function() {
		$('<div class="nowrap" style="width:500px;">Error happened while setting Unit.</div>').dialog({
			modal: true,
			title: "Error",
			width: "auto"
		 }).show();
			
	});
}
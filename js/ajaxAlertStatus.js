// JavaScript Document
function toggleStatus(id,status,user_id){
			
           if (status == 0) statusToggle = 1;
		   if (status == 1) statusToggle = 0;
		   $.ajax({
                  url: 'index.php?r=alert/ajaxStatus',
				  type: "POST",
				  data: "status="+statusToggle+"&id="+id+"&user_id="+user_id,
				})
				.done(function(data) {//if( console && console.log ) {console.log("found: "+ found)};
									
									})
				.fail(function() { alert("Couldn't Update the status");})
		             
		
	
}
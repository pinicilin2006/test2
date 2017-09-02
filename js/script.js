$(document).ready(function(){
//обработка формы добавления записи
    $('#main_form').submit(function( event ) {
		var a = $("#main_form").serialize();
		$.ajax({
		  type: "POST",
		  url: 'ajax/message_add.php',
		  data: a,
		  success: function(data) {
		  	if(data=='success'){
		  		$('#add_message_modal').modal('hide');
		  		setTimeout('window.location.reload()', 200)
		  	} else {
			  	$("#result_message").slideUp(50);
			  	$("#result_message").html(data);
			  	$("#result_message").slideDown(100);
		  	}
		  }
		});
    	return false;
    });
});
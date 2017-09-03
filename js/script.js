$(document).ready(function(){
//Обработка модального окна добавления записи при открытие
	$('#add_message_modal').on('show.bs.modal', function (event) {
	  var button = $(event.relatedTarget); 
	  var content = button.data('content');
	  $('#parent').val(content);
	})

//Обработка модального окна редактирования записи при открытие
	$('#edit_message_modal').on('show.bs.modal', function (event) {
	  var button = $(event.relatedTarget); 
	  var id_message = button.data('content');
	  $('#edit_user_message').val($('#'+id_message).html());
	  $('#id_message').val(id_message);
	})

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
//обработка формы редактирования записи
    $('#edit_form').submit(function( event ) {
		var a = $("#edit_form").serialize();
		$.ajax({
		  type: "POST",
		  url: 'ajax/message_edit.php',
		  data: a,
		  success: function(data) {
		  	if(data=='success'){
		  		$('#edit_message_modal').modal('hide');
		  		setTimeout('window.location.reload()', 200)
		  	} else {
			  	$("#edit_result_message").slideUp(50);
			  	$("#edit_result_message").html(data);
			  	$("#edit_result_message").slideDown(100);
		  	}
		  }
		});
    	return false;
    });    
});
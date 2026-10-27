jQuery(document).ready(function($){
	 // We'll pass this variable to the PHP function example_ajax_request
    
	$('body').on('click', '.rfq-continue', function(event){


		event.preventDefault();

		var rfq_url = $(this).attr('href');

		
		$.ajax({
			url: hatt_params.ajax_url,
			data: {
				'action':'continue_to_rfq',
			},
			success:function(data) {
				if(data){
					 window.location.href = rfq_url;
				}else{
					alert('Please select your vehicle model or tyre size.');
				}
				
			},
			error: function(errorThrown){
				console.log(errorThrown);
			}
		});


	});


	$('body').on('click', '.input_checkbox', function(i,e){
		
		var item_title = $(this).attr('attr_title');
		var item_id = $(this).attr('attr_id');
		var is_checked = $(this).attr('checked');
		var set_list = "off";


		if( is_checked == 'checked'  ){
			set_list = "on";
		}else{
			set_list = "off";
		}
		
		// This does the ajax request
		$.ajax({
			url: hatt_params.ajax_url,
			data: {
				'type':'POST',
				'action':'rfq_ajax_set_items',
				'item_title' : item_title,
				'item_id' : item_id,
				'set_list' : set_list
			},
			success:function(data) {
				// This outputs the result of the ajax request
				//console.log("here"+data);
			},
			error: function(errorThrown){
				console.log(errorThrown);
			}
		});
	});

	
	$('.rfq-remove').click(function(){
		var item_id = $(this).attr('id');
		
		console.log(item_id);
		
		$.ajax({
			url: hatt_params.ajax_url,
			data: {
				'type':'POST',
				'action':'rfq_ajax_set_items',
				'item_title' : '',
				'item_id' : item_id,
				'set_list' : 'off'
			},
			success:function(data) {
				//removes the tyre item from the form list
				$('.rfq-selected-tyres #'+item_id).fadeOut("slow");
			},
			error: function(errorThrown){
				console.log(errorThrown);
			}
		});
	});
	
	//unsets the session for tyres listing
	$('#btn-submit-rfq').click(function(){
		
		var selected = $('#selected-tyres ul li div :first span').html()
		console.log(selected);
		$('#tyres-list').val(selected);
		
		$.ajax({
			url: hatt_params.ajax_url,
			data: {
				'type':'POST',
				'action':'unset_tyre_list',
			},
			success:function(data) {
				//removes the tyre item from the form list
				console.log(data);
			},
			error: function(errorThrown){
				console.log(errorThrown);
			}
		});
		
		// scroll to top when validation error
		setTimeout(function() {
			var invalid=$("form.wpcf7-form").hasClass("invalid");
			// console.log("invalid",invalid);
			if(invalid){
				$(window).scrollTop($('.wpcf7-form').offset().top -50 );
			}
		}, 500);


	});
		 
	$.ajax({
		url: hatt_params.ajax_url,
		data: {
			'type':'POST',
			'action':'get_tyre_list',
		},
		success:function(data) {
			//removes the tyre item from the form list
			console.log(data);
			$('#tyres-list').val(data);
		},
		error: function(errorThrown){
			console.log(errorThrown);
		}
	});
	
	$.ajax({
		url: hatt_params.ajax_url,
		data: {
			'type':'POST',
			'action':'get_vehicle_filters',
		},
		success:function(data) {
			//removes the tyre item from the form list
			console.log(data);
			$('#vehicle-filters').val(data);
		},
		error: function(errorThrown){
			console.log(errorThrown);
		}
	});
	
	//for compare checkbox
	/*$('.check .input_checkbox').click(function(){
		var is_checked = $(this).attr('checked');
		var item_title = $(this).attr('attr_title');
		var item_id = $(this).attr('attr_id');
			
		if(is_checked!="checked"){ //add to tyre list session
			// This does the ajax request
			$.ajax({
				url: hatt_params.ajax_url,
				data: {
					'type':'POST',
					'action':'rfq_ajax_set_items',
					'item_title' : item_title,
					'item_id' : item_id,
					'set_list' : "on"
				},
				success:function(data) {
					// This outputs the result of the ajax request
					console.log(data);
				},
				error: function(errorThrown){
					console.log(errorThrown);
				}
			});
		}
		else{ //remove from tyre list session
			console.log("not checked!");
		}
	});*/
	
});
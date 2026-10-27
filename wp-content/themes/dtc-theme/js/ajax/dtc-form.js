(function($, window, document, undefined) {
    "use strict";

    $.fn.chained = function(parent_selector, options) {

        return this.each(function() {

            /* Save this to child because this changes when scope changes. */
            var child   = this;
            var backup = $(child).clone();

            /* Handles maximum two parents now. */
            $(parent_selector).each(function() {
                $(this).bind("change", function() {
                    updateChildren();
                });

                /* Force IE to see something selected on first page load, */
                /* unless something is already selected */
                if (!$("option:selected", this).length) {
                    $("option", this).first().attr("selected", "selected");
                }

                /* Force updating the children. */
                updateChildren();
            });

            function updateChildren() {
                var trigger_change = true;
                var currently_selected_value = $("option:selected", child).val();

                /* Also check for first parent without subclassing. */
                /* TODO: This should be dynamic and check for each parent */
                /*       without subclassing. */
                var first;
                if ($.isArray(parent_selector)) {
                    first = $(parent_selector[0]).first();
                } else {
                    first = $(parent_selector).first();
                }
                var selected_first = $("option:selected", first).val();

                // Paul
                if (selected_first === "") {
                    $(child).prop("disabled", true);
                    $(child).val('');
                } else {
                    $(child).prop("disabled", false);
                    $(child).val('');
                }
                if (trigger_change) {
                    $(child).trigger("change");
                }
                // Paul
            }
        });
    };

    /* Alias for those who like to use more English like syntax. */
    $.fn.chainedTo = $.fn.chained;

    /* Default settings for plugin. */
    $.fn.chained.defaults = {};

})(window.jQuery || window.Zepto, window, document);

jQuery( document ).ready(function(){
	var $ = jQuery;
	const d = new Date();
	let ms = d.getMilliseconds()

	var states_dropdown = $('.states');
	var areas_dropdown = $('.areas');
	var addr_states_dropdown = $('.addr-states');
	var addr_areas_dropdown = $('.addr-areas');

	var find_retailer = $('.find_retailer');
	var dtc_tyres = $('input[name=dtc_tyres]').val().split(",");

	// (phone input mask removed: it was a single country's number format)

	var original_label =  $('input[type=submit]').val();

	//reset onload
	areas_dropdown.find("option:gt(0)").remove();
	addr_areas_dropdown.find("option:gt(0)").remove();

	
	// GET STORE SLUG
	// QR CODE RELATED
	var slug = $('#store_slug').val();

	if(slug !== 'other' && slug !== '') {
		var data = [];
	    data.push({ name: "security",  value: $('input#ajax-nonce').val() });
		data.push({ name: "store_slug" ,  value: $('#store_slug').val() });
		data.push({ name: "action" ,  value: 'dtc_get_store_area_state' });
	        $.ajax({
	            type: 'POST',
	            url: hatt_params.ajax_url,
	            data: data,
	            dataType: 'json'
	        })
	        .done(function(result){
			if(result['province'] !== '' && result['area'] !== '' && result['store'] !== '') {
	        	$('#province').empty();
	        	$('#area').empty();
	        	$('#find_retailer').empty(); 
		    	var state = document.createElement('option');
			    state.value = result['state'];
			    state.innerHTML = result['state'];
			    document.getElementById('province').appendChild(state);

			    var area = document.createElement('option');
			    area.value = result['area'];
			    area.innerHTML = result['area'];
			    document.getElementById('area').appendChild(area);
			    $('#area').prop('disabled',false);

			    var find_retailer = document.createElement('option');
			    find_retailer.value = result['store'];
			    find_retailer.innerHTML = result['store'];
			    document.getElementById('find_retailer').appendChild(find_retailer);
			    $('#find_retailer').prop('disabled',false);
			}
	        })
	}


	// for store address
	$.getJSON(hatt_params.theme_url + '/js/'+hatt_params.locale+'-location-filter.json?r=' + ms, function(result){

		var locations = result.location;
		var sorted_location = {};
		Object.keys(locations).sort().forEach(function(key) {
		  sorted_location[key] = locations[key];
		});


		$.each( sorted_location , function ( state ){
			addr_states_dropdown.append( $('<option></option>').val(state).html(state));
			states_dropdown.append( $('<option></option>').val(state).html(state));

		});

		areas_dropdown.attr('disabled','disabled');
		addr_areas_dropdown.attr('disabled','disabled');
		find_retailer.attr('disabled','disabled');


		addr_states_dropdown.on('change',function(){

			var selected_state = $(this).val();

			if(locations[selected_state] != undefined && locations[selected_state] != ''){
				// Remove disable when province changes
				addr_areas_dropdown.find("option:gt(0)").remove();
				addr_areas_dropdown.attr('disabled', false);

				$.each( locations[selected_state] , function ( index , area ){
					addr_areas_dropdown.append($('<option></option>').val(area).html(area));
				});
				// addr_areas_dropdown.append($('<option value=OTHERS>Others</option>'));

			} else {
				addr_areas_dropdown.find("option:gt(0)").remove();
				addr_areas_dropdown.attr('disabled', 'disabled');
			}

		});


		states_dropdown.on('change',function(){

			var selected_state = $(this).val();

			find_retailer.find("option:gt(0)").remove();
			find_retailer.attr('disabled','disabled');

			if(locations[selected_state] != undefined && locations[selected_state] != ''){
				// Remove disable when province changes
				areas_dropdown.find("option:gt(0)").remove();
				areas_dropdown.attr('disabled', false);

				$.each( locations[selected_state].sort() , function ( index , area ){
					areas_dropdown.append($('<option></option>').val(area).html(area));
				});
				areas_dropdown.append($('<option value=OTHERS>Others</option>'));

			} else {
				areas_dropdown.find("option:gt(0)").remove();
				areas_dropdown.attr('disabled', 'disabled');
			}

		});

		areas_dropdown.on('change',function(){

			// Reset find retailer
			find_retailer.find("option:gt(0)").remove();

			var area = $(this).val();

			if( area != '' && area != undefined) {
				var data = [];
		        data.push({ name: "security",  value: $('input#ajax-nonce').val() });
				data.push({ name: "province" ,  value: $('#province').val() });
				data.push({ name: "area" ,  value: $('#area').val() });
				data.push({ name: "action" ,  value: 'dtc_get_retailers' });

				// console.log(hatt_params.ajax_url);


		        $.ajax({
		            type: 'POST',
		            url: hatt_params.ajax_url,
		            data: data,
		            dataType: 'json'
		        })
		        .done(function(result){
					find_retailer.attr('disabled',false);
					if ($.trim(result)){
						$.each( result , function ( index , retailer ){
							find_retailer.append($('<option></option>').val(retailer).html(retailer));
						});
					}

					find_retailer.append($('<option value=OTHERS>Others</option>'));
		        })
		   	} else {
				find_retailer.attr('disabled','disabled');
		    }
			if (areas_dropdown.val() == 'OTHERS') {
				$('.others_area').show();
				$('input[name=others_area]').show();


			} else {
				$('input[name=others_area]').hide();
				$('.others_area').hide();

			}
		});

		find_retailer.on('change', function(){
			if (find_retailer.val() == 'OTHERS') {
				$('.others_dealer').show();
				$('input[name=others_dealer]').show();
			} else {
				$('input[name=others_dealer]').hide();
				$('.others_dealer').hide();
			}
		});
	});
	// RAYA PROMO events
	// when checkbox raya agree, make the raya reason required
	$("#is_raya_promo").change(function() {
   	 if(this.checked) {
        	$('#raya_reason').attr('required', true);
    		}
	else{

        	$('#raya_reason').attr('required', false);
		}
	});
	// when raya reason is keydown = limit to 20 words only
	$('#raya_reason').keydown(function(event) {
		var wordLen = 25;
		var len = $(this).val().split(/[\s]+/);
		if (len.length > wordLen) {
		if ( event.keyCode == 46 || event.keyCode == 8 ) {// Allow backspace and delete buttons
   		} else if (event.keyCode < 48 || event.keyCode > 57 ) {//all other buttons
    			event.preventDefault();
   			}
		}
		wordsLeft = (wordLen) - len.length;
		$('.words-left').html(wordsLeft+ ' words left');
		if(wordsLeft == 0) {
			$('.words-left').addClass('text-danger');
				if ( event.keyCode == 46 || event.keyCode == 8 ) {// Allow backspace and delete buttons
   					} else if (event.keyCode < 48 || event.keyCode > 57 ) {//all other buttons
    					event.preventDefault();
   				}
		}
	});
	//end of RAYA PROMO events
	$('select[id^=dtc-vehicle-]').on('change',function(i,e){
		var data = [];
		var current_option_id = $(this).attr('id').split('-');
		data.push({ name: "security",  value: $('input#ajax-nonce').val() });
		data.push({ name: "selected_option" ,  value: $(this).val() });
		data.push({ name: "option_order" ,  value: current_option_id[2]});
		data.push({ name: "total_options" ,  value: $('select[id^=dtc-vehicle-]').length });
		data.push({ name: "action" ,  value: 'dtc_get_vehicle_child' });


	 	$.ajax({
            type: 'POST',
            url: hatt_params.ajax_url,
            data: data,
            dataType: 'json'
        })
        .done(function(result){

        	for ( var i = result['append_to']  ; i < result['total_options']; i++) {
        		$('#dtc-vehicle-'+i).attr('disabled','disabled');
        		$('#dtc-vehicle-'+i).find("option:gt(0)").remove();
        	}

			$('#dtc-vehicle-'+result['append_to']).attr('disabled',false);
        	$('#dtc-vehicle-'+result['append_to']).append(result.html);

        })
        .fail(function(){console.log('Connection fail.');});

	});

	$('#datepicker').change(function(){
		$('#datepicker').parsley().validate();
	});

	$('#tnc').change(function(){
		$('#tnc').parsley().validate();
	});
	
	var plateTimer;
	
	$("#vehicle_reg_id").on("input", function () {
	
		clearTimeout(plateTimer);
	
		var plate = $(this).val().trim().toUpperCase();
	
		$("#plateNumErrorMsg").html("");
	
		if (plate.length < 3) {
			return;
		}
	
		plateTimer = setTimeout(function () {
	
			$.ajax({
				type: "POST",
				url: hatt_params.ajax_url,
				headers: {
					'X-Requested-With': 'XMLHttpRequest'
				},
				data: {
					action: "validate_plate_number",
					vehicle_reg_id: plate
				},
				dataType: "json",
	
				success: function (response) {

					if (response.success && response.data.exists) {
				
						var errorMessage = response.data.message;
				
						$("#plateNumErrorMsg").html(
							"<span style='color:red;'>" +
							errorMessage +
							"</span><br>" +
							"<a href='/warranty/check-warranty' target='_blank'>Please verify your registration here</a>"
						);
				
						// Disable submit
						$("input[type=submit]")
							.prop("disabled", true)
							.addClass("disable-dtc-button");
				
					} else {
				
						// Plate number is valid
						$("#plateNumErrorMsg").html(
							"<span style='color:green;'></span>"
						);
				
						// Enable submit again
						$("input[type=submit]")
							.prop("disabled", false)
							.removeClass("disable-dtc-button");
					}
				}
	
			});
	
		}, 500);
	
	});

	// Datepicker
	//$("#datepicker").datepicker({ maxDate: new Date, yearRange: "-100:+0" });

	$('#dtc-register-form').parsley().on('field:validated', function() {
		// console.log('validating. . .');
		// Make some validation here . . .


		// // Set invoice as required only if it's visible
		// if( $('input[name=invoice]').is(':visible') ){
		// 	$('input[name=invoice]').attr('required', 'required');
		// } else {
		// 	$('input[name=invoice]').removeAttr('required', 'required');

		// }

		// Set dtc_card_no field as required only if it's visible
		if( $('input[name=dtc_card_no]').is(':visible') ){
      		$('button[name=dtc_card_button]').show();
      		$('p[id=dtc_card_label]').show();
			$('input[name=dtc_card_no]').attr('required', 'required');

		} else {
			$('input[name=dtc_card_no]').removeAttr('required', 'required');

		}
		// set required for Raya promo
		if($('input[name=is_raya_promo]').is(':checked') ){
			$('input[name=raya_reason]').attr('required', 'required');

		} else {
			$('input[name=raya_reason]').removeAttr('required', 'required');

		}
		if( $('input[name=others_area]').is(':visible') ){
			$('input[name=others_area]').attr('required', 'required');
		} else {
			$('input[name=others_area]').removeAttr('required', 'required');
		}
		if( $('input[name=others_dealer]').is(':visible') ){
			$('input[name=others_dealer]').attr('required', 'required');
		} else {
			$('input[name=others_dealer]').removeAttr('required', 'required');
		}

	//$('[name=nric_no]').parsley().removeError('has-error', {updateClass: true});
	//$('[name=nric_no]').parsley().removeError('success', {updateClass: true});
	//var nric_no = $('#nric_no').val();

	//if( nric_no.length != 12 && nric_no.length > 0 ){
		// $('[name=nric_no]').parsley().addError('has-error required', {message: '* NRIC Number must be 12 digit', assert: true, updateClass: true});
	//}

	})

	.on('form:submit', function() {

  		/***** DTC submit form *****/

        /*
        * register ajax request snippet
        * Returns Thank you page.
        */

		$('input[type=submit]').val('Processing...');
       	$('input[type=submit]').attr('disabled', 'disabled').addClass('disable-dtc-button');


		var data =  new FormData($( "#dtc-register-form" )[0]);
		// Display the key/value pairs
		//for (let [key, value] of data) {
		//  console.log(`${key}: ${value}`)
		//}



		data.append("security", $('input#ajax-nonce').val());
		data.append("action" ,  'dtc_submit');
		data.append("locale" ,  hatt_params.locale);

  		// var data = $("#dtc-register-form").serializeArray();
		// data.push({ name: "security",  value: $('input#ajax-nonce').val() });
		// data.push({ name: "action" ,  value: 'dtc_submit' });
		// data.push({ name: "locale" ,  value: hatt_params.locale });

		// var vehicle = [];
		// $('select[id^=dtc-vehicle-]').each(function(i,e){
		// 	var vhcle_parts = $(e).val().split('|');
		// 	vehicle.push(vhcle_parts[1]);
		// });

		// data.push({ name: "vehicle" ,  value: vehicle.join('|') });


		$.ajax({
            type: 'POST',
			headers: { 'X-Requested-With': 'XMLHttpRequest' },
            url: hatt_params.ajax_url,
              data: data,
	          // dataType: 'json',
	          processData: false,
	          contentType: false,
	          cache: false,
        })
		.done(function(result){
			if (typeof result === 'string') {
				try {
					result = JSON.parse(result);
				} catch (error) {
					result = null;
				}
			}

			var registrationSucceeded = false;

			if (result === 1 || result === '1') {
				$('input[name=dtc_card_no]').val('');
				$('#message').html('<div class="alert alert-danger" role="alert">Record already exists.</div>');
			} else if (result === 2 || result === '2') {
				$('input[name=dtc_card_no]').val('');
				$('#message').html('<div class="alert alert-danger" role="alert">Your data was submitted, but we could not return a confirmation. Please check your registration before trying again.</div>');
			} else if (result && typeof result.html === 'string') {
				registrationSucceeded = true;
				$('#dtc-register-form')[0].reset();
				$('#dtc-register-form').hide();
				$('#plateNumErrorMsg').empty();
				$('#message').html(result.html);
				$('#message')[0].scrollIntoView();

				setTimeout(function() {
					if ($('#gy-dtc-survey-form').length) {
						$.magnificPopup.open({
							items: { src: '#gy-dtc-survey-form' },
							type: 'inline'
						});
						$('.gy-survey-form .wpcf7-submit').attr('disabled', 'disabled');
					}
				}, 1000);
			} else {
				$('#message').html('<div class="alert alert-danger" role="alert">We could not complete your registration. Please check your details and try again.</div>');
			}

			$('input[type=submit]').val(original_label);
			$('input[type=submit]').prop('disabled', registrationSucceeded).toggleClass('disable-dtc-button', registrationSucceeded);
		})
		.fail(function(xhr){
			console.log('Connection fail.');
		
			var response;
			try {
				response = JSON.parse(xhr.responseText);
			} catch (e) {
				response = null;
			}
		
			if ( response && response.data ) {
				var errorMessage = response.data.message;
				var errorCode = response.data.code;

				if (errorCode === 6) {
					$('#dtc-card-message').text(errorMessage);
					$('#dtc_card_no').addClass('is-invalid');
				} else if (errorCode === 3) {
					$('#message').html(
						$('<div>', { class: 'alert alert-danger', role: 'alert' })
							.text(errorMessage + ' Please verify your registration.')
					);
				} else {
					$('#message').html(
						$('<div>', { class: 'alert alert-danger', role: 'alert' }).text(errorMessage || 'We could not complete your registration. Please check your details and try again.')
					);
				}
			} else {
				$('#message').html('<div class="alert alert-danger" role="alert">We could not connect to the registration service. Please try again in a moment.</div>');
			}
		
			$('input[type=submit]').val(original_label);
			$('input[type=submit]').removeAttr('disabled', 'disabled').removeClass('disable-dtc-button');
		});
		return false;
        //.fail(function(){console.log('Connection fail.');});
		//return false; // Don't submit form for this demo

	});

    $('#date_purchase').on('click', function(){
    	$("#date_purchase_picker").datepicker("show");

    });

	$(function() {
	    $("#date_purchase_picker").datepicker({
	    	yearRange: "-10:+0",
	    	maxDate: '0',
	        changeMonth: true,
	        changeYear: true,
	        showButtonPanel: false
	    });

	    // Apply chain dropdown
        $("#width").chained('#product_model');
     	$("#ratio").chained('#width');
   	$("#diameter").chained('#ratio');
	$("#qty").chained('#diameter');
	});

	$('input[name=dtc_card_no_legacy]').focus(function(){
		$('input[type=submit]').attr('disabled', 'disabled').addClass('disable-dtc-button');
	});


	// Will validate for DTC Code
	$('button[name=dtc_card_button]').click(function(e){
		//console.log('Typing >> ', e.target.value);
		var loader = $("<div class='uil-default-css dtc-loader' style='transform:scale(0.18);'><div style='top:165px;left:-80px;width:14px;height:40px;background:#cec9c9;-webkit-transform:rotate(0deg) translate(0,-60px);transform:rotate(0deg) translate(0,-60px);border-radius:10px;position:absolute;'></div><div style='top:165px;left:-80px;width:14px;height:40px;background:#cec9c9;-webkit-transform:rotate(30deg) translate(0,-60px);transform:rotate(30deg) translate(0,-60px);border-radius:10px;position:absolute;'></div><div style='top:165px;left:-80px;width:14px;height:40px;background:#cec9c9;-webkit-transform:rotate(60deg) translate(0,-60px);transform:rotate(60deg) translate(0,-60px);border-radius:10px;position:absolute;'></div><div style='top:165px;left:-80px;width:14px;height:40px;background:#cec9c9;-webkit-transform:rotate(90deg) translate(0,-60px);transform:rotate(90deg) translate(0,-60px);border-radius:10px;position:absolute;'></div><div style='top:165px;left:-80px;width:14px;height:40px;background:#cec9c9;-webkit-transform:rotate(120deg) translate(0,-60px);transform:rotate(120deg) translate(0,-60px);border-radius:10px;position:absolute;'></div><div style='top:165px;left:-80px;width:14px;height:40px;background:#cec9c9;-webkit-transform:rotate(150deg) translate(0,-60px);transform:rotate(150deg) translate(0,-60px);border-radius:10px;position:absolute;'></div><div style='top:165px;left:-80px;width:14px;height:40px;background:#cec9c9;-webkit-transform:rotate(180deg) translate(0,-60px);transform:rotate(180deg) translate(0,-60px);border-radius:10px;position:absolute;'></div><div style='top:165px;left:-80px;width:14px;height:40px;background:#cec9c9;-webkit-transform:rotate(210deg) translate(0,-60px);transform:rotate(210deg) translate(0,-60px);border-radius:10px;position:absolute;'></div><div style='top:165px;left:-80px;width:14px;height:40px;background:#cec9c9;-webkit-transform:rotate(240deg) translate(0,-60px);transform:rotate(240deg) translate(0,-60px);border-radius:10px;position:absolute;'></div><div style='top:165px;left:-80px;width:14px;height:40px;background:#cec9c9;-webkit-transform:rotate(270deg) translate(0,-60px);transform:rotate(270deg) translate(0,-60px);border-radius:10px;position:absolute;'></div><div style='top:165px;left:-80px;width:14px;height:40px;background:#cec9c9;-webkit-transform:rotate(300deg) translate(0,-60px);transform:rotate(300deg) translate(0,-60px);border-radius:10px;position:absolute;'></div><div style='top:165px;left:-80px;width:14px;height:40px;background:#cec9c9;-webkit-transform:rotate(330deg) translate(0,-60px);transform:rotate(330deg) translate(0,-60px);border-radius:10px;position:absolute;'></div></div>");
		var that = $('input[name=dtc_card_no]');
		var dtc_card_no = $('input[name=dtc_card_no]').val();
		// Add validation that will check only if the length is 8 or 9
		//console.log(dtc_card_no.length);
		if( dtc_card_no.length === 8 || dtc_card_no.length === 9 ){
			var data = [];


			// Set params
			data.push({ name: "security",  value: $('input#ajax-nonce').val() });
			data.push({ name: "dtc_code" ,  value: dtc_card_no });
			data.push({ name: "action" ,  value: 'is_dtc_card_valid' });

			// Show up the loader
			$(this).parent().append(loader);

			$.ajax({
	            type: 'POST',
	            url:  hatt_params.ajax_url,
	            data: data,
	            dataType: 'json'
	        })
	        .done(function(data){
	        	$('[name=dtc_card_no]').parsley().removeError('has-error', {updateClass: true});
	        	$('[name=dtc_card_no]').parsley().removeError('success', {updateClass: true});
	        	console.log('finishing...');
	        	$(that).parent().parent().find(".dtc-loader").remove();
	        	if( data.success ) {
	        		$('[name=dtc_card_no]').parsley().addError('success', {message: 'This is a valid DTC Code', assert: true, updateClass: true});
	        		$('input[type=submit]').removeAttr('disabled', 'disabled').removeClass('disable-dtc-button');
				$('#raya-promo-panel').show();
				$('#myDtcErrModal').modal();
	        	} else {
				console.log(data)
	        		$('[name=dtc_card_no]').parsley().addError('has-error required', {message: 'DTC number is used or invalid, please enter a valid DTC number', assert: true, updateClass: true});
	        		$('input[type=submit]').attr('disabled', 'disabled').addClass('disable-dtc-button');
				$('#raya-promo-panel').hide();
				$('#myDtcErrModal').modal();
	        	}
	        })
	        .fail(function(){console.log('Connection fail.');});
		}
    else if ( dtc_card_no.length > 8 ) {
			$('input[name=dtc_card_no]').addClass('parsley-has-error').parsley().validate();
		} else {
			$('[name=dtc_card_no]').parsley().removeError('has-error', {updateClass: true});
	        	$('[name=dtc_card_no]').parsley().removeError('success', {updateClass: true});
			console.log('remove loader');
			// reached = false;
			$(this).parent().find(".dtc-loader").remove();
			$('#raya-promo-panel').hide();
			$('[name=dtc_card_no]').parsley().addError('has-error', {message: 'DTC Code must be 8 characters', assert: true, updateClass: true});
			$('#myDtcErrModal').modal();

		}
	});

	$('#qty').change(function(){
		const rimSize = $('#diameter').val();
		const qty = $('#qty').val();
	})
	
	// Onload, hide DTC Card #
	// $('input[name=dtc_card_no]').hide();

	// $('input[name=invoice]').hide();
	// $('p[id=invoice-header]').hide();
	// $('input[name=personnel]').hide();

	$('input[name=others_area]').hide();
	$('input[name=others_dealer]').hide();
	$('.alphaonly').bind('keyup blur',function(){
	    var node = $(this);
	    node.val(node.val().replace(/[^a-zA-Z ]/g,'') ); }
	);

	$('.numberonly').bind('keyup blur',function(){
	    var node = $(this);
	    node.val(node.val().replace(/[^0-9 ]/g,'') ); }
	);

        $('#product_model').on('change', function(){
		
		var qty = $('#qty').val();
		var selected_diameter = $('#diameter').val();
		var selected_tyre = $(this).val();
		// 2023 David Tyre Company Assurance Comforttred Promo - Tire Code 11585
		var promo_valid_diameter = ['16', '17', '18','19'];
		if((selected_tyre == '11585') && (promo_valid_diameter.includes(selected_diameter))){
			if(qty == '2'){
				$('#comforttredPromoModal2').modal();
			} else if( qty == '4'){
				$('#comforttredPromoModal4').modal();
			}
		}
	});


	$('#qty').on('change', function(){

		var qty = $(this).val();
		var selected_diameter = $('#diameter').val();
		var selected_tyre = $('#product_model').val();
		var dtc_tyres = $('input[name=dtc_tyres]').val().split(',');

		$('[name=dtc_card_no]').parsley().removeError('has-error', {updateClass: true});
	    $('[name=dtc_card_no]').parsley().removeError('success', {updateClass: true});
	    $('input[type=submit]').removeAttr('disabled', 'disabled').removeClass('disable-dtc-button');

		if( qty >= 1  && dtc_tyres.indexOf(selected_tyre) != -1 ){

                // 2023 David Tyre Company Assurance Comforttred Promo - Tire Code 11585
		var promo_valid_diameter = ['16', '17', '18','19'];
		if((selected_tyre == '11585') && (promo_valid_diameter.includes(selected_diameter))){
			if(qty == '2'){
				$('#comforttredPromoModal2').modal();
			} else if( qty == '4'){
				$('#comforttredPromoModal4').modal();
			}
		}


			// $('input[name=dtc_card_no]').show();
      		// $('button[name=dtc_card_button]').show();
      		// $('p[id=dtc_card_label]').show();
			$('input[name=dtc_card_no]').attr('required', 'required');

			// $('input[name=invoice]').show();
			// $('p[id=invoice-header]').show();
			// $('input[name=personnel]').show();
			
			/* Hide the DTC Code input for consumer tyres pattern*/
			var consumer_tyres = ['2175', '2183', '9501','2196', '2190','2193','2179','9822','2206','7869']
			if(consumer_tyres.indexOf(selected_tyre) > 0 ) {
				$('input[name=dtc_card_no]').removeAttr('required');
				// $('input[name=dtc_card_no]').hide();
    			// $('button[name=dtc_card_button]').hide();
    			// $('p[id=dtc_card_label]').hide();

    			// $('input[name=invoice]').hide();
				// $('p[id=invoice-header]').hide();
			}

			//Raya Promo Enabled
			$("input[name=raya_reason]").prop('disabled', false);
			$("input[name=is_raya_promo]").prop('disabled', false);



		} else {

			// (DTC Code is kept and stays required; dtc-card-live.js validates it)

			// Hide the DTC Code.
			// (DTC Code is kept when the quantity changes)
			// $('input[name=dtc_card_no]').hide();
      		// $('button[name=dtc_card_button]').hide();
      		// $('p[id=dtc_card_label]').hide();

      		// $('input[name=invoice]').hide();
      		// $('p[id=invoice-header]').hide();
			// $('input[name=personnel]').hide();


			// Raya promo disabled
			//$("input[name=raya_reason]").prop('disabled', true);
			//$("input[name=is_raya_promo]").prop('disabled', true);

			// (DTC Code is validated by dtc-card-live.js, not on every quantity change)
		}

	});

});


function titleCase(str) {
  return str.toLowerCase().split(' ').map(function(word) {
    return word.replace(word[0], word[0].toUpperCase());
  }).join(' ');
}

jQuery( document ).ready(function(){
	var $ = jQuery;
	
	/* Submit Check Registry Form */
	
	if ($('#dtc-check-registry-form').length > 0) {
		$('#dtc-check-registry-form').parsley().on('field:validated', function() {
			// console.log('validating. . .');
			// Make some validation here . . .
		})
		.on('form:submit', function() { 

			/***** DTC checker submit form *****/
		
			/*
			* check registry ajax request snippet
			* Returns with result 
			*/
			
			var data = $("#dtc-check-registry-form").serializeArray();
			data.push({ name: "security",  value: $('input#ajax-nonce').val() });
			data.push({ name: "action" ,  value: 'dtc_check_registry' });
			
			/*  Google recaptcha validation */
			if(data[1].value == ''){
				return false; // Don't submit form 
			} 

			$.ajax({ 
				type: 'POST',
				url: hatt_params.ajax_url,
				data: data,
				dataType: 'json'
			})
			.done(function(result, data){
				$.fn.gotoAnchor = function(anchor) {
					location.href = this.selector;
				}
				if( result == 0 ){

					$('#message').html(function(){
						return '<br><br><div class="alert alert-danger"><i class="fa fa-warning"></i> No record found.</div> <br />';
					});
					$('#result').html('');

				} else { 
					$('#message').html('');
					$('#result').html(function(){
						return result.html;
					});
				}


			})
			.fail(function(){console.log('Connection fail.');});

			return false; // Don't submit form 
		});
	}

	$(document).on('submit', '.dtc-claim__form', function(event) {
		event.preventDefault();

		var form = $(this);
		var button = form.find('button[type="submit"]');
		var message = form.find('.dtc-claim__message');
		var idempotencyField = form.find('input[name="idempotency_key"]');
		var idempotencyStorageKey = 'dtc_claim_idempotency_' + form.find('input[name="dtc_card_no"]').val();
		var idempotencyKey = idempotencyField.val();
		var submissionSucceeded = false;
		try {
			var savedIdempotencyKey = window.sessionStorage.getItem(idempotencyStorageKey);
			if (savedIdempotencyKey) {
				idempotencyKey = savedIdempotencyKey;
				idempotencyField.val(savedIdempotencyKey);
			} else {
				window.sessionStorage.setItem(idempotencyStorageKey, idempotencyKey);
			}
		} catch (error) {
			// Continue with the key embedded in the form if session storage is unavailable.
		}
		var data = new FormData(form[0]);
		data.set('idempotency_key', idempotencyKey);
		data.set('action', 'dtc_submit_claim');

		button.prop('disabled', true);
		message.text('');

		$.ajax({
			type: 'POST',
			url: hatt_params.ajax_url,
			data: data,
			dataType: 'json',
			processData: false,
			contentType: false,
			cache: false
		})
		.done(function(response) {
			var text = response && response.data && response.data.message
				? response.data.message
				: 'Your claim was submitted.';
			message.text(text);
			if (response && response.success) {
				submissionSucceeded = true;
				try {
					window.sessionStorage.removeItem(idempotencyStorageKey);
				} catch (error) {
					// The successful response is still handled when session storage is unavailable.
				}
				$.ajax({
					type: 'POST',
					url: hatt_params.ajax_url,
					data: {
						action: 'dtc_check_registry',
						security: form.find('input[name="security"]').val(),
						dtc_code: form.find('input[name="dtc_card_no"]').val()
					},
					dataType: 'json'
				})
				.done(function(lookup) {
					if (lookup && lookup.html) {
						$('#message').empty();
						$('#result').html(lookup.html);
						return;
					}

					message.text(text + ' Please check the warranty again to view the updated status.');
				})
				.fail(function() {
					message.text(text + ' Please check the warranty again to view the updated status.');
				});
			}
		})
		.fail(function(xhr) {
			var response = xhr.responseJSON;
			var text = response && response.data && response.data.message
				? response.data.message
				: 'We could not submit your claim. Please try again later.';
			message.text(text);
		})
		.always(function() {
			button.prop('disabled', submissionSucceeded);
		});
	});

	$(document).on('submit', '.dtc-claim-response__form', function(event) {
		event.preventDefault();

		var form = $(this);
		var button = form.find('button[type="submit"]');
		var message = form.find('.dtc-claim-response__message');
		var data = form.serializeArray();
		data.push({ name: 'action', value: 'dtc_customer_claim_response' });

		button.prop('disabled', true);
		message.removeClass('is-error').text('');

		$.ajax({
			type: 'POST',
			url: hatt_params.ajax_url,
			data: data,
			dataType: 'json'
		})
		.done(function(response) {
			message.text(response && response.data && response.data.message
				? response.data.message
				: 'Your additional information was sent to our team.');
			form.find('textarea, input[name="vehicle_reg_id"]').prop('disabled', true);
		})
		.fail(function(xhr) {
			var response = xhr.responseJSON;
			message.addClass('is-error').text(response && response.data && response.data.message
				? response.data.message
				: 'We could not send your update. Please try again later.');
			button.prop('disabled', false);
		});
	});

});

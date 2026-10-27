jQuery( document ).ready(function($){

	var states_dropdown = $('.states');
	var areas_dropdown = $('.areas');

	//reset onload
	areas_dropdown.find("option:gt(0)").remove();


	$.getJSON(hatt_params.theme_url + '/js/'+hatt_params.locale+'-location-ac.json', function(result){

		var locations = result.location;

		var sorted_location = {};
		
		if (locations && locations.length) {
			Object.keys(locations).sort().forEach(function(key) {
			  sorted_location[key] = locations[key];
			});

			$.each( sorted_location , function ( state ){
				states_dropdown.append( $('<option></option>').val(state).html(state));
			});

			states_dropdown.on('change',function(){

				var selected_state = $(this).val();

				areas_dropdown.find("option:gt(0)").remove();

				if(locations[selected_state] != undefined){
					$.each( locations[selected_state] , function ( index , area ){
						areas_dropdown.append($('<option></option>').val(area).html(area));
					});
				}

			});
		}

	});

});

jQuery.ajaxSetup ({ cache: false });

jQuery(document).ready(function ($) {
	

	$(window).load(function () { return false; });

	var STORES = {
		__ajax_request : null, //to cancel previous request
		__locale : storeFilters.locale , //locale to switch map

		//html elem selectors
		_dropdown_post_per_page : $('#post-per-page'),
		_dropdown_range : $('#range'),
		_dropdown_states : $('select[class=states]'),
		_dropdown_areas : $('select[class=areas]'),
		_dropdown_specialty : $('select[class=specialty]'),
		_dropdown_category : $('select[class=store_category]'),
		_store_list : $('#store-list'),
		_store_list_template : $('#store_template .store-box'),
		_store_mobile_filter : $('.filter-by-header'),
		_current_loc : $('.currentLocation'),
		_list_pagination : $('#store-pagination'),
		_checkbox_dtc_zero_percent : $('#filterstore_dtc_zero_percent'),
		_checkbox_uhp_rof_tyre_available : $('#filterstore_uhp_rof_tyre_available'),
		_pagination : null,

		//map
		_map_canvas:  $('#map'),
		_maps : function(){
			return (this.__locale == 'cn') ? 'http://map.baidu.com/?l=&s=s%26wd%3D' : 'http://maps.google.com/?q=';	
		} ,		
		map : null, //map object
		map_viewport : [],
		markers: [],
		markerClusterer: null,
		markerClusterer_bounds: null,
		markerClusterer_marker: null,
		markerClusterer_viewpoint: null,
		show_cluster_marker: false,

		//cache
		c_as_overlay: null,
		c_as_markers: null,
		c_as_center: null,
		c_as_zoom: null,

		//data feed
		locations : null,
		all_specialty : null,
		specialty : null,
		all_categories : null,
		categories : null,

		//request filters
		filters : {
			'use_current_location' : false,
			'coordinates': null,
			'range': 10,
			'state': storeFilters.state,
			'area': storeFilters.area,
			'specialty': storeFilters.specialty,
			'category' : storeFilters.category,
			'current_page': 1,
			'post_per_page': 207,
			'all_stores': 1, //first load only
		},

		init : function( ){
			_this = this;

			//get location filter json
			$.getJSON('wp-content/themes/dtc-theme/js/'+_this.__locale+'-location-filter.json',function(data){
				_this.locations = data.location;
				_this.updateStates();
				_this._dropdown_areas.prop("disabled", true);
				_this._dropdown_range.prop("disabled", true);

				//if(_this.__locale == 'cn'){
				//	_this._dropdown_specialty.hide();
				//}

				//console.log(_this.__locale);

				if(_this.__locale == 'in' || _this.__locale == 'tw'){
					$('.location-filter-bar').hide();
					$('#store-map-container').hide();
					$('#india-store-location-filter').show();
					$('#wapper').css({'margin-top':'40px'});
					$('.mobile-location-filter .locate-me-btn').hide();
				}

			})
			.done(function(){

				if( storeFilters.state || storeFilters.category || storeFilters.specialty ){

					_this.filters.state = storeFilters.state;
					_this.filters.area = storeFilters.area;
					

					_this._dropdown_states.val(storeFilters.state);
					_this.updateAreas();
					_this._dropdown_areas.val(storeFilters.area);

					_this.filters.category = storeFilters.category;
					_this.filters.all_stores = 0;

					_this.getStores();

				}

			})
			.fail(function(){
				console.log('unable to load location filters.');
			});

			this._dropdown_range.prop("disabled", true);

			//bind event listeners
			this._dropdown_states.on('change',function(){
				//update other dropdown
				_this._dropdown_states.val( $(this).val());

				_this._dropdown_range.prop("disabled", true);
				_this.filters.use_current_location = false;
				_this._current_loc.addClass('disable');
				_this.filters.coordinates = null;
				_this.filters.specialty = null; 
				_this.filters.category = null; 
				_this.filters.current_page = 0;
				_this.updateFilter('area' , null);
				_this.updateFilter('state' , $(this).val());
				_this.updateAreas();
			});

			this._dropdown_areas.on('change',function(){
				//update other dropdown
				_this._dropdown_areas.val( $(this).val());

				_this.filters.use_current_location = false;
				_this._current_loc.addClass('disable');
				_this.filters.current_page = 0;
				_this.filters.specialty = null; 
				_this.filters.category = null; 
				_this.updateFilter('area' , $(this).val());
			});

			this._dropdown_specialty.on('change',function(){

				//update other dropdown
				_this._dropdown_specialty.val( $(this).val() );

				_this.filters.current_page = 0;
				_this.updateFilter('specialty' , $(this).val());
			});

			this._dropdown_category.on('change',function(){

				//update other dropdown
				if ($(this).val() === "Store category"){
					_this._dropdown_category.val("-");
				}else{
					_this._dropdown_category.val( $(this).val());
				}
				

				_this.filters.current_page = 0;
				if ($(this).val() === "Store category"){
					_this.updateFilter('category' , "-");
				}else{
					_this.updateFilter('category' , $(this).val());
				}
				
			});

			this._dropdown_post_per_page.on('change',function(){
				_this.filters.current_page = 0;
				_this.updateFilter('post_per_page' , $(this).val());
			});

			this._dropdown_range.on('change',function(){
				_this.filters.current_page = 0;
				_this.updateFilter('range' , $(this).val());
			});

			this._current_loc.on('click',function(){
				_this.filters.current_page = 0;
				_this.filters.use_current_location = true;

				//remove state & area filter
				_this._dropdown_states[0].selectedIndex = 0;
				_this._dropdown_areas[0].selectedIndex = 0;
				_this.filters.state = null; 
				_this.filters.area = null; 
				_this.filters.specialty = null; 
				_this.filters.category = null; 
				_this._dropdown_areas.prop("disabled", true);
				_this._dropdown_range.prop("disabled", false);

				_this.getCurrentLocation();
				$(this).removeClass('disable');
			});
			
			this._store_mobile_filter.on('click',function(){
				$(this).toggleClass( 'open' );
				$('#special-cat-filter').toggle();
			});

			// DTC 0% interest
			this._checkbox_dtc_zero_percent.on('change',function(){

				var zpo = "off";
				if($(this).is(":checked")) {
					var zpo = "on";
				}


				_this._checkbox_dtc_zero_percent.val(zpo);

				_this.filters.current_page = 0;

				_this.updateFilter('dtc_zero_percent' , zpo);

				console.log(zpo);
				
			});

			// UHP Tyres and ROF Tyres Available
			this._checkbox_uhp_rof_tyre_available.on('change',function(){
				
				var uhp_rof = "off";
				if($(this).is(":checked")) {
					var uhp_rof = "on";
				}


				_this._checkbox_uhp_rof_tyre_available.val(uhp_rof);

				_this.filters.current_page = 0;

				_this.updateFilter('uhp_rof_tyre_available' , uhp_rof);

				console.log(uhp_rof);
				
			});





//			if( storeFilters.specialty || storeFilters.category ){
//				_this.filters.all_stores = 0;
//		    }


			//preselect cat and spec
			$.when( _this.init_map() ).done( function() { 
				_this.getStores();
			});

			//default store list 
			//$.when( this.getStores() ).done( this.getAllStores() ); 
			//console.info( 'init-end: ', this.markerClusterer  );
			//initial load - load all shop markers
			
		},

		updateStates: function(){
			_this = this;
			$.each(this._dropdown_states,function(i,e){
				
				var states_sort = [];
				for(var key in _this.locations) {
					states_sort.push(key);
				}

				var sorted_states = (_this.__locale != 'cn') ? states_sort.sort() : states_sort;
					
				for(var key in sorted_states) {
					$(e).append( $('<option></option>').val(sorted_states[key]).html(sorted_states[key]) ); 
				}

			});
		},

		updateAreas: function( ){
			_this = this;
			
			$.each(this._dropdown_areas,function(i,e){
				$(e).find('option').not(':first').remove();
				
				var area_sort = [];

				for(var key in _this.locations[ _this.filters.state ]) {
					
					area_sort.push( _this.locations[ _this.filters.state ][key] );
				}

				var sorted_area = (_this.__locale != 'cn') ? area_sort.sort() : area_sort;

				for(var key in sorted_area ) {
					$(e).append( $('<option></option>').val( sorted_area[key] ).html( sorted_area[key]  ) ); 
				}

			});

			if(_this.filters.state == null)
			{
				_this._dropdown_areas.prop("disabled", true);
			}else{
				_this._dropdown_areas.prop("disabled", false);
			}
		},

		updateSpecialty: function( options ){
			_this = this;

/*			if(  ( _this.filters.state == null && _this.filters.area == null ) &&  this.c_as_markers != null ){
				options = _this.all_specialty;
			}*/


			$.each(this._dropdown_specialty, function( i, e) {
				$(e).find('option').not(':first').remove();

				for(var key in options ) {

					if (options[key].name === null) continue; 

					var status = ( options[key] == _this.filters.specialty ) ? 'selected' : '';

					$(e).append( $('<option></option>').val(  options[key] ).html(  options[key]  ).prop('selected',status) ); 
				}
			});
		},

		updateCategories: function( options ){
			_this = this;

		/*	if(  ( _this.filters.state == null && _this.filters.area == null )  &&  this.c_as_markers != null ){
				options = _this.all_categories;
			}*/

			$.each(_this._dropdown_category, function( i, e) {

				$(e).find('option').not(':first').remove();

				for(var key in options) {

					if (options[key].name === null) continue; 
					
					var status = ( options[key].slug == _this.filters.category  ||  options[key].name == _this.filters.category ) ? 'selected' : '';

					var option_val = (_this.__locale == 'cn') ? options[key].slug : options[key].name;

					$(e).append( $('<option></option>').val( option_val ).html(  options[key].name  ).prop('selected',status) ); 
				}

			});
		},

		updateFilter: function ( name, value){
			var param_val = (value == "" ) ? null  : value;
			this.filters[name] = param_val;
			this.getStores( name );
		},

		getCurrentLocation: function(){
			_this = this;

			if (navigator.geolocation) {
		        navigator.geolocation.getCurrentPosition(function(position){
		        	_this.filters.coordinates = { 'latitude': position.coords.latitude , 'longitude': position.coords.longitude };
		       		_this.getStores();
		        });

		    } else {
		        alert( "Geolocation is not supported by this browser." );
		    }
		},

		init_map: function( ){

			if( this.__locale == 'cn'){
				//baidu map
				this.map = new BMap.Map("store-map");
				this.map.centerAndZoom(new BMap.Point( 96.543635  , 35.952671 ), 5	); // point to china by default
				this.map.addControl(new BMap.ScaleControl());  
				this.map.addControl(new BMap.MapTypeControl());  

				this.map.enableScrollWheelZoom(true); 
			}else{
				//google map
 				var mapOptions = {
		          center: { lat: 0, lng: 0},
		          zoom: 4,
		     	  maxZoom: 18,
		          mapTypeId: google.maps.MapTypeId.ROADMAP
		        };
		        //console.log('google map')

		       	this.map = new google.maps.Map(document.getElementById('store-map'), mapOptions);
			}
	
			//remove state & area filter
			this._dropdown_states[0].selectedIndex = 0;
			this._dropdown_areas[0].selectedIndex = 0;
			this.filters.state = null; 
			this.filters.area = null; 
		},

		clearMarkerOverlay : function(){
			//reset current map center
			if(!this.filters.use_current_location) {
				this.filters.coordinates = null;
			}


			if( this.markerClusterer != null ) { 
				if( this.__locale == 'cn') this.map.clearOverlays(); //
				//clear clustering overlays
				//alert('a');
				this.markerClusterer.clearMarkers(); 
				//console.info('after clear',_this.markerClusterer.getMarkers());
			}


			//clear existing markers
			this.map_viewport = [];
			this.markers = []; 
			
			
		},

		b_plotMarkers : function(store_markers){

			//reset markers
			this.clearMarkerOverlay();

			//load cache markers
			if( 

				this.filters.use_current_location == false &&
				( this.filters.all_stores == 0 && 
				this.filters.state == null &&  
				this.filters.area == null && 
				this.filters.specialty == null &&  
				this.filters.category == null)
			){
				//map cluster
				this.markerClusterer = new BMapLib.MarkerClusterer( this.map , { markers: this.c_as_markers });
		    	this.markerClusterer.setStyles([{
					url: "wp-content/themes/dtc-theme/images/ClusterMarker.png",
					size: new BMap.Size(30,26),
					opt_anchor: [16,0],
					textColor:'#ffffff',
					opt_textSize: 10
				}]);

		    	//set map viewport -center map
	    		this.map.setViewport(this.c_as_viewport);
	    		return true;
			}


			if(store_markers === undefined ){
		

				if(  this.filters.coordinates != null )
					this.map.centerAndZoom( new BMap.Point( this.filters.coordinates.longitude ,  this.filters.coordinates.latitude ), 12);
			}else{

				//new bound
				var markerClusterer_bounds = new BMap.Bounds();

		    	//marker loop
		    	for(var key in store_markers) {

		    		//marker postion & overlay
		    		var marker_coor = new BMap.Point( store_markers[key].ht_store_map_long, store_markers[key].ht_store_map_lat);
					var marker = new BMap.Marker(marker_coor);
					//this.map.addOverlay(marker);

					//marker Info window
					var InfoBox  = "<div class='info_content'><h3>"+ store_markers[key].title +"</h3>"; 
						InfoBox += '<p>'+store_markers[key].ht_store_address + '</p>';
						InfoBox += '<p>Phone: ' +  store_markers[key].ht_store_phone +'</p>' ;
					var option = {width: 300};
					var infoWindow = new BMap.InfoWindow (InfoBox, option); 

					this.addClickHandler(InfoBox,marker); 

					//for reference
					markerClusterer_bounds.extend(marker_coor);
					this.markers.push(marker);
					//this.map_viewport.push(marker_coor);
		    	}

		    	//map cluster
		    	this.markerClusterer = new BMapLib.MarkerClusterer( this.map , { markers: this.markers });
		    	this.markerClusterer.setStyles([{
					url: "wp-content/themes/dtc-theme/images/ClusterMarker.png",
					size: new BMap.Size(30,26),
					opt_anchor: [16,0],
					textColor:'#ffffff',
					opt_textSize: 10
				}]);

		    	//set map viewport -center map
	    		this.map.setViewport([ markerClusterer_bounds.getSouthWest() , markerClusterer_bounds.getNorthEast() ]);
			}

			//if using current location
			if(this.filters.use_current_location) {

				var location_icon = new BMap.Icon("wp-content/themes/dtc-theme/images/locate-me.png", new BMap.Size(30,26));
		
				var marker_coor = new BMap.Point(  this.filters.coordinates.longitude  ,   this.filters.coordinates.latitude );
				var marker = new BMap.Marker(marker_coor,{icon:location_icon});
				this.map.addOverlay(marker);
			}

	    
	    	//set map viewport
	    	//var map_center = this.map.getViewport( this.map_viewport );
			//this.setMapCenter( map_center.center.lng , map_center.center.lat , map_center.zoom );

			//cache results
			if( this.filters.all_stores == 1 ){
				//console.log('cache result');
				this.c_as_markers = this.markers ;
				this.c_as_viewport =  [ markerClusterer_bounds.getSouthWest() , markerClusterer_bounds.getNorthEast() ] ;
				this.filters.all_stores = 0;

				$('.preload').fadeOut();
			}
		},


		addClickHandler: function( content , marker){
			_this = this;
			marker.addEventListener("click",function(e){
				_this.openInfo(content,e)}
			);
		},

		openInfo: function (content,e){
			var opts = {width: 300};
			var p = e.target;
			var point = new BMap.Point(p.getPosition().lng, p.getPosition().lat);
			var infoWindow = new BMap.InfoWindow(content,opts);  // 创建信息窗口对象 
			this.map.openInfoWindow(infoWindow,point); //开启信息窗口
		},

		resetFilter: function(){
			for(var key in STORES.filters) {
			   this.filters[key] = null;
			}
		},

		g_plotMarker: function(store_markers){
			_this = this;
			_this.clearMarkerOverlay();

			if(store_markers === undefined ){
				//this.map.centerAndZoom( new BMap.Point( this.filters.coordinates.longitude ,  this.filters.coordinates.latitude ), 12);
				return false;
			}

			//load cache markers
			if( 
				this.filters.use_current_location == false &&
				( this.filters.all_stores == 0 && 
				this.filters.state == null &&  
				this.filters.area == null && 
				this.filters.specialty == null &&  
				this.filters.category == null)
			){
				//console.log('cache')
				//map cluster
				_this.markerClusterer = new MarkerClusterer( _this.map, _this.c_as_markers );

				var marker_style = [{
			        url: "wp-content/themes/dtc-theme/images/ClusterMarker.png",
			        height: 30,
			        width: 30,
			        anchor: [4, 0],
			        textColor: '#ffffff'
			    }];

				_this.markerClusterer.fitMapToMarkers();
				_this.markerClusterer.setStyles(marker_style);
	    		return true;
			}

			var infowindow = new google.maps.InfoWindow();
			//var bounds = new google.maps.LatLngBounds();
		
			//var x  = 0;

			for(var key in store_markers) {
				

				//check valid coordinates - do not plot the  shop into the map if invalid	
				if( !_this.validateCoordinates(store_markers[key].ht_store_map_lat , store_markers[key].ht_store_map_long ) ) {
					console.info('Invalid coordinates',store_markers[key].title);
					continue;
				}
				
				//if(store_markers[key].ht_store_map_long == '')
				//	console.log( store_markers[key].ht_store_map_long);

				//if( parseFloat(store_markers[key].ht_store_map_lat) === NaN || parseFloat(store_markers[key].ht_store_map_long) === NaN  ) console.log(store_markers[key]);


				if(store_markers[key].ht_store_map_lat == 0 || store_markers[key].ht_store_map_long == 0 ||
				store_markers[key].ht_store_map_lat == '' || store_markers[key].ht_store_map_long == ''  ) continue;

				var myLatlng = new google.maps.LatLng(store_markers[key].ht_store_map_lat , store_markers[key].ht_store_map_long);
				
				var InfoBox  = "<div class='info_content'><h3>"+ store_markers[key].title +"</h3>"; 
					InfoBox += '<p>'+store_markers[key].ht_store_address + '</p>';
					InfoBox += '<p>Phone: ' +  store_markers[key].ht_store_phone +'</p>' ;

				var marker = new google.maps.Marker({
				  position: myLatlng,
				  map: this.map,
				  icon: 'wp-content/themes/dtc-theme/images/ClusterMarker.png',
				  zIndex: 1
				});


				google.maps.event.addListener(marker, 'click', (function(marker,InfoBox,infowindow) {
			        return function() {
			          infowindow.setContent(InfoBox);
			          infowindow.open(_this.map, marker);
			        }
			    })(marker,InfoBox,infowindow));

				_this.markers.push(marker);

				//bounds.extend(marker.getPosition());
			}

			//_this.map.fitBounds(bounds);

			_this.markerClusterer = new MarkerClusterer( _this.map, _this.markers );

			//console.log(_this.markerClusterer.getTotalClusters());


			var marker_style = [{
		        url: "wp-content/themes/dtc-theme/images/ClusterMarker.png",
		        height: 30,
		        width: 30,
		        anchor: [4, 0],
		        textColor: '#ffffff'
		    }];

			_this.markerClusterer.fitMapToMarkers();
			_this.markerClusterer.setStyles(marker_style);
  			//_this.map.fitBounds(bounds);

			_this.markerClusterer.resetViewport();
			//console.log(_this.map.getAverageCenter());

			//if using current location
			if(this.filters.use_current_location) {

				var user_marker = [{
			        url: "wp-content/themes/dtc-theme/images/locate-me.png",
			        height: 30,
			        width: 30,
			        anchor: [4, 0],
			        textColor: '#ffffff'
			    }];


				var image = 'wp-content/themes/dtc-theme/images/locate-me.png';
				var user_marker = new google.maps.Marker({
					position: {lat: this.filters.coordinates.latitude , lng: this.filters.coordinates.longitude },
					map: _this.map,
					icon: image,
					zIndex: 999
				});
			}



			//cache results
			if( this.filters.all_stores == 1 ){
				//console.log('cache result');
				this.c_as_markers = this.markers ;
				//this.c_as_viewport =  [ markerClusterer_bounds.getSouthWest() , markerClusterer_bounds.getNorthEast() ] ;
				this.filters.all_stores = 0;

				//$('.preload').fadeOut();
			}



		},


		validateCoordinates: function(lat,lng){

			 if (lat < -90 || lat > 90) return false;
			 if (lng < -180  || lng > 180 ) return false;

			 return true;

		},

		getStores: function( selected_update ){
			_this = this;
			_this._store_list.html('loading...');
			_this._list_pagination.empty();

			if(_this.__ajax_request )
				_this.__ajax_request.abort();

			_this.__ajax_request = $.ajax({
			    type: 'POST',
			    url: '/wp-content/themes/dtc-theme/dtc_david_templates/stores/ajax-find-stores.php',
			    data: _this.filters,
			    success: function(result){
			    	data = $.parseJSON(result);

			    	if(data.total_results == 0){
			    		_this._dropdown_specialty.prop('disabled','disabled');
			    		_this._dropdown_category.prop('disabled','disabled');
			    	}else{
			    		_this._dropdown_specialty.prop('disabled','');
			    		_this._dropdown_category.prop('disabled','');
			    	}

					_this.updateStoreList(data.stores); //always use listing stores
					_this.updateTotalResults(data.total_results);
					_this.updatePagination(data.pagination);

					if(  selected_update != 'specialty' || ( _this.filters.specialty == null  ) ) {
						//console.log('update specialty')
						//console.info(data.all_specialty);
						_this.updateSpecialty(data.all_specialty); 
					}

					if(  selected_update != 'category' || (  _this.filters.category == null )  ){
						//console.log('update cat')
						//console.info(data.all_categories);
						_this.updateCategories(data.all_categories); 
					}
					

			    	var stores = (data.all_stores ) ?  data.all_stores : data.stores;
			    	
			    	if(_this.__locale == 'cn'){
			    		_this.b_plotMarkers(stores); //use all stores if available
			    	}else{
			    		_this.g_plotMarker(stores);
			    	}


			    	if(data.all_stores){ //cache all category & specialty
			    		_this.all_specialty = data.all_specialty;
			    		_this.all_categories = data.all_categories;
			    	}

			    }
			});
		},

		updateTotalResults: function(total){
			$('#total_result').html(total);
		},

		updatePagination: function(html){
			_this = this;

			_this._list_pagination.empty().html(html);

			_this._pagination = $('body #store-pagination a.pagination');

			_this._pagination.on('click',function(e){
				e.preventDefault();

				var page_identifier = e.currentTarget.className;
				var page_selected;

				if(page_identifier === 'prev pagination'){
					page_selected = parseInt(_this.filters.current_page) - 1;
				} else if(page_identifier === 'next pagination'){
					page_selected = parseInt(_this.filters.current_page) + 1;
				} else{
					page_selected = parseInt(e.currentTarget.text); //parseInt(_this.filters.current_page);
				}

				// var page_selected = ( $(this).text() != '' ) ? $(this).text() :  parseInt(_this.filters.current_page) + 1;

				if( page_selected  != '...') {
					_this.filters.current_page = page_selected ;
					_this.getStores();
				}
			});
		},

		updateStoreList : function(stores){

			this._store_list.empty();

			if(typeof stores === 'undefined'){
				$('#no-result-found').clone().appendTo(this._store_list);
				return false;
			}

			for(var key in stores) {

				store_template = this._store_list_template.clone();

				store_template.find('.store-title');

				store_title = store_template.find('.store-title');
				store_title.attr('href','store/' + stores[key].slug);
				store_title.html(stores[key].title);

				store_address = store_template.find('.store-address');

				var postal_code = '';

				if( typeof stores[key].ht_store_postal_code != 'undefined' && stores[key].ht_store_postal_code != '' && stores[key].ht_store_postal_code != null ){
                     postal_code = ' - ' + stores[key].ht_store_postal_code;
                }

				/*address = stores[key].ht_store_address + ',  <br/> ' + stores[key].ht_store_area + ', ' + stores[key].ht_store_state   + postal_code;*/
				address = stores[key].ht_store_address;

				store_address.html(address);

				store_map = store_template.find('.store-map-link'); 
				store_map.attr('href', this._maps() + encodeURIComponent(store_title.html()) + ' ' + encodeURIComponent(stores[key].ht_store_address+' '+stores[key].ht_store_state + ' ' + stores[key].ht_store_area + ' ' + stores[key].ht_store_postal_code));
				store_map.attr('target', '_blank');

                store_contact = store_template.find('p.phone.hidden-xs a.store-contact');
         	
                if( typeof stores[key].ht_store_phone != 'undefined' && stores[key].ht_store_phone != ''){
                    //store_contact.html(stores[key].ht_store_phone);
					//store_contact.attr('href', 'tel:'+ stores[key].ht_store_phone);
					var slug = decodeURIComponent(stores[key].slug);
					store_contact.html(
						'<a href="tel:' + stores[key].ht_store_phone + '" class="storelocator-phone" data-qa-id="' + slug + '">' +
					'<span style="text-decoration: underline; font-weight: bold;">' + stores[key].ht_store_phone + '</a>'
					);
                }else{
                    store_contact.hide();
                }


				store_contact_m = store_template.find('.phone.visible-xs a.store-contact');
					
				if( typeof stores[key].ht_store_phone != 'undefined' && stores[key].ht_store_phone != '' ){
					//store_contact_m.html(stores[key].ht_store_phone);
					//store_contact_m.attr('href', 'tel:'+ stores[key].ht_store_phone);
					var slug = decodeURIComponent(stores[key].slug);
				
					store_contact_m
						.html('<span style="text-decoration: underline; font-weight: bold;">' + stores[key].ht_store_phone)
						.attr('href', 'tel:' + stores[key].ht_store_phone)
						.addClass('storelocator-phone')
						.attr('data-qa-id', slug);
				}else{
					mobile_contact = store_template.find('.phone.visible-xs');
					mobile_contact.hide().addClass('hidden-xs');
				}
				
				
                store_whatsapplink = store_template.find('p.whatsapplink.hidden-xs');
         	
                if( typeof stores[key].ht_whatsapp_link != 'undefined' && stores[key].ht_whatsapp_link != ''){
                    store_whatsapplink.html('<a href="' + stores[key].ht_whatsapp_link + '" target="_blank" data-label="' + stores[key].title + '"><img src="/wp-content/themes/dtc-theme/images/WhatsApp_Logo_1.png" height="45"></a>'); 
                }else{
                    store_whatsapplink.hide();
                }

				store_whatsapplink_m = store_template.find('.whatsapplink.visible-xs a.store-contact');
					
				if( typeof stores[key].ht_whatsapp_link != 'undefined' && stores[key].ht_whatsapp_link != '' ){
					store_whatsapplink_m.html('&nbsp;');
					store_whatsapplink_m.attr('href', stores[key].ht_whatsapp_link); 
					store_whatsapplink_m.attr('data-label', stores[key].title); 
				}else{
					whatsapplink_contact = store_template.find('.whatsapplink.visible-xs');
					whatsapplink_contact.hide().addClass('hidden-xs');
				}

				store_category = store_template.find('.store-category');

				//check for null value
				if(stores[key].category_img){
					if( stores[key].category_img.indexOf("wp-content/uploads") > -1){
						var service_img = "<img src='"+stores[key].category_img+"' class='img-responsive'/>";
						store_category.html(service_img);
					}else{
						store_category.html(stores[key].category_img);
					}	
				}

				if(typeof (stores[key].ht_dtc_zero_percent_outlet) != 'undefined' && stores[key].ht_dtc_zero_percent_outlet =="on"){
					//store-xpo
					store_zpo = store_template.find('.store-zpo');
					store_zpo.html("<div class='col-sm-5'><p><img src='/wp-content/uploads/zpo.png' alt='0% interest payment plans'></div><div class='col-sm-7'>0% interest installment plan</p></div>");
					store_zpo.removeClass("visible-xs");
					store_zpo_uhp = store_template.find('.store-zpo-uhp');
					store_zpo_uhp.html("<p><strong>Available Here:</strong></p>");
				}

				if(typeof (stores[key].ht_uhp_rof_tyre_available) != 'undefined' && stores[key].ht_uhp_rof_tyre_available =="on"){
					//store-xpo
					store_uhp = store_template.find('.store-uhp');
					store_uhp.html("<div class='col-sm-5'><p><img src='/wp-content/uploads/uhp-rof.png' alt='David Tyre Company UHP Tires and Run-On-Flat Tires'></div><div class='col-sm-7'>David Tyre Company UHP Tires and Run-On-Flat Tires</p></div>");
					store_uhp.removeClass("visible-xs");
					store_zpo_uhp = store_template.find('.store-zpo-uhp');
					store_zpo_uhp.html("<p><strong>Available Here:</strong></p>");
				}	
				
				store_template.appendTo(this._store_list);
				
				$("html, body").animate({scrollTop: 0}, 0);
			}	
		},
	}

	STORES.init();
	
});
jQuery(document).ready(function ($) {

	//tooltip
	$('[data-toggle="tooltip"]').tooltip();

	$(window).load(function () {
		$('.preload').fadeOut();

		if(!isMobile()){			
			new WOW().init({
				offset:       200,
				mobile:       false
			});	
		}


	});


	/* checkbox label link handler */
	$('label a, .dtc-section a').click(function(e){
		e.preventDefault();
		if( $(this).attr('target') == undefined ) {
			window.location = $(this).attr('href');
		}else{
			window.open($(this).attr('href'),$(this).attr('target'));
		}
	});


	/*
	 $(window).scroll(function(e){
	 var wintop = $(window).scrollTop();
	 var winheight = $(window).height();
	 topcoords = $('#banner').offset().top;
	 if(wintop > (topcoords - (winheight*.75))){
	 $('.baner-box-detail').animate({
	 'opacity' : '1',
	 'bottom' : '0px'
	 }, 1000);
	 }
	 });
	 */




	//--baidu tracking-- track outbound links
	"use strict";
	
	// 0. GA TRACKING +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	// current page host
	var baseURI = window.location.host;	 
	// click event on body
	// $("body").on("click", function(e) {	 
	// 	// abandon if link already aborted or analytics is not available
	// 	// Emil removed ga is present criteria
	// 	// console.log('track outbound link');

	// 	if (e.isDefaultPrevented()) return;	 
	// 	// abandon if no active link or link within domain
	// 	var link = $(e.target).closest("a");
	// 	// console.log(link, link[0].host);
	// 	// e.preventDefault();	return;

	// 	if (link.length != 1 || baseURI == link[0].host) { return; }
	// 	// cancel event and record outbound link
	// 	e.preventDefault();
	// 	var href = link[0].href;
	// 	var target = link[0].target;
	// 	console.log("targetURL",href);
	// 	_hmt.push (['_trackEvent', "clicks", "outbound link click", href]);	 

	// 	// redirect after one second if recording takes too long
	// 	setTimeout(loadPage, 1000);	 
	// 	// redirect to outbound page
	// 	function loadPage() {
	// 		if(target){
	// 			window.open(href, target);
	// 		}else{
	// 			document.location = href;	
	// 		}			
	// 	}

	// });


	
	$(".wechat").on("click", function(e) {	
		trackWechat();
	}); 


	function trackWechat(){
		//for baidu CN tracking
		console.log("wechat tracking");
		_hmt.push (['_trackEvent', "navigation", "click", "we-chat"]);
	}




	if($('#wapper').hasClass('home')) {
	// if($("#home-blade-2").length > 0) {
		// $("#home-blade-2").attr("data-wow-delay","0.5s");
		var blades = $('#wapper > .st.bg-holder');
		// console.log(blades.length);

		//home blades
		for(var i=3; i<blades.length; i++) {
			var blade=blades[i];
			$(blade).addClass("wow fadeIn");
			$(blade).attr("data-wow-offset",250);

			// console.log($(blade).find('.offers-box-info-content > .title'));
			// console.log('len',$(blade).find('.offers-box-info-content > .title').length);
			
			//Noel:commented because pre loader is remove
			//if($(blade).find('.offers-box-info-content > .title').length >0 ){
				// console.log('right?',$(blade).find('.offers-box-info-content .title').hasClass('pull-right'));
				//if($(blade).find('.offers-box-info-content > .title').hasClass('pull-right') ){
					//$(blade).find('.offers-box-info-content h1').addClass("wow fadeInRight");
					//$(blade).find('.offers-box-info-content .offer_sub_title').addClass("wow fadeInRight");
					//$(blade).find('.offers-box-info-content .more').addClass("wow fadeInRight");
				//}else{
					//$(blade).find('.offers-box-info-content h1').addClass("wow fadeInLeft");
					//$(blade).find('.offers-box-info-content .offer_sub_title').addClass("wow fadeInLeft");
					//$(blade).find('.offers-box-info-content .more').addClass("wow fadeInLeft");
				//}


			//}
		}

		// $("#home-blade-2").addClass("wow fadeIn");
		// $("#home-blade-2").attr("data-wow-offset",250);
		// $("#home-blade-3").addClass("wow fadeIn");
		// $("#home-blade-3").attr("data-wow-offset",250);
		// $('#home-blade-3 .offers-box-info-content h1').addClass("wow fadeInLeft");
		// $('#home-blade-3 .offers-box-info-content .offer_sub_title').addClass("wow fadeInLeft");
		// $('#home-blade-3 .offers-box-info-content .more').addClass("wow fadeInLeft");

		$(".offers-box-info-content h1").attr("data-wow-delay","0.5s");
		$(".offers-box-info-content .offer_sub_title").attr("data-wow-delay","0.6s");
		$(".offers-box-info-content .more").attr("data-wow-delay","0.7s");
		
		var banner = $('.vc_col-sm-4');
		// console.log(banner);
		// feature banner boxes
		for(var i=0;i<banner.length;i++){
			$(banner[i]).find('.banner_feature.baner-box.hidden-xs').attr("data-wow-delay", (i*0.3)+"s");
		}
		$('.banner_feature.baner-box.hidden-xs').addClass("wow fadeIn");

	}//end home check

	




	// 0. LIGHTBOX (SOCIAL) +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	$("a[rel^='prettyPhoto']").prettyPhoto({
		social_tools: false
	});




	// 0. PLACEHOLDER SEARCH +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	var placeholder = 'SEARCH';
	$('.navbar-form .search').blur(function () {
		if ($(this).val() == '')
			$(this).val(placeholder).addClass('placeholder');
	}).focus(function () {
		if ($(this).val() == placeholder)
			$(this).val('').removeClass('placeholder');
	}).val(placeholder).addClass('placeholder');
	var placeholder2 = 'Select a tyre to compare';
	$('.type-input-select').blur(function () {
		if ($(this).val() == '')
			$(this).val(placeholder2).addClass('placeholder');
	}).focus(function () {
		if ($(this).val() == placeholder2)
			$(this).val('').removeClass('placeholder');
	}).val(placeholder2).addClass('placeholder');
	
	// var placeholder3 = '查找城市';
	// $('.store-input-search').blur(function () {
	// 	if ($(this).val() == '')
	// 		$(this).val(placeholder3).addClass('store-seach-place');
	// }).focus(function () {
	// 	if ($(this).val() == placeholder3)
	// 		$(this).val('').removeClass('store-seach-place');
	// }).val(placeholder3).addClass('store-seach-place');


	




	// 0. MISC FUNCTIONS +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	$('.backtotop ').click(function () {
		$('html,body').animate({
			scrollTop: 0
		}, 700);
	})

	$('.store-input-search').click(function () {
		$('.location-me').show();
	})


	if ($('#wpadminbar').length) {
		$('.navbar-fixed-top').css({
			top: '32px'
		})
	}
	var senseSpeed = 5;
	var previousScroll = 0;

	$(window).scroll(function (event) {
		var scroller = $(this).scrollTop();
		if (scroller - senseSpeed > previousScroll) {
			// $("#topbar").filter(':not(:animated)').slideUp(200);
			$("#topbar").filter(':not(:animated)').animate({
				top:"-70"
			},300);
		} else if (scroller + senseSpeed < previousScroll) {
			// $("#topbar").filter(':not(:animated)').slideDown(200);
			$("#topbar").filter(':not(:animated)').animate({
				top:"0"
			},300);
		}
		previousScroll = scroller;
	});


	$('.print').click(function () {
		//--baidu tracking--
		var pagePath=window.location.pathname;
		// console.log(window.location.pathname);
		_hmt.push (['_trackEvent', "clicks", "print page", pagePath]);
		window.print();
	});



	// 0. HELPER FUNCTION ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	function GetParameterOBJ(data, url) {
		$.each(data, function (index, value) {
			if (url.indexOf(index + "=") >= 0) {
				 var prefix = url.substring(0, url.indexOf(index));
				 var suffix = url.substring(url.indexOf(index));
				 suffix = suffix.substring(suffix.indexOf("=") + 1);
				 suffix = (suffix.indexOf("&") >= 0) ? suffix.substring(suffix.indexOf("&")) : "";
				 console.log(prefix);
				 url = prefix + index + "=" + value + suffix;
			}
			else {
				 if (url.indexOf("?") < 0)
						url += "?" + index + "=" + value;
				 else
						url += "&" + index + "=" + value;
			}
		});
		console.log(url);
		return url;
	}
	function setGetParameterOBJ(data) {

		var url = window.location.href;
		var hash = window.location.hash;
		url = url.substr(0,url.indexOf('#')); //without hash
		$.each(data, function(index,value){
			if (url.indexOf(index + "=") >= 0) {
				var prefix = url.substring(0, url.indexOf(index));
				var suffix = url.substring(url.indexOf(index));
				suffix = suffix.substring(suffix.indexOf("=") + 1);
				suffix = (suffix.indexOf("&") >= 0) ? suffix.substring(suffix.indexOf("&")) : "";
				url = prefix + index + "=" + value + suffix;
			}
			else {
				if (url.indexOf("?") < 0)
					url += "?" + index + "=" + value;
				else
					url += "&" + index + "=" + value;
			}
		});
		url = url+hash;
		console.log("setGet ParameterOBJ");
		window.location.href = url;
	}










	// 0. BANNER FEATURE +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	var isTouch =  !!("ontouchstart" in window) || window.navigator.msMaxTouchPoints > 0;
	if( !isTouch ){
		$('.banner_feature').hover(function () {
				clearTimeout($.data(this, 'timer'));
				// $(this).stop(true, true).animate({
					// 'height': '120px'
				// }, 500);
				$(this).find('.baner-box-detail').stop(true, true).animate({
					'height': '120px'
				}, 400);
				$(this).find('.thumb-link').stop(true, true).animate({
					'opacity': '0.6'
				}, 400);

		}, function () {
				$.data(this, 'timer', setTimeout($.proxy(function () {
					$(this).find('.baner-box-detail').stop(true, true).animate({
						 'height': '60px'
					}, 400);
					$(this).find('.thumb-link').stop(true, true).animate({
						'opacity': '1'
					}, 400);

				}, this), 100));
		});
	}


	/*
	$('.baner-box-detail').hover(function () {
		clearTimeout($.data(this, 'timer'));
		$(this).stop(true, true).animate({
			'height': '120px'
		}, 500);
	}, function () {
		$.data(this, 'timer', setTimeout($.proxy(function () {
			$(this).stop(true, true).animate({
				'height': '60px'
			}, 500);
		}, this), 100));
	});*/


	var widthWapper = $('#wapper').width();
	var offset = $('#wapper').offset();
	$('.nav-destop li ul').css({
		'width': widthWapper,
		'left': offset.left
	});
	var navbarHeight = $('.navbar').height();
	//Scroll
	$('.scroll-down a').bind('click', function (event) {
		event.preventDefault ? event.preventDefault() : event.returnValue = false;
		var $anchor = $(this);
		var $next = $($anchor.attr('href'));
		if ($next.length <= 0) return;
		$('html, body').stop().animate({
			scrollTop: $($next).offset().top - navbarHeight
		}, 1000);
	});
	var navbarHeight = $('.navbar').height();


	//$('.nav-main li ul').css('top', navbarHeight);

	/**
	 * @todo what purpose for this 2 lines? It broke mobile menu!
	 */
	//var navChildHtml = $('.nav-main li ul').html();
	//$('.nav-main li ul').html('<div class="nav-child-wap">' + navChildHtml + '</div>');



	// 0. HOME PAGE +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
	// desktop main menu
	var isHovered = false;
	var isAnimating=false;
	$('.nav-destop').mouseleave(function (e) {
		$(e.delegateTarget).find('ul.sub-menu').stop(true, true).slideUp(200, resetAnim);
		isHovered = false;
		console.log("--mouse leave");
	});
	$('.nav-destop').find('>li').mouseenter(function() {
		
		// if(isAnimating) return;
		// isAnimating=true;

		var _this = $(this);
		console.log("--mouse enter");
		if(isHovered) {
				// _this.siblings().find('>ul.sub-menu').stop(true, true).slideUp(200);
				// _this.find('>ul.sub-menu').stop(true, true).delay(300).slideDown(300);
				_this.siblings().find('>ul.sub-menu').stop(true, false).slideUp(200);
				_this.find('>ul.sub-menu').delay(250).slideDown(300, resetAnim);
		} else {
				_this.find('>ul.sub-menu').stop(true, false).slideDown(300, resetAnim);
				isHovered = true;
		}

	});

	function resetAnim() {
		// isAnimating=false;
	}
	/*
	var isHovered = false;
	$('.nav-destop').mouseleave(function (e) {
		$(e.delegateTarget).find('ul.sub-menu').stop(true, true).slideUp(300);
		// $(e.delegateTarget).find('ul.sub-menu').stop(true, true).animate({
		// 		'top': '-30px'
		// 	}, 400);
		isHovered = false;
	}).find('>li').mouseenter(function() {
		var _this = $(this);
		if(isHovered) {
				_this.siblings().find('>ul.sub-menu').stop(true, true).slideUp(300);
				// _this.siblings().find('>ul.sub-menu').stop(true, true).animate({
				// 		'top': '-30px'
				// 	}, 400);
				_this.find('>ul.sub-menu').stop(true, true).delay(400).slideDown(300);
				// _this.find('>ul.sub-menu').stop(true, true).css('display','block');
				// _this.find('>ul.sub-menu').stop(true, true).delay(300).animate({
				// 		'top': '97px'
				// 	}, 400);
		} else {
				_this.find('>ul.sub-menu').stop(true, true).slideDown(300);
				// _this.find('>ul.sub-menu').stop(true, true).css('display','block');
				// _this.find('>ul.sub-menu').stop(true, true).animate({
				// 		'top': '97px',
				// 		'display':'block'
				// 	}, 400);
				isHovered = true;
		}
	});
	*/



	
	// mobile main menu
	$('.nav-mobile li').on('click', function () {
		var childen = $(this).find('ul');
		if ($(childen).is(':hidden')) {
			$(this).addClass('top');
			$(childen).slideDown();
		}else{
			$(this).removeClass('top');
			$(childen).slideUp();
		}
	});












	// MOBILE BANNER
	$('#mobile-burger-btn').on('click', function () {
		if ($('.nav-mobile').is(':hidden')) {
			$(this).css('background', '#004ea8');
			$('#navbar').slideDown();
		} else {
			$(this).css('background', 'none');
			$('#navbar').slideUp();
		}

		//hide search
		$('#navbar-form-mobile').slideUp();
		$('.collapsed-search').css('background', 'none');
	});
	$('.collapsed-search').on('click', function () {
		if ($('#navbar-form-mobile').is(':hidden')) {
			$(this).css('background', '#004ea8');
			$('#navbar-form-mobile').slideDown();
		} else {
			$(this).css('background', 'none');
			$('#navbar-form-mobile').slideUp();
		}

		//hide main
		$('#navbar').slideUp();
		

	});
	// $('.collapsed-search').on('click', function () {
	// 	$('#navbar-form-mobile').slideToggle();
	// });
	if ($(window).outerWidth() + 17 < 768) {
		var heightMore = $('.blade-first .more').outerHeight();
		$('.blade-first h2').css('bottom', heightMore + 15 + 'px');
	}
	if ($(window).outerWidth() + 17 < 1000) {
		$('.main h1').css('bottom', 25);
	}

	//if ($('#main .item img').length) {
	//    $('#main .item img').load(function () {
	//        var ht_title_banner = $('.ht_title_banner').height();
	//        var breadcrumb = $('.breadcrumb').height();
	//        var height_main = ht_title_banner + 15 + navbarHeight + 55 + breadcrumb;
	//        $('.social_bar').css({
	//            top: (ht_title_banner + 15 + navbarHeight + 35 + breadcrumb ) + 'px',
	//            position: 'relative',
	//            right: '0px'
	//        });
	//        $('.main h1').css({top: (navbarHeight + 35 + breadcrumb + 35) + 'px'});
	//        console.log(1);
	//        var image_item = $('#main .item img').height();
	//        if (image_item < height_main) {
	//            $('#main').css('height', height_main + 'px')
	//        } else {
	//            $('#main').css('height', image_item + 'px')
	//        }
	//        if ($(window).width() < 768)
	//            $('.main h1').css('bottom', (image_item / 2 - 15));
	//        //} else {
	//        //    $('.main h1').css('bottom', (image_item / 2 - 50));
	//        //}
	//    })
	//} else {
	//    var ht_title_banner = $('.ht_title_banner').height();
	//    var breadcrumb = $('.breadcrumb').height();
	//    var height_main = ht_title_banner + 15 + navbarHeight + 55 + breadcrumb;
	//    $('.social_bar').css({
	//        top: (ht_title_banner + 15 + navbarHeight + 35 + breadcrumb ) + 'px',
	//        position: 'relative',
	//        right: '0px'
	//    });
	//    $('#main').css('height', height_main + 'px')
	//    $('.ht_title_banner').css({top: (navbarHeight + 35 + breadcrumb + 35) + 'px'});
	//}




















	// 1. RESPONSIVE +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	$(window).resize(function () {
		var widthWapper = $('#wapper').outerWidth();
		var offset = $('#wapper').offset();
		var height = $('.img-responsive').height();
		$('.nav-destop li ul').css({
			'width': widthWapper,
			'left': offset.left
		});
		if ($(window).width() + 17 < 768) {
			var heightMore = $('.blade-first .more').outerHeight();
			$('.blade-first h2').css('bottom', heightMore + 15 + 'px');
			$('.main h1').css('bottom', (height / 2 - 15));
		} else {
			$('.main h1').css('bottom', (height / 2 - 50));
		}
	});
	$('.main .breadcrumb').css('top', (navbarHeight + 35) + 'px');



	// 2. STORE-CAROUSEL +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	$("#store-carousel").owlCarousel({
		autoPlay: 3000,
		navigation: true,
		slideSpeed: 300,
		paginationSpeed: 400,
		singleItem: true
	});
	/* dropdown */
	$('html').click(function () {
		if ($(this).hasClass('dropdown')) {
			$(this).children('.dropdown-menu').show();
		} else {
			$(this).children('.dropdown-menu').hide();
		}

	});
	/* footer nav */
	$('#bottom h5 a').on('click', function () {
		$(this).parent().next().slideToggle();
		return false;
	})



	// 2. some checkbox ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	function update_compares(compare_arr){
		//save compare to cookies
		var str_tyre_compare = compare_arr.join(',');
		console.log('str_tyre_compare: '+str_tyre_compare);

		$.cookie('ftcompare',str_tyre_compare);

	}
	function capture_compare_smallbox(){
		var arr_tyre_compare = [];
		$('.compare_item').each(function () {
			if ($(this).find('.compare_item_content').html().length > 0) {
				var compare_id = $(this).find('.compare_item_content').attr('attr_id');
				arr_tyre_compare.push(compare_id);
			}
		})

		update_compares(arr_tyre_compare);

	}

	$('body').on('click', '.input_checkbox', function () {

		//count selected items 

		if($('.compare_item div[class*=compare_add_]').length == 3){

			if($('.compare_add_'+ $(this).attr('attr_id') ).length != 1){
				$('.compare-warning').stop(true).fadeOut();
				warning_message = $(this).siblings('.compare-warning');
				//basta tumigil ka na
				$(warning_message).stop(true).hide().fadeIn().delay(1500).fadeOut();
				return false;
			}
			
		}

		var obj = $(this), status, id, thumb, title;
		id = obj.attr('attr_id');
		thumb = obj.attr('attr_thumb');
		title = obj.attr('attr_title');
		if (obj.parent().find('.uncheck').hasClass('uncheck')) {
			obj.parent().find('.uncheck').removeClass('uncheck').addClass('checked');
			obj.attr("checked", true);
			status = 'add';
		} else {
			obj.parent().find('.checked').removeClass('checked').addClass('uncheck');
			obj.attr("checked", false);
			status = 'remove';
		}

		if (status == 'add') {
			var height = '';
			$('.compare_item').each(function () {
				var compare_item_content = $(this).find('.compare_item_content');
				if (compare_item_content.html().length < 1) {
					$(this).find('.default-text').html('');
					var height_ht_compare_center= $('.ht_compare_center').height();
					var height_ht_compare= $('.ht_compare_center .compare').height();
					$('.ht_compare_center .compare').css({
						marginTop:(height_ht_compare_center-height_ht_compare)/2+'px'
					})
					compare_item_content.addClass('compare_add_' + id);
					compare_item_content.attr('attr_id',id);
					html = '<p><img width=50px height=50px src=" ' + thumb + '"><span class="hidden-xs">' + title + '</p><span attr_id="' + id + '" class="remove">x</span>';
					compare_item_content.html(html)
					setTimeout(function(){
						var height_cur = compare_item_content.height();
						if(height_cur>=height){
							height = height_cur
							console.log(height);
							check_height_compare_item(height);
						}
					},800   );
					return false
				}
			})


		}
		if (status == 'remove') {
			var height_ht_compare_center= $('.ht_compare_center').height();
			var height_ht_compare= $('.ht_compare_center .compare').height();
			$('.ht_compare_center .compare').css({
				marginTop:(height_ht_compare_center-height_ht_compare)/2+'px'
			})
			// $('.compare_add_' + id).html('');
			// $('.compare_add_' + id).parent().find('.default-text').html('Select a tyre to compare');
			$('.compare_item_content[attr_id=' + id + ']').html('');
			$('[attr_id=' + id + ']').removeClass('compare_add_' + id);
			$('[attr_id=' + id + ']').parent().find('.default-text').html('Select a tyre to compare');
		}

		remove();

		capture_compare_smallbox();

	});




	// 4. COMPARE TYRES  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	function remove() {
		$('body').on('click', '.compare_item_content span', function () {
			var target = $(this);
			var target_parent_div = target.parent().closest('div');
			var id = target_parent_div.find('span.remove').attr('attr_id');
			var height_ht_compare_center= $('.ht_compare_center').height();
			var height_ht_compare= $('.ht_compare_center .compare').height();
			$('.ht_compare_center .compare').css({
				marginTop:(height_ht_compare_center-height_ht_compare)/2+'px'
			})
			$('.button_compare_' + id).removeClass('checked').addClass('uncheck');
			target_parent_div.removeClass('compare_add_' + id);
			target_parent_div.html('');
			target_parent_div.prev('.default-text').html('Select a tyre to compare');

			capture_compare_smallbox();

		});
		//$('.compare-close').click(function () {
		//    var id = $(this).attr('attr_id');
		//    $('.compare_box_id_' + id).html('');
		//})
		$('.compare_remove_mobile').click(function () {
			var id = target.attr('attr_id');
			$('.compare_box_id_' + id).html('');
		})
	}

	remove();

	$('body').on('click', '.compare-box', function () {

		var href = $(this).find('a').attr('href');
		var compare_null = 0;
		var compare_id='';
		data = {};
		data['tyre'] =[];
		$('.compare_item').each(function () {
			if ($(this).find('.compare_item_content').html().length < 1) {
				compare_null++;
			}else{
				compare_id = $(this).find('.compare_item_content').attr('attr_id');
				data['tyre'].push(compare_id);
			}
		})
		if (compare_null >= 2) {
			alert('Min tyre to compare 2 ')
		} else {
			data['compare_true']=1
			setGetParameterOBJ(data);
		}
	});

	function check_height_compare_item(maxheight){
		$('.compare_item').css({
			height:maxheight+'px'
		})
	}




	// 5. TYRE DETAILS PAGE VIDEO + CAROUSEL +++++++++++++++++++++++++++++++++++++++++++
	if ($('#slider').length) {
		$('#slider').flexslider({
			animation: "fade",
			controlNav: false,
			animationLoop: false,
			smoothHeight: false,
			slideshow: false,
			before: stopFlexVideo,
			sync: "#carousel"
		});
		$('#carousel').flexslider({
			animation: "slide",
			controlNav: false,
			animationLoop: false,
			slideshow: false,
			itemWidth: 75,
			maxItems: 4,
			minItems: 3,
			itemMargin: 15,
			asNavFor: '#slider'
		});
	}

	function stopFlexVideo(){
		//stopVideo(); // stop youtube video
		console.log("stop video");
		var vv=$(".video-js video");
		// console.log(vv);
		for(var i=0;i<vv.length;i++){
			vid=vv[i].getAttribute("id");
			// console.log(vid);
			// console.log(videojs(vid));
			videojs(vid).pause();
			// videojs(vid).hide();
		}
		// var api = flowplayer();
		// var i=0;
		// while( flowplayer(i) !==undefined ){
		// 	console.log( flowplayer(i) );
		// 	// flowplayer(i).stop();
		// 	i++;
		// }
	}






























	// ---------------------------------------------------------------------
	


	function getUrlParameter(sParam) {
		var sPageURL = window.location.search.substring(1);
		var sURLVariables = sPageURL.split('&');
		for (var i = 0; i < sURLVariables.length; i++) {
			var sParameterName = sURLVariables[i].split('=');
			if (sParameterName[0] == sParam) {
				 return sParameterName[1];
			}
		}
	}

	function setGetParameter(paramName, paramValue) {
		var url = window.location.href;
		if (url.indexOf(paramName + "=") >= 0) {
			var prefix = url.substring(0, url.indexOf(paramName));
			var suffix = url.substring(url.indexOf(paramName));
			suffix = suffix.substring(suffix.indexOf("=") + 1);
			suffix = (suffix.indexOf("&") >= 0) ? suffix.substring(suffix.indexOf("&")) : "";
			url = prefix + paramName + "=" + paramValue + suffix;
		}
		else {
			if (url.indexOf("?") < 0)
				 url += "?" + paramName + "=" + paramValue;
			else
				 url += "&" + paramName + "=" + paramValue;
		}


		if(paramName == 'category'){
			url = removePaged(url);
			url = removeParam('feature', url);
		}

		window.location.href = url;
	}
	function removePaged(url) {
		return url.replace(/page\/[1-99]/,"");
	}

	function removeParam(key, sourceURL) {
			var rtn = sourceURL.split("?")[0],
					param,
					params_arr = [],
					queryString = (sourceURL.indexOf("?") !== -1) ? sourceURL.split("?")[1] : "";
			if (queryString !== "") {
					params_arr = queryString.split("&");
					for (var i = params_arr.length - 1; i >= 0; i -= 1) {
							param = params_arr[i].split("=")[0];
							if (param === key) {
									params_arr.splice(i, 1);
							}
					}
					rtn = rtn + "?" + params_arr.join("&");
			}
			return rtn;
	}




	//filter tyre dropdown
	$('select#category-filter-mobile').change(function(){
		setGetParameter('category', $(this).val() );
	});

	$('.type-cate label').click(function () {
		var getID = $(this).attr('for').split('_');
		editUrl_fix(getID[0], getID[1]);
		//setGetParameter(getID[0], getID[1]);
		if ($(this).hasClass('type_checked') == true) {
			$(this).removeClass('type_checked')
		} else {
			$(this).addClass('type_checked');
		}
	});
	$('.tab-content-fix input#filtertyre_rof').click(function () {
		var rof_on = ($(this).is(':checked'))? 'on':'off';
		setGetParameter('rof', rof_on );
	});


	$('.post_per_page').change(function () {
		var getID = $(this).val();
		setGetParameter('post_per_page', getID);
	});

	function editUrl_fix(type, id) {
		var checktype = '';
		if (getUrlParameter(type)) {
			checktype = getUrlParameter(type);
		}
		if (checktype !=id) {
			checktype=id
		} else {
			checktype='';
		};
		
		setGetParameter(type, checktype);
	}
	function editUrl(type, id) {
		var checktype = [];
		if (getUrlParameter(type)) {
			checktype = getUrlParameter(type).split(',');
		}
		if ($.inArray(id, checktype) > -1) {
			checktype = $.grep(checktype, function (value) {
				 return value !== id;
			})
		} else {
			checktype.push(id);
		};
		setGetParameter(type, checktype.join(','));

	}

	$('.box-colspace h2.title').on('click', function(){
		if($(this).parent('.box-colspace').find('.box-colspace-content').is(':hidden')){
			$(this).removeClass('box-close').addClass('box-open');
			$(this).parent('.box-colspace').find('.box-colspace-content').slideDown();
		}
		else{
			$(this).removeClass('box-open').addClass('box-close');
			$(this).parent('.box-colspace').find('.box-colspace-content').slideUp();
		}
		return false;
	});

	$('.table-mobile').owlCarousel({
		navigation: false, // Show next and prev buttons
		slideSpeed: 300,
		pagination: false,
		paginationSpeed: 400,
		singleItem: true
	})

	$('.box-colspace').each(function () {
		if ($(this).find('h2').hasClass('box-close')) {
			$(this).find('.box-colspace-content').hide();
		}
		if ($(this).find('h2').hasClass('box-open')) {
			$(this).find('.box-colspace-content').show();
		}
	})

	


	
	$('.ht_find_vehicle span').each(function (val, index) {
		var check = $(this).attr('attr_id');
		if (check) {
			$(this).css({
				color: '#013A82'
			})
		}
	})

	$('.learn_tab a').on('click', function () {
		if ($(this).hasClass('learn_tab_active')) {
			$(this).removeClass('learn_tab_active');
		} else {
			$('.learn_tab a').removeClass('learn_tab_active');
			$(this).addClass('learn_tab_active');
		}
	});

	$('.box-colspace-learn h2.title').on('click', function(){
		if($(this).next('.box-colspace-content-learn').is(':hidden')){
			$(this).removeClass('box-close-learn').addClass('box-open-learn');
			$(this).next('.box-colspace-content-learn').slideDown();
		}
		else{
			$(this).removeClass('box-open-learn').addClass('box-close-learn');
			$(this).next('.box-colspace-content-learn').slideUp();
		}
		return false
	});

	$('.learn_title').on('click', function() {
		var obj = $(this).parent();
		if ($(this).hasClass('learn_title_active')) {
			$(this).removeClass('learn_title_active');
			obj.find('.learn_content').slideUp();
		} else {
			$(this).addClass('learn_title_active');
			obj.find('.learn_content').slideDown();

			//--baidu tracking--
			var parenth2=$(this).parent().parent().parent().parent().find('h2');
			blabel = $(parenth2).text() + " - " + $(this).text();
			// console.log(blabel);
			_hmt.push (['_trackEvent', "clicks", "FAQ", blabel]);


		}
	});

	$('.learn-right-content').on('click', function () {
		//var height = $(this).parents('.box-colspace-learn').offset().top;
		$('body,html').animate({
			//scrollTop: height - 40
			scrollTop: 0
		}, 400);
	});
	$('.corporate_back_to_top').on('click', function () {
		$('body,html').animate({
			scrollTop: 0
		}, 800);
	});
	
	$('.cn-learn-right-content').on('click', function () {
		$('body,html').animate({
			scrollTop: 0
		}, 800);
	});
	

	$('.aboutus-right-content').on('click', function () {
		var height = $(this).parents('.aboutus-tab-content').offset().top;
		$('body,html').animate({
			scrollTop: height - 40
		}, 800);
	});














	$('.text-custom-search img').click(function () {
		var getID = $(this).attr('for').split('_');
		editUrl(getID[0], getID[1]);

	});
	$('.type-box').each(function () {
		var type_left_h = $(this).find('.type-left').height(),
			type_right_h = $(this).find('.type-right').height();

		if (type_left_h <= type_right_h) {
			$(this).find('.type-right').addClass('type_border');
		} else {
			$(this).find('.type-left').addClass('type_border');

		}
	});

	$('.ht_custom_select_tab').change(function () {
		var val = $(this).val();
		$('.ht_custom_tab').hide();
		$('#' + val).show();
	})
	$('.ht_light_box').magnificPopup({
		type: 'image',
		closeOnContentClick: true,
		closeBtnInside: false,
		fixedContentPos: true,
		mainClass: 'mfp-no-margins mfp-with-zoom', // class to remove default margin from left and right side
		image: {
			verticalFit: true
		},
		zoom: {
			enabled: true,
			duration: 300 // don't foget to change the duration also in CSS
		}
	});



	$(window).load(function () {
		var height_sticky = $('.ht_custom_sticky_compare_box').offset();
		var width_compare = $('.ht_custom_sticky_compare_box').width() + 70;
		if (height_sticky) {
			height_sticky = height_sticky.top - 500;
			$(window).scroll(function () {
				 var height_scroll_cur = window.scrollY
				 if (height_scroll_cur > height_sticky) {
						$('.type-bottom-destop').css({
							position: 'static',
							bottom: '',
							width: '',
							zIndex: '',
							'margin-left': '0px'
						})
				 } else {
						$('.type-bottom-destop').css({
							position: 'fixed',
							bottom: '0px',
							//width: (width_compare - 30) + 'px',
							width: width_compare + 'px',
							zIndex: 10000,
							
							'margin-left': '-35px'
						})
				 }
			})
		}
	});

	$(document).on('click', '.compare-close, a.btn-add-tyre', function () {
		var count_compare = $('.have_tyre').length,
			id = $(this).attr('attr_id'),
			list_id = $('.information').attr('attr_id'),
			url = $('.information').attr('attr_url');
			$('.tyre_title_id_'+id).html('');

		list_id_array = list_id.split(',');
		if (list_id_array) {
			list_id_array = $.grep(list_id_array, function (value) {
				 return value != id;
			});
		}

		//update cookie
		update_compares(list_id_array);

		var data ={};
		data['compare_item_return']=list_id_array.join(',')
		console.log("data " + data);
		$('.information').attr('attr_id',data['compare_item_return']);
		var url_fix = window.location.protocol + '//' + window.location.host + window.location.pathname + GetParameterOBJ(data,"")
		
		//default find-tyre page
		//var tyre_listing_url = url_fix.substr(0, url_fix.indexOf('filter-tyre')) + 'filter-tyre' +GetParameterOBJ(data,"");
		var tyre_listing_url = url_fix; //go to filtering page

		if (count_compare > 2) {
			var obj = $(this).parents('.compare-top-box');
			obj.removeClass('have_tyre')
			$(this).remove();
			$('.box-colspace-content').find('.compare_box_id_'+id).html('');
			obj.find('.wp-post-image').remove();
			obj.find('.tyre-desc').remove();
			// obj.find('.find-store').html('<h2 class="text-center">同时可以比较3款轮胎产品</h2><a href="' + url_fix + '" class="btn-find-store btn-add-tyre">增加轮胎</a>');
			obj.find('.if-no-tyre').css("display","block");
			obj.find('.if-have-tyre').css("display","none");
			obj.find('.if-no-tyre .return-url').attr("href",url_fix);			
			$('.tyre_title_id_'+id).html('<a href="'+url_fix+'" class="return-url btn-find-store btn-add-tyre text-center" style="margin:-10px 5px !important; padding: 10px 0 7px 20px !important;">Add a tyre</a>');
		} else {
			window.location = tyre_listing_url;
		}

	});



	//$('.compare-top-box-desc').find('.compare-image').css({
	//    height:max_height+'px'
	//})


	//var height_compare ='';
	//$('.compare-top-box-desc').each(function(){
	//    var height_cur = $(this).find('.find-store').height();
	//    if(height_cur >= height_compare){
	//        height_compare = height_cur;
	//        console.log(height_cur);
	//
	//    }
	//})
	//$('.compare-top-box-desc').find('.find-store').css({
	//    height:height_compare+'px'
	//})


	




















	// 6. Scroll Timeline  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	var iScrollPos = 0;

	var wHeight=$(window).height();
	console.log("wh",wHeight);
	console.log("dh",$(document).height());

	// init
	var blowFixed = $('.blow-fixed');
	var midpoint=wHeight/2;
	// console.log("midpoint",midpoint);

	//listener
	$(window).resize(function () {
		wHeight=$(window).height();
		midpoint=wHeight/2;
		// console.log("midpoint",midpoint);
	});



	var timeline = $('.timeline');
	if ((timeline.length > 0) && !$('body').hasClass('breakpoints-768') ){			
			$(window).scroll(function () {				
				checkTimeline();
			});
		checkTimeline();
	}
	function checkTimeline(){
		var timelineOffsetTop = timeline.offset().top;
		var timelineHeight = timeline.height();

		var timelineDetail = timeline.find('.timeline-detail');
		var lastTimelineDetail = timelineDetail.filter(':last');
		var lastTimelineDetailOffsetTop = lastTimelineDetail.offset().top;
		

		blowFixed.css("top", midpoint + "px");

		var iCurScrollPos = $(this).scrollTop() + midpoint;
		// console.log(iCurScrollPos, midpoint);

		if (iCurScrollPos >= timelineOffsetTop && iCurScrollPos <= (timelineOffsetTop + timelineHeight)) { //if within the top dot and the bottom of timeline
			
			// console.log("within");

			blowFixed.css('display', function(){
				return iCurScrollPos >= lastTimelineDetailOffsetTop ? 'none' : 'block';
			});

			timelineDetail.each(function(index, element){
				var self = $(element);
				var selfOffsetTop = self.offset().top;
				var selfOffsetBottom = selfOffsetTop + self.height();

				if (iCurScrollPos > iScrollPos) { //if scrolling down
					// console.log("v");
					if (iCurScrollPos >= selfOffsetTop ) {
					// if (iCurScrollPos >= selfOffsetTop && iCurScrollPos <= selfOffsetBottom) {
						timelineDetail.removeClass('timeline-active');
						self.addClass('timeline-active');
						if(!isMobile()){
							self.find('.timeline-effect').fadeIn('slow');
						}
						// self.find('.timeline-effect').css("display","block");
					}
				}
				else { //scrolling up
					// console.log("^");
					if (iCurScrollPos <= selfOffsetTop + 100) {
					// if (iCurScrollPos >= selfOffsetTop && iCurScrollPos <= selfOffsetTop + 100) {
						timelineDetail.removeClass('timeline-active');
						self.addClass('timeline-active');
						if(!isMobile()){
							self.find('.timeline-effect').fadeOut('slow');
						}
						// self.find('.timeline-effect').css("display","none");
					}
				}
			});
			iScrollPos = iCurScrollPos;

		} else {
			// console.log("outside");
			blowFixed.css('display', 'none');

			if (iCurScrollPos < timelineOffsetTop) { //hide all
				timelineDetail.each(function(index, element){
						var self = $(element);
						var selfOffsetTop = self.offset().top;
						var selfOffsetBottom = selfOffsetTop + self.height();
						
						timelineDetail.removeClass('timeline-active');
						self.addClass('timeline-active');
						if(!isMobile()){
							self.find('.timeline-effect').fadeOut('slow');
						}
						// self.find('.timeline-effect').css("display","none");
				});
			}else if(iCurScrollPos > (timelineOffsetTop + timelineHeight) ){ //show all
				timelineDetail.each(function(index, element){
						var self = $(element);
						var selfOffsetTop = self.offset().top;
						var selfOffsetBottom = selfOffsetTop + self.height();

						timelineDetail.removeClass('timeline-active');
						self.addClass('timeline-active');
						if(!isMobile()){
							self.find('.timeline-effect').fadeIn('slow');
						}
				});
			}

		}//else
	}
	//old timeline codes
	/*
		$(window).scroll(function () {
			if (timeline.length === 0) { return; }
			if (!$('body').hasClass('breakpoints-768')) { return; }
			var timelineOffsetTop = timeline.offset().top;
			var timelineHeight = timeline.height();

			var timelineDetail = timeline.find('.timeline-detail');
			var lastTimelineDetail = timelineDetail.filter(':last');
			var lastTimelineDetailOffsetTop = lastTimelineDetail.offset().top;
			
			blowFixed.css("top", midpoint + "px");

			var iCurScrollPos = $(this).scrollTop() + midpoint;
			console.log(iCurScrollPos, midpoint);

			if (iCurScrollPos >= timelineOffsetTop && iCurScrollPos <= (timelineOffsetTop + timelineHeight)) { //if within the top dot and the bottom of timeline
				
				console.log("within");

				blowFixed.css('display', function(){
					return iCurScrollPos >= lastTimelineDetailOffsetTop ? 'none' : 'block';
				});

				timelineDetail.each(function(index, element){
					var self = $(element);
					var selfOffsetTop = self.offset().top;
					var selfOffsetBottom = selfOffsetTop + self.height();

					if (iCurScrollPos > iScrollPos) { //if scrolling down
						if (iCurScrollPos >= selfOffsetTop ) {
						// if (iCurScrollPos >= selfOffsetTop && iCurScrollPos <= selfOffsetBottom) {
							timelineDetail.removeClass('timeline-active');
							self.addClass('timeline-active');
							self.find('.timeline-effect').fadeIn('slow');
							// self.find('.timeline-effect').css("display","block");
						}
					}
					else {
						if (iCurScrollPos >= selfOffsetTop && iCurScrollPos <= selfOffsetTop + 100) {
							timelineDetail.removeClass('timeline-active');
							self.addClass('timeline-active');
							self.find('.timeline-effect').fadeOut('slow');
							// self.find('.timeline-effect').css("display","none");
						}
					}
				});
				iScrollPos = iCurScrollPos;

			} else {
				console.log("outside");
				blowFixed.css('display', 'none');

				if (iCurScrollPos < timelineOffsetTop) { //hide all
					timelineDetail.each(function(index, element){
							var self = $(element);
							var selfOffsetTop = self.offset().top;
							var selfOffsetBottom = selfOffsetTop + self.height();
							
							timelineDetail.removeClass('timeline-active');
							self.addClass('timeline-active');
							self.find('.timeline-effect').fadeOut('slow');
							// self.find('.timeline-effect').css("display","none");
					});
				}else if(iCurScrollPos > (timelineOffsetTop + timelineHeight) ){ //show all
					timelineDetail.each(function(index, element){
							var self = $(element);
							var selfOffsetTop = self.offset().top;
							var selfOffsetBottom = selfOffsetTop + self.height();

							timelineDetail.removeClass('timeline-active');
							self.addClass('timeline-active');
							self.find('.timeline-effect').fadeIn('slow');
					});
				}

			}//else


		});
	*/






	function isMobile(){
		  var check = false;
		  (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4)))check = true})(navigator.userAgent||navigator.vendor||window.opera);
		  return check;
	}



	function trackWechat(){
		//for baidu CN tracking
		console.log("wechat tracking");
		_hmt.push (['_ trackEvent', "navigation", "click", "we-chat"]);
	}


	// ADD SLIDEDOWN ANIMATION TO DROPDOWN //
	$('.dropdown').on('show.bs.dropdown', function(e){
	  $(this).find('.dropdown-menu').first().stop(true, true).slideDown(300);
	});

	// ADD SLIDEUP ANIMATION TO DROPDOWN //
	$('.dropdown').on('hide.bs.dropdown', function(e){
	  e.preventDefault();
	  $(this).find('.dropdown-menu').first().stop(true, true).slideUp(300, function(){
	    $(this).parent().removeClass('open');
	  });
	});	
	
	// Social Sharing of videoa
	$(".wcp-share-single").jsSocials({
		showLabel: false,
		showCount: false,	
		shareIn: "popup",
		shares: ["pinterest", "twitter", "facebook", "googleplus"]
	});	
	
    $('body').on("click",".wcp-share-btn a.video-share",function(){
		var shareid = $(this).attr("data-shareid"); 
		var vidurl = "https://www.youtube.com/embed/" + $(this).attr("data-video"); 
		$("#"+shareid).toggle();
		var shareurl = $(this).attr("data-shareurl");
		$("#"+shareid).jsSocials({
			url: shareurl,
			showLabel: false,
			showCount: false,	
			shareIn: "popup",
			shares: ["pinterest", "twitter", "facebook", "googleplus"],
			on: {
				click: function(e) {
					console.log(vidurl);
					if(this.share === "twitter") {
						ga('send', {
						  hitType: 'event',
						  eventCategory: event_cat,
						  eventAction: 'share_twitter',
						  eventLabel: vidurl
						});						
					}
					else if(this.share === "pinterest") {
						ga('send', {
						  hitType: 'event',
						  eventCategory: event_cat,
						  eventAction: 'share_pinterest',
						  eventLabel: vidurl
						});						
					}	
					else if(this.share === "facebook") {
						ga('send', {
						  hitType: 'event',
						  eventCategory: event_cat,
						  eventAction: 'share_facebook',
						  eventLabel: vidurl
						});						
					}	
					else if(this.share === "googleplus") {
						ga('send', {
						  hitType: 'event',
						  eventCategory: event_cat,
						  eventAction: 'share_googleplus',
						  eventLabel: vidurl
						});						
					}						
				}
			}			
		});	
	});	

});

/** Begin Homepage Banner Rotator
	Add a Masthead and assign it the className "gy-rotating-banner"
**/
function rotate_banner(dir){
	var numItems = $('.gy-rotating-banner').length;
	var maxIndex = numItems - 1;
	var ch = 0;
	$('.gy-rotating-banner').each(function(i, obj) {
		if($(this).is(':hidden')==false){
			ch = i;
		}
	});
	$('.gy-rotating-banner').hide();
	if(dir == 1){
		var cs = ch + 1;
		if(cs <= maxIndex){
			$('.gy-rotating-banner:eq(' + cs +' )').show();
		}
		else{
			$('.gy-rotating-banner:eq(0)').show();
		}
	}
	else {
		var cs = ch - 1;
		if(cs >= 0){
			$('.gy-rotating-banner:eq(' + cs + ')').show();
		}
		else{
			$('.gy-rotating-banner:eq(' + maxIndex + ')').show();
		}
	}
}
$(document).ready(function() {
	$('.gy-rotating-banner').hide();
	$('.gy-rotating-banner:eq(0)').show();
	setInterval(function(){ rotate_banner(1); }, 4000);
});
$('.home .container-fluid').append('<div class="navigate-button"><a class="prev" href="#" onclick="rotate_banner(0);">❮</a><a class="next" href="#" onclick="rotate_banner(1);">❯</a></div>');
/** End of Homepage Banner Rotator **/ 

/** RFQ submit handler **/
document.addEventListener( 'wpcf7submit', function( event ) {
    if ( '4650' == event.detail.contactFormId ) { 
        window.location.replace('https://dtc.local/thank-you');
    }
}, false ); 
/** End RFQ submit handler **/ 
 
/** Detect IE **/
var isIE = false;
var ua = window.navigator.userAgent;
var old_ie = ua.indexOf('MSIE ');
var new_ie = ua.indexOf('Trident/');

if ((old_ie > -1) || (new_ie > -1)) {
    isIE = true;
}

if ( isIE ) {
	var message_eos = "We have detected that you may be using an outdated browser that is not compatible with our website.<br>For a better browsing experience, please view using Microsoft Edge, Google Chrome, Mozilla Firefox or Safari.";
	$('#ie_eos').html(message_eos); 
	$('#ie_eos').show();
}
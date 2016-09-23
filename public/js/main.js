( function( $ ) {
	$(document).ready(function(){

		// Animate .main-header
		$('.link.animate').click(function(e){
			e.preventDefault()
			$(this).parent().parents('div[class^="main-nav"]').removeClass('in').addClass('collapse');
			$('html,body').animate({scrollTop:$( $(this).attr('href') ).offset().top - $('.main-header').height() })
		})

		$(window).scroll(function (event) {
			var y = $(this).scrollTop();
			var active_section = "";
			$('.main-content').children('section,aside').each(function(){
				if (y >= ($(this).offset().top - $('.main-header').height() - 10) )   {
					active_section = $(this).attr('id');
				}
			});
			$('.link.animate').removeClass('active').blur();
			$('.link.animate[href="#'+active_section+'"]').addClass('active');
		});

		// Initialize isotope
		var $container = $('#isotope');
		$container.imagesLoaded( function(){
			$container.isotope({
				itemSelector: '.item',
				layoutMode: 'fitRows',
				// itemWidth: 300,
				animationEngine : 'best-available',
				animationOptions: {
					duration: 300,
					easing: 'linear',
					queue: false
				},
			})
		});

		// Setup isotope filter
		$('#filter li a').click(function(){
			$('#filter li').find('a.is-checked').removeClass('is-checked');
			$(this).addClass('is-checked');
			var filtr = $(this).attr('data-filter');
			$container.isotope({ filter: filtr });
			return false;
		});

		// Setup isotope filter
		$('#filter li a[data-filter="*"]').click();

		// Initialize MagnificPopup lightbox
		$('#work .row .item .iwrap a').magnificPopup({
			type:'image',
			closeOnContentClick: true,
			closeBtnInside: false,
			fixedContentPos: true,
			image: {
				verticalFit: false,
				titleSrc: 'title'
			},
			// retina: {
			// 	ratio: 2,
			// 	replaceSrc: function(item, ratio) {
			// 		return item.src.replace(/\.\w+$/, function(m) { return '@2x' + m; });
			// 	}
			// }
		});
	})
} )( jQuery );
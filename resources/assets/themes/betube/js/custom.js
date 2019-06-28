jQuery(document).ready(function(jQuery){
	
	setTimeout(function () {
		jQuery(".mycar").owlCarousel({
			dots: false,
			items: 6,
			margin: 5,
			loop: true,
			lazyLoad: true,
			lazyContent: true,
			autoplay: true,
			autoplayTimeout: 3000,
			responsive:{
				0:{
					items: 2,
					nav:false
				},
				600:{
					items: 2,
					nav:false
				},
				1000:{
					items:6,
					nav:false
				},
				1900:{
					items:6,
					nav:false
				}
			}
		});
	}, 300)
	
	setTimeout(function () {
		jQuery(".albumsCar").owlCarousel({
			dots: false,
			items: 6,
			margin: 5,
			loop: true,
			lazyLoad: true,
			lazyContent: true,
			autoplay: true,
			autoplayTimeout: 3000,
			responsive:{
				0:{
					items: 2,
					nav:false
				},
				600:{
					items: 2,
					nav:false
				},
				1000:{
					items:6,
					nav:false
				},
				1900:{
					items:6,
					nav:false
				}
			}
		});
	}, 300)
	
});
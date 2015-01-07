(function ($) {
	$(document).ready(function () {

		if (!$('.maginfic-popup-gallery').length)
			return {};

		$('.maginfic-popup-gallery').magnificPopup({
			delegate: 'a',
			type: 'image',
			tLoading: 'Laster #%curr%...',
			mainClass: 'mfp-img-mobile',
			gallery: {
				enabled: true,
				navigateByImgClick: true,
				preload: [0, 1],
			  	tPrev: 'Forrige (Venstre piltast)', // title for left button
	  			tNext: 'Neste (Høyre piltast)', // title for right button
				tCounter: '%curr% av %total%' // markup of counter
			},
			image: {
				tError: '<a href="%url%">Bildet #%curr%</a> kunne ikke bli lastet.',
				titleSrc: function(item) {
					return item.el.attr('title');
				}
			}
		});

	});
})(jQuery);
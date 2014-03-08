(function ($) {
	$(document).ready(function () {

		if (!$('.maginfic-popup-gallery').length)
			return {};

		console.log('r');

		$('.maginfic-popup-gallery').magnificPopup({
			delegate: 'a',
			type: 'image',
			tLoading: 'Laster #%curr%...',
			mainClass: 'mfp-img-mobile',
			gallery: {
				enabled: true,
				navigateByImgClick: true,
				preload: [0, 1]
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
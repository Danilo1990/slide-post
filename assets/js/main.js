jQuery(window).on('elementor/frontend/init', function () {
	elementorFrontend.hooks.addAction('frontend/element_ready/calaslide_posts.default', function ($scope) {
		// Solo lo slider di QUESTA istanza del widget, e mai due volte.
		$scope.find('.multiple-items').not('.slick-initialized').slick();
	});
});

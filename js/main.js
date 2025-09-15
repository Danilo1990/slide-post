jQuery(window).on('elementor/frontend/init', function () {
    elementorFrontend.hooks.addAction('frontend/element_ready/slide_post.default', function ($scope, $) {

        $('.multiple-items').slick();

    });
});

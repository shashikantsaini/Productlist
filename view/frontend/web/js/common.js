/**
 * Created By : Rohan Hapani
 */
require(['jquery', 'GameChange_ProductList/js/owl.carousel'], function($) {
    $(document).ready(function() {
        $('.owl-carousel').owlCarousel({
	        loop: false,
	        margin: 10,
	        nav: true,
	        navText: [
		        "<i class='fa fa-caret-left'></i>",
		        "<i class='fa fa-caret-right'></i>"
	        ],
	        autoplay: true,
	        autoplayHoverPause: true,
	        responsive: {
	            0: {
	              items: 1
	            },
	            600: {
	              items: 3
	            },
	            1000: {
	              items: 5
	            }
	        }
	    });
    });
});
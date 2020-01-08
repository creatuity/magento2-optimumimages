/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
define([
	'jquery',
	'slick'
], function ($) {
	"use strict";


	$.widget('creatuity.optimumSlider', {

		options: {
			slideDelay: 3000
		},

		_create: function () {
			$(this.element).slick({
				autoplay: true,
				autoplaySpeed: this.options.slideDelay,
				slidesToShow: 1,
				slidesToScroll: 1
			})
		}

	});

	return $.creatuity.optimumSlider;
});

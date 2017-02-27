jQuery(document).ready(function($) {
	var money             = fx.noConflict();
	var current_currency  = wc_currency_converter_params.current_currency;
	var currency_codes    = jQuery.parseJSON( wc_currency_converter_params.currencies );
	var currency_position = wc_currency_converter_params.currency_pos;
	var currency_decimals = wc_currency_converter_params.num_decimals;
	var remove_zeros      = wc_currency_converter_params.trim_zeros;

	money.rates           = wc_currency_converter_params.rates;
	money.base            = wc_currency_converter_params.base;
	money.settings.from   = wc_currency_converter_params.currency;

	function switch_currency( to_currency ) {

		// Span.amount
		jQuery('span.amount').each(function(){

			// Original markup
			var original_code = jQuery(this).attr("data-original");

			if (typeof original_code == 'undefined' || original_code == false) {
				jQuery(this).attr("data-original", jQuery(this).html());
			}

			// Original price
			var original_price = jQuery(this).attr("data-price");

			if (typeof original_price == 'undefined' || original_price == false) {

				// Get original price
				var original_price = jQuery(this).html();

				// Small hack to prevent errors with $ symbols
				jQuery( '<del></del>' + original_price ).find('del').remove();

				// Remove formatting
				original_price = original_price.replace( wc_currency_converter_params.thousand_sep, '' );
				original_price = original_price.replace( wc_currency_converter_params.decimal_sep, '.' );
				original_price = original_price.replace(/[^0-9\.]/g, '');
				original_price = parseFloat( original_price );

				// Store original price
				jQuery(this).attr("data-price", original_price);
			}

			price = money( original_price ).to( to_currency );
			price = price.toFixed( currency_decimals );
			price = accounting.formatNumber( price, currency_decimals, wc_currency_converter_params.thousand_sep, wc_currency_converter_params.decimal_sep );

			if ( remove_zeros ) {
				price = price.replace( wc_currency_converter_params.zero_replace, '' );
			}

			if ( currency_codes[ to_currency ] ) {

				if ( currency_position == 'left' ) {

					jQuery(this).html( currency_codes[ to_currency ] + price );

				} else if ( currency_position == 'right' ) {

					jQuery(this).html( price + " " + currency_codes[ to_currency ] );

				} else if ( currency_position == 'left_space' ) {

					jQuery(this).html( currency_codes[ to_currency ] + " " + price );

				} else if ( currency_position == 'right_space' ) {

					jQuery(this).html( price + " " + currency_codes[ to_currency ] );

				}

			} else {

				jQuery(this).html( price + " " + to_currency );

			}

			jQuery(this).attr( 'title', wc_currency_converter_params.i18n_oprice + original_price );
		});

		// #shipping_method prices
		jQuery('#shipping_method option').each(function(){

			// Original markup
			var original_code = jQuery(this).attr("data-original");

			if (typeof original_code == 'undefined' || original_code == false) {

				original_code = jQuery(this).text();

				jQuery(this).attr("data-original", original_code);

			}

			var current_option = original_code;

			current_option = current_option.split(":");

			if (!current_option[1] || current_option[1] == '') return;

			price = current_option[1];

			if (!price) return;

			// Remove formatting
			price = price.replace( wc_currency_converter_params.thousand_sep, '' );
			price = price.replace( wc_currency_converter_params.decimal_sep, '.' );
			price = price.replace(/[^0-9\.]/g, '');
			price = parseFloat( price );

			price = money(price).to(to_currency);
			price = price.toFixed( currency_decimals );
			price = accounting.formatNumber( price, currency_decimals, wc_currency_converter_params.thousand_sep, wc_currency_converter_params.decimal_sep );

			if ( remove_zeros ) {
				price = price.replace( wc_currency_converter_params.zero_replace, '' );
			}

			jQuery(this).html( current_option[0] + ": " + price  + " " + to_currency );

		});

		price_filter_update( to_currency );

		jQuery('body').trigger('currency_converter_switch');

	}

	if ( current_currency ) {

		switch_currency( current_currency );

		jQuery('ul.currency_switcher li a[data-currencycode="' + current_currency + '"]').addClass('active');

	} else {

		jQuery('ul.currency_switcher li a.default').addClass('active');

	}

	function price_filter_update( to_currency ) {
		if ( to_currency ) {
			jQuery('.ui-slider').each(function() {
				theslider = jQuery( this );
				values    = theslider.slider("values");

				original_price = "" + values[1];
				original_price = original_price.replace( wc_currency_converter_params.thousand_sep, '' );
				original_price = original_price.replace( wc_currency_converter_params.decimal_sep, '.' );
				original_price = original_price.replace(/[^0-9\.]/g, '');
				original_price = parseFloat( original_price );

				price_max = money(original_price).to(to_currency);

				original_price = "" + values[0];
				original_price = original_price.replace( wc_currency_converter_params.thousand_sep, '' );
				original_price = original_price.replace( wc_currency_converter_params.decimal_sep, '.' );
				original_price = original_price.replace(/[^0-9\.]/g, '');
				original_price = parseFloat( original_price );

				price_min = money(original_price).to(to_currency);

				jQuery('.price_slider_amount').find('span.from').html( price_min.toFixed(2) + " " + to_currency );
				jQuery('.price_slider_amount').find('span.to').html( price_max.toFixed(2) + " " + to_currency );
			});
		}
	}

	jQuery(document).ready(function($) {
		jQuery('body').on( "price_slider_create price_slider_slide price_slider_change", function() {
			price_filter_update( current_currency );
		} );

		price_filter_update( current_currency );
	});

	jQuery('ul.currency_switcher li a:not(".reset")').click(function() {

		to_currency = jQuery(this).attr('data-currencycode');

		switch_currency( to_currency );

		jQuery('ul.currency_switcher li a').removeClass('active');

		jQuery(this).addClass('active');

		jQuery.cookie('woocommerce_current_currency', to_currency, { expires: 7, path: '/' });

		current_currency = to_currency;

		return false;
	});

	jQuery('ul.currency_switcher li a.reset').click(function() {

		jQuery('span.amount, #shipping_method option').each(function(){

			var original_code = jQuery(this).attr("data-original");

			if (typeof original_code !== 'undefined' && original_code !== false) {

				jQuery(this).html( original_code );

			}

		});

		jQuery('ul.currency_switcher li a').removeClass('active');

		if ( jQuery(this).is('.default') )
			jQuery(this).addClass('active');

		jQuery.cookie('woocommerce_current_currency', '', { expires: 7, path: '/' });

		current_currency = '';

		jQuery('body').trigger('currency_converter_reset');

		if ( jQuery( '.price_slider' ).size() > 0 )
			jQuery('body').trigger('price_slider_slide', [jQuery(".price_slider").slider("values", 0), jQuery(".price_slider").slider("values", 1)]);

		return false;
	});

	// Ajax events
	jQuery('body').bind('show_variation updated_checkout updated_shipping_method added_to_cart cart_page_refreshed cart_widget_refreshed updated_addons', function() {
		if ( current_currency ) {
			switch_currency( current_currency );
		}
	});
});
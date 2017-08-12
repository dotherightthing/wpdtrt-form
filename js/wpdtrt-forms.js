/**
 * Scripts for the public front-end
 *
 * This file contains JavaScript.
 *    PHP variables are provided in wpdtrt_soundcloud_pages_config.
 *
 * @link        http://dotherightthing.co.nz
 * @since       0.1.0
 *
 * @package     Wpdtrt_Forms
 * @subpackage  Wpdtrt_Forms/views
 */

jQuery(document).ready(function($){

	$('.wpdtrt-forms-badge').hover(function() {
		$(this).find('.wpdtrt-forms-badge-info').stop(true, true).fadeIn(200);
	}, function() {
		$(this).find('.wpdtrt-forms-badge-info').stop(true, true).fadeOut(200);
	});

  $.post( wpdtrt_forms_config.ajax_url, {
    action: 'wpdtrt_forms_data_refresh'
  }, function( response ) {
    //console.log( 'Ajax complete' );
  });

});

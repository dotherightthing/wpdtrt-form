/**
 * @file js/_frontend.js
 * @summary Scripting for the public front-end.
 * @description PHP variables are provided in wpdtrt_forms_config.
 * @requires DTRT WordPress Plugin Boilerplate Generator 0.9.1
 */

/* globals jQuery, wpdtrt_forms_config */
/* eslint-disable camelcase, no-unused-vars */

/**
 * jQuery object
 *
 * @external jQuery
 * @see {@link http://api.jquery.com/jQuery/}
 */

/**
 * @namespace wpdtrtFormsUi
 */
const wpdtrtFormsUi = {

    /**
     * Method: init
     *
     * Initialise front-end scripting.
     */
    // init: () => {}
};

jQuery(($) => {
    const config = wpdtrt_forms_config; // eslint-disable-line

    console.log('wpdtrtFormsUi.init'); // eslint-disable-line no-console
});

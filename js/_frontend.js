/**
 * @file js/_frontend.js
 * @summary Scripting for the public front-end.
 * @description PHP variables are provided in wpdtrt_form_config.
 * @requires DTRT WordPress Plugin Boilerplate Generator 0.9.1
 */

/* globals jQuery, wpdtrt_form_config */
/* eslint-disable camelcase, no-unused-vars */

/**
 * jQuery object
 *
 * @external jQuery
 * @see {@link http://api.jquery.com/jQuery/}
 */

/**
 * @namespace wpdtrtFormUi
 */
const wpdtrtFormUi = {

    /**
     * @function validateForm
     * @summary Validate a form when it is submitted
     * @memberof wpdtrtFormUi
     * @protected
     *
     * @param {string} selector - CSS selector of the form to validate
     * @see {@link https://jqueryvalidation.org/validate/#errorelement}
     * @see {@link https://jqueryvalidation.org/validate/#errorplacement}
     * @see {@link https://jqueryvalidation.org/validate/#highlight}
     */
    validateForm: function (selector) {
        const $ = wpdtrtFormUi.$;

        $(selector).validate({
            errorElement: 'strong',
            errorPlacement: function (error, element) {
                error.appendTo($(`#${element.data('errors')}`)); // data-errors='fieldname-validation'
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass(errorClass).removeClass(validClass);
                $(element.form).find(`label[for='${element.id}']`).addClass(errorClass);
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass(errorClass).addClass(validClass);
                $(element.form).find(`label[for='${element.id}']`).removeClass(errorClass);
            }
        });
    },

    /**
     * Method: init
     *
     * Initialise front-end scripting.
     */
    init: () => {
        // Custom forms
        wpdtrtFormUi.validateForm('.wpdtrt-form-template');

        // WordPress
        wpdtrtFormUi.validateForm('#commentform');

        console.log('wpdtrtFormUi.init'); // eslint-disable-line no-console
    }
};

jQuery(($) => {
    const config = wpdtrt_form_config; // eslint-disable-line

    wpdtrtFormUi.$ = $;

    wpdtrtFormUi.init();
});

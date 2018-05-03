<?php
/**
 * Plugin sub class.
 *
 * @package     wpdtrt_forms
 * @version 	0.0.1
 * @since       0.7.10
 */

/**
 * Plugin sub class.
 *
 * Extends the base class to inherit boilerplate functionality.
 * Adds application-specific methods.
 *
 * @version 	0.0.1
 * @since       0.7.10
 */
class WPDTRT_Forms_Plugin extends DoTheRightThing\WPPlugin\Plugin {

    /**
     * Hook the plugin in to WordPress
     * This constructor automatically initialises the object's properties
     * when it is instantiated,
     * using new WPDTRT_Weather_Plugin
     *
     * @param     array $settings Plugin options
     *
	 * @version 	0.0.1
     * @since       0.7.10
     */
    function __construct( $settings ) {

    	// add any initialisation specific to wpdtrt-forms here

		// Instantiate the parent object
		parent::__construct( $settings );
    }

    //// START WORDPRESS INTEGRATION \\\\

    /**
     * Initialise plugin options ONCE.
     *
     * @param array $default_options
     *
     * @version     0.0.1
     * @since       0.7.10
     */
    protected function wp_setup() {

    	parent::wp_setup();

		// add actions and filters here
    }

    //// END WORDPRESS INTEGRATION \\\\

    //// START SETTERS AND GETTERS \\\\

    /**
     * Request the data from the API
     *  which in this case is a static JSON file.
     *
     * @return      object $data The body of the JSON response
     *
     * @since       0.1.0
     * @uses        ../../../../wp-includes/http.php
     * @see         https://developer.wordpress.org/reference/functions/wp_remote_get/
     */
    public function get_api_data() {

        $plugin_options = $this->get_plugin_options();
        $template = $plugin_options['template']['value']; // value must be set in options array
        $endpoint = WPDTRT_FORMS_URL . 'data/form-' . $template . '.json';
        $args = array(
            'timeout' => 30, // seconds to wait for the request to complete
            'blocking' => true // false = nothing loads
        );

        $response = wp_remote_get(
            $endpoint,
            $args
        );

        /**
        * Return the body, not the header
        * Note: There is an optional boolean argument, which returns an associative array if TRUE
        */
        $data = json_decode( $response['body'], true );

        // Save the data and retrieval time
        $this->set_plugin_data( $data );
        $this->set_plugin_data_options( array(
            'last_updated' => time()
        ));

        return $data;
    }

    //// END SETTERS AND GETTERS \\\\

    //// START RENDERERS \\\\
    //// END RENDERERS \\\\

    //// START FILTERS \\\\
    //// END FILTERS \\\\

    //// START HELPERS \\\\

    /**
     * Sanitize form data
     *  Validating: Ensure that submitted data matches your expectations
     *  Santization: Clean user input to fit within an acceptable range
     *  Escaping: Secure existing data prior to rendering it to the end user
     *
     * @return      Sanitized form data
     *
     * @see https://www.sitepoint.com/build-your-own-wordpress-contact-form-plugin-in-5-minutes/
     * @see https://premium.wpmudev.org/blog/how-to-build-your-own-wordpress-contact-form-and-why/
     * @see http://www.butlerblog.com/2012/09/23/testing-the-wp_mail-function/
     * @see https://codeseekah.com/2012/02/27/getting-error-feedback-from-wp_mail/
     * @see https://codex.wordpress.org/Option_Reference
     * @see https://codex.wordpress.org/Validating_Sanitizing_and_Escaping_User_Data
     * @see /wp-includes/formatting.php
     * @see https://developer.wordpress.org/reference/functions/sanitize_email/
     * @see https://developer.wordpress.org/reference/functions/sanitize_text_field/
     * @see https://developer.wordpress.org/reference/functions/sanitize_textarea_field/
     * @see https://developer.wordpress.org/reference/functions/wp_mail/
     * @todo Form seems to submit even if Subject field is empty
     */
    public function helper_sanitize_form_data() {

        $submitted_data = array();

        // if the submit button is clicked, send the email
        if ( isset( $_POST['wpdtrt_forms_submitted'] ) ) {

            $wpdtrt_forms_options = get_option('wpdtrt_forms');

            // this requires json_decode to use the optional second argument
            // to return an associative array
            $data = $this->get_plugin_data();
            $template_fields = $data['template_fields'];

            // sanitize form values
            // empty or unsanitary values are output as ''
            foreach( $template_fields as $template_field ) {

                // some fields like checkbox don't need sanitizing
                if ( isset( $template_field['sanitizer'] ) ) {

                    $sanitizer = $template_field['sanitizer'];

                    /**
                     * Verify that the contents of a variable can be called as a function
                     * @see http://php.net/is_callable
                     */
                    if ( is_callable( $sanitizer ) ) {

                        /**
                         * Call the callback given by the first parameter
                         * @see http://php.net/manual/en/function.call-user-func.php
                         */
                        $submitted_data[ $template_field['id'] ] = call_user_func( $sanitizer, $_POST[ 'wpdtrt_forms_' . $template_field['id'] ] );
                    }

                }
            }
        }

        return $submitted_data;
    }

    /**
     * Send an email using $_POST data
     *
     * @return $sentmail Whether the email contents were sent successfully.
     *
     * @see https://developer.wordpress.org/reference/functions/wp_mail/
     * @see http://www.wordpresscheatsheets.com/how-to-send-html-emails-from-wordpress-using-wp_mail-function
     * @todo Use template loader
     */
    public function helper_sendmail() {

        // if the submit button is clicked, send the email
        if ( isset( $_POST['wpdtrt_forms_submitted'] ) ) {

            $submitted_data = $this->helper_sanitize_form_data();

            $blogname = get_option( 'blogname' );

            // get the blog administrator's email address
            $to = get_option( 'admin_email' );

            $headers = "From: " . $submitted_data['name'] . "<" . $submitted_data['email'] . ">" . "\r\n";

            if ( $submitted_data['message'] !== '' ) {

                $message = $submitted_data['message'] . "\r\n\r\n";

                if ( isset ( $_POST['wpdtrt_forms_email_updates'] ) ) {
                    $message .= 'I would like to receive email updates.' . "\r\n\r\n";
                }

                $message .= '---' . "\r\n\r\n";
                $message .= 'Sent from the "' . $blogname . '" Contact Form.';
            }
            else {
                $message = '';
            }

            $sentmail = wp_mail( $to, $submitted_data['subject'], $message, $headers );

            $plugin_options = $this->get_plugin_options();

            if ( key_exists('errors_list', $plugin_options) ) {
                $errors_list = $plugin_options['errors_list'];                
            }
            else {
                $errors_list = false;
            }

            $data = $this->get_plugin_data();
            require( WPDTRT_FORMS_PATH . 'template-parts/wpdtrt-forms-status.php' );

            return $sentmail;
        }
    }

    //// END HELPERS \\\\
}

?>
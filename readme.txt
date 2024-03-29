
=== DTRT Form ===
Contributors: dotherightthingnz
Donate link: http://dotherightthing.co.nz
Tags: forms, accessible, WCAG
Requires at least: 5.6
Tested up to: 5.6
Requires PHP: 7.2.20
Stable tag: 0.3.8
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Simple, accessible forms.

== Description ==

Simple, accessible forms.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/wpdtrt-form` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Use the Settings->DTRT Form screen to configure the plugin

== Frequently Asked Questions ==

See [WordPress Usage](README.md#wordpress-usage).

== Changelog ==

= 0.3.8 =
* [fc0da20] Don't load generic wpdtrt-scss styles in plugins (dotherightthing/wpdtrt-scss#1)

= 0.3.7 =
* [9ff96fa] Update wpdtrt-scss to 0.1.17
* [6db6df6] Update wpdtrt-scss to 0.1.14
* [3dc2de1] Lint PHP
* [5e20f2f] Update wpdtrt-scss to 0.1.13

= 0.3.6 =
* [aaf73d0] Lint PHP
* [09bc739] Update dependencies
* [ee54670] Update wpdtrt-plugin-boilerplate from 1.7.16 to 1.7.17
* [853d4b2] Revert "Add missing number argument to demo_shortcode_params (dotherightthing/wpdtrt-plugin-boilerplate#192)"
* [487def9] Make contact form data the default (fixes #17)
* [ec000cb] Add missing number argument to demo_shortcode_params (dotherightthing/wpdtrt-plugin-boilerplate#192)

= 0.3.5 =
* [17b94da] Replace subject field with hardcoded value
* [8e78fe5] Change order of fields on contact form to prioritise message field

= 0.3.4 =
* [3a1dff5] Update wpdtrt-plugin-boilerplate from 1.7.15 to 1.7.16
* [17c97c8] Remove redundant classes

= 0.3.3 =
* [bd80a7d] Add space between name and email address in email headers (#11)
* [b285e1a] Remove redundant widget, rewrite, taxonomy functions (fixes #16)

= 0.3.2 =
* [1068579] Update wpdtrt-npm-scripts to 0.3.30

= 0.3.1 =
* [d32e6d1] Remove duplicate call to load template data
* [0dfb802] Add fallbacks if template data could not be loaded
* [ecc7ee2] Docs

= 0.3.0 =
* [9387746] Docs
* [c4f76c5] Add Akismet (to finish)
* [6a928fa] Separate anchor from URL
* [9cc8190] Housekeeping, lint PHP
* [03cab7d] Jump to message section after email is sent
* [f8465c7] Restructure JSON data and rename variables
* [e7fcda7] Rename 'submitted' to 'submit'
* [c8368b5] Docs
* [b19f622] Dynamically identify required fields and those with mail roles
* [e5aad25] Use Post/Redirect/Get pattern to avoid the browser's 'Confirm Form Resubmission' warning if the page is refreshed after the form is successfully submit and the email sent
* [f5313a8] Remove redundant variable
* [3f303bb] Remove redundant status class
* [651da29] Only output $heading_class if it was specified
* [ee9cf74] Make $errors_list and $errors_inline optional
* [cba887b] Tweak success message
* [1cf1d4d] Lint SCSS
* [ec71a59] Fix sanitisation checks, fix escaped output in textarea
* [8122352] Remove dashes from input names
* [1dd1028] Use correct variables in sanitization checks
* [59191d5] Simplify $errors_inline and $errors_list checks
* [fc90e40] Fix format of function calls inside shortcode
* [94f7dac] Fix helpers
* [ca124b6] Simplify $errors_list check
* [350d523] Housekeeping
* [76b3445] Change data-errors to data-describedby
* [07ce20e] Document variables
* [a3cf17f] Lint PHP
* [84e7b62] Use helpers to build consistent name and id strings
* [3eb7a02] Fix error output logic
* [412dd56] Link field to validation message container rather than validation message
* [e485e91] Add error class, fix conditional
* [8a31794] Rename $submitted_data to $sanitized_form_data
* [473a3c8] Fix documented shortcode argument values
* [d66c2c1] Remove HTML5 validation
* [18abfea] Housekeeping
* [730ac1f] Use styled PHP validation rather than HTML5 if JS is disabled
* [bfe1687] Improve notes styling
* [c03f1bb] Fix errors_list output and improve messages
* [93002f4] Style errors list
* [fbf7aaf] Remove notes keys with empty values
* [a124b72] Add icons
* [06bb9c2] Add heading to status message, removing colouring
* [9ce0193] Fix icomoon config
* [97c690b] Alphabetically sort keys
* [38a649d] Add autocomplete
* [d5661d8] Fix submit status layout
* [dbc61d3] Update test function
* [142c5b3] Document working catchmail configuration
* [b9da540] Document PHP version
* [75e333c] Document mailcatcher / catchmail setup
* [b720ee3] Add test function
* [e8d9fda] Docs
* [417926a] Lint PHP
* [1631950] Use dynamic form ID
* [68f01d1] Log mail sending errors
* [58af5cb] Docs
* [d01f6a5] Add name to form for emails about it
* [45e6953] Remove email signup notification message
* [bc69bbb] Docs
* [c557ceb] Document testing emails (to finish)
* [bf82b4e] Fix form field name processing on successful submit
* [ca90397] Update status message colours
* [2a2d672] Update HTML5 validation
* [5152aff] Only output inline errors if they are enabled
* [5ed7f4a] Lint CSS
* [accf99b] Match structure of comment form to match styling and enable jQuery validation
* [113c107] Update contact form structure and styling
* [35ea50d] Move email signup to a separate form
* [453dab5] Rename from wpdtrt-forms to wpdtrt-form
* [0ae1710] Update wpdtrt-scss
* [78ae01b] Ignore generated file
* [0954094] Update lockfile
* [5b38eb1] Fix extend
* [8551b97] Rename from wpdtrt-forms to wpdtrt-form
* [be827b3] Restructure extends
* [1895daf] Relocate form styles from wpdtrt-dbth and wpdtrt-scss
* [4b94895] Docs
* [33aaafc] Remove redundant __fields container
* [f706499] Remove trailing colons from labels
* [785d262] Relocate form styles from wpdtrt-scss
* [559e772] Relocate jQuery validation from wpdtrt-dbth
* [b7d5961] Fix form HTML structure
* [e5b5afe] Fix path to status template partial
* [88eb528] Fix form not rendering due to missing data
* [584cfa1] Update contact form
* [f7dd27f] Update plugin description
* [51a5a49] Update wpdtrt-plugin-boilerplate from 1.7.14 to 1.7.15
* [0d71f44] Update wpdtrt-plugin-boilerplate from 1.7.13 to 1.7.14
* [93d03a0] Lint PHP
* [04ae26e] Update wpdtrt-plugin-boilerplate from 1.7.12 to 1.7.13
* [f10e153] Add placeholders for string replacements
* [b6006b3] Load boilerplate JS, as it is not compiled by the boilerplate
* [5882e0a] Fix path to label template partial
* [1bedfec] Rebuild from generator-wpdtrt-plugin-boilerplate 0.9.1

= 0.2.4 =
* Update wpdtrt-plugin to 1.4.14

= 0.2.3 =
* Fix path to autoloader when loaded as a test dependency

= 0.2.2 =
* Include release number in wpdtrt-plugin namespaces
* Update wpdtrt-plugin to 1.4.6

= 0.2.1 =
* Add string for Settings link
* Move get_api_data() into parent class
* Set API $endpoint via filter
* Update wpdtrt-plugin to 1.3.5

= 0.2.0 =
* Refactor SCSS
* Migrate to wpdtrt-plugin (1.3.3)

= 0.1.1 =
* Fix form spacing

= 0.1.0 =
* Initial version

== Upgrade Notice ==

= 0.1.0 =
* Initial release

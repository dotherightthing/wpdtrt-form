
=== WPDTRT Forms ===
Contributors: dotherightthingnz
Donate link: http://dotherightthing.co.nz
Tags: forms
Requires at least: 4.8.1
Tested up to: 4.8.1
Stable tag: 0.1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Author simple and accessible forms

== Description ==

Author simple and accessible forms

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/wpdtrt-forms` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' screen in WordPress

== Frequently Asked Questions ==

= How do I embed a form? =

Please use the provided shortcode to embed a form:

```
<!-- within the editor -->
[wpdtrt_forms option="value"]

// in a PHP template, as a template tag
<?php echo do_shortcode( '[wpdtrt_forms option="value"]' ); ?>
```

This will load the following data file:

```
./data/wpdtrt-forms-form-<strong>contact</strong>.json
```

Edit the data file to change the field attributes or order.

= Shortcode options =

1. `template="contact"` - generate a form from the template and JSON data
2. `errors_list="true|false"` - display a list of errors above the form; clicking an error jumps the user to the affected field
3. `errors_inline="true|false"` - display each error directly after the affected field;

== Screenshots ==

1. The caption for ./assets/screenshot-1.(png|jpg|jpeg|gif)
2. The caption for ./assets/screenshot-2.(png|jpg|jpeg|gif)

== Changelog ==

= 0.1 =
* Initial version

== Upgrade Notice ==

= 0.1 =
* Initial release


=== DTRT Forms ===
Contributors: dotherightthingnz
Donate link: http://dotherightthing.co.nz
Tags: forms, accessible, WCAG
Requires at least: 4.9.5
Tested up to: 4.9.5
Requires PHP: 5.6.30
Stable tag: 0.2.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A WordPress plugin to author simple, accessible forms.

== Description ==

A WordPress plugin to author simple, accessible forms.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/wpdtrt-forms` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Use the Settings->DTRT Forms screen to configure the plugin

== Frequently Asked Questions ==

= How do I use the widget? =

One or more widgets can be displayed within one or more sidebars:

1. Locate the widget: Appearance > Widgets > *DTRT Forms Widget*
2. Drag and drop the widget into one of your sidebars
3. Add a *Title*
4. Specify options

= How do I embed a form? =

Please use the provided shortcode to embed a form:

```
<!-- within the editor -->
[wpdtrt_forms option="value"]

// in a PHP template, as a template tag
<?php echo do_shortcode( '[wpdtrt_forms option="value"]' ); ?>
```

= How do I edit the form fields? =

Edit the data file to change the field attributes or order:

```
./data/form-{templatename}.json
```

= Shortcode options =

1. `template="contact"` - generate a form from the template and JSON data
2. `errors_list="true|false"` - display a list of errors above the form; clicking an error jumps the user to the affected field
3. `errors_inline="true|false"` - display each error directly after the affected field;

== Roadmap ==

1. Anti-Spam
2. Escaping of content in email
3. Translation support

== Screenshots ==

1. The caption for ./images/screenshot-1.(png|jpg|jpeg|gif)
2. The caption for ./images/screenshot-2.(png|jpg|jpeg|gif)

== Changelog ==

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

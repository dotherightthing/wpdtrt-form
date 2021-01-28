# DTRT Forms

[![GitHub release](https://img.shields.io/github/v/tag/dotherightthing/wpdtrt-forms)](https://github.com/dotherightthing/wpdtrt-forms/releases) [![Build Status](https://github.com/dotherightthing/wpdtrt-forms/workflows/Build%20and%20release%20if%20tagged/badge.svg)](https://github.com/dotherightthing/wpdtrt-forms/actions?query=workflow%3A%22Build+and+release+if+tagged%22) [![GitHub issues](https://img.shields.io/github/issues/dotherightthing/wpdtrt-forms.svg)](https://github.com/dotherightthing/wpdtrt-forms/issues)

Simple, accessible forms.

## Setup and Maintenance

Please read [DTRT WordPress Plugin Boilerplate: Workflows](https://github.com/dotherightthing/wpdtrt-plugin-boilerplate/wiki/Workflows).

## WordPress Installation

Please read the [WordPress readme.txt](readme.txt).

## WordPress Usage

### Form shortcode

Please use the provided shortcode to embed a form:

```php
<!-- within the editor -->
[wpdtrt_forms option="value"]

// in a PHP template, as a template tag
<?php echo do_shortcode( '[wpdtrt_forms option="value"]' ); ?>
```

Options

1. `template="contact"` - generate a form from the template and JSON data
2. `errors_list="true|false"` - display a list of errors above the form; clicking an error jumps the user to the affected field
3. `errors_inline="true|false"` - display each error directly after the affected field;

### Edit the form fields

Edit the data file to change the field attributes or order: `./data/form-{templatename}.json`

### Styling

Core CSS properties may be overwritten by changing the variable values in your theme stylesheet.

See `scss/variables/_css.scss`.

## Dependencies

None.

## Demo pages

None.

## Roadmap

1. Anti-Spam
2. Escaping of content in email
3. Translation support

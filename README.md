# DTRT Form

[![GitHub release](https://img.shields.io/github/v/tag/dotherightthing/wpdtrt-form)](https://github.com/dotherightthing/wpdtrt-form/releases) [![Build Status](https://github.com/dotherightthing/wpdtrt-form/workflows/Build%20and%20release%20if%20tagged/badge.svg)](https://github.com/dotherightthing/wpdtrt-form/actions?query=workflow%3A%22Build+and+release+if+tagged%22) [![GitHub issues](https://img.shields.io/github/issues/dotherightthing/wpdtrt-form.svg)](https://github.com/dotherightthing/wpdtrt-form/issues)

Simple, accessible forms.

## Setup and Maintenance

Please read [DTRT WordPress Plugin Boilerplate: Workflows](https://github.com/dotherightthing/wpdtrt-plugin-boilerplate/wiki/Workflows).

## WordPress Installation

Please read the [WordPress readme.txt](readme.txt).

## WordPress Usage

### Backend forms

Limited restyling of the WP Admin plugin options page.

### Comment form

Styling and jQuery validation of the standard comment form (`#commentform`).

### Custom form shortcode

Please use the provided shortcode to embed a custom form:

```php
<!-- within the editor -->
[wpdtrt_form option="value"]

// in a PHP template, as a template tag
<?php echo do_shortcode( '[wpdtrt_form option="value"]' ); ?>
```

Options

1. `template="contact"` - generate a form from the template and JSON data
2. `errors_list="true|false"` - display a list of errors above the form; clicking an error jumps the user to the affected field
3. `errors_inline="true|false"` - display each error directly after the affected field;

### Custom form fields

Edit the data file to change the field attributes or order: `./data/form-{templatename}.json`

### SPAM management

TODO

### Testing that form data is sent to your email address

<https://mailcatcher.me/> via <https://wordpress.stackexchange.com/a/195830> and <https://tommcfarlin.com/mailcatcher-mamp-wordpress/>:

1. `gem install mailcatcher`
2. `mailcatcher`
3. Update php.ini (in MAMP Pro this is `File > Edit > PHP > Version`):
    1. Replace `;sendmail_path =` with `sendmail_path = /Users/dan/.rvm/gems/ruby-2.6.3/wrappers/catchmail -f wpdev@localhost.dev` (any email works)

    1. Replace `smtp_port = 25` with `smtp_port = 1025`
4. MAMP Pro View > Postfix
    1. Include Postfix service in GroupStart
    2. Set domain of outgoing e-mails to: `localhostname.tld`
    3. Use a Smart host for routing
       1. Server name: 127.0.0.1:1080
5. Send mail via a form submit etc
6. Watch for mail at <http://127.0.0.1:1080/>

#### Troubleshooting mailcatcher

1. Send mail > `env: catchmail: No such file or directory`
1. `gem environment gemdir` (display the path where gems are installed) > `/Users/dan/.rvm/gems/ruby-2.6.3`
1. `cd /Users/dan/.rvm/gems/ruby-2.6.3 && ls` > `bin    build_info    cache    doc    environment    extensions    gems    specifications    wrappers`
1. `sendmail_path = /Users/dan/.rvm/gems/ruby-2.6.3/bin/catchmail -f wpdev@localhost.dev` > send mail > `env: ruby_executable_hooks: No such file or directory`
1. `sudo gem install --user-install executable-hooks` (<https://stackoverflow.com/a/29519638>) > send mail > `env: ruby_executable_hooks: No such file or directory`
1. `which ruby_executable_hooks` > `/Users/dan/.rvm/gems/ruby-2.6.3/bin/ruby_executable_hooks` > unsure how to use this information
1. `sendmail_path = /Users/dan/.rvm/gems/ruby-2.6.3/environment catchmail -f wpdev@localhost.dev` > `Users/dan/.rvm/gems/ruby-2.6.3/environment: Permission denied`
1. `sendmail_path = /Users/dan/.rvm/gems/ruby-2.6.3/wrappers/catchmail -f wpdev@localhost.dev` (<https://github.com/rvm/executable-hooks/issues/6#issuecomment-609032741>) > Mail sent :)

### Styling

Core CSS properties may be overwritten by changing the variable values in your theme stylesheet.

See `scss/variables/_css.scss`.

## Dependencies

### JavaScript

* [jQuery](https://jquery.com/)
* [jQuery Validation Plugin](https://jqueryvalidation.org/)

## Demo pages

See plugin settings page in WP Admin.

## Roadmap

1. Anti-Spam
2. Escaping of content in email
3. Translation support

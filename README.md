# DTRT Form

[![GitHub release](https://img.shields.io/github/v/tag/dotherightthing/wpdtrt-form)](https://github.com/dotherightthing/wpdtrt-form/releases) [![Build Status](https://github.com/dotherightthing/wpdtrt-form/workflows/Build%20and%20release%20if%20tagged/badge.svg)](https://github.com/dotherightthing/wpdtrt-form/actions?query=workflow%3A%22Build+and+release+if+tagged%22) [![GitHub issues](https://img.shields.io/github/issues/dotherightthing/wpdtrt-form.svg)](https://github.com/dotherightthing/wpdtrt-form/issues)

Simple, accessible forms.

## Features

* Autocomplete
* Inline JavaScript validation (optional)
* Inline Noscript validation (optional)
* Block Noscript validation error links list (optional)
* No *Confirm Form Resubmission* prompt on resubmit

## Issues & Roadmap

See [issues](https://github.com/dotherightthing/wpdtrt-form/issues).

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
2. `errors_list="1|0"` - display a list of errors above the form; clicking an error jumps the user to the affected field
3. `errors_inline="1|0"` - display each error directly after the affected field;

### Custom form fields

Edit the data file to change the field attributes or order: `./data/form-{templatename}.json`

### Styling

Core CSS properties may be overwritten by changing the variable values in your theme stylesheet.

See `scss/variables/_css.scss`.

## Dependencies

### JavaScript

Inline validation works with or without JavaScript, but is faster when JavaScript is enabled.

* [jQuery](https://jquery.com/)
* [jQuery Validation Plugin](https://jqueryvalidation.org/)

## Demo pages

See plugin settings page in WP Admin.

---

## Testing

### Autocomplete

#### Chrome

* Preferences > Auto-fill > Addresses and more > Save and fill addresses

### Emailing of form submission in local development

1. Install and run [MailCatcher](https://mailcatcher.me/) (see <https://wordpress.stackexchange.com/a/195830>):

    ```sh
    gem install mailcatcher
    mailcatcher
    ```

1. Update php.ini:

    ```sh
    # php.ini (MAMP Pro: File > Edit > PHP > Version)
    sendmail_path = /Users/dan/.rvm/gems/ruby-2.6.3/wrappers/catchmail -f wpdev@localhost.dev # any email works
    smtp_port = 1025
    ```

1. MAMP Pro View > Postfix
    1. *Include Postfix service in GroupStart*
    2. *Set domain of outgoing e-mails to:* `localhostname.tld`
    3. *Use a Smart host for routing*: *Server name:* `127.0.0.1:1080`
1. Send mail
1. Watch for mail at <http://127.0.0.1:1080/>

#### MailCatcher troubleshooting

1. Update php.ini (<https://tommcfarlin.com/mailcatcher-mamp-wordpress/>):

    ```sh
    # php.ini
    smtp_port = 1025
    sendmail_path = /usr/bin/env catchmail -f wpdev@localhost.dev
    ```

1. Send mail:

    ```sh
    # Apache log
    env: catchmail: No such file or directory
    ```

1. Locate the path where gems are installed:

    ```sh
    gem environment --help
    gem environment gemdir # /Users/dan/.rvm/gems/ruby-2.6.3
    ```

1. Locate the `catchmail` binary (executable):

    ```sh
    cd /Users/dan/.rvm/gems/ruby-2.6.3 && ls # bin    build_info    cache    doc    environment    extensions    gems    specifications    wrappers
    ```

1. Update php.ini:

    ```sh
    # php.ini
    sendmail_path = /Users/dan/.rvm/gems/ruby-2.6.3/bin/catchmail -f wpdev@localhost.dev`
    ```

1. Send mail:

    ```sh
    # Apache log
    send mail > env: ruby_executable_hooks: No such file or directory
    ```

1. Refresh the `executable-hooks` to the latest version (<https://stackoverflow.com/a/29519638>):

    ```sh
    sudo gem install --user-install executable-hooks
    ```

1. Send mail:

    ```sh
    # Apache log
    send mail > env: ruby_executable_hooks: No such file or directory
    ```

1. Locate `ruby_executable_hooks`:

    ```sh
    which ruby_executable_hooks # /Users/dan/.rvm/gems/ruby-2.6.3/bin/ruby_executable_hooks
    # unsure how to use this information..
    ```

1. Update php.ini:

    ```sh
    # php.ini
    sendmail_path = /Users/dan/.rvm/gems/ruby-2.6.3/environment catchmail -f wpdev@localhost.dev
    ```

1. Send mail:

    ```sh
    # Apache log
    Users/dan/.rvm/gems/ruby-2.6.3/environment: Permission denied
    ```

1. Update php.ini (<https://github.com/rvm/executable-hooks/issues/6#issuecomment-609032741>):

    ```sh
    # php.ini
    sendmail_path = /Users/dan/.rvm/gems/ruby-2.6.3/wrappers/catchmail -f wpdev@localhost.dev
    ```

1. Send mail :)

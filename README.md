# Loclathon

Source repository for the website of [Le Loclathon](https://loclathon.ch).

## Summary

*Le Loclathon* is an annual event organized by the *Association du Loclathon*
(which I'm part of) that brings absinthe lovers to a long walk across
the city of Le Locle (NE, Switzerland) for 12 hours. The goal is to enjoy a good
time with friends and discover the beautiful parts of the town by visiting each
of its fountains. There, we drink a glass of absinthe (or anything else) with
the fresh water they deliver.

This website is used to present the event and to sell the dedicated absinthe of
*Le Loclathon*, [La Locloise](https://loclathon.ch/#locloise).

## How it works

This website is built upon a custom framework inspired by Laravel, that handles
pages rendering, routing, caching, requests management, responses, requests
validation, localization and so on... It uses a functional paradigm based on
static classes loaded at runtime when necessary. No external underlying system,
but to be used with caution as it does not handle all the security for you.
Every request has to be passed to the [index.php](index.php) file.

For the frontend, you'll find a custom CSS library that handles the layout
and the JS usage is very limited in order to be supported by no-JS browsers.

## Requirements

- Apache >=2
- Composer
- PHP >=7
- SQLite3

Modules:
- [PHPMailer](https://github.com/PHPMailer/PHPMailer) (via Composer)
- [Checkout-PHP-SDK](https://github.com/paypal/Checkout-PHP-SDK/) (via Composer)

## Installation

From the project directory:

```sh
# Install PHP modules.
composer install
# Create database for orders.
cat static/database.sql | sqlite3 database.db
# Configure the project.
cp config.example.php config.php
$EDITOR config.php
# Secure files permissions.
chmod -R 770 .
chmod 660 config.php database.db
```

### Tweaks

- Add a cron job to remove old order caches.
- Mount the `cache` and `static` folders in *tmpfs* to speed up data transfers.
  Consider at least 100 Mb for `cache`.

## Development

Use the PHP internal server:

```sh
php -S 127.0.0.1:8000 index.php
```

## Roadmap

Please refer to [TODO.md](TODO.md).

## Contact

Please, don't hesitate to open an issue, or pull request, if you have found a
bug.  
For feedbacks or questions, you'll find my email address on my
[website](https://drowned.ch).

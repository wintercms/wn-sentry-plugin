# Sentry Plugin
[![MIT License](https://img.shields.io/badge/license-MIT-blue.svg)](https://github.com/wintercms/wn-sentry-plugin/blob/main/LICENSE)

Integrates the [sentry-laravel](https://github.com/getsentry/sentry-laravel) package into Winter CMS.

Supports:
- Performance & Error monitoring via the Sentry Laravel integration
- Performance & Error monitoring via the Sentry JS integration

## Installation

This plugin is available for installation via [Composer](http://getcomposer.org/).

```bash
composer require winter/wn-sentry-plugin
```

After installing the plugin you will need to run the migrations and (if you are using a [public folder](https://wintercms.com/docs/develop/docs/setup/configuration#using-a-public-folder)) [republish your public directory](https://wintercms.com/docs/develop/docs/console/setup-maintenance#mirror-public-files).

```bash
php artisan migrate
```

## Configuration

If you are using the [`.env` file](https://wintercms.com/docs/setup/configuration#dotenv-configuration) for configuration, simply add your Sentry DSN to the environment file as `SENTRY_LARAVEL_DSN` or `SENTRY_DSN`. If you are not using the `.env` file, simply copy `plugins/winter/sentry/config/config.php` to `config/winter/sentry/config.php` and change the value of `dsn`.

After you have provided the DSN, you can go to `example.com/debug-sentry` to test that exceptions are being reported to Sentry. Note that by default this route is only enabled when debug mode is enabled, although you can set it to be explicitly enabled or disabled by changing `enableTestRoute` in `config/winter/sentry/config.php`.

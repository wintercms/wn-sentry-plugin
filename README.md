# About

Integrates the [sentry-laravel](https://github.com/getsentry/sentry-laravel) package into Winter CMS.

# Configuration

If you are using the [`.env` file](https://wintercms.com/docs/setup/configuration#dotenv-configuration) for configuration, simply add your Sentry DSN to the environment file as `SENTRY_LARAVEL_DSN` or `SENTRY_DSN`. If you are not using the `.env` file, simply copy `plugins/winter/sentry/config/config.php` to `config/winter/sentry/config.php` and change the value of `dsn`.

After you have provided the DSN, you can go to `example.com/debug-sentry` to test that exceptions are being reported to Sentry. Note that by default this route is only enabled when debug mode is enabled, although you can set it to be explicitly enabled or disabled by changing `enableTestRoute` in `config/winter/sentry/config.php`.

# Installation

To install from the [Marketplace](https://wintercms.com/plugin/winter-sentry), click on the "Add to Project" button and then select the project you wish to add it to. Once the plugin has been added to the project, go to the backend and check for updates to pull in the plugin.

To install from the backend, go to **Settings -> Updates & Plugins -> Install Plugins** and then search for `Winter.Sentry`.

To install from [the repository](https://github.com/wintercms/wn-sentry-plugin), clone it into **plugins/winter/sentry** and then run `composer update` from your project root in order to pull in the dependencies.

To install it with Composer, run `composer require winter/wn-sentry-plugin` from your project root.

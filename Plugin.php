<?php namespace Winter\Sentry;

use App;
use Block;
use Event;
use Config;
use Url;
use System\Classes\PluginBase;
use Illuminate\Foundation\AliasLoader;

/**
 * Winter.Sentry Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Ensure plugin runs on command line too
     */
    public $elevated = true;

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'winter.sentry::lang.plugin.name',
            'description' => 'winter.sentry::lang.plugin.description',
            'author'      => 'Winter CMS',
            'icon'        => 'icon-bug',
            'homepage'    => 'https://github.com/wintercms/wn-sentry-plugin',
            'replaces'    => ['LukeTowers.Sentry' => '<=1.0.2'],
        ];
    }

    /**
     * Runs right before the request route
     */
    public function boot()
    {
        // Setup required packages
        $this->bootPackages();

        Event::listen('exception.report', function ($exception) {
            if (app()->bound('sentry')) {
                app('sentry')->captureException($exception);
            }
        });

        if ($jsDsn = env('SENTRY_JAVASCRIPT_DSN')) {
            $this->enableJavascriptSentry($jsDsn);
        }
    }

    /**
     * Boots (configures and registers) any packages found within this plugin's packages.load configuration value
     *
     * @see https://luketowers.ca/blog/how-to-use-laravel-packages-in-october-plugins
     * @author Luke Towers <wintercms@luketowers.ca>
     */
    public function bootPackages()
    {
        // Get the namespace of the current plugin to use in accessing the Config of the plugin
        $pluginNamespace = str_replace('\\', '.', strtolower(__NAMESPACE__));

        // Instantiate the AliasLoader for any aliases that will be loaded
        $aliasLoader = AliasLoader::getInstance();

        // Get the packages to boot
        $packages = Config::get($pluginNamespace . '::config.packages');

        // Boot each package
        foreach ($packages as $name => $options) {
            // Setup the configuration for the package, pulling from this plugin's config
            if (!empty($options['config']) && !empty($options['config_namespace'])) {
                Config::set($options['config_namespace'], $options['config']);
            }

            // Register any Service Providers for the package
            if (!empty($options['providers'])) {
                foreach ($options['providers'] as $provider) {
                    App::register($provider);
                }
            }

            // Register any Aliases for the package
            if (!empty($options['aliases'])) {
                foreach ($options['aliases'] as $alias => $path) {
                    $aliasLoader->alias($alias, $path);
                }
            }
        }
    }

    public function enableJavascriptSentry(?string $javascriptDsn)
    {
        $script = Url::asset('/plugins/winter/sentry/assets/js/dist/sentry.js');
        $env = Config::get('app.env');
        $sampleRate = Config::get('sentry.traces_sample_rate');

        $html = <<<HTML
            <script>
                window.sentryEnv = window.sentryEnv || {};
                window.sentryEnv.SENTRY_JAVASCRIPT_DSN = "{$javascriptDsn}";
                window.sentryEnv.APP_ENV = "{$env}";
                window.sentryEnv.SENTRY_TRACES_SAMPLE_RATE = {$sampleRate};
            </script>
            <script src="{$script}"></script>
        HTML;

        if ($this->app->runningInBackend()) {
            // Inject into the Block placeholder `head` in the backend
            Block::append('head', $html);
        } elseif (!$this->app->runningInConsole()) {
            // Inject into the {% scripts %} tag in the frontend
            Block::append('scripts', $html);
        }
    }
}

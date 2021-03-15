<?php
$enableRoute = Config::get('winter.sentry::config.enableTestRoute');
if (is_null($enableRoute)) {
    $enableRoute = Config::get('app.debug');
}
if ($enableRoute) {
    Route::get('/debug-sentry', function () {
        throw new Exception('Sentry test exception, check sentry.io to confirm successful report');
    });
}
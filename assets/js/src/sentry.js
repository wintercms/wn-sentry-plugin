import * as Sentry from "@sentry/browser";
import { BrowserTracing } from "@sentry/tracing";

window.sentryEnv = window.sentryEnv || {};

(function (dsn, environment, tracesSampleRate) {
    if (!dsn) {
        console.warn("Sentry plugin enabled but no DSN set");
        return;
    }

    Sentry.init({
        dsn: dsn,
        integrations: [new BrowserTracing()],
        environment: environment || "production",

        // Set tracesSampleRate to 1.0 to capture 100%
        // of transactions for performance monitoring.
        // We recommend adjusting this value in production
        tracesSampleRate: tracesSampleRate || 1.0,
    });
})(window.sentryEnv.SENTRY_JAVASCRIPT_DSN, window.sentryEnv.APP_ENV, window.sentryEnv.SENTRY_TRACES_SAMPLE_RATE);




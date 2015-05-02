requirejs.config({
    baseUrl: '/assets/js',
    shim: {
        bootstrap: {
            deps: ['jquery']
        },
        'jQuery': {
            exports: '$'
        },
        'underscore': {
            exports: '_'
        }
    }
});

require(['main']);
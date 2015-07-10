requirejs.config({
    deps: [

    ],
    paths: {
        messages: "messages",
        react: "../vendor/react/react-with-addons.min",
        JSXTransformer: "../vendor/jsx-requirejs-plugin/js/JSXTransformer",
        jsx: "../vendor/jsx-requirejs-plugin/js/jsx",
        text: "../vendor/requirejs-text/text",
        less: "../vendor/less/dist/less",
        bootstrap: "../vendor/bootstrap/dist/js/bootstrap",
        jquery: "../vendor/jquery/dist/jquery"
    },
    shim: {
        bootstrap: [
            "jquery"
        ]
    },
    jsx: {
        fileExtension: ".jsx"
    },
    packages: [

    ]
});

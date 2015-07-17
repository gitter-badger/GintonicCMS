define(function(require) {

    var React = require('reactDev');

    var Heading = React.createClass({displayName: "Heading",
        render: function() {
            return (
                React.createElement("div", {className: "panel-heading"}, 
                    React.createElement("i", {className: "fa fa-comments"}), " Chat", 
                    React.createElement("div", {className: "pull-right"}, 
                        React.createElement("a", {"data-toggle": "collapse", "data-parent": "#accordion", href: "#collapseOne"}, 
                            React.createElement("i", {className: "fa fa-minus"})
                        )
                    )
                )
            );
        }
    });

    return Heading;
});


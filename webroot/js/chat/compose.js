define(function(require) {

    var React = require('reactDev');

    var Compose = React.createClass({displayName: "Compose",
        handleSubmit: function(e){
            e.preventDefault();
            var body = React.findDOMNode(this.refs.body).value.trim();
            if (!body) {
                return;
            }
            this.props.handleSubmit({body: body});
            React.findDOMNode(this.refs.body).value = '';
        },
        render: function() {
            return (
                React.createElement("div", {className: "panel-footer"}, 
                    React.createElement("form", {className: "chatComposeForm", onSubmit: this.handleSubmit}, 
                        React.createElement("div", {className: "input-group"}, 
                            React.createElement("input", {id: "btn-input", type: "text", className: "form-control input-sm", ref: "body", placeholder: "Type your message here..."}), 
                            React.createElement("span", {className: "input-group-btn"}, 
                                React.createElement("input", {className: "btn btn-warning btn-sm", type: "submit", id: "btn-chat"}, "Send")
                            )
                        )
                    )
                )
            );
        }
    });

    return Compose;
});


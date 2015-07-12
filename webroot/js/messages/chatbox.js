define(function(require) {

    var React = require('reactDev');
    var classNames = require('classnames');

    var data = [
        {author: "Denis Coderre", content: "Salut le gros"},
        {author: "Luc Ferrandez", content: "C'est toi le gros"},
    ]

    var ChatBox = React.createClass({displayName: "ChatBox",
        render: function() {
            return (
                React.createElement("div", {id: "accordion", className: "panel panel-default"}, 
                    React.createElement(ChatHeading, null), 
                    React.createElement("div", {className: "panel-collapse collapse in", id: "collapseOne"}, 
                        React.createElement("div", {className: "panel-body"}, 
                            React.createElement(ChatMessages, {data: this.props.data})
                        ), 
                        React.createElement(ChatCompose, null)
                    )
                )
            );
        }
    });

    var ChatHeading = React.createClass({displayName: "ChatHeading",
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

    var ChatCompose = React.createClass({displayName: "ChatCompose",
        render: function() {
            return (
            React.createElement("div", {className: "panel-footer"}, 
                React.createElement("div", {className: "input-group"}, 
                    React.createElement("input", {id: "btn-input", type: "text", className: "form-control input-sm", placeholder: "Type your message here..."}), 
                    React.createElement("span", {className: "input-group-btn"}, 
                        React.createElement("button", {className: "btn btn-warning btn-sm", id: "btn-chat"}, 
                            "Send")
                    )
                )
            )
            );
        }
    });

    var ChatMessages = React.createClass({displayName: "ChatMessages",
        render: function() {
            var messages = this.props.data.map(function (message){
                return(
                    React.createElement("li", {className: "left clearfix"}, 
                        React.createElement("span", {className: "chat-img pull-left"}, 
                           React.createElement("img", {className: "img-circle avatar", src: "/gintonic_c_m_s/img/avatar.jpg"})
                        ), 
                        React.createElement("div", {className: "chat-body clearfix"}, 
                            React.createElement("div", {className: "header"}, 
                                React.createElement("strong", {className: "primary-font"}, message.author), 
                                React.createElement("small", {className: "pull-right text-muted"}, 
                                    React.createElement("span", {className: "glyphicon glyphicon-time"}), 
                                    "12 mins ago"
                                )
                            ), 
                            React.createElement("p", null, message.content)
                        )
                    )
                );
            });
            return (
                React.createElement("ul", {className: "chat"}, 
                    messages
                )
            );
        }
    });
    React.render(
        React.createElement(ChatBox, {data: data}),
        document.getElementById('example')
    );

});


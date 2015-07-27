define(function(require) {

    var React = require('reactDev');

    var Messages = React.createClass({displayName: "Messages",
        render: function() {
            var messages = this.props.data.messages.map(function (message){
                var email = 'Me';
                if(('user' in message) && ('email' in message.user)) {
                    email = message.user.email;;
                }
                return(
                    React.createElement("li", {className: "left clearfix"}, 
                        React.createElement("span", {className: "chat-img pull-left"}, 
                           React.createElement("img", {className: "img-circle avatar", src: "/gintonic_c_m_s/img/avatar.jpg"})
                        ), 
                        React.createElement("div", {className: "chat-body clearfix"}, 
                            React.createElement("div", {className: "header"}, 
                                React.createElement("strong", {className: "primary-font"}, email), 
                                React.createElement("small", {className: "pull-right text-muted"}, 
                                    React.createElement("span", {className: "glyphicon glyphicon-time"}), 
                                    "12 mins ago"
                                )
                            ), 
                            React.createElement("p", null, message.body)
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

    return Messages;
});


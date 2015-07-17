define(function(require) {

    var React = require('reactDev');

    var Messages = React.createClass({displayName: "Messages",
        render: function() {
            console.log(this.props.data);
            var messages = this.props.data.map(function (message){
                return(
                    React.createElement("li", {className: "left clearfix"}, 
                        React.createElement("span", {className: "chat-img pull-left"}, 
                           React.createElement("img", {className: "img-circle avatar", src: "/gintonic_c_m_s/img/avatar.jpg"})
                        ), 
                        React.createElement("div", {className: "chat-body clearfix"}, 
                            React.createElement("div", {className: "header"}, 
                                React.createElement("strong", {className: "primary-font"}, message.user.email), 
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


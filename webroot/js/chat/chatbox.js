define(function(require) {

    var React = require('reactDev');
    var Messages = require('chat/messages');
    var Heading = require('chat/heading');
    var Compose = require('chat/compose');
    var CommunicationMixin = require('gintonic_c_m_s/js/websocket/mixin');

    var ChatBox = React.createClass({displayName: "ChatBox",

        mixins: [CommunicationMixin],

        fetchUrl: "/threads/get.json",
        sendUrl:  "/messages/send.json",
        recieveUri: "messages.send",

        getInitialState: function() {
            return {
                messages: []
            };
        },

        preSend: function(data){
            data['thread_id'] = 1;
            this.send(data);
        },

        fetched: function(data){
            this.setState({messages: data['threads']['messages']});
        },

        recieved: function(data){
            this.state.messages.push(data);
            this.setState({messages: this.state.messages});
        },

        render: function() {
            return (
                React.createElement("div", {id: "accordion", className: "panel panel-default"}, 
                    React.createElement(Heading, null), 
                    React.createElement("div", {className: "panel-collapse collapse in", id: "collapseOne"}, 
                        React.createElement("div", {className: "panel-body"}, 
                            React.createElement(Messages, {data: this.state})
                        ), 
                        React.createElement(Compose, {submit: this.preSend})
                    )
                )
            );
        }
    });

    return ChatBox;
});


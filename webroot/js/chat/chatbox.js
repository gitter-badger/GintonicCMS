define(function(require) {

    var React = require('reactDev');
    var Messages = require('chat/messages');
    var Heading = require('chat/heading');
    var Compose = require('chat/compose');
    var WebsocketMixin = require('gintonic_c_m_s/js/websocket/mixin');

    var ChatBox = React.createClass({displayName: "ChatBox",

        mixins: [WebsocketMixin],

        retrieveUrl: "/threads/get.json",
        submitUrl:  "/messages/send.json",
        recieveUri: "messages.send",

        getInitialState: function() {
            return {
                data: {
                    messages: [],
                }
            };
        },

        submit: function(data){
            //console.log(data);
            //this.state.data.messages.push({
            //    body:data['body'],
            //    user:{
            //        email: 'test@blackhole.io'
            //    }
            //});
            //this.setState({data: this.state.data});

            data['thread_id'] = 1;
            data['user_id'] = 4;
            this.websocketSubmit(data);
        },

        retrieve: function(data){
            this.setState({data: data['threads'][0]});
        },

        recieve: function(data){
            console.log('recieved data');
            console.log(data);
            this.setState({data: data['threads'][0]});
        },

        render: function() {
            return (
                React.createElement("div", {id: "accordion", className: "panel panel-default"}, 
                    React.createElement(Heading, null), 
                    React.createElement("div", {className: "panel-collapse collapse in", id: "collapseOne"}, 
                        React.createElement("div", {className: "panel-body"}, 
                            React.createElement(Messages, {data: this.state.data.messages})
                        ), 
                        React.createElement(Compose, {submit: this.submit})
                    )
                )
            );
        }
    });

    return ChatBox;
});


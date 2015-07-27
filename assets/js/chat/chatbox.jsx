define(function(require) {

    var React = require('reactDev');
    var Messages = require('chat/messages');
    var Heading = require('chat/heading');
    var Compose = require('chat/compose');
    var CommunicationMixin = require('gintonic_c_m_s/js/websocket/mixin');

    var ChatBox = React.createClass({

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
                <div id="accordion" className="panel panel-default">
                    <Heading />
                    <div className="panel-collapse collapse in" id="collapseOne">
                        <div className="panel-body">
                            <Messages data={this.state}/>
                        </div>
                        <Compose submit={this.preSend}/>
                    </div>
                </div>
            );
        }
    });

    return ChatBox;
});


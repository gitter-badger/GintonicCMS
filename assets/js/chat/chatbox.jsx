define(function(require) {

    var React = require('reactDev');
    var Messages = require('chat/messages');
    var Heading = require('chat/heading');
    var Compose = require('chat/compose');
    var WebsocketMixin = require('gintonic_c_m_s/js/websocket/mixin');

    var ChatBox = React.createClass({

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
                <div id="accordion" className="panel panel-default">
                    <Heading />
                    <div className="panel-collapse collapse in" id="collapseOne">
                        <div className="panel-body">
                            <Messages data={this.state.data.messages}/>
                        </div>
                        <Compose submit={this.submit}/>
                    </div>
                </div>
            );
        }
    });

    return ChatBox;
});


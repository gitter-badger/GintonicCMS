define(function(require) {

    var React = require('reactDev');
    var Messages = require('chat/messages');
    var Heading = require('chat/heading');
    var Compose = require('chat/compose');
    var websocket = require('gintonic_c_m_s/js/websocket');

    var ChatBox = React.createClass({

        getInitialState: function() {
            return {
                data: {
                    messages: []
                }
            };
        },

        componentDidMount: function() {
            this.retrieveMessages();
        },

        handleSubmit: function(message) {

            // update chatbox
            this.state.data.messages.push({
                body:message['body'],
                user:{
                    email: 'test@blackhole.io'
                }
            });
            this.setState({data: this.state.data});

            data = {};
            data['thread_id'] = this.props.id;
            data['body'] = message['body'];
            var payload = [
                this.props.sendUrl,
                JSON.stringify(data)
            ];
            websocket.publish('server', payload);
        },

        retrieveMessages: function(){
            $.ajax({
                url: this.props.getUrl,
                method: "POST",
                dataType: 'json',
                cache: false,
                data: {
                    id: [this.props.id]
                },
                success: function(data) {
                    this.setState({data: data['threads'][0]});
                }.bind(this),
                    error: function(xhr, status, err) {
                    console.error(this.props.url, status, err.toString());
                }.bind(this)
            });
        },

        render: function() {
            return (
                <div id="accordion" className="panel panel-default">
                    <Heading />
                    <div className="panel-collapse collapse in" id="collapseOne">
                        <div className="panel-body">
                            <Messages data={this.state.data.messages}/>
                        </div>
                        <Compose handleSubmit={this.handleSubmit}/>
                    </div>
                </div>
            );
        }
    });

    return ChatBox;
});


define(function(require) {

    var React = require('reactDev');
    var Messages = require('chat/messages');
    var Heading = require('chat/heading');
    var Compose = require('chat/compose');

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
            //setInterval(this.retrieveMessages, this.props.pollInterval);
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

            // send to server
            $.ajax({
                url: this.props.sendUrl,
                method: "POST",
                dataType: 'json',
                cache: false,
                data: {
                    thread_id: this.props.id,
                    body: message['body']
                },
                error: function(xhr, status, err) {
                    console.error(this.props.sendUrl, status, err.toString());
                }.bind(this)
            });
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


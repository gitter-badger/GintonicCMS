define(function(require) {

    var React = require('reactDev');
    var Messages = require('chat/messages');
    var Heading = require('chat/heading');
    var Compose = require('chat/compose');

    var ChatBox = React.createClass({

        getInitialState: function() {
            return {data: {
                messages: []
            }};
        },

        componentDidMount: function() {
            this.retrieveMessages();
            setInterval(this.retrieveMessages, this.props.pollInterval);
        },

        handleSubmit: function(message) {
            this.state.data.messages.push({
                body:message,
                user:{
                    email: 'test@blackhole.io'
                }
            });
            this.setState({data: this.state.data});
        },

        retrieveMessages: function(){
            $.ajax({
                url: this.props.url,
                dataType: 'json',
                cache: false,
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


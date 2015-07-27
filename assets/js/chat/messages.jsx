define(function(require) {

    var React = require('reactDev');

    var Messages = React.createClass({
        render: function() {
            var messages = this.props.data.messages.map(function (message){
                var email = 'Me';
                if(('user' in message) && ('email' in message.user)) {
                    email = message.user.email;;
                }
                return(
                    <li className="left clearfix">
                        <span className="chat-img pull-left">
                           <img className="img-circle avatar" src="/gintonic_c_m_s/img/avatar.jpg"></img> 
                        </span>
                        <div className="chat-body clearfix">
                            <div className="header">
                                <strong className="primary-font">{email}</strong> 
                                <small className="pull-right text-muted">
                                    <span className="glyphicon glyphicon-time"></span>
                                    12 mins ago
                                </small>
                            </div>
                            <p>{message.body}</p>
                        </div>
                    </li>
                );
            });
            return (
                <ul className="chat">
                    {messages} 
                </ul>
            );
        }
    });

    return Messages;
});


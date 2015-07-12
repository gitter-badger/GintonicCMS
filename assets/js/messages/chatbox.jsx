define(function(require) {

    var React = require('reactDev');
    var classNames = require('classnames');

    var data = [
        {author: "Denis Coderre", content: "Salut le gros"},
        {author: "Luc Ferrandez", content: "C'est toi le gros"},
    ]

    var ChatBox = React.createClass({
        render: function() {
            return (
                <div id="accordion" className="panel panel-default">
                    <ChatHeading />
                    <div className="panel-collapse collapse in" id="collapseOne">
                        <div className="panel-body">
                            <ChatMessages data={this.props.data}/>
                        </div>
                        <ChatCompose/>
                    </div>
                </div>
            );
        }
    });

    var ChatHeading = React.createClass({
      render: function() {
        return (
            <div className="panel-heading">
                <i className="fa fa-comments"></i> Chat
                <div className="pull-right">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                        <i className="fa fa-minus"></i>
                    </a>
                </div>
            </div>
        );
      }
    });

    var ChatCompose = React.createClass({
        render: function() {
            return (
            <div className="panel-footer">
                <div className="input-group">
                    <input id="btn-input" type="text" className="form-control input-sm" placeholder="Type your message here..." />
                    <span className="input-group-btn">
                        <button className="btn btn-warning btn-sm" id="btn-chat">
                            Send</button>
                    </span>
                </div>
            </div>
            );
        }
    });

    var ChatMessages = React.createClass({
        render: function() {
            var messages = this.props.data.map(function (message){
                return(
                    <li className="left clearfix">
                        <span className="chat-img pull-left">
                           <img className="img-circle avatar" src="/gintonic_c_m_s/img/avatar.jpg"></img> 
                        </span>
                        <div className="chat-body clearfix">
                            <div className="header">
                                <strong className="primary-font">{message.author}</strong> 
                                <small className="pull-right text-muted">
                                    <span className="glyphicon glyphicon-time"></span>
                                    12 mins ago
                                </small>
                            </div>
                            <p>{message.content}</p>
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
    React.render(
        <ChatBox  data={data}/>,
        document.getElementById('example')
    );

});


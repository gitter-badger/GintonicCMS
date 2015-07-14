define(function(require) {

    var React = require('reactDev');

    var Compose = React.createClass({
        handleSubmit: function(e){
            e.preventDefault();
            var body = React.findDOMNode(this.refs.body).value.trim();
            if (!body) {
                return;
            }
            this.props.handleSubmit({body: body});
            React.findDOMNode(this.refs.body).value = '';
        },
        render: function() {
            return (
                <div className="panel-footer">
                    <form className="chatComposeForm" onSubmit={this.handleSubmit}>
                        <div className="input-group">
                            <input id="btn-input" type="text" className="form-control input-sm" ref="body" placeholder="Type your message here..." />
                            <span className="input-group-btn">
                                <input className="btn btn-warning btn-sm" type="submit" id="btn-chat">Send</input>
                            </span>
                        </div>
                    </form>
                </div>
            );
        }
    });

    return Compose;
});


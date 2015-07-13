define(function(require) {

    var React = require('reactDev');

    var Heading = React.createClass({
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

    return Heading;
});


define(function(require) {

    var React = require('reactDev');
    var ChatBox = require('chat/chatbox');

    React.render(
        <ChatBox url="/threads/get.json" pollInterval={2000}/>,
        document.getElementById('example')
    );

});


define(function(require) {

    var React = require('reactDev');
    var ChatBox = require('chat/chatbox');

    React.render(
        <ChatBox id={1}/>,
        document.getElementById('example')
    );

});


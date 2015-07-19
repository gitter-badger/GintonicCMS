define(function(require) {

    var React = require('reactDev');
    var ChatBox = require('chat/chatbox');

    React.render(
        React.createElement(ChatBox, {id: 1}),
        document.getElementById('example')
    );

});


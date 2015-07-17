define(function(require) {

    var React = require('reactDev');
    var ChatBox = require('chat/chatbox');

    React.render(
        React.createElement(ChatBox, {
            sendUrl: "/messages/send.json", 
            getUrl: "/threads/get.json", 
            pollInterval: 2000, 
            id: 1}),
        document.getElementById('example')
    );

});


define(function(require) {

    var websocket = require('gintonic_c_m_s/js/websocket/websocket');

    var WebsocketMixin = {

        componentDidMount: function() {
            websocket.subscribe({
                topic: this.recieveUri,
                method: this.recieve,
            });
            this.baseRetrieve();
        },

        baseRetrieve: function(){
            $.ajax({
                url: this.retrieveUrl,
                method: "POST",
                dataType: 'json',
                cache: false,
                data: {
                    id: [this.props.id]
                },
                success: function(data) {
                    this.retrieve(data);
                }.bind(this),
                    error: function(xhr, status, err) {
                    console.error(this.retrieveUrl, status, err.toString());
                }.bind(this)
            });
        }, 

        websocketSubmit: function(data) {
            var destination = [
                this.submitUrl,
                this.props.id,
            ];
            websocket.publish(destination, JSON.stringify(data));
        },
    };
    
    return WebsocketMixin;
});


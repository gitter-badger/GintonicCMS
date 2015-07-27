define(function(require) {

    var websocket = require('gintonic_c_m_s/js/websocket/websocket');

    var CommunicationMixin = {

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

        baseSubmit: function(data) {

            $.ajax({
                url: this.submitUrl,
                method: "POST",
                dataType: 'json',
                cache: false,
                data: data,
            })
            .done(function(data){
                console.log('success');
                console.log(data);
                this.retrieve(data);
            })
            .fail(function(data){
                console.log('fail');
                console.log(data);
            })
            .always(function(data){
                console.log('always');
                console.log(data);
            });
        },
    };
    
    return CommunicationMixin;
});


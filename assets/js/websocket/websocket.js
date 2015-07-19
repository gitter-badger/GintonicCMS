define(function(require) {

    var autobahn = require('autobahn');
    var instance = null;

    function Websocket() {
        if (instance != null) {
            return;
        }

        this.connection = new autobahn.Connection({url: 'ws://127.0.0.1:9090', realm: 'realm1'});
        this.subscribes = [];
        this.session = null;

        that = this;
        this.connection.onopen = function (session) {

            that.session = session;
            that.subscribes.forEach(function(sub) {
                session.subscribe(sub['topic'], sub['method'])
            });
        };

        this.connection.open();
    }

    Websocket.prototype.subscribe = function(sub) {
        if (this.session == null) {
            this.subscribes.push(sub);
        } else {
            this.session.subscribe(sub['topic'], sub['method']);
        }
    }

    Websocket.prototype.publish = function(data) {
        if (this.session != null) {
           this.session.publish('server', data);
        }
    }

    Websocket.getInstance = function(){
        if (instance === null) {
            instance = new Websocket();
        }
        return instance;
    }

    return Websocket.getInstance();


});


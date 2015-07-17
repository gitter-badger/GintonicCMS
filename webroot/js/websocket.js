define(function(require) {

    var autobahn = require('autobahn');
    var instance = null;
    var session = null;

    function Websocket() {
        if (instance != null) {
            return;
        }

        this.connection = new autobahn.Connection({url: 'ws://127.0.0.1:9090', realm: 'realm1'});
        this.objects = [];
        console.log(this.connection);

        that = this;
        this.connection.onopen = function (session) {

           that.session = session;
           that.objects.forEach(function(obj){
               obj.execute();
           });
           // 1) subscribe to a topic
           //function onevent(args) {
           //   console.log("Event:", args[0]);
           //}
           //session.subscribe('messages.index', that.onevent);
           //that.addSubscribe(session);

           // 2) publish an event
           //session.publish('com.myapp.hello', ['Hello, world!']);

           //// 3) register a procedure for remoting
           //function add2(args) {
           //   return args[0] + args[1];
           //}
           //session.register('com.myapp.add2', add2);

           //// 4) call a remote procedure
           //session.call('com.myapp.add2', [2, 3]).then(
           //   function (res) {
           //      console.log("Result:", res);
           //   }
           //);
        };

        this.connection.open();
        //console.log('test');
    }

    Websocket.prototype.registerObject = function(object) {
        this.objects.push(object);
    }

    Websocket.prototype.subscribe = function(method) {
       this.session.subscribe('messages.index', method);
    }

    Websocket.prototype.publish = function(topic, data, kwdata) {
       this.session.publish(topic, data);
    }

    Websocket.getInstance = function(){
        if (instance === null) {
            instance = new Websocket();
        }
        return instance;
    }

    return Websocket.getInstance();


});


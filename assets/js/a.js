define(function(require) {

    var websocket = require('gintonic_c_m_s/js/websocket');

    function A(){
        this.test = 'pizza';
    }

    A.prototype.onevent = function(args){
        console.log("Event:", args[0]);
    }

    var a = new A();

    setTimeout(function(){
        console.log('test after 2');
        websocket.subscribe(a.onevent);
    }, 2000);

});


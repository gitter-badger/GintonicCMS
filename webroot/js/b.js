define(function(require) {

    var websocket = require('gintonic_c_m_s/js/websocket');

    function B(){
        this.test = 'giros';
    }

    B.prototype.execute = function(){
        console.log(this.test);
    }

    websocket.registerObject(new B());

});


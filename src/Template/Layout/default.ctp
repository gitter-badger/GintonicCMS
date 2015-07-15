<!DOCTYPE html>
<html lang="en">
    <head>
        <?= $this->Html->charset() ?>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <?= $this->Html->meta('icon') ?>

        <title>
            <?= $this->fetch('title') ?>
        </title>

        <?= $this->Html->css('TwbsTheme.default') ?>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>

        <?= $this->element('GintonicCMS.Menus/top_menu')?>

        <div class="container">
            <div class="row">
                <?= $this->Flash->render(); ?>
            </div>
        </div>

        <?= $this->fetch('content'); ?>	                    

        <footer class="footer">
          <div class="container">
            <p class="text-muted">Powered by <a href="https://github.com/gintonicweb/GintonicCMS">GintonicCMS</a> from <a href="http://gintonicweb.com">Gintonic Web</a> </p>
          </div>
        </footer>
        <?= $this->Require->req('jquery');?>
        <?= $this->Require->req('bootstrap');?>
        <!--
        <?= $this->Require->load(); ?>
        -->

<script src="gintonic_c_m_s/autobahn.min.jgz"></script>
<script>
var connection = new autobahn.Connection({url: 'ws://127.0.0.1:9090', realm: 'realm1'});

console.log(connection);

connection.onopen = function (session) {

   // 1) subscribe to a topic
   function onevent(args) {
      console.log("Event:", args[0]);
   }
   session.subscribe('gintoniccms.messages.index', onevent);

   // 2) publish an event
   session.publish('com.myapp.hello', ['Hello, world!']);

   // 3) register a procedure for remoting
   function add2(args) {
      return args[0] + args[1];
   }
   session.register('com.myapp.add2', add2);

   // 4) call a remote procedure
   session.call('com.myapp.add2', [2, 3]).then(
      function (res) {
         console.log("Result:", res);
      }
   );
};

//connection.open();
</script>

    </body>
</html>





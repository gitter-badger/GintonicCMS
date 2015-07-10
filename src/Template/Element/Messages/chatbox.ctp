<div class="col-md-5">
    <div id="accordion" class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-comments"></i> Chat
            <div class="pull-right">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                    <i class="fa fa-minus"></i>
                </a>
            </div>
        </div>
        <div class="panel-collapse collapse in" id="collapseOne">
            <div class="panel-body">
                <ul class="chat">
                    <li class="left clearfix">
                        <span class="chat-img pull-left">
                            <?= $this->Html->image('GintonicCMS.avatar.jpg', ['class'=>'img-circle avatar']) ?>
                        </span>
                        <div class="chat-body clearfix">
                            <div class="header">
                                <strong class="primary-font">Jack Sparrow</strong> <small class="pull-right text-muted">
                                    <span class="glyphicon glyphicon-time"></span>12 mins ago</small>
                            </div>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare
                                dolor, quis ullamcorper ligula sodales.
                            </p>
                        </div>
                    </li>
                    <li class="right clearfix">
                        <span class="chat-img pull-right">
                            <?= $this->Html->image('GintonicCMS.avatar.jpg', ['class'=>'img-circle avatar']) ?>
                        </span>
                        <div class="chat-body clearfix">
                            <div class="header">
                                <small class=" text-muted"><span class="glyphicon glyphicon-time"></span>13 mins ago</small>
                                <strong class="pull-right primary-font">Bhaumik Patel</strong>
                            </div>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare
                                dolor, quis ullamcorper ligula sodales.
                            </p>
                        </div>
                    </li>
                    <li class="left clearfix">
                        <span class="chat-img pull-left">
                            <?= $this->Html->image('GintonicCMS.avatar.jpg', ['class'=>'img-circle avatar']) ?>
                        </span>
                        <div class="chat-body clearfix">
                            <div class="header">
                                <strong class="primary-font">Jack Sparrow</strong> <small class="pull-right text-muted">
                                    <span class="glyphicon glyphicon-time"></span>14 mins ago</small>
                            </div>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare
                                dolor, quis ullamcorper ligula sodales.
                            </p>
                        </div>
                    </li>
                    <li class="right clearfix">
                        <span class="chat-img pull-right">
                            <?= $this->Html->image('GintonicCMS.avatar.jpg', ['class'=>'img-circle avatar']) ?>
                        </span>
                        <div class="chat-body clearfix">
                            <div class="header">
                                <small class=" text-muted"><span class="glyphicon glyphicon-time"></span>15 mins ago</small>
                                <strong class="pull-right primary-font">Bhaumik Patel</strong>
                            </div>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare
                                dolor, quis ullamcorper ligula sodales.
                            </p>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="panel-footer">
                <div class="input-group">
                    <input id="btn-input" type="text" class="form-control input-sm" placeholder="Type your message here..." />
                    <span class="input-group-btn">
                        <button class="btn btn-warning btn-sm" id="btn-chat">
                            Send</button>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

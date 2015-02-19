<?php
use Cake\Core\Configure;
use Cake\Core\Configure\Engine\PhpConfig;

$this->Helpers()->load('GintonicCMS.GtwRequire');
echo $this->GtwRequire->req('users/register_validation'); 
?>
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h1 class="text-center login-title"><?php echo __('Sign up'); ?></h1>
            <div class="account-wall">
                <?php 
                echo $this->Html->image(Configure::read('Gtw.site_logo_url'), ["class" => "img-responsive profile-img", "alt" => Configure::read('Gtw.site_name')]);
                echo $this->Flash->render();
                echo $this->Form->create('Users',['templates'=>['inputContainer'=>'<div class="form-group">{{content}}</div>'],'class' => 'form-signin','id'=>'UserSignupForm']);
                echo $this->Form->input('first',['class'=>'form-control','placeholder'=>__('First Name'),'id'=>'signup-first'],'required');
                echo $this->Form->input('last',['class'=>'form-control','placeholder'=>__('Last Name'),'id'=>'signup-last']);
                echo $this->Form->input('email',['class'=>'form-control','placeholder'=>__('Email'),'id'=>'signup-email','parsley-trigger'=>'change','required']);
                echo $this->Form->input('password',['type'=>'password','class'=>'form-control','placeholder'=>__('Password'),'id'=>'signup-password']);
                echo $this->Form->submit(__('Sign up'),['class'=>'btn btn-lg btn-primary btn-block']);
                echo $this->Form->end();
                ?>
            </div>
            <?php echo $this->Html->link(__('Already have an account?'),['controller'=>'Users','action'=>'signin'],['escape'=>false,'class' => 'text-center new-account']); ?>
        </div>
    </div>
</div>
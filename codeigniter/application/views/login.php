<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    
    <title>Twitter</title>
    
    <link href="<?=base_url();?>resources/css/bootstrap.min.css" rel="stylesheet">
    <script src="<?=base_url();?>resources/js/jquery.js"></script>
    <script src="<?=base_url();?>resources/js/bootstrap.min.js"></script>
    
    <style type="text/css">
        body {
            background: url("<?=base_url();?>resources/images/green-bg.jpg");
            background-size: auto auto;
            background-repeat: no-repeat;
        }
    </style>
    
</head>

<body>

    <nav class="navbar navbar-inverse" role="navigation">
        <div class="navbar-header">
            <a class="navbar-brand" href="<?=base_url();?>index.php/twitter/homepage">Twitter</a>
        </div>
    </nav>

    <div class="container">
                      
        <div class="col-md-4">

            <div class="text-danger"><?=form_error('mail');?></div>
            <div class="text-danger"><?=form_error('password');?></div>
            <?=$this->session->flashdata('error_msg');?>

            <?php
                $attributes = array("class" => "form-horizontal", "id" => "login_form");
                echo form_open('twitter/login', $attributes);
                echo form_label('メールアドレス', 'mail');
                $data_mail_input = array(
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => 'mail',
                    'name' => 'mail',
                    'placeholder' => 'example@gmail.com'
                );
                echo form_input($data_mail_input);
                echo br();
                echo form_label('パスワード', 'password');
                $data_form_password = array(
                    'type' => 'password',
                    'class' => 'form-control',
                    'id' => 'password',
                    'name' => 'password',
                    'placeholder' => '123456'
                );
                echo form_password($data_form_password);
            ?> 

            <div class="col-md-offset-4 col-md-9">
              <?php 
                $data_form_submit = array(
                  'type' => 'submit',
                  'name' => 'btn-login',
                  'class' => 'btn btn-info',
                  'value' => 'ログイン',
              );
              echo br();
              echo form_submit($data_form_submit);
              echo br(2);
              ?>
            </div>
               
            <div class="col-md-offset-2 col-md-9">
                <label>
                    <h4><?=anchor('twitter/register', 'ユーザー登録こちらから');?></h4>
                </label>
            </div>
            
            <?=form_close();?>

        </div>
        
    </div>

</body>

</html>

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

            <div class="text-danger"><?=form_error('name');?></div>
            <div class="text-danger"><?=form_error('mail');?></div>
            <div class="text-danger"><?=form_error('password');?></div>
            <div class="text-danger"><?=form_error('confirm_password')?></div>
            <?=$this->session->flashdata('error_msg');?>

            <?php
                $attributes = array("class" => "form-horizontal", "id" => "register_form");
                
                echo form_open('twitter/register', $attributes);

                echo form_label('名前', 'name');
                $data_name_input = array(
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => 'name',
                    'name' => 'name',
                    'placeholder' => 'manh'
                );
                echo form_input($data_name_input);
                echo br();

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
                echo br();

                echo form_label('パスワード確認', 'confirm_password');
                $data_form_confirm_password = array(
                    'type' => 'password',
                    'class' => 'form-control',
                    'id' => 'confirm_password',
                    'name' => 'confirm_password',
                    'placeholder' => '123456'
                );
                echo form_password($data_form_confirm_password);               
            ?> 
            
            <div class="col-md-offset-4 col-md-9">
                <?php 
                  $data_form_submit = array(
                      'type' => 'submit',
                      'name' => 'btn-register',
                      'id' => 'btn_register',
                      'class' => 'btn btn-info',
                      'value' => '登録',
                  );
                  echo br();
                  echo form_submit($data_form_submit);
                  echo br();
                ?>                    
            </div>
               
            <?=form_close();?>
        </div>
        
    </div>

</body>

</html>

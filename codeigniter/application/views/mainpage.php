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
          background-repeat: repeat;
      }
    </style>

    <script type="text/javascript">

        function clearText() {
            document.getElementById("tweet_form").reset();
        }

        $(document).ready(function() {
            var limit = 10; 

            $('#btn_addtweet').click(function(event) {
                limit+=10;
                $('#tweet_list').load('tweet/' + String(limit));
            });

            $('#btn_tweet').click(function(event) {
                event.preventDefault();
                var tweet = $('#tweet').val();
                if ((tweet.length == 0) || (tweet.length>140)) {
                    $('#err_msg').html("ツイート欄は必須です。");
                }
                
                $.ajax({
                    url: "<?=base_url();?>index.php/tweet_controller/post",
                    type: "POST",
                    data: {
                        "<?=$this->security->get_csrf_token_name()?>": "<?=$this->security->get_csrf_hash()?>",
                        "tweet": tweet
                    },
                    success: function() {
                        $('#tweet_list').load('tweet/' + String(limit));
                    }
                });
                clearText();
            });
        });
        
    </script>
    
</head>

<body>
    <nav class="navbar navbar-inverse" role="navigation">
        <div class="navbar-header">
            <a class="navbar-brand" href="<?=base_url();?>index.php/twitter/homepage">Twitter</a>
        </div>
        <div>
            <ul class="nav navbar-nav navbar-right">
                <li class="active"><a href="#"><?=$name;?></a></li>
                <li><a href="<?=base_url(); ?>index.php/twitter/logout">ログアウト</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
                      
        <div class="col-md-5">
                        
            <div class="text-danger" id="err_msg"></div>         
            <?php
                echo br();
                $attributes = array("class" => "form-horizontal", "id" => "tweet_form");
                echo form_open('twitter/homepage', $attributes);
                ?>
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                <?php
                $data_tweet_input = array(
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => 'tweet',
                    'name' => 'tweet',
                    'placeholder' => '今どうしてる',
                    'rows' => 3,
                    'cols' => 20
                );
                echo form_textarea($data_tweet_input);
                echo "<br>";
                
            ?>

            <div class="col-md-offset-4 col-md-9">
                <?php    
                    $data_btn_tweet = array(
                        'type' => 'submit',
                        'class' => 'btn btn-info',
                        'name' => 'btn-tweet',
                        'id' => 'btn_tweet',
                        'content' => 'ツイート'
                    );
                    echo form_button($data_btn_tweet); 
                ?>
            </div>
            <?php echo form_close(); ?>

            <br></br><br></br>
            
            <div id="new_tweet"></div>

            <div id="tweet_list">
                <?php foreach($tweets as $tweet): ?>
                    <ul class="list-group">
                        <li class="list-group-item active">                                                     
                            <span class="badge">
                                <?php 
                                    $post_time = strtotime($tweet['time']);
                                    
                                    $diff = time() - $post_time;
                                    $day = floor($diff/86400);
                                    $hour = floor($diff/3600);
                                    $min = floor($diff/60);

                                    if ($day > 0) {
                                        echo $day."日前";
                                    } else if ($hour > 0) {                                        
                                        echo $hour."時前";    
                                    } else if ($min > 0) {
                                        echo $min."分前";    
                                    } else {
                                        echo "たった今";
                                    }     
                                ?>
                            </span>
                            <?php echo $tweet['name']; ?>                                                       
                        </li>
                        <li class="list-group-item">
                            <p class="list-group-item-text">
                                <?php echo $tweet['tweet']; ?>
                            </p>
                        </li>
                            
                    </ul>
                
                <?php endforeach; ?>
            </div>
             
            <div class="col-md-offset-4 col-md-9"> 
                <?php 
                    $data_btn_addtweet = array(
                        'type' => 'submit',
                        'class' => 'btn btn-info',
                        'name' => 'btn-addtweet',
                        'id' => 'btn_addtweet',
                        'content' => 'もっと見る'
                    );
                    echo form_button($data_btn_addtweet);
                ?>  
            </div>
        </div>

    </div>

</body>

</html>

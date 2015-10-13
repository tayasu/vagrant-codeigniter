
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Twitter</title>

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <script type="text/javascript">
    	("#btn_tweet").click(function() {
    		alert('clicked');
    	});
    </script>
    
</head>

<body>
    <nav class="navbar navbar-inverse" role="navigation">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Twitter</a>
        </div>
        <div>
            <ul class="nav navbar-nav">
             	<li class="active"><a href="#"><?php echo ($name); ?></a></li>
             	<li class="active>"><a href="#">ログアウト</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <!-- <div class="row"> -->
                      
            <div class="col-md-5">
                            
                <div class="text-danger"><?php echo form_error('tweet'); ?></div>
                <?php
                    $attributes = array("class" => "form-horizontal");
                ?> 
                <?php echo form_open('twitter/homepage', $attributes); ?>
                
                   <div class="form-group">
                        <label for="mail" class="col-md-4">ツイート</label>
                        <textarea class="form-control" id="tweet" name="tweet"></textarea>
                   </div>
                       
                   <div class="form-group">
                      
                         <button type="submit" class="btn btn-default" name="btn-tweet" value = "Tweet" id="btn_tweet">ツイート</button>
                      
                   </div>
                   
                <?php echo form_close(); ?>

                <div id="tweet_list"></div>
                <script type="text/javascript">
                //	<?php echo $btn_tweet; ?>
                </script>

                <?php foreach($tweets as $tweet): ?>
	                <ul class="list-group">
	                	<li class="list-group-item">	      					      						
         					<span class="badge"><?php echo $tweet['time'] ?></span>
	         				<?php echo $tweet['name']; ?>	         						      				
	   					</li>
	                	<li class="list-group-item">
	                		<p class="list-group-item-text">
	         					<?php echo $tweet['tweet']; ?>
	      					</p>
	                	</li>

	                </ul>
            	<?php endforeach; ?>
            	
            	<button type="submit" class="btn btn-default" name="btn-addtweet" value = "AddTweet" id="btn_addtweet">もっと見る</button>
            </div>
        <!-- </div> -->
    </div>
</body>

</html>

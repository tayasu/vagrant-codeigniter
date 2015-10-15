<!-- もっとツイートを表示する（AJAXを呼び出すのため） -->
<?php foreach($tweets as $tweet): ?>
    <ul class="list-group">

    	<li class="list-group-item active">	      					      						
			<span class="badge">
				<?php 
                    //　投稿時間を処理する 
                    $post_time = strtotime($tweet['time']);
                    
                    $diff = time() - $post_time;
                    $day = floor($diff/86400);
                    $hour = floor($diff/3600);
                    $min = floor($diff/60);

                    if($day > 0) {
                        echo $day."日前";
                    } else if($hour > 0) {                                        
                        echo $hour."時前";    
                    } else if($min > 0){
                        echo $min."分前";    
                    } else {
                    	echo "たった今";
                    }
                     
                ?>
            </span>
			<?php echo $tweet['name']; ?>	         						      				
		</li>
		<!-- ツイート -->
    	<li class="list-group-item">
    		<p class="list-group-item-text">
				<?php echo $tweet['tweet']; ?>
			</p>
    	</li>

    </ul>
<?php endforeach; ?>

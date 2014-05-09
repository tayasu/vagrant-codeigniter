<?php $session_data = $this->session->userdata('logged_in');?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Room</title>

<link rel="stylesheet" type="text/css" href="<? echo(base_url());?>css/mystyle.css">

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js">
</script>
<script>
$(document).ready(function(){
	var nl2br = function($varTest){
		return $varTest.replace(/(\r\n|\n\r|\r|\n)/g, "<br/>");
	}
	
	var bs2nbsp = function($varTest){
		return $varTest.replace(/ /g, "&nbsp;");
	}
	
	var appendAtTop = function($time_of_post,$status){
		var username = "<?php echo($session_data['username']);?>";
		var dText="<p class='usernameClass'>" +username+"<h7 class='dateClass'>"+$time_of_post+"</h7></p><p>"+nl2br(bs2nbsp($status))+"</p>";
		var idNum = $("#hiddenID").val();
		statusByInputID.insertAdjacentHTML("afterbegin","<br/><div id="+idNum+" class='statusDisplayClass'></div>");
		$("#"+idNum).html(dText);
		$("#hiddenID").val(idNum + 1);
	};
	
	var appendAtEnd = function($data,$numberOfPosts) {
		var increment = $("#divIDnumber").val();
		for(var k = 0; k < $numberOfPosts; k++){
			var dText="<p class='usernameClass'>" + $data[k].username+"<h7 class='dateClass'>"+$data[k].time_of_post+"</h7></p><p>"+$data[k].posts+"</p>";
			$("#statusByAjaxID").append("<div id=\"statusDisplayID"+increment+ "\" class=\"statusDisplayClass\"></div><br>");
			$("#statusDisplayID" + increment).html(dText);
			increment++;
		}
		$("#divIDnumber").val(increment);
		return true; 
	};

	$("#see_moreID").click(function(){
		$.ajax({
			type: "POST",
			dataType: "text",  
			url: "<?php echo(base_url());?>room/ajaxDisplay/", 
			data: {"postid":$("#lastPostID").val(),"<?php echo($this->security->get_csrf_token_name()); ?>":"<?php echo($this->security->get_csrf_hash());?>"},
      
			success: 
				function (data, status) {
					var arrayOfPostAsJSONObject = JSON.parse(data);			//getting the responseText from the server
					var numberOfPosts = arrayOfPostAsJSONObject.length;    
					if(arrayOfPostAsJSONObject[0].message == "OUT_OF_INDEX"){
						$("#morePostID").hide();
					}else{
						var postid = arrayOfPostAsJSONObject[arrayOfPostAsJSONObject.length - 1].postid; 
						//console.log(arrayOfPostAsJSONObject[1]);
						//console.log(data.length);
						console.log(postid);
						$("#lastPostID").val(postid);
						if(numberOfPosts < <?php echo(LENGTH);?>){                      			//if max view reached pegination link changes 
							$("#morePostID").hide();
						}
						appendAtEnd(arrayOfPostAsJSONObject,numberOfPosts);		//this is defined above to append the posts at the end
					}
				},
			error: 
				function (xhr, desc, err) {
					console.log(xhr);
					console.log("Desc: " + desc + "\nErr:" + err);
				}
		});
    return false;
	});
  
	$("#postID").click(function(){
		$.ajax({
			type: "POST",
			dataType: "text",  
			url: "<?php echo(base_url());?>room/ajaxPost/", 
			data: {"status":nl2br(bs2nbsp($("#textAreaID").val())),"<?php echo($this->security->get_csrf_token_name()); ?>":"<?php echo($this->security->get_csrf_hash());?>"},
        
			success: 
				function (data, status) {
					console.log(data);
					var time_of_post = data;						//getting the responseText from the server	
					if(time_of_post){
					appendAtTop(time_of_post,$("#textAreaID").val());                 //this function is defined above
					$("#NoPostID").hide();
					$("#morePostID").show();
					$("#textAreaID").val(" ");
				}
				else{
					alert("ERROR");
				}
			},
			error: 
				function (xhr, desc, err) {
				console.log(xhr);
				console.log("Desc: " + desc + "\nErr:" + err);
				}
		});
    return false;
	});
	
	$("#textAreaID").focus(function(){
		$("#textAreaID").val(" ");
	});
});

</script>

</head>
<body>
<div id="roomMenuID">
<?php echo($session_data['username']);?>
<a href="<?php echo(base_url());?>room/logout">Logout</a>
</div>

<div id="msgID" style="display:none"></div>

<!----------------------------------------------------THE ROOM BODY--------------------------------------------------------->
<div id="roomBodyID">
<!-----------------------------------------------------STATUS INPUT--------------------------------------------------------->
<br/>
<div id="statusInputID">
<?php 
$this->load->helper('form');
echo form_open('room/post',array('name' => 'statusInputForm')); 
?>
<textarea name="text" id="textAreaID"><?php echo(DEFAULT_STATUS);?></textarea>
<input type="hidden" name="IDnumberHolder" value="1" id="hiddenID"></input>
<?php echo form_close();?>
</div>
<br>
<div id="postButtonID"><a href="#" id="postID">Post</a></div>
<!------------------------------------------------STATUS BY INPUT DISPLAY---------------------------------------------------->
<br/>
<div id="statusByInputID">										
</div>	
<!--------------------------------------------------DEFAULT STATUS DISPLAY---------------------------------------------------->
<?php 
if(isset($message) && $message == "NO_POSTS_YET"){
	echo("<script>
		$(document).ready(function(){
			$(\"#morePostID\").hide();
		});
		</script>");
	echo("<br><div id='NoPostID'>");
	echo("<p>".$message."</p></div>");
}
else{
	$data = json_decode($jsonObject);
	$postid = $data[count($data)-1]->postid;
	for($i = 0; $i < LENGTH; $i++){
		if(isset($data[$i]->username)){
			echo("<br/><div id='statusDisplayID'>");
			echo("<p class='usernameClass'>".$data[$i]->username."<h7 class='dateClass'>".$data[$i]->time_of_post."</h7></p>");
			echo("<p>".$data[$i]->posts."</p>");
			echo("</div>");
		}
	}
}
?>
<!---------------------------------------------------AJAX STATUS DISPLAY------------------------------------------------------->
<br/>
<div id="statusByAjaxID">	
<input type="hidden" name="divIDnumberHolder" id="divIDnumber" value="1"></input>									
</div>	
<!------------------------------------------------------BOTTOM LINKS------------------------------------------------------------>    
<br/>
<div id="morePostID">
<?php echo("<a href='#' id='see_moreID'>see more..</a>");?>
<input type="hidden" name="page" id="lastPostID" value="
<?php 
if(isset($data)){
	echo($postid);
}
?>"></input>
</div>
<br style="clear:both" />
</div>
<!----------------------------------------------------------FOOTER-------------------------------------------------------------->
<div id="footerID">

</div>
</body>
</html>
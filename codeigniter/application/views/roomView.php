<?php $session_data = $this->session->userdata('logged_in');?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Room</title>

<link rel="stylesheet" type="text/css" href="<? echo(base_url());?>css/mystyle.css">

<script language="javascript">
function getXMLObject(){ 
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  return xmlhttp;
}

function appendAtTop(time_of_post,status){
	var username = "<?php echo($session_data['username']);?>";
	var dText="<p class='usernameClass'>" +username+"<h7 class='dateClass'>"+time_of_post+"</h7></p><p>"+status+"</p>";
	var idNum = document.getElementById('hiddenID').value;
	
	statusByInputID.insertAdjacentHTML("afterbegin","<br/><div id="+idNum+" class='statusDisplayClass'></div>");
	
	document.getElementById(idNum).innerHTML = dText;
}

function appendAtEnd(data,numberOfPosts){
	var arrayDiv = new Array();      //to hold div element

	var increment = document.getElementById("divIDnumber").value;
	
	console.log(data);
	for(var k = 0; k < numberOfPosts; k++){
		var dText="<p class='usernameClass'>" + data[k].username+"<h7 class='dateClass'>"+data[k].time_of_post+"</h7></p><p>"+data[k].posts+"</p>";
		var br = document.createElement('br');
		arrayDiv[increment] = document.createElement('div');
		arrayDiv[increment].id = 'statusDisplayID' + increment;
		arrayDiv[increment].className = 'statusDisplayClass';
		statusByAjaxID.appendChild(arrayDiv[increment]);
		statusByAjaxID.appendChild(br);
		document.getElementById("statusDisplayID" + increment).innerHTML = dText;
		increment++;
	}
	document.getElementById("divIDnumber").value = increment;
	return true;
}

function postStatusByAjax(){
	var status = document.getElementById('textAreaID').value;
	
	xmlhttp = getXMLObject();
	
	xmlhttp.open("POST","<?php echo(base_url() . "room/ajaxPost");?>",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("status="+status+"&<?php echo urlencode($this->security->get_csrf_token_name()) ?>=<?php echo urlencode($this->security->get_csrf_hash()) ?>");
	
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			var time_of_post = xmlhttp.responseText;						//getting the responseText from the server	
			if(time_of_post){
				appendAtTop(time_of_post,status);                 //this function is defined above
				document.getElementById("NoPostID").style.display = "none";
			}
			else{
				alert("ERROR");
			}
		}
	}
}

function ajaxPegination(str) {
  if (str=="") {
	document.getElementById("statusDisplayID").innerHTML="";
    return;
  }
  
  xmlhttp = getXMLObject();							//this is defined above for creating an xmlObject
  
  xmlhttp.open("GET","<?php echo(base_url() . "room/ajaxDisplay/");?>"+str,true);
  xmlhttp.send();
  
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		var arrayOfPostAsJSONObject = JSON.parse(xmlhttp.responseText);			//getting the responseText from the server
		var numberOfPosts = arrayOfPostAsJSONObject.length;    
		if(arrayOfPostAsJSONObject[0].message == "OUT_OF_INDEX"){
			document.getElementById("see_moreID").href = "<?php echo(base_url() . "room/");?>";
			document.getElementById("see_moreID").innerHTML = "recent only...";
		}else{
			var page = parseInt(document.getElementById("pageID").value) + 1; 
			document.getElementById("see_moreID").href = "javascript:ajaxPegination(" + page + ")"; //pegination link
			document.getElementById("pageID").value = page;
			if(numberOfPosts < <?php echo(LENGTH);?>){                      			//if max view reached pegination link changes 
				document.getElementById("see_moreID").href = "<?php echo(base_url() . "room/");?>";
				document.getElementById("see_moreID").innerHTML = "recent only...";
			}
			appendAtEnd(arrayOfPostAsJSONObject,numberOfPosts);		//this is defined above to append the posts at the end
		}
		
    }
  }
}

function makeItBlank(){
	document.getElementById('textAreaID').value = "";
}
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
<textarea name="text" id="textAreaID" onfocus="makeItBlank()"><?php echo(DEFAULT_STATUS);?></textarea>
<input type="hidden" name="IDnumberHolder" value="1" id="hiddenID"></input>
<?php echo form_close();?>
</div>
<br>
<div id="postButtonID"><a href="javascript:postStatusByAjax()">Post</a></div>
<!------------------------------------------------STATUS BY INPUT DISPLAY---------------------------------------------------->
<br/>
<div id="statusByInputID">	
									
</div>	
<!--------------------------------------------------DEFAULT STATUS DISPLAY---------------------------------------------------->
<?php 
if(isset($message) && $message == "NO_POSTS_YET"){
	echo("<br><div id='NoPostID' style='display:block'>");
	echo("<p>".$message."</p></div>");
}
else{
	$data = json_decode($jsonObject);
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
<?php echo("<a href='javascript:ajaxPegination(2)' id='see_moreID'>see more..</a>");?>
<input type="hidden" name="page" id="pageID" value="2"></input>
</div>
<br style="clear:both" />
</div>
<!----------------------------------------------------------FOOTER-------------------------------------------------------------->
<div id="footerID">

</div>
</body>
</html>
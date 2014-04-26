<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Room</title>

<link rel="stylesheet" type="text/css" href="<? echo base_url();?>css/mystyle.css">

<script language="javascript">
function getData(rawData){
	var arraySeparated = new Array();
	var data = new Array();
	
	var tableColumn = new Array();
	tableColumn = ["username","posts","time_of_post"];    //only in case if the table contains any other columns
	var numCol = tableColumn.length;
		
	var numberOfPosts = rawData.split("Array").length-2;
	
	for(var i = 0; i <= numberOfPosts + 1; i++){
		arraySeparated[i] = rawData.split("Array")[i].split("=>");
	}
		
	for(var i = 0;i <3; i++){
		data[i] = arraySeparated[1][i + 1].substring(1,arraySeparated[1][i + 1].indexOf("\n"));
	}
	for(var j = 2; j <= numberOfPosts+1; j++){
		for(var k = 1; k <= numCol; k++){
			data[i] = arraySeparated[j][k].substring(1,arraySeparated[j][k].indexOf("\n"));
			i++;
		}
	}
	data[i] = arraySeparated[j-1][k].substring(1,arraySeparated[j-1][k].indexOf("\n"));
	
	//objectification of the data
	var post = new Array();
	
	post[0] = new Array();
	for(var j=0; j < 3;j++){
		post[0][j] = data[j];
	}
	for(var i = 1;i <= numberOfPosts; i++){
		post[i] = new Array();
		for(var k=0; k < numCol; k++){
			post[i][k] = data[j];
			j++;	
		}
	}
	post[i] = new Array();
	post[i][0] = data[j];
	
	return post;
}

function ajaxPegination(str) {
  var data = new Array();
  //if (str=="") {
   // document.getElementById("txtHint").innerHTML="";
    //return;
  //} 
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		var rawData = xmlhttp.responseText;
		var data = getData(rawData);
		document.getElementById("statusByAjaxID").innerHTML=rawData;
		console.log(data);
    }
  }
  xmlhttp.open("GET","<?php echo(base_url() . "room/ajax/");?>"+str,true);
  xmlhttp.send();
}
</script>

</head>
<body>



<div id="roomMenuID">
<?php
echo($di0);
?>
<a href="<?php echo(base_url());?>room/logout">Logout</a>
</div>



<div id="spacerID"></div>



<div id="msgID" style="display:block">
<?php
//echo the message of successful registration, whenever done
if(isset($message)){
	echo($message);
}
?>
</div>



<div id="spacerID"></div>



<div id="roomBodyID">
	<br/>

	<div id="statusInputID"></div>
<br>
<div id="statusByInputID">	</div>	
<?php 
for($i = 3; $i < $di1; $i++){
	echo("<br/><div id='statusDisplayID'>");
	echo("<p class='usernameClass'>".
			${'di'.$i}['username'].
			"<h7 class='dateClass'>".
			${'di'.$i}['time_of_post']
			
			."</h7></p>");
	echo("<p>".${'di'.$i}['posts']."</p>");
	echo("</div>");
}
?>
<br>
<div id="statusByAjaxID">	</div>	
    
    <br/>
    
    <div id="morePostID">
	<?php
	if($message == "NOT_SET"){
		//echo("<a href='" . base_url() . "room/more/" . ($di2 + 1) . "'>see more..</a>");
		echo("<a href='javascript:ajaxPegination(" . ($di2 + 1) . ")'>see more..</a>");
	}
	else{
		echo("<a href='" . base_url() . "room/'>recent only..</a>");
	}
	?>
	
	
	</div>

	<br style="clear:both" />
					
</div>



<div id="instructionID"></div>

</body>
</html>
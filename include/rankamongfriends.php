<?php



session_start();


include('include/fbapi.php');
include("functions.php");
if(!isset($_SESSION['access_token'])) {
     
	 
     $dialog_url = "https://www.facebook.com/dialog/oauth?client_id=" 
       . $app_id . "&redirect_uri=" . urlencode($my_url) . "&scope=user_birthday,email,read_stream,user_education_history,read_friendlists";

     echo("<script> top.location.href='" . $dialog_url . "'</script>");
	 
	 
   }


$con=connect();



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!-- Website Template by freewebsitetemplates.com -->
<html>
<head>
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />

<meta http-equiv="content-type" content="text/html; charset=utf-8" />

<title>Cryptex , Phoenix 2012</title>

<meta name="keywords" content="" />

<meta name="Gestured" content="" />

<style type="text/css">
@font-face
{
font-family: extras;
src: url('fonts/Roboto-Light.woff');
}
#contents
{

	font-family: extras;
	margin-left:20px;
	margin-right: 60px;
	max-height: 600px;
	overflow:scroll;

}
#num{

font-family: arial;

}
td{
text-align:center;


}
</style>
	
	
	<link rel="stylesheet" href="css/style.css" type="text/css">
</head>
<body>
	<div id="background">
		<div id="header">
			<?php

	include("include/header.php");

	?>
		</div><div id="body">
		
		
		
		
		
		
		
		
		
		
		
			
		<div>
		
		
			<div>
			
			<div id="contents" >
			<?php
				include("include/sidemenu.php");
			?>
			<br/>
			<center><font color = "red" size = "180%"> Rank Among Friends</font></center>
			<br/><br/>
			<table cellspacing="2" cellpadding="2" align="center" width="60%" style="font-family: arial ;">



<tr style="text-align:center; ">



<th>Rank</th> 



<th>Name</th>







<th>Level</th>
<th>College</th>



</tr>
<?php
	
	$con = connect();
	$rank = 1;
	$graph_url = "https://graph.facebook.com/me/friends". '?fields=username,name&access_token=' . $_SESSION['access_token'];
	$user = json_decode(file_get_contents($graph_url),true);
	$query = "SELECT fb_id,username,level,college from register where username not in ('Shiva Sah','Dhruv Jagetiya','Ankit Gupta', 'Gaurav Yadav', 'Shuchit Khurana' ,'Manaswini Thakur', 'Kushagra Chandra', 'Aditya Sinha', 'Ra Hihoha')  ORDER BY level  desc , registertime asc";
	$output = mysql_query($query);
	if(isset($_SESSION['username']))
$usernames = $_SESSION['username'];
else{

$usernames = cleandata(extract_username());
$_SESSION['username'] = $usernames;

}
	$name22=$usernames;
	
	while($row = mysql_fetch_array($output)){
	
		
		if($row['fb_id']==$name22)
			echo "<tr style = 'background-color: green; font-weight: bold; font-color:white;'><td><font color = 'white'>".$rank++."</td><td ><font color = 'white'>".$row["username"]."</td><td><font color = 'white'>".$row["level"]."</td><td><font color = 'white'>".$row["college"]."</td></tr>";
		else{
		foreach($user['data'] as $x){
			if(in_array($row['fb_id'],$x)){
					if($row["level"] == 60) continue;
					echo "<tr><td>".$rank++."</td><td>".$row["username"]."</td>";
					//echo "<td><a href = 'https://www.facebook.com/".$row['fb_id']."'><img src = 'https://graph.facebook.com/" .$row['fb_id']."/picture'/></a></td>";
					
					echo "<td>".$row["level"]."</td><td>".$row["college"]."</td></tr>";
			}
			}
				
		}
		
		}
	
	

?>

</table><br/><br/>
			
				</div>
				</div>
		</div>
		</div>
		</div>
		
		<?php include("include/footer.php"); ?>
	</div>
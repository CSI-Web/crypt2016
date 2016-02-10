<?php



// session_start();


// include('include/fbapi.php');
include("functions.php");
// if(!isset($_SESSION['access_token'])) {
     
	 
//      $dialog_url = "https://www.facebook.com/dialog/oauth?client_id=" 
//        . $app_id . "&redirect_uri=" . urlencode($my_url) . "&scope=user_birthday,email,read_stream,user_education_history,read_friendlists";

//      echo("<script> top.location.href='" . $dialog_url . "'</script>");
	 
	 
//    }


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
th{

font-color:red;

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
			<center><font color = "red" size = "180%"> Leaderboard </font></center>
			<br/><br/>
			<p id = 'board'>
			<table cellspacing="2" cellpadding="2" align="center" width="60%" style="font-family: arial ;">



<tr style="text-align:center; font-color:red ">



<th>Rank</th> 



<th>Name</th>








<th>Level</th>
<th>Lifelines-Left</th>
<th>College</th>



</tr>
						<?php

$i=1;

//4th message



$sql_query2="Select fb_id , level, college,username,levelskip,firstlast,lengthans from register where username not in ('Shiva Sah','Dhruv Jagetiya','Ankit Gupta', 'Gaurav Yadav', 'Shuchit Khurana' ,'Manaswini Thakur', 'Kushagra Chandra','Aditya Sinha','Ra Hihoha'  ) order by level  desc , registertime asc";



$r2=mysql_query($sql_query2);



while($row2=mysql_fetch_array($r2))



{
if($row2['level']==60) continue;


?>







<tr>



<td><?php echo $i++.'        '; ?></td>



<td><?php echo $row2['username'].'        '; ?></td>








<td>
<?php 




echo $row2['level'].'        ';

?>
</td>
<td>
<?php 



echo $row2['levelskip']+$row2['firstlast']+$row2['lengthans'].'        ';

?>
</td>
<td>
<?php 



echo $row2['college'].'        ';

?>
</td>
</tr>





<?php

}

?>
</table>
</p><br/><br/>
			
				</div>
				</div>
		</div>
		</div>
		</div>
		
		<?php include("include/footer.php"); ?>
	</div>
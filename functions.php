<?php
session_start();
function connect()

       {

         // $con = mysql_connect("166.62.6.102 ","cryptexmod","CSImod2016");
       		$con = mysql_connect("127.0.0.1 ","root","root");

         if (!$con)

         {

          echo "Error: Could not connect to database. Please try again later.";
          

          exit;

         } 
          
         mysql_select_db("cryptex16",$con);
         

         return $con;

       }


function phonenumber($phone)

{

if (!preg_match("/^[0-9]{8,10}/i", $phone))

				{

					 return false;

				}

				return true;



}

	function get_all_user()

	{

		$con=connect();

		$sql_query="SELECT username FROM register";

		$r=mysql_query($sql_query);

		echo "<select name='user'> "; 

		while($row=mysql_fetch_array($r))

		{

			echo "<option value='".$row[0]."'>".$row[0]."</option>";

		}

		echo "</select>";

	}


function tries($level)
{
$con=connect();

if(isset($_SESSION['username']))
$username = $_SESSION['username'];
else{

$username = cleandata(extract_username());
$_SESSION['username'] = $username;

}

$query2 = "select username from register where fb_id = '".$username."'";
$result2 =mysql_query($query2);
if($row2 = mysql_fetch_array($result2))
	$username = $row2['username'];
	
	$sql_query="SELECT count(*) FROM  activity_log WHERE username='".$username."' and status = 0 and levelplayed = '".$level."'";

	$r=mysql_query($sql_query);

while($row=mysql_fetch_array($r))

{
return $row[0];

}



}
function delete_user($username)

{

	$con=connect();

	$sql_query="SELECT * FROM register where username='".$username."'";

	$r=mysql_query($sql_query);

	if(mysql_num_rows($r)==1)

	{

		$sql_query1="DELETE FROM register where username='".$username."'";

		$sql_query1="DELETE FROM admin where username='".$username."'";

		mysql_query($sql_query1);

		echo "<p>".$username." deleted</p>";

	}

	else

		echo "<p> Username does not exist.</p>";	

}



function insertlog($answer ,$level ,$status)

{


if(isset($_SESSION['username']))
$username = $_SESSION['username'];
else{

$username= cleandata(extract_username());
$_SESSION['username'] = $username;

}
$query2 = "select username from register where fb_id = '".$username."'";
$result2 =mysql_query($query2);
if($row2 = mysql_fetch_array($result2))
	$username = $row2['username'];

$con=connect();
$answer=md5($answer);

$sql_query="INSERT INTO activity_log (sno, username, levelplayed, answer, status, timestamp) VALUES (NULL, '$username', '$level', '$answer', '$status', CURRENT_TIMESTAMP)";

//echo $sql_query;



$r=mysql_query($sql_query);

}



function checkvalidemail($email)

{

if (!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email))

				{

					 return false;

				}

				return true;

}

function checkpassword($pas1,$pas2)

{

if(strlen($pas1)>=6  && $pas1==$pas2)

					{

				//echo "$pas1 and $pas2";

						 return true;

					} 

				//echo " false $pas1 and $pas2";

					return false;

		}

		

			function extract_email(){

$graph_url = "https://graph.facebook.com/me?access_token=" 
       . $_SESSION['access_token'];
		$user = json_decode(file_get_contents($graph_url));
		return $user->email;

}
function extract_id(){

$graph_url = "https://graph.facebook.com/me?access_token=" 
       . $_SESSION['access_token'];
		$user = json_decode(file_get_contents($graph_url));
		return $user->id;

}
function extract_name(){

$graph_url = "https://graph.facebook.com/me?access_token=" 
       . $_SESSION['access_token'];
		$user = json_decode(file_get_contents($graph_url));
		return ($user->first_name . ' '.$user->last_name);

}

function extract_username(){

if(isset($_SESSION['username']) && !empty($_SESSION['username']))
	return cleandata($_SESSION['username']);

$graph_url = "https://graph.facebook.com/me?access_token=" 
       . $_SESSION['access_token'];
		$user = json_decode(file_get_contents($graph_url));
		$_SESSION['username'] = cleandata($user->id);
		return cleandata($user->id);

}


function extract_college(){

$graph_url = "https://graph.facebook.com/me?access_token=" 
       . $_SESSION['access_token'];
	   $college="";
	   $education="";
		$user = json_decode(file_get_contents($graph_url));
		foreach($user->education as $education){
		
			if($education->type == "College")
				break;
		
		}
return $education->school->name;

}

function useravailable($name)

{

//make this function

$con=connect();

$username=$name;

$username=cleandata($username);

	$sql_query="SELECT sno,username FROM register WHERE username='".$username."'";

//echo $sql_query;

	//$password=Secure::encrypt_value($password,$username);

$r=mysql_query($sql_query);

$i=0;

while($row=mysql_fetch_array($r))

{

$i++;

}

if($i!=0 || $username=="")

{

	return false;

}

	else

	return true;



}		

		

		function notempty($field)

		{

		

		if(strlen($field)==0)

		return true;

		return false;

		}

function redirect($location =NULL)

 {

		if ($location != NULL) {

			header("Location: {$location}");

			exit;

		}

	}

function logged_in() {
		
		//return isset($_SESSION['username']);
		$con=connect();
		
		$userid=extract_username();
		$sql_query="SELECT fb_id FROM register where fb_id = '$userid'";

		$r=mysql_query($sql_query);
		
				
		if(mysql_num_rows($r)==1) {
		

			return true;

		}
		else{
		
			return false;
		
		}
		
		
		
		

	}

	

function confirm_logged_in() {

		if (!logged_in()) {

			redirect("NewLOGIN.php");

		}

	}	 

function cleandata($field)

{



$f=trim($field);

$f=stripslashes($f);

$f=mysql_real_escape_string($f);

return $f;

}



function getlevel($username)

{



$con=connect();

$username=cleandata($username);

	$sql_query="SELECT level FROM register WHERE fb_id='".$username."'";

//echo $sql_query;

$r=mysql_query($sql_query);

$level=0;

while($row=mysql_fetch_array($r))

{

$level=$row['level'];

}

return $level;



}



function setlevel($username,$level)

{

$con=connect();

$username=cleandata($username);

$level=cleandata($level);



$sql_query="update register set level =".$level." WHERE username='".$username."'";

//echo $sql_query;

mysql_query($sql_query);



}



function checkans($ans,$level,$username)

{

$con=connect();

$ans=cleandata($ans);

$ans=strtolower($ans);

$ans=md5($ans);

$level=cleandata($level);


if($level == 8){

if($ans == '1a8a261b15afb8e4f0dd253919d8f9fb' || $ans == '4c145b3ecaaa15b1b0fe612d515d6459'){

return true;

}
else 
return false;

}


$sql_query=" select * from levelans where number=$level and answer='$ans'";

//echo $sql_query;

$r=mysql_query($sql_query);

$i=0;

while($row=mysql_fetch_array($r))

{

$i++;

}

if($i==1)


return true;

//echo " cleared and see explanation ";

else

return false;



}



function pagelevel()

{

$con=connect();




$username = extract_username();




$sql_query="select page from levelans , register where levelans.number=register.level and register.fb_id='".$username."'";



$r=mysql_query($sql_query);

$page="notfound.php";

if($row=mysql_fetch_array($r))

{

$page=$row['page'];

}

return $page;



}



function updatelevel($level,$username)

{

$con=connect();

$level=cleandata($level);

$sql_query="update register set level=(select gotolevel from levelans where number=$level) where username='".$username."'";

mysql_query($sql_query);

}



function gotolevelpageofpresentlevel($level)

{

$con=connect();

$level=cleandata($level);

$sql_query="select page from levelans where number=(select gotolevel from levelans where number=$level)";

$page="notfound.php";

$r=mysql_query($sql_query);

while($row=mysql_fetch_array($r))

{

$page=$row['page'];

}

return $page;



}

function getexplanationandupdate($level,$username)

{



$con=connect();
$username=cleandata($username);
$level=cleandata($level);

$sql_query="update register set level=(select gotolevel from levelans where number=$level) , registertime=CURRENT_TIMESTAMP where fb_id='".$username."' ";

//echo $sql_query;

mysql_query($sql_query);





}

function getexplanation($level)

{



$con=connect();

$level=cleandata($level);

$sql_query="select  explanation from levelans where number=$level";

$exp="";

$r=mysql_query($sql_query);

while($row=mysql_fetch_array($r))

{

$exp=$row['explanation'];

}

return $exp;



}





function levelatpage($page)

{

$con=connect();

$page=cleandata($page);

$sql_query="select number from levelans where page='$page'";



$r=mysql_query($sql_query);

while($row=mysql_fetch_array($r))

{

$exp=$row['number'];

}

return $exp;



}

function currentpage() {



 return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);

}

?>
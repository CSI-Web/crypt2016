<?php
	session_start();
	require_once("functions.php");
	if(logged_in())
		header('location:profile.php');
	$uid = $_GET["uid"];
	$accessToken = $_GET["access_token"];
	$path = "https://graph.facebook.com/me?access_token=".$accessToken;
	$ch = curl_init($path);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
	$user_graph = curl_exec($ch);
	curl_close($ch);
	$data_json = json_decode($user_graph, true);
	
	if($data_json['type'] == "OAuthException"){
		// Not valid user or error occurred
		header('location:404.html');
	}
	
	// Password is set to id
	$password = $data_json['id'];
	$mypassword = md5($password);
	$email = $data_json['email'];
		$name = $data_json['username'];
		//."_".$uid;
		if($name == "")
			$name = $data_json['first_name'];
			
		$name = $name."_".substr($uid,strlen($uid)-6,5);
		
	
	$con=connect();
	$sql_query="SELECT * from register where password='".$mypassword."' and username = '".$name."' and email = '".$email."'";
	$result = mysql_query($sql_query);
	
	if($row = mysql_fetch_array($result)){
		// Existing user
		$name = $row['username'];
	}
	else{
		// New user registration
	
		$colgname = $data_json['education'][sizeof($data_json['education'])-1]['school']['name'];
		$colgroll = "";
		
		$sql_query="INSERT INTO register (username,password,colgname,colgroll,email,registertime) VALUES ('".$name."','".$mypassword."','".$colgname."','".$colgroll."','". $email."',CURRENT_TIMESTAMP)";
		mysql_query($sql_query);
	}
	
	// User log in
	$_SESSION['username']=$name;
	$_SESSION['logged_in_via']="Facebook";
	echo "<form action='profile.php' id='foo' method='post'>";
	echo "<input type='hidden' name='username' value='".$name."'>";
	echo "<input type='hidden' name='password' value='".$password."'>";
	echo "<input type='hidden' name='submitfromfb' value='Submit'>";
	echo "</form>";
?>

<script type="text/javascript">
	function myfunc () {
	var frm = document.getElementById("foo");
	frm.submit();
	}
	window.onload = myfunc;
</script>


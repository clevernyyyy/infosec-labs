<?php
	ini_set('display_errors', 'On');
	error_reporting(E_ALL | E_STRICT);

	ob_start();
	$host = "CHANGE_ME";
	$username = "CHANGE_ME";
	$password = "CHANGE_ME";
	$db_name = "CHANGE_ME";
	$tbl_name="members"; // Table name 

	// Connect to server and select databse.
	mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
	mysql_select_db("$db_name")or die("cannot select DB");

	// $myusername and $mypassword from form
	$myusername=$_POST['myusername']; 
	$mypassword=$_POST['mypassword']; 

	// To protect MySQL injection (more detail about MySQL injection)
	// $myusername = stripslashes($myusername);
	$mypassword = hash('md5', $myusername . $mypassword);
	$myusername = mysql_real_escape_string($myusername);
	$mypassword = mysql_real_escape_string($mypassword);
	$sql="SELECT * FROM $tbl_name WHERE username='$myusername' and password='$mypassword'";
	echo $sql;
	$result=mysql_query($sql);

	// Mysql_num_row is counting table row
	$count=mysql_num_rows($result);

	// If result matched $myusername and $mypassword, table row must be 1 row
	if($count==1)
	{
		// Register $myusername, $mypassword and redirect to file "login_success.php"
		session_start();
		$_SESSION["myusername"] = $myusername;
		$_SESSION["mypassword"] = $mypassword;
		header("location:login_success.php");
	}
	else
	{
		echo "Wrong Username or Password";
	        header('Refresh: 2; URL=main_login.php');
	}
	ob_end_flush();
?>


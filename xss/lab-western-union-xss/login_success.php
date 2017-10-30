<?php
        session_start();
?>

<html>
<head><link rel="shortcut icon" href="favicon.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" 
integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" 
crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" 
integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="./style.css">

		<title>
			XSS Lab
		</title>
	</head>	
	<body>
    <nav class="navbar navbar-toggleable-md navbar-light bg-faded">
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" 
aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand" href="http://enveed.com">Enveed.com</a>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <?php 
				$myusername = $_SESSION['myusername'];
            	echo "<a class='nav-link' href='#'>Welcome $myusername </a>"; 
            ?>
          </li>
        </ul>

        <form class="form-inline my-2 my-lg-0" method="post" action="logout.php">
          <button class="btn btn-outline-primary my-2 my-sm-0" type="submit" name="Submit">Logout</button>
        </form>
      </div>
    </nav>
	<div class="container">
<?php
	$myusername = $_SESSION['myusername'];
	
	$host = "CHANGE_ME";
	$username = "CHANGE_ME";
	$password = "CHANGE_ME";
	$db_name = "CHANGE_ME";
	$tbl_name = "messages";

	if(!isset($myusername))
	{
		header("location:main_login.php");
	}
	else
	{
		//The output link with the username so I know who I'm logged in as
		//echo "<div align='right'><a href='logout.php'>log out $myusername</a></div>";

		//Set up the sql connection and get my credit count to display
		mysql_connect("$host", "$username", "$password")or die("cannot connect");
		mysql_select_db("$db_name")or die("cannot select db");
		$sql = "select credits from `members` where username = '$myusername'"; 
		$mycredits = mysql_result(mysql_query($sql), 0, 0);
	}
	
	//The user is sending a message
	if(isset($_POST['submitted']) && $_POST['randcheck']==$_SESSION['rand'])
	{
		$mto = $_POST['user'];
		$message = $_POST['message'];
		$credits = $_POST['credits'];
		
		if($credits > $mycredits)
		{
			echo "You don't have $credits credits to give";
		}
		elseif($credits < 0)
		{
			echo "You can't take credits (at least not like that)";
		}
		elseif($myusername === $mto && $credits > 0)
		{
			echo "You can't send yourself credits";
		}
		else
		{
			//send the message
			//mysql_connect("$host", "$username", "$password")or die("cannot connect");
			//mysql_select_db("$db_name")or die("cannot select db");
			mysql_query("insert into `$tbl_name` (mfrom, mto, message, credits) values('$myusername', '$mto', 
'$message', $credits)");

			//move the credits
			//remove my credits
			$mycredits = $mycredits - $credits;
			mysql_query("update `members` set credits = $mycredits where username = '$myusername'");

			//get the recipients credit count
			$sql = "select credits from `members` where username = '$mto'"; 
			$recipcredits = mysql_result(mysql_query($sql), 0, 0);

			//add recipients credits
			mysql_query("update `members` set credits = " . ($recipcredits + $credits) . " where username = '$mto'");
			
		}
		//header('location:login_success.php');
		echo("<script>location.href = 'login_success.php';</script>");
	}
?>
		<center>
			Login Successful<br />
			Welcome to Secure Quotes Loudly Idiot<br />
		</center>
<?php
	echo "<center><strong>You have $mycredits credits!</strong></center>";
?>

		<table width="300" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
			<tr>
				<form name="send" method="post">
				  <?php
				   $rand=rand();
				   $_SESSION['rand']=$rand;
				  ?>
				 <input type="hidden" value="<?php echo $rand; ?>" name="randcheck" />
								
					<td>
						<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
							<tr>
								<td colspan="3"><strong>Send a Message</strong></td>
							</tr>
							<tr>
								<td width="78">User</td>
								<td width="6">:</td>
								<td width="294"><input name="user" type="text" id="user"></td>
							</tr>
							<tr>
								<td>Message</td>
								<td>:</td>
								<td><input name="message" type="text" id="message"></td>
							</tr>
							<tr>
								<td>Credits</td>
								<td>:</td>
								<td><input name="credits" type="text"  placeholder="0" 
id="credits"></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td><input type="hidden" name="submitted"><input type="submit" 
name="Submit" value="Send"></td>
							</tr>
						</table>
					</td>
				</form>
			</tr>
		</table>
		<br />
		<center><strong>Your messages</strong></center>
		<table width="300" border="0" align="center" cellpadding="0" cellspacing="1">
			<tr>
				<th>From</th>
				<th>Message</th>
				<th>Credits</th>
			</tr>
<?php
	mysql_connect("$host", "$username", "$password")or die("cannot connect");
	mysql_select_db("$db_name")or die("cannot select db");
	$result = mysql_query("select * from `$tbl_name` where mto = '$myusername'");

	while($row = mysql_fetch_array($result))
	{
		echo "\t\t\t<tr align='center'>\n";
		echo "\t\t\t\t<td>" . $row['mfrom'] . "</td>\n";
		echo "\t\t\t\t<td>" . $row['message'] . "</td>\n";
		echo "\t\t\t\t<td>" . $row['credits'] . "</td>\n";
		echo "\t\t\t</tr>\n";
	}
?>
		</table>
		
		</div>
<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" 
integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" 
integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" 
integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
</body>
</html>


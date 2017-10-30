<html>
  <head>
    <link rel="shortcut icon" href="favicon.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" 
integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" 
crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" 
integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="./style.css">

    <title>
      SQLi Lab
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
            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/instructions.html">Instructions</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/hints.html">Hints</a>
          </li>
        </ul>


        <form class="form-inline my-2 my-lg-0" method="post" action="checklogin.php">
          <input class="form-control mr-sm-2" name="myusername" placeholder="Username" type="text" id="myusername">
          <input class="form-control mr-sm-2" name="mypassword" type="password" placeholder="Password" id="mypassword">
          <button class="btn btn-outline-primary my-2 my-sm-0" type="submit" name="Submit">Login</button>
        </form>
      </div>
    </nav>

    <div class="container">
      <div class="jumbotron" style="margin-top:20px;">
        <h1 class="display-3">Welcome to Secure Quotes Loudly Idiot</h1>
        <p class="lead">As our name states this site is secure and coded impeccably!</p>
        <hr class="my-4">
        <p>Send money to friends with Secure Quotes Loudly Idiot (SQLi for short!)</p>
        <p class="lead">
          <form name='send' method='post' action='' style="display: inline-block;">
            <a class="btn btn-primary btn-lg" href="/instructions.html" role="button">Learn more</a>
          </form>
          <form name='send' method='post' action='' style="display: inline-block; margin-left: 35px">
            <input type='hidden' name='reset' value='1'><button class='btn btn-danger btn-lg' type='submit' name='Submit'>Reset the 
box, I've done a bad, bad thing</button>
          </form>
        </p>
      </div>
</div>

<?php
  echo "<form name='send' method='post' action=''>";
  echo "<br /><center></center>";
  echo "</form>";

        if(isset($_POST['reset']))
  {
	$host = "CHANGE_ME";
	$username = "CHANGE_ME";
	$password = "CHANGE_ME";
	$db_name = "CHANGE_ME";

    mysql_connect("$host", "$username", "$password")or die("cannot connect - mainlogin.php");
    mysql_select_db("$db_name")or die("cannot select db - mainlogin.php");

    //Drop both tables
    mysql_query("DROP TABLE IF EXISTS `members`");
    mysql_query("DROP TABLE IF EXISTS `messages`");

    //Recreate the members table
    mysql_query("CREATE TABLE IF NOT EXISTS `members` (
        `id` int(4) NOT NULL AUTO_INCREMENT,
        `username` varchar(65) NOT NULL,
        `password` varchar(65) NOT NULL,
        `credits` int(10) NOT NULL,
        PRIMARY KEY (`id`),
        UNIQUE KEY `username` (`username`)
      ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;");

    //Recreate the messages table
    mysql_query("CREATE TABLE IF NOT EXISTS `messages` (
        `id` int(4) NOT NULL AUTO_INCREMENT,
        `mfrom` varchar(15) NOT NULL,
        `mto` varchar(15) NOT NULL,
        `message` varchar(255) NOT NULL,
        `credits` int(4) NOT NULL,
        PRIMARY KEY (`id`)
      ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=333 ;");

    //Recreate the members users
    mysql_query("INSERT INTO `members` (`id`, `username`, `password`, `credits`) VALUES
      (1, 'megarich', '8895a633388d240d1f9dda7e703dad06', 1000000),
      (2, 'pooruser', 'f1c8054358200b7674d9b5f31b69eb0f', 20);");
  }
?>
<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" 
integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" 
integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" 
integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
</body>
</html>

<?php
	session_start();
	session_destroy();
	header('Refresh: 1; URL=main_login.php');
?>



<html>
        <head>
                <link rel="shortcut icon" href="favicon.png">
        </head>

	<div>You have been logged out, redirecting to login page...</div>
</html>


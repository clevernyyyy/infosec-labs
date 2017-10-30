<?php
if (isset($_GET['src']))
    highlight_file(__FILE__) and die();
if (isset($_GET['md5']))
{
    $md5=$_GET['md5'];
    if ($md5==md5($md5))
        echo "Wonderbubulous! Flag is [here goes a flag]"; //.require __DIR__."/flag.php";
    else
        echo "Nah... '",htmlspecialchars($md5),"' not the same as ",md5($md5);
}


?>
<h1>Welcome to Cryptographers Anonymous</h1>
<h4>For access to our hallowed halls, you must solve the following riddle:</h4>
<p>Find a string that has a MD5 digest equal to itself!</p>
<form>
    <label>Answer: </label>
    <input type='text' name='md5' />
    <input type='submit' />
</form>

<a href='?src'>Source Code</a> <br/>

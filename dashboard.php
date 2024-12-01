<?php
session_start();
//check for required fields from the form
if ((!filter_input(INPUT_POST, 'username'))
        || (!filter_input(INPUT_POST, 'password'))) {

	header("Location: login.php");
	exit;
}

//connect to server and select database


//For more info about mysqli functions, go to the site below:
//http://www.w3schools.com/php/php_ref_mysqli.asp

/* create and issue the query
$sql = "SELECT f_name, l_name FROM auth_users WHERE username = '".$_POST["username"].
        "' AND password = SHA1('".$_POST["password"]."')";
*/

//create and issue the query
$targetname = filter_input(INPUT_POST, 'username');
$targetpasswd = filter_input(INPUT_POST, 'password');
$sql = "SELECT f_name, l_name FROM auth_users WHERE username = '".$targetname.
        "' AND password = SHA1('".$targetpasswd."')";


$result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));

//get the number of rows in the result set; should be 1 if a match
if (mysqli_num_rows($result) == 1) {

	//if authorized, get the values of f_name l_name
	while ($info = mysqli_fetch_array($result)) {
		$f_name = stripslashes($info['f_name']);
		$l_name = stripslashes($info['l_name']);
	}

	
	//set authorization cookie using curent Session ID
	setcookie("auth", session_id(), time()+60*30, "/", "", 0);
        
        
	//create display string
	$display_block = "
        <body style='background-color:bisque'>
	<p>".$f_name." ".$l_name." is authorized!</p>
	<p>Authorized Users' Menu:</p>
        </body>";
} else {
	//redirect back to login form if not authorized
	header("Location: login.php");
	exit;
}
?>
<html>
<head>
<title>User Login</title>
</head>
<body>
<?php echo "$display_block"; ?>
</body>
</html>




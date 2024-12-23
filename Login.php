<!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>User Login Form</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="./stylesheet.css">
</head>
<body class="bg-body-tertiary">  

<?php

session_start();
$credentialsErr = !empty($credentialsErr) ? $credentialsErr : "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $password = $name = "";

    //this should never go to prod in real scenario and can be done in a better and more secure way.    $mysqli = mysqli_connect("localhost", "cs213user", "letmein", "dentalDB");
        $mysqli = mysqli_connect("localhost", "cs213user", "letmein", "dentalDB");
    $targetname = filter_input(INPUT_POST, 'username');
    $targetpasswd = filter_input(INPUT_POST, 'password');
    $sql = "SELECT f_name, username, password FROM auth_users WHERE username = '".$targetname.
        "' AND password = SHA1('".$targetpasswd."')";

    $result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));


    if (mysqli_num_rows($result) == 1) {
        
       while ($info = mysqli_fetch_array($result)) {
		$username = stripslashes($info['username']);
                $name = stripslashes($info['f_name']);
	}
        
        $_SESSION['username'] = $username;
        $_SESSION['f_name'] = $name;
        
        setcookie("auth", session_id(), time()+60*30, "/", "", 0);
        
        header("Location: Dashboard.php");

        exit();
    } else {
        $credentialsErr = "<span class='error' >Invalid username or password</span>";
    }
    
    
}



    
    


?>
        <div class="container-fluid vh-100 d-flex">
            <div class="row w-100 align-items-center">
                <div class="col-6 p-0 video-container">
                    <video class="video object-fit-cover" width= "900" height="780" autoplay muted loop>
                            <source src="./images/login-video.mp4" type="video/mp4">
                    </video>
                </div>
                <div class="col-6 col-xs-12 justify-content-center">
                    <div class="row">
                    <nav class="navbar">
                        <div class="container-fluid">
                            <a class="navbar-brand fs-6" href="Login.php">
                                <img src="./images/dental_logo.png" alt="Logo" width="55" height="55" class="align-text-middle">
                                DentalHash
                            </a>
                        </div>
                    </nav>
                    </div>
                    <div class="row d-flex" id="login-row">
                    <div class="login-container">                     
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <h3> Login </h3>
                        <br>
                            <label for="validationCustomUsername" class="form-label username-label">Username</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text" id="inputGroupPrepend">@</span>
                                <input type="text" name="username" pattern="^[A-Za-z\s]{1,15}$" class="form-control <?php echo !empty($credentialErr) ? 'is-invalid' : ''; ?>" id="validationCustomUsername" aria-describedby="inputGroupPrepend" required>
                         </div>
                        <div class="mb-3">
                            <label for="password-label" class="form-label">Password</label>
                            <input type="password" name="password" pattern="^[a-z]{3,15}$" class="form-control <?php echo !empty($credentialErr) ? 'is-invalid' : ''; ?>" id="password-login-field" required>
                            <?php echo $credentialsErr; ?>
                        </div>
                        <button type="submit" name="submit" value="login" class="btn btn-primary">Submit</button>
                        <a href="Password.php" class=btn btn-danger">Forgot Password?</a>
                    </form>
                        
                    </div>
                </div>
            </div>
            </div>
        </div>
         <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>          
</body>
</html>


<?php
session_start();
//check for required fields from the form
if ((!filter_input(INPUT_POST, 'username'))
        || (!filter_input(INPUT_POST, 'password'))) {

	header("Location: login.php");
	exit;
}

//connect to server and select database
$mysqli = mysqli_connect("localhost", "cs213user", "letmein", "dentalDB");

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
        
        //Get number of appointments 
        $get_number_app = "SELECT COUNT(*) AS Total FROM L4_Appointments WHERE app_date = '2024-11-04'";
        
        $number_app_sql = mysqli_query($mysqli, $get_number_app) or die(mysqli_error($mysqli));
        
        if (mysqli_num_rows($number_app_sql) > 0) {
            	while ($info = mysqli_fetch_array($number_app_sql)) {
                        $num_app = stripslashes($info['Total']);
                }
        }
        
        //Get number of procedures
        $get_number_proc_sql = "SELECT COUNT(*) AS Total_Pros FROM L4_App_Pros ap, L4_Appointments a WHERE ap.app_id = a.id and app_date = '2024-11-04'";
        $get_number_proc_query = mysqli_query($mysqli, $get_number_proc_sql) or die(mysqli_error($mysqli));
        
        if (mysqli_num_rows($get_number_proc_query) > 0) {
            	while ($info = mysqli_fetch_array($get_number_proc_query)) {
                        $get_number_proc = stripslashes($info['Total_Pros']);
                }
        }
        
        //Get today's appointments
        $get_proc_sql = "SELECT a.id AS id, CONCAT(p.fname, ' ', p.lname) AS patient_name, d.name AS dentist_name, roomNo"
        . " FROM L4_Appointments a, L4_Dentists d, L4_Patients p WHERE a.pat_id = p.id and a.den_id = d.id and app_date = '2024-11-04'";
        
        $get_proc_query = mysqli_query($mysqli, $get_proc_sql) or die(mysqli_error($mysqli));


        $row = '';
        //get the number of rows in the result set; should be 1 if a match
        if (mysqli_num_rows($get_proc_query) > 0) {

	//if authorized, get the values of the columns
	while ($info = mysqli_fetch_array($get_proc_query)) {
		$row .= '<tr>' .'<td>'.$info['id'].'</td>'.
                        '<td>'.$info['patient_name'].'</td>'.
                        '<td>'.$info['dentist_name'].'</td>'.
                        '<td>'.$info['roomNo'].'</td></tr>';
	}
        }
        
} else {
	//redirect back to login form if not authorized
	header("Location: login.php");
	exit;
}
?>
<html>
<head>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Dashboard</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="./stylesheet.css">
    </head>
<body class="bg-body-tertiary">
    <nav class="navbar navbar-expand-lg bg-white">
  <div class="container-fluid">
    <a class="navbar-dental" href="#">Dental#</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-link active" aria-current="page" href="#">Dashboard</a>
        <a class="nav-link" href="patients.php">Patients</a>
        <a class="nav-link" href="appoinments.php">Appointments</a>
      </div>
    </div>
  </div>
</nav>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-xs-12" id="app-summary">
                <h5 class="mt-4">Good afternoon, <?php echo "$f_name"; ?>!</h5>
                <h6 class="text-secondary"><?php echo date('l, F j, Y'); ?> </h6>
            </div>
            
        </div>
  <div class="row">
    <div class="col-lg-6 col-xs-12 rounded shadow-sm p-3 mt-5 mb-5 bg-white" id="app-summary">
        <h5 class="mb-4">Today's Summary</h5>
        <div class="row text-center">
            <div class="row">
            <div class="col-lg-6 col-sm-6" id="app-in-container">
                <h5 class="text-secondary">Appointments</h5>
            </div>
                <div class="col-lg-6 col-sm-6" id="app-in-container">
                <h5 class="text-secondary">Procedures</h5>
            </div>
            </div>
            <div class="row">
            <div class="col-lg-6 col-sm-6" id="app-in-container">
                <h6><?php echo "$num_app"; ?></h6>
            </div>
               <div class="col-lg-6 col-sm-6"  id="app-in-container">
                <h6><?php echo "$get_number_proc"; ?></h6>
            </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-xs-12">

    </div>
  </div>
  <div class="row">

    <div class="col-12 rounded shadow-sm p-3 mt-5 mb-5 bg-white">
        <div class="col-lg-6 col-sm-6 mb-2" id="app-list-title">
            <h6 class="font-weight-bold">Today's Appointments List</h6>
        </div>
      <table class="table table-light table-striped table-hover">
  <thead>
    <tr>
      <th scope="col" class="text-secondary">Appointment Id</th>
      <th scope="col" class="text-secondary">Patient Name</th>
      <th scope="col" class="text-secondary">Dentist Name</th>
      <th scope="col" class="text-secondary">Room Number</th>
    </tr>
  </thead>
  <tbody>
      <?php echo "$row"; ?>
      
  </tbody>
</table>
    </div>
  </div>
    </div>

</body>
</html>




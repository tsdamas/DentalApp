<?php
session_start();
$mysqli = mysqli_connect("localhost", "cs213user", "letmein", "dentalDB");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstName = filter_input(INPUT_POST, 'first-name', FILTER_SANITIZE_STRING);
    $lastName = filter_input(INPUT_POST, 'last-name', FILTER_SANITIZE_STRING);
    $appointmentDate = filter_input(INPUT_POST, 'appointment-date', FILTER_SANITIZE_STRING);
    echo $appointmentDate;
    // Find patient ID using first and last name
    $findPatientQuery = "SELECT ID FROM L4_Patients WHERE fname = '$firstName' AND lname = '$lastName'";
    
    $result = mysqli_query($mysqli, $findPatientQuery) or die(mysqli_error($mysqli));
    
    if (mysqli_num_rows($result) > 0) {
        $patient = $result->fetch_assoc();
        $patientID = $patient['ID'];
        echo $patientID;
        // Delete appointment using patient ID and appointment date
        $deleteAppointmentQuery = "DELETE FROM L4_Appointments WHERE Pat_ID = $patientID AND app_date = '$appointmentDate'";
        
        
        if (mysqli_query($mysqli, $deleteAppointmentQuery)) {
            echo "<script>
                    alert('Appointment successfully removed!');
                    window.location.href = 'ManageAppts.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Failed to remove appointment.');
                    window.location.href = 'RemoveAppt.php';
                  </script>";
        }
    } else {
        echo "<script>
                alert('No patient found with the given name.');
                window.location.href = 'RemoveAppt.php';
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Remove Appointment</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="bg-light">
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand fs-6" href="Dashboard.php">
                    <img src="./images/dental_logo.png" alt="Logo" width="55" height="55" class="align-text-middle">
                    DentalHash
                </a>
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item"><a class="nav-link" id="dashboard-link" href="#">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" id="patients-link" href="#">Patients</a></li>
                        <li class="nav-item"><a class="nav-link" id="appointments-link" href="#">Appointments</a></li>
                        <li class="nav-item"><a class="nav-link" id="logout-link" href="#">Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-lg-8 bg-white p-5 shadow-sm rounded">
                    <h3 class="text-center mb-4">Remove Appointment</h3>
                    <form method="POST" action="">
                        <div class="row mb-3">
                            <div class="col">
                                <label for="first-name" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="first-name" name="first-name"
                                       placeholder="First Name" maxlength="25" pattern="[A-Za-z]+" title="Please enter letters only." required>
                            </div>
                            <div class="col">
                                <label for="last-name" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="last-name" name="last-name"
                                       placeholder="Last Name" maxlength="30" pattern="[A-Za-z]+" title="Please enter letters only." required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="appointment-date" class="form-label">Appointment Date</label>
                            <input type="date" class="form-control" id="appointment-date" name="appointment-date" required>
                        </div>
                        <button type="submit" class="btn btn-danger w-100">Remove Appointment</button>
                    </form>
                </div>
            </div>
        </div>
        <script>
            document.getElementById('dashboard-link').onclick = function () {
                window.location.href = 'Dashboard.php';
            };
            document.getElementById('patients-link').onclick = function () {
                window.location.href = 'Patients.php';
            };
            document.getElementById('appointments-link').onclick = function () {
                window.location.href = 'ManageAppts.php';
            };
            document.getElementById('logout-link').onclick = function () {
                window.location.href = 'Login.php';
            };
        </script>
    </body>
</html>
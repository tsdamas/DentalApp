<?php
session_start();
$mysqli = mysqli_connect("localhost", "cs213user", "letmein", "dentalDB");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = filter_input(INPUT_POST, 'first-name', FILTER_SANITIZE_STRING);
    $lastName = filter_input(INPUT_POST, 'last-name', FILTER_SANITIZE_STRING);
    $phone = filter_input(INPUT_POST, 'phone-number', FILTER_SANITIZE_STRING);
    
    $streetNumber = filter_input(INPUT_POST, 'street-number', FILTER_SANITIZE_STRING);
    $streetName = filter_input(INPUT_POST, 'street-name', FILTER_SANITIZE_STRING);
    $postalCode = filter_input(INPUT_POST, 'postal-code', FILTER_SANITIZE_STRING);
    $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
    $country = filter_input(INPUT_POST, 'country', FILTER_SANITIZE_STRING);
    
    $rowCountQuery = "SELECT MAX(ID) AS max_id FROM L4_Patients";
    $resultRow = mysqli_query($mysqli, $rowCountQuery) or die(mysqli_error($mysqli));
    $rowCountData = mysqli_fetch_assoc($resultRow);
    $patientID = $rowCountData['max_id'] + 1;

    // Combine address
    $address = $streetNumber . " " . $streetName . ", " . $city;
    
    // Insert new patient
    $insertPatientQuery = "INSERT INTO L4_Patients (ID, fname, lname, address, phone, Ins_ID) VALUES ($patientID, '$firstName', '$lastName', '$address', '$phone', 2)";
    
    

    if (mysqli_query($mysqli, $insertPatientQuery)) {
        echo "<script>
                alert('Patient successfully added!');
                window.location.href = 'Patients.php';
              </script>";
    } else {
        echo 'Failure';
        echo "<script>
                alert('Failed to add patient: " . mysqli_error($mysqli) . "');
                window.location.href = 'AddPatient.php';
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Add Patient</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="bg-light">
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
            <div class="container">
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
                    <h3 class="text-center mb-4">Add Patient</h3>
                    <form method="POST" action="">
                        <div class="row mb-3">
                            <div class="col">
                                <label for="first-name" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="first-name" name="first-name" pattern="[A-Za-z]+" title="Please enter letters only." placeholder="First Name" maxlength="25" required>
                            </div>
                            <div class="col">
                                <label for="last-name" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="last-name" name="last-name" pattern="[A-Za-z]+" title="Please enter letters only." placeholder="Last Name" maxlength="30" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="dob" class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" id="dob" name="dob" required>
                        </div>
                        <div class="mb-3">
                            <label for="health-number" class="form-label">Health Number</label>
                            <input type="text" class="form-control" id="health-number" name="health-number" placeholder="123-456-789" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone-number" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="phone-number" name="phone-number" placeholder="(123)-456-7890" maxlength="15" required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <div class="row">
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="Street Number" id="street-number" name="street-number" maxlength="6" required>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="Street Name" id="street-name" name="street-name" maxlength="20" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <input type="text" class="form-control" placeholder="City" id="city" name="city" pattern="[A-Za-z]+" required>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Postal Code" id="postal-code" name="postal-code" required>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Country" id="country" name="country" pattern="[A-Za-z]+" maxlength="14" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Add Patient</button>
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

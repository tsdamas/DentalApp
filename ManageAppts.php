<?php
session_start();
$mysqli = mysqli_connect("localhost", "cs213user", "letmein", "dentalDB");
$query = "
    SELECT
        a.Pat_ID AS PatientID,
        p.fname AS FirstName,
        p.lname AS LastName,
        a.app_date AS AppointmentDate
    FROM
        L4_Appointments a
    JOIN
        L4_Patients p
    ON
        a.Pat_ID = p.ID
    ORDER BY
        a.app_date ASC
";
$result = mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Manage Appointments</title>
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
        	<h3 class="text-center mb-4">Appointments</h3>
            <div class="d-flex justify-content-between mb-3">
                <button onclick="window.location.href='Appointment.php'" class="btn btn-primary">Create Appointment</button>
                <button onclick="window.location.href='RemoveAppt.php'" class="btn btn-danger">Remove Appointment</button>
            </div>
            <div class="card shadow-sm">
                <div class="card-body">
                    
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Patient ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Appointment Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['PatientID']); ?></td>
                                    <td><?php echo htmlspecialchars($row['FirstName']); ?></td>
                                    <td><?php echo htmlspecialchars($row['LastName']); ?></td>
                                    <td><?php echo htmlspecialchars($row['AppointmentDate']); ?></td>
                                    <td>
                                        <?php
                                        $appointmentDate = strtotime($row['AppointmentDate']);
                                        $currentDate = strtotime('now');
                                        $dateDiff = ($appointmentDate - $currentDate) / (60 * 60 * 24);
                                        // If appointment is within 30 days, show the button
                                        if ($dateDiff >= 0 && $dateDiff <= 30) {
                                            echo '<button class="btn btn-primary" onclick="sendReminder()">Send Reminder</button>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
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
            function sendReminder() {
                alert("Appointment Reminder has been sent out.");
            } 
        </script>
    </body>
</html>
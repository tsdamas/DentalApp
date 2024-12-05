<?php
session_start();
$mysqli = mysqli_connect("localhost", "cs213user", "letmein", "dentalDB");
if (!$mysqli) {
    die("Connection failed: " . mysqli_connect_error());
}
$patient_id = isset($_GET['patient_id']) ? (int) $_GET['patient_id'] : 0;
$query = "SELECT ID, fname, lname, address, phone, ins_ID FROM L4_Patients WHERE ID = $patient_id";
$result = mysqli_query($mysqli, $query) or die("Query failed: " . mysqli_error($mysqli));
$patient = mysqli_fetch_assoc($result);
if (!$patient) {
    die("Patient not found.");
}
$total_cost_query = "
    SELECT SUM(p.price) AS total_cost
    FROM L4_Appointments a
    LEFT JOIN L4_App_Pros ap ON a.ID = ap.App_ID
    LEFT JOIN L4_Procedures p ON ap.Pro_ID = p.ID
    WHERE a.Pat_ID = $patient_id
";
$total_cost_result = mysqli_query($mysqli, $total_cost_query);

if (!$total_cost_result) {
    die("Error fetching total cost: " . mysqli_error($mysqli));
}

$total_cost_row = mysqli_fetch_assoc($total_cost_result);
$total_cost = $total_cost_row['total_cost'];

$appointments_query = "
    SELECT a.app_date, p.description, p.price 
    FROM L4_Appointments a
    LEFT JOIN L4_App_Pros ap ON a.ID = ap.App_ID
    LEFT JOIN L4_Procedures p ON ap.Pro_ID = p.ID
    WHERE a.Pat_ID = $patient_id
    ORDER BY a.app_date ASC
";

$result2 = mysqli_query($mysqli, $appointments_query);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Patient Profile</title>
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
                        <li class="nav-item"><a class="nav-link" href="Dashboard.php">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="patients.php">Patients</a></li>
                        <li class="nav-item"><a class="nav-link" href="ManageAppts.php">Appointments</a></li>
                        <li class="nav-item"><a class="nav-link" href="login.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container mt-5">
            <h3 class="text-center mb-4">Patient Profile</h3>

            <div class="row mb-4">
                <div class="col-md-6">
                    <h5>Personal Information</h5>
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>First Name:</th>
                                <td><?php echo htmlspecialchars($patient['fname']); ?></td>
                            </tr>
                            <tr>
                                <th>Last Name:</th>
                                <td><?php echo htmlspecialchars($patient['lname']); ?></td>
                            </tr>
                            <tr>
                                <th>Address:</th>
                                <td><?php echo htmlspecialchars($patient['address']); ?></td>
                            </tr>
                            <tr>
                                <th>Patient ID:</th>
                                <td><?php echo htmlspecialchars($patient['ID']); ?></td>
                            </tr>
                            <tr>
                                <th>Phone Number:</th>
                                <td><?php echo htmlspecialchars($patient['phone']); ?></td>
                            </tr>
                            <tr>
                                <th>Insurance ID:</th>
                                <td><?php echo htmlspecialchars($patient['ins_ID']); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5>Appointments</h5>
                    <div class="table-responsive" style="max-height: 400px; overflow-y: scroll;">

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Appointment Date</th>
                                    <th>Procedure</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($result2)): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['app_date']); ?></td>
                                        <td><?php echo htmlspecialchars($row['description']); ?></td>
                                        <td><?php echo htmlspecialchars($row['price']); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                    <p><strong>Total Cost for Procedures: </strong> $<?php echo number_format($total_cost, 2); ?></p>
                </div>
            </div>
        </div>
    </body>
</html>


<?php
session_start();
if (empty($_SESSION['username'])) {
    
    header("Location: Login.php");
    exit;
}


// Database connection
$mysqli = mysqli_connect("localhost", "cs213user", "letmein", "dentalDB");
if (!$mysqli) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch patients from the database, sorted by ID
$query = "SELECT ID, fname, lname, address, phone, ins_ID FROM L4_Patients ORDER BY ID";
$result = mysqli_query($mysqli, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($mysqli));
}

// Count total patients
$totalPatients = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patients</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f9f9f9;
        }
    </style>
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
                    <li class="nav-item"><a class="nav-link" href="Dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="Patients.php">Patients</a></li>
                    <li class="nav-item"><a class="nav-link" href="ManageAppts.php">Appointments</a></li>
                    <li class="nav-item"><a class="nav-link" href="Login.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h3 class="text-center mb-4">Patients</h3>
        <div class="d-flex justify-content-between mb-3">
        <a href="AddPatient.php" class="btn btn-primary">Add Patient</a>
        <a href="RemovePatient.php" class="btn btn-danger">Remove Patient</a>
    </div>
        <div class="table-responsive">
            <table class="table table-light table-striped table-hover">
                <thead>
                    <tr>
                        <th colspan="6" class="text-end">Total Patients: <?php echo $totalPatients; ?></th>
                    </tr>
                    <tr>
                        <th>Patient ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Address</th>
                        <th>Phone Number</th>
                        <th>Insurance ID</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><a href="PatientProfile.php?patient_id=<?php echo $row['ID']; ?>"><?php echo htmlspecialchars($row['ID']); ?></a></td>
                            <td><?php echo htmlspecialchars($row['fname']); ?></td>
                            <td><?php echo htmlspecialchars($row['lname']); ?></td>
                            <td><?php echo htmlspecialchars($row['address']); ?></td>
                            <td><?php echo htmlspecialchars($row['phone']); ?></td>
                            <td><?php echo htmlspecialchars($row['ins_ID']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
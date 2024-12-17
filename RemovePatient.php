<?php
session_start();
if (empty($_SESSION['username'])) {

    header("Location: Login.php");
    exit();
}

$mysqli = mysqli_connect("localhost", "cs213user", "letmein", "dentalDB");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patientID = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $firstName = filter_input(INPUT_POST, 'first-name', FILTER_SANITIZE_STRING);
    $lastName = filter_input(INPUT_POST, 'last-name', FILTER_SANITIZE_STRING);

    $deleteQuery = "DELETE FROM L4_Patients WHERE ID = $patientID AND fname = '$firstName' AND lname = '$lastName'";

    if (mysqli_query($mysqli, $deleteQuery)) {
        if (mysqli_affected_rows($mysqli) > 0) {
            echo "<script>
                    alert('Patient successfully removed!');
                    window.location.href = 'Patients.php';
                  </script>";
        } else {
            echo "<script>
                    alert('No matching patient found.');
                    window.location.href = 'RemovePatient.php';
                  </script>";
        }
    } else {
        echo "<script>
                    alert('Failed to remove patient: " . mysqli_error($mysqli) . "');
                    window.location.href = 'RemovePatient.php';
                  </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Remove Patient</title>
<link
	href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
	rel="stylesheet">
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
		<div class="container-fluid">
			<a class="navbar-brand fs-6" href="Dashboard.php"> <img
				src="./images/dental_logo.png" alt="Logo" width="55" height="55"
				class="align-text-middle"> DentalHash
			</a>
			<div class="collapse navbar-collapse">
				<ul class="navbar-nav ml-auto">
					<li class="nav-item"><a class="nav-link" id="dashboard-link"
						href="#">Dashboard</a></li>
					<li class="nav-item"><a class="nav-link" id="patients-link"
						href="#">Patients</a></li>
					<li class="nav-item"><a class="nav-link" id="appointments-link"
						href="#">Appointments</a></li>
					<li class="nav-item"><a class="nav-link" id="logout-link" href="#">Logout</a></li>
				</ul>
			</div>
		</div>
	</nav>
	<div class="container mt-5">
		<div class="row justify-content-center">
			<div class="col-lg-8 bg-white p-5 shadow-sm rounded">
				<h3 class="text-center mb-4">Remove Patient</h3>
				<form method="POST" action="">
					<div class="row mb-3">
						<div class="col">
							<label for="id" class="form-label">Patient ID</label> <input
								type="text" class="form-control" id="id" name="id"
								placeholder="Patient ID" pattern="[\d\-]+" maxlength="4"
								required>
						</div>
						<div class="col">
							<label for="first-name" class="form-label">First Name</label> <input
								type="text" class="form-control" id="first-name"
								name="first-name" placeholder="First Name" pattern="[A-Za-z]+"
								title="Please enter letters only." maxlength="25" required>
						</div>
						<div class="col">
							<label for="last-name" class="form-label">Last Name</label> <input
								type="text" class="form-control" id="last-name" name="last-name"
								placeholder="Last Name" pattern="[A-Za-z]+"
								title="Please enter letters only." maxlength="30" required>
						</div>
					</div>
					<button type="submit" class="btn btn-danger w-100">Remove Patient</button>
				</form>
			</div>
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="Banner.js"></script>
</body>
</html>

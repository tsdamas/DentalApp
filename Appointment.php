<?php
session_start();
if (empty($_SESSION['username'])) {

    header("Location: Login.php");
    exit();
}

$mysqli = mysqli_connect("localhost", "cs213user", "letmein", "dentalDB");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $firstName = filter_input(INPUT_POST, 'first-name', FILTER_SANITIZE_STRING);
    $lastName = filter_input(INPUT_POST, 'last-name', FILTER_SANITIZE_STRING);
    $dob = filter_input(INPUT_POST, 'dob', FILTER_SANITIZE_STRING);
    $healthNumber = filter_input(INPUT_POST, 'health-number', FILTER_SANITIZE_STRING);
    $phoneNumber = filter_input(INPUT_POST, 'phone-number', FILTER_SANITIZE_STRING);
    $streetNumber = filter_input(INPUT_POST, 'street-number', FILTER_SANITIZE_STRING);
    $streetName = filter_input(INPUT_POST, 'street-name', FILTER_SANITIZE_STRING);
    $postalCode = filter_input(INPUT_POST, 'postal-code', FILTER_SANITIZE_STRING);
    $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
    $country = filter_input(INPUT_POST, 'country', FILTER_SANITIZE_STRING);
    $appointmentDate = filter_input(INPUT_POST, 'appointment-date', FILTER_SANITIZE_STRING);

    $rowCountQuery = "SELECT MAX(ID) AS max_id FROM L4_Patients";
    $resultRow = mysqli_query($mysqli, $rowCountQuery) or die(mysqli_error($mysqli));
    $rowCountData = mysqli_fetch_assoc($resultRow);
    $patientID = $rowCountData['max_id'] + 1;

    // Combine address
    $address = $streetNumber . " " . $streetName . ", " . $city;
    // Insert new patient
    $insertPatientQuery = "INSERT INTO L4_Patients (ID, fname, lname, address, phone, Ins_ID) VALUES ($patientID, '$firstName', '$lastName', '$address', '$phoneNumber', 2)";

    mysqli_query($mysqli, $insertPatientQuery) or die(mysqli_error($mysqli));

    // Find an available dentist
    $findDentistQuery = "SELECT ID FROM L4_Dentists ORDER BY RAND() LIMIT 1";
    $result = mysqli_query($mysqli, $findDentistQuery) or die(mysqli_error($mysqli));
    $dentist = mysqli_fetch_assoc($result);

    $rowCountQuery2 = "SELECT MAX(ID) AS total FROM L4_Appointments";
    $resultRow2 = mysqli_query($mysqli, $rowCountQuery2) or die(mysqli_error($mysqli));
    $rowCountData2 = mysqli_fetch_assoc($resultRow2);
    $appID = $rowCountData2['total'] + 1;
    $dentistID = $dentist['ID'];

    // Create appointment
    $insertAppointmentQuery = "INSERT INTO L4_Appointments (ID, Pat_ID, Den_ID, app_date, RoomNo) VALUES ($appID, $patientID, $dentistID, '$appointmentDate', 'L201')";

    if (mysqli_query($mysqli, $insertAppointmentQuery)) {
        echo "<script>
                alert('Appointment successfully created!');
                window.location.href = 'ManageAppts.php';
              </script>";
    } else {
        echo "<script>
                alert('Failed to create appointment.');
                window.location.href = 'Appointment.php';
              </script>";
    }
    // header("Location: " . $_SERVER['PHP_SELF']);
    // exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Book Appointment</title>
<link
	href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
	rel="stylesheet">
</head>
<body class="bg-light">
	<?php include 'Navbar.php'; ?>
	<div class="container mt-5">
		<div class="row justify-content-center">
			<div class="col-lg-8 bg-white p-5 shadow-sm rounded">
				<h3 class="text-center mb-4">Book a Patient Appointment</h3>
                    <?php
                    if (isset($successMessage)) {
                        echo "<div class='alert alert-success'>$successMessage</div>";
                    }
                    ?>
                    <?php
                    if (isset($errorMessage)) {
                        echo "<div class='alert alert-danger'>$errorMessage</div>";
                    }
                    ?>
                    <form method="POST" action="">
					<div class="row mb-3">
						<div class="col">
							<label for="first-name" class="form-label">First Name</label> <input
								type="text" class="form-control" id="first-name"
								name="first-name" placeholder="First Name" maxlength="25"
								pattern="[A-Za-z]+" title="Please enter letters only." required>
						</div>
						<div class="col">
							<label for="last-name" class="form-label">Last Name</label> <input
								type="text" class="form-control" id="last-name" name="last-name"
								placeholder="Last Name" maxlength="30" pattern="[A-Za-z]+"
								title="Please enter letters only." required>
						</div>
					</div>
					<div class="mb-3">
						<label for="dob" class="form-label">Date of Birth</label> <input
							type="date" class="form-control" id="dob" name="dob" required>
					</div>
					<div class="mb-3">
						<label for="health-number" class="form-label">Health Number</label>
						<input type="text" class="form-control" id="health-number"
							name="health-number" placeholder="123-456-789" required>
					</div>
					<div class="mb-3">
						<label for="phone-number" class="form-label">Phone Number</label>
						<input type="tel" class="form-control" id="phone-number"
							name="phone-number" placeholder="(123)-456-7890" maxlength="15"
							required>
					</div>
					<div class="mb-3">
						<label for="address" class="form-label">Address</label>
						<div class="row">
							<div class="col">
								<input type="text" class="form-control"
									placeholder="Street Number" id="street-number"
									name="street-number" maxlength="6" required>
							</div>
							<div class="col">
								<input type="text" class="form-control"
									placeholder="Street Name" id="street-name" name="street-name"
									maxlength="20" required>
							</div>
						</div>
					</div>
					<div class="row mb-3">
						<div class="col">
							<input type="text" class="form-control" placeholder="City"
								id="city" name="city" required>
						</div>
						<div class="col">
							<input type="text" class="form-control" placeholder="Postal Code"
								id="postal-code" name="postal-code" required>
						</div>
						<div class="col">
							<input type="text" class="form-control" placeholder="Country"
								id="country" name="country" maxlength="14" required>
						</div>
					</div>
					<div class="mb-3">
						<label for="appointment-date" class="form-label">Appointment Date</label>
						<input type="date" class="form-control" id="appointment-date"
							name="appointment-date" required>
					</div>
					<button type="submit" class="btn btn-primary w-100">Submit</button>
				</form>
			</div>
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="Banner.js"></script>

</body>
</html>

<?php
session_start();
if (empty($_SESSION['username'])) {

    header("Location: Login.php");
    exit();
}

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
    WHERE
        a.app_date >= CURDATE()
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
<link
	href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
	rel="stylesheet">
</head>
<body class="bg-light">
	<?php include 'Navbar.php'; ?>
	<div class="container mt-5">
		<h3 class="text-center mb-4">Appointments</h3>
		<div class="d-flex justify-content-between mb-3">
			<button onclick="window.location.href='Appointment.php'"
				class="btn btn-primary">Create Appointment</button>
			<button onclick="window.location.href='RemoveAppt.php'"
				class="btn btn-danger">Remove Appointment</button>
		</div>
		<div class="card shadow-sm">
			<div class="card-body">

				<table class="table table-light table-striped table-hover">
					<thead>
						<tr>
							<th>Patient ID</th>
							<th>First Name</th>
							<th>Last Name</th>
							<th>Appointment Date</th>
							<th>Appointment Reminder</th>
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
            function sendReminder() {
                alert("Appointment Reminder has been sent out.");
            } 
        </script>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="Banner.js"></script>
</body>
</html>
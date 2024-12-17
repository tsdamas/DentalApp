$(document).ready(function () {
    $('#dashboard-link').click(function () {
        window.location.href = 'Dashboard.php';
    });

    $('#patients-link').click(function () {
        window.location.href = 'Patients.php';
    });

    $('#appointments-link').click(function () {
        window.location.href = 'ManageAppts.php';
    });

	$('#logout-link').click(function (e) {
	    e.preventDefault(); 
	    $.ajax({
	        url: 'Logout.php',
	        type: 'POST',
	        success: function (response) {
	            if (response.status === 'success') {
	                alert(response.message);
	                window.location.href = 'Login.php'; 
	            } else {
	                alert('Unexpected response from the server.');
	            }
	        },
	        error: function () {
	            alert('Logout has failed.');
	        }
	    });
	});

});

<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Administrator Dashboard</title>

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	</head>
	<body>
		<nav class="navbar navbar-dark bg-dark">
			<span style="color: #fff;"><?php echo ucfirst($accountType); ?> > <em><?php echo $username; ?></em></span>
			<a class="btn btn-danger btn-sm" href="<?php echo base_url()?>index.php/System/logout">Logout</a>
		</nav>
		<div class="container" style="margin-top: 20px">
			<div id="dashboard">
				<div class="row">
					<div class="col-md-4 offset-md-4 mt-3">
						<a id="registerTherapistButton" class="btn btn-info btn-lg btn-block" style="text-transform: uppercase; color: #fff;">register a new therapist</a>
					</div>
				<div class="col-md-4 offset-md-4 mt-3">
						<a id="downloadFilesButton" class="btn btn-info btn-lg btn-block" style="text-transform: uppercase; color: #fff;">Download Files</a>
				</div>
			</div>
			</div>
		</div>

		<!-- JQuery JS -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

		<!-- Popper JS -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

		<!-- Bootstrap JS -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

		<!-- Custom Script -->
		<script type="text/javascript">
			$(document).ready(function(){
				var base_url = "<?php echo base_url()?>";

				$(document).on("click", "#downloadFilesButton", function(){
					window.location.href = base_url+"index.php/UserManagement/pull_assign_page";
				});
					$(document).on("click", "#registerTherapistButton", function(){
					window.location.href = base_url+"index.php/System/load_registration_page";
					});
				});

		</script>
	</body>
</html>

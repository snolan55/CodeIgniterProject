<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Patient Registration</title>

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	</head>
	<body>
      <div class="container" style="margin-top: 10px">
          <div class="row mt-3">
            <div class="col">
              <div class="text-center">
                      <h2>Patient Registration</h2>
              </div>
            </div>
          </div>
          <div class="row mt-3"></div>
            <div class="col-md-6 offset-md-3">
              <div class="text-center">
                <form id="form" action="<?php echo base_url() ?>index.php/UserManagement/create_new_patient" method="post">
                  <div>
										<?php echo form_error('patientFirstName'); ?>
                    <label for="firstName">First Name:</label>
                    <input type="text" name="patientFirstName" id="patientFirstName">
                  </div>

                  <div>
										<?php echo form_error('patientLastName'); ?>
                    <label for="lastName">Last Name:</label>
                    <input type="text" name="patientLastName" id="patientLastName">
                  </div>

                  <div>
										<?php echo form_error('patientDateOfBirth'); ?>
                    <label for="patientDateOfBirth">Date of Birth (YYYY-MM-DD):</label>
                    <input type="text" name="patientDateOfBirth" id="patientDateOfBirth">
                  </div>

                  <div>
                    <input type="hidden" name="userId" value="<?php echo $_SESSION['userId']; ?>" />
                  </div>

                  <div>
										<?php echo form_error('patientUsername'); ?>
                    <label for="userName">Patient Username:</label>
                    <input type="text" name="patientUsername" id="patientUsername">
                  </div>

                  <div>
										<?php echo form_error('patientPassword'); ?>
                    <label for="password">Patient Password:</label>
                    <input type="password" name="patientPassword" id="patientPassword">
                  </div>
									
                    <input type="submit" value="Submit">
                  </form>
        </div>


		<!-- JQuery JS -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

		<!-- Popper JS -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

		<!-- Bootstrap JS -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

		<!-- Typeahead -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>

		<!-- Custom Script -->
		<script type="text/javascript">
			$(document).ready(function(){
				var base_url = "<?php echo base_url()?>";
			});
		</script>
	</body>
</html>

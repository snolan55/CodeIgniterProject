<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Therapist Registration</title>

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	</head>
	<body>
      <div class="container" style="margin-top: 10px">
          <div class="row mt-3">
            <div class="col">
              <div class="text-center">
                      <h2>Therapist Registration</h2>
              </div>
            </div>
          </div>
          <div class="row mt-3"></div>
            <div class="col-md-6 offset-md-3">
              <div class="text-center">
                <form id="form" action="<?php echo base_url() ?>index.php/UserManagement/create_new_therapist" method="post">
                  <div>
										<?php echo form_error('therapistFirstName'); ?>
                    <label for="firstName">First Name:</label>
                    <input type="text" name="therapistFirstName" id="therapistFirstName">
                  </div>

                  <div>
										<?php echo form_error('therapistLastName'); ?>
                    <label for="lastName">Last Name:</label>
                    <input type="text" name="therapistLastName" id="therapistLastName">
                  </div>

                  <div>
                      <input type="hidden" name="userId" value="<?php echo $_SESSION['userId']; ?>" />
                  </div>

                  <div>
										<?php echo form_error('therapistUsername'); ?>
                    <label for="userName">Therapist Username:</label>
                    <input type="text" name="therapistUsername" id="therapistUsername">
                  </div>

                  <div>
										<?php echo form_error('therapistPassword'); ?>
                    <label for="password">Therapist Password:</label>
                    <input type="password" name="therapistPassword" id="therapistPassword">
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
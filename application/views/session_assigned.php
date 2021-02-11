<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Session Assigned</title>

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	</head>
	<body>
		<div class="container" style="margin-top: 10px">
        <div class="row mt-3">
          <div class="col">
            <div class="text-center">
                    <h2>Session Successfully Assigned!</h2>
            </div>
          </div>
        </div>
        <div class="row mt-5">
          <div class="col-md-8 offset-md-2">
            <div class="jumbotron">
              <div class="mx-auto dflex">
                <div class="jumbotron text-left">
                  <div class="row">
                    <div class="col">
                      <div>
                        <h4 style="font-size:20px">Confirmation Details</h4>
                      </div>
                      <p style="font-size:15px"><strong>Patient:</strong> <?php echo $patientName;?></p>
                      <p style="font-size:15px"><strong>Therapist:</strong> <?php echo $therapistName;?></p>
                      <p style="font-size:15px"><strong>Date Assigned:</strong> <?php echo $date;?></p>
                        <div class="col offset-10">
                          <button type="button" id="homeButton" class="btn btn-primary" title="Return to Home Page">Home</button>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
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

				$(document).on("click", "#homeButton", function() {
					window.location.href = base_url+"index.php/Dashboard/therapist";
				});
			});
		</script>
	</body>
</html>

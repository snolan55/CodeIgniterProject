<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Patient View</title>

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	</head>
	<body>
      <div class="container" style="margin-top: 10px">
          <div class="row mt-3">
            <div class="col">
              <div class="text-center">
                      <h2>Download a Summary</h2>
              </div>
            </div>
          </div>
          <div class="row mt-3"></div>
            <div class="col-md-6 offset-md-3">
              <div class="text-center">
              <form id="form" action="<?php echo base_url() ?>index.php/Download/createPdf" method="post">
                <input type="search" class="form-control" id="searchBar" name="search"
                placeholder="Search for a patient..." autocomplete="off">

                  <div id="content">
                  </div>

									<input type="submit" style="display: none;">
                </form>
            </div>
          </div>
      </div>

		}

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

				$(document).on("click", "#downloadButton", function() {
					$("#form").submit();
				});

				var $input = $("#searchBar");
				$input.typeahead({
					source: function(query, process) {
						$.ajax({
							url: base_url+"index.php/UserManagement/get_patient_fname_lname",
							type: 'POST',
							data: {query: query, tId: <?php echo $_SESSION['userId']; ?>},
							dataType: 'JSON',
							async: true,
							success: function(data){
								process(data);
							}
						});
					}
				});

				$input.change(function() {
					var current = $input.typeahead("getActive");
					if (current) {
						if (current.name == $input.val()) {
							$.ajax({
								url: base_url+"index.php/UserManagement/get_patient_information2",
								type: 'POST',
								data: {pId: current.id, tId: <?php echo $_SESSION['userId']; ?>},
								dataType: 'JSON',
								async: true,
								success: function(data){
									$("#content").html("");
									$("#content").html(data.pkg);
								}
							});
						}
					}
				});
			});
		</script>
	</body>
</html>
}

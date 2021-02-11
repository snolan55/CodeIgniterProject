<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Sign in</title>

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	</head>
	<body>
		<div class="container">
            <div class="row" style="margin-top:120px;">
                <div class="col-md-4 offset-md-4 col-sm-8 offset-sm-2">
                
                    <!-- <ErrorAlert> -->
                    <?php if ($this->session->flashdata('login_error')): ?>
                        <div class="alert alert-danger alert-dismissible">
                            <?php echo $this->session->flashdata('login_error'); ?>
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>
                    <!-- </ErrorAlert> -->

                    <div class="card">
                        <div class="card-header">
                            <h5 class="text-center">Sign in</h5>
                        </div>
                        <div class="card-body">
                            <form action="<?php echo base_url() ?>index.php/System/login_user" method="POST">
                                <!-- <UsernameField> -->
                                <?php if (form_error('username')): ?>
                                    <div class="form-group mb-2">
                                        <label for="username">Username</label>
                                        <input id="username" class="form-control form-control-sm is-invalid" type="text" name="username" autocomplete="off">
                                        <div class="invalid-feedback"><?php echo form_error('username'); ?></div>
                                    </div>
                                <?php else: ?>
                                    <div class="form-group mb-2">
                                        <label for="username">Username</label>
                                        <input id="username" class="form-control form-control-sm" type="text" name="username" autocomplete="off">
                                    </div>
                                <?php endif; ?>
                                <!-- </UsernameField> -->


                                <!-- <PasswordField> -->
                                <?php if (form_error('password')): ?>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input id="password" class="form-control form-control-sm is-invalid" type="password" name="password">
                                        <div class="invalid-feedback"><?php echo form_error('password'); ?></div>
                                    </div>
                                <?php else: ?>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input id="password" class="form-control form-control-sm" type="password" name="password">
                                    </div>
                                <?php endif; ?>
                                <!-- </PasswordField> -->


                                <div class="form-group">
                                    <label for="account-type">Account Type</label>
                                    <select name="account-type" id="account-type" class="form-control form-control-sm">
                                        <option value="patient">Patient</option>
                                        <option value="therapist">Therapist</option>
                                        <option value="admin">Administrator</option>
                                    </select>
                                </div>
                                <input class="btn btn-primary btn-block" type="submit" value="Sign in">
                            </form>
                        </div>
                        <div class="card-footer text-center">
                            <small class="text-muted">&copy; Christoforou Intervention Systems</small>
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

				
			});
		</script>
	</body>
</html>

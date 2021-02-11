<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Patient Dashboard</title>

		<!-- Custom CSS For Related Memory Activity -->
		<style>
			#canvas {
				margin-top: 50px;
			}

			#left, #right, #row > div{
				display: inline-block;
			}

			#draggable {
				transform: translate(400%, -104%);
			}

			#draggable:hover {
				cursor: grab;
			}

			#draggable, .target, .answerField {
				border: 2px solid black;
				width: 150px;
				height: 150px;
				position: relative;
			}

			.target {
				border-right: none;
			}

			#draggable > p, .target > p, .answerField > p {
				margin: 0;
				position: absolute;
				top: 50%;
				left: 50%;
				transform: translate(-50%, -50%);
				font-size: 20px;
				font-style: italic;
			}

			.invisible {
				display: none;
			}

			#attempts_left {
				display: inline-block;
			}

			#stopInterventionButton, #timer{
				float: right;
			}

			#canvas-body {
				margin: 20px 0;
			}

			.hovering {
				border-style: dashed;
			}

			.correctEffect {
				animation: correct 1.5s ease;
			}

			.wrongEffect {
				animation: wrong 1.5s ease;
			}

			@keyframes correct {
				0% {
					border-color: black;
				}

				50% {
					border-color: #00ff00;
				}

				99% {
					border-color: black;
				}
			}

			@keyframes wrong {
				0% {
					border-color: black;
				}

				50% {
					border-color: red;
				}

				99% {
					border-color: black;
				}
			}
		</style>

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
					<div class="col-md-2 offset-md-5">
						<a id="getInterventionsButton" class="btn btn-primary btn-lg" style="text-transform: uppercase; color: #fff;">interventions</a>
					</div>
					<div class="col-md-2 offset-md-5" style="margin-top: 100px;">
                        
					</div>
				</div>
			</div>
			<div id="content"></div>
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

				/**
				Autonomously renders the Related Memory Activity for any level. */
				function renderRelatedMemoryActivity(data)
				{
					var failCounter = parseInt(data.failCounter);
					var contentDiv = document.getElementById('content');
					var canvas = document.createElement('div');
					canvas.id = 'canvas';

					// Define the left and right portion of the canvas
					var left = document.createElement('div');
					left.id = 'left';
					var right = document.createElement('div');
					right.id = 'right';

					// Options
					var options = [data.optionOne, data.optionTwo, data.optionThree];

					// Answer Pool
					var answers = [data.answerOne, data.answerTwo, data.answerThree];

					// Determine answer
					var rand = Math.floor(Math.random() * 3);	// Generate random integer between 0 and 2

					// Canvas Header
					var header = document.createElement('div');
					header.id = 'canvas-header';

					// Game Title
					var title = document.createElement('h3');
					var node = document.createTextNode(data.activityName);
					title.appendChild(node);
					header.appendChild(title);

					var subHeader = document.createElement('div');

					// Attempts and Timer UI
					var attempts_left = document.createElement('h5');
					node = document.createTextNode("Remaining attempts: " + (3 - failCounter));
					attempts_left.appendChild(node);
					attempts_left.id = 'attempts_left';
					subHeader.appendChild(attempts_left);

					var timer = document.createElement('h3');
					node = document.createTextNode(parseInt(data.timer) / 1000);
					timer.appendChild(node);
					timer.id = "timer";
					subHeader.appendChild(timer);

					header.appendChild(subHeader);
					canvas.appendChild(header);

					// Canvas Body
					var body = document.createElement('div');
					body.id = 'canvas-body';

					// Generate options
					for(let i = 0; i < data.options; i++)
					{
						var row = document.createElement('div');
						row.id = 'row';
						
						let targetDiv = document.createElement('div');
						targetDiv.className = 'target';
						
						if(data.levelType == "txt") // Alphabetic level
						{
							let target_p = document.createElement('p');
							let textNode = document.createTextNode(options[i]);
							target_p.appendChild(textNode);
							targetDiv.appendChild(target_p);
						}
						else // data.levelType == "img" // Pre-alphabetic level
						{
							targetDiv.style = "background-image: url("+ options[i] +")";
						}

						

						let answerFieldDiv = document.createElement('div');
						answerFieldDiv.className = 'answerField';

						if(i === rand)
						{
							answerFieldDiv.className += ' correct';
						}
						else
						{
							answerFieldDiv.className += ' wrong';
						}

						// Drag and Drop Event Listener for the answer fields
						answerFieldDiv.addEventListener('dragover', function(e) {
							e.preventDefault();	
						});

						answerFieldDiv.addEventListener('drop', function() {
							var field = this.getAttribute('class');
							field = field.split(" ");
							if(field[1] === "correct")	// Pass condition
							{
								draggableDiv.style = 'border-color: white;';
								answerFieldDiv.classList.add('correctEffect');
								clearInterval(interval); // Stop timer for current game instance
								if(data.levelType == "txt") // Alphabetic level
								{
									this.appendChild(p);
								}
								else	// Pre-alphabetic level
								{
									this.style = "background-image: url("+ answers[rand] +")";
								}

								setTimeout(() => { 
									answerFieldDiv.classList.remove('correctEffect'); 
									$.post(base_url+"index.php/InterventionSession/level_passed",
									{
										iSID: data.interventionSessionId,
										activityId: data.currentActivity,
										level: data.currentLevel
									}, function(response){
										if(response.session_done == true)
										{
											$.post(base_url+"index.php/InterventionSession/stop_intervention", {iSID: response.interventionSessionId}, function(data){
												$("#content").html("");
												$("#content").html(data.pkg);
											}, "json");
										}
										else
										{
											loadNextActivity(response.interventionSessionId);
										}
									}, "json");
								}, 1500);
							}
							else	// Fail condition
							{
								answerFieldDiv.classList.add('wrongEffect');
								setTimeout(() => { answerFieldDiv.classList.remove('wrongEffect'); }, 1500);
								draggableDiv.className = '';

								failCounter++;
								$("#attempts_left").text("Remaining attempts: " + (3 - failCounter));
								if(failCounter === 3)
								{
									$.post(base_url + "index.php/InterventionSession/lock_activity", {
										iSID: data.interventionSessionId,
										activityId: data.currentActivity
									}, function(response){
										alert("You have run out of attempts. This activity has been locked, temporarily. Another activity shall now be loaded.");
										loadNextActivity(response.interventionSessionId);
									}, "json");
								}
							}
						});


						row.appendChild(targetDiv);
						row.appendChild(answerFieldDiv);
						left.appendChild(row);
					}

					// Generate draggable div
					var draggableDiv = document.createElement('div');
					draggableDiv.id = 'draggable';
					draggableDiv.draggable = 'true';

					if(data.levelType == "txt") // Alphabetic level
					{
						var p = document.createElement('p');
						var textNode = document.createTextNode(answers[rand]);
						p.appendChild(textNode);
						draggableDiv.appendChild(p);
					}
					else // data.levelType == "img" // Pre-alphabetic level
					{
						draggableDiv.style = "background-image: url("+ answers[rand] +")";
					}

					// Drag and Drop Event Listeners for the draggable element
					draggableDiv.addEventListener('dragstart', function() {
						setTimeout(function() {
							draggableDiv.className = 'invisible';
							$('.answerField').addClass('hovering');
							document.body.style.cursor = 'grabbing';
						}, 0);
					});

					draggableDiv.addEventListener('dragend', function() {
						draggableDiv.className = '';
						$('.answerField').removeClass('hovering');
						document.body.style.cursor = 'default';
					});

					right.appendChild(draggableDiv);

					body.appendChild(left);
					body.appendChild(right);
					canvas.appendChild(body);

					// Canvas Footer
					var footer = document.createElement('div');
					footer.id = 'canvas-footer';

					// Create and append the help button
					var helpButton = document.createElement('button');
					helpButton.type = 'button';
					helpButton.id = 'helpButton';
					helpButton.className = 'btn btn-secondary mt-2';
					helpButton.innerHTML = 'HELP';
					footer.appendChild(helpButton);

					$(document).on("click", "#helpButton", function() {
						isPaused = true;
						alert(data.instructions);
						isPaused = false;
					});
					
					// Create and append the stop button
					var stopButton = document.createElement('button');
					stopButton.type = 'button';
					stopButton.id = 'stopInterventionButton';
					stopButton.className = 'btn btn-danger mt-2';
					stopButton.setAttribute('iSID', data.interventionSessionId);
					stopButton.innerHTML = 'STOP';
					footer.appendChild(stopButton);

					canvas.appendChild(footer);

					$(document).on("click", "#stopInterventionButton", function(){
						clearInterval(interval);
						failCounter++;
						var iSID = $(this).attr("iSID");
						$.post(base_url+"index.php/InterventionSession/stop_intervention", {iSID: iSID, failCounter: failCounter, activityId: data.currentActivity}, function(data){
							$("#content").html("");
							$("#content").html(data.pkg);
						}, "json");

					});

					// Append Canvas to the DOM
					contentDiv.appendChild(canvas);

					// Timer functionality
					var isPaused = false;
					var time = parseInt(data.timer);
					var interval = setInterval(() => {
						if(!isPaused)
						{
							time-=1000;
							$("#timer").text(time / 1000);
							if(time === 0)
							{
								alert("Time's up!");
								failCounter++;
								$("#attempts_left").text("Remaining attempts: " + (3 - failCounter));
								if(failCounter == 3)
								{
									$.post(base_url + "index.php/InterventionSession/lock_activity", {
										iSID: data.interventionSessionId,
										activityId: data.currentActivity
									}, function(response){
										alert("You have run out of attempts. This activity has been locked, temporarily. Another activity shall now be loaded.");
										loadNextActivity(response.interventionSessionId);
									}, "json");
								}
								else
								{
									// Reset timer
									time = parseInt(data.timer);
									$("#timer").text(time / 1000);
								}
							}
						}
					}, 1000);
				}

				/**
				Loads data that describes the next activity from the database. */
				function loadNextActivity(id)
				{
					$.post(base_url+"index.php/InterventionSession/start_intervention", {iSID: id}, function(data){
						if(data.currentActivity == 1) // Render Related Memory Activity
						{
							$("#content").html("");
							renderRelatedMemoryActivity(data);
						}
						else
						{
							// Placeholder since other games haven't been implemented.
							$("#content").html("");
							$("#content").html("<h1>Next Activity</h1>");
						}
					}, "json");
				}

				// TODO: Amanda, all API requests should go here. Use JQuery $.post requests to do so: https://api.jquery.com/jquery.post/

				//First Request
				$(document).on("click", "#getInterventionsButton", function(){
					$.post(base_url+"index.php/InterventionSession/get_intervention_sessions", {pId: <?php echo $_SESSION['userId']; ?>}, function(data){
						$("#dashboard").css("display", "none");
						$("#content").html(data.pkg);
					}, "json");

				});

				//Second Request
				$(document).on("click", ".startInterventionButton", function(){
					var iSID = $(this).attr("iSID");
					loadNextActivity(iSID);
				});

				$(document).on("click", "#back_to_dashboard", function(){
					$("#content").html("");
					$("#dashboard").css("display", "block");
				});

				$(document).on("click", "#homeButton", function() {
					$("#content").html("");
					$("#dashboard").css("display", "block");
				});
			});
		</script>
	</body>
</html>

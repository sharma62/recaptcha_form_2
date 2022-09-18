<?php
require('constant.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Contact Us</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
	<script src="component/jquery/jquery-3.2.1.min.js"></script>
	<script>
		$(document).ready(function(e) {
			$("#frmContact").on('submit', (function(e) {
				e.preventDefault();
				$("#mail-status").hide();
				$('#send-message').hide();
				$('#loader-icon').show();
				$.ajax({
					url: "contact.php",
					type: "POST",
					dataType: 'json',
					data: {
						"name": $('input[name="name"]').val(),
						"email": $('input[name="email"]').val(),
						"phone": $('input[name="phone"]').val(),
						"content": $('textarea[name="content"]').val(),
						"g-recaptcha-response": $('textarea[id="g-recaptcha-response"]').val()
					},
					success: function(response) {
						$("#mail-status").show();
						$('#loader-icon').hide();
						if (response.type == "error") {
							$('#send-message').show();
							$("#mail-status").attr("class", "error");
						} else if (response.type == "message") {
							$('#send-message').hide();
							$("#mail-status").attr("class", "success");
						}
						$("#mail-status").html(response.text);
					},
					error: function() {}
				});
			}));
		});
	</script>
	<style>
		input,
		.label {
			margin: 8px;
		}

		.background-img {
			background-image: url('https://www.designyourway.net/blog/wp-content/uploads/2018/12/programming-wallpaper7-800x600.jpg');
			/* background-image: url('https://www.designyourway.net/blog/wp-content/uploads/2018/12/programming-wallpaper3.jpg'); */
			background-repeat: no-repeat;
			background-position: right;
			background-size: cover;
			border-bottom-width: 10px;
		
		}

		b {
			color: red;
		}
		body{
			color: white;
			background-color: black;
		}
	</style>

	<script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body >

	<h1 class="text-center py-3 border-bottom">Contact Me</h1>
	<div id="central" class="container py-3 ">
		<div class="content row my-3">
			<div id="message" class="col" style="background-color: white ; color:black ; ">
				<form id="frmContact" action="" class="form " method="POST" novalidate="novalidate">
					<div class="label">Name:</div>
					<div class="field">
						<input type="text" class="form-control" id="name" name="name" placeholder="enter your name here" title="Please enter your name" class="required" aria-required="true" required>
					</div>
					<div class="label">Email:</div>
					<div class="field">
						<input type="text" id="email" class="form-control" name="email" placeholder="enter your email address here" title="Please enter your email address" class="required email" aria-required="true" required>
					</div>
					<div class="label">Phone Number:</div>
					<div class="field">
						<input type="text" id="phone" class="form-control" name="phone" placeholder="enter your phone number here" title="Please enter your phone number" class="required phone" aria-required="true" required>
					</div>
					<div class="label">Comments:</div>
					<div class="field">
						<textarea class="form-control" id="comment-content" name="content" placeholder="enter your comments here"></textarea>
					</div>
					<div class="g-recaptcha my-3" data-sitekey="<?php echo SITE_KEY; ?>"></div>
					<div id="mail-status"></div>
					<button type="Submit" class="btn btn-primary my-3" id="send-message" style="clear:both;">Send Message</button>
				</form>
				<div id="loader-icon" style="display:none;"><img src="img/loader.gif" /></div>
			</div>
			<div class="col-7 background-img">
				
			</div>
		</div>

	</div>
</body>

</html>
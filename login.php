<?php
	include 'connect.php';
	include 'check.php';
	ob_start();
	session_start();

	if( loggedin() )
		header("Location: dashboard.php");

	if( isset($_POST['email']) && isset($_POST['password']) )
	{
		$email = $_POST['email'];
		$pass  = crypt($_POST['password'], 'admin');

		$sql    = "SELECT * FROM users WHERE email='$email' AND password='$pass' LIMIT 1";
		$result = $conn->query($sql);

		if( $result->num_rows )
		{
			while($row = $result->fetch_assoc())
			  $_SESSION["id"] = $row['id'];
			$conn->close();
			header("Location: dashboard.php");
		}
		echo '<strong>Wrong email and password combination</strong>';
	}
?>

<html>
	<head>
		<?php include 'css.php';?>
		<style type="text/css">
			strong {
				color: red;
				font-size: 12;
			}
		</style>
	</head>
	<body>
		<form class="form-inline" method="POST" action="login.php" id="reg-form">
	    <div class="form-group col-sm-12">
	      <label for="Email">Email</label>
	      <input class="form-control" name="email" type="email">
	      <br>
	      <strong id="error-email"></strong>
	    </div>
	    <div class="form-group col-sm-12">
	      <label for="Password">Password</label>
	      <input class="form-control" name="password" type="password">
	      <br>
	      <strong id="error-pass"></strong>
	    </div>

	    <div class="form-group col-sm-12">
	    	<button type="submit" class="btn btn-success">Go</button>
	    </div>
		</form>

		<?php include 'js.php';?>

		<script type="text/javascript">
			$(function(){
				$('input[name="dob"]').datepicker();
			});

			$('#reg-form').submit(function(e){
				e.preventDefault();
				email = $(this).find('input[name="email"]').val();
				pass  = $(this).find('input[name="password"]').val();

				$('strong').html('')

				if( email == '' )
					$('#error-email').html('Email required');
				else if( pass == '' )
					$('#error-pass').html('Password required');
				else this.submit();
			});
		</script>

	</body>
</html>
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
		echo '<div class="error"><strong>Wrong email and password combination</strong></div>';
	}
	if( isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['middle_name']) && isset($_POST['email']) && isset($_POST['dob']) && isset($_POST['gender']) && isset($_POST['password']) && isset($_POST['confirm_password']) )
	{
		$sql    = "SELECT id FROM users WHERE email='".$_POST['email']."' LIMIT 1";
		$result = $conn->query($sql);

		if( $result->num_rows )
			echo '<strong>User with same email id already exists</strong>';
		else
		{
			$fname = $_POST['first_name'];
			$mname = $_POST['middle_name'];
			$lname = $_POST['last_name'];
			$email = $_POST['email'];
			$dob   = $_POST['dob'];
			$gen   = $_POST['gender'];
			$pass  = crypt($_POST['password'], 'admin');

			$sql = "INSERT INTO users (first_name, middle_name, last_name, gender, dob, email, password) VALUES ('$fname', '$mname', '$lname', '$gen', '$dob', '$email', '$pass')";

			if ($conn->query($sql) === TRUE) {
				$sql    = "SELECT id FROM users WHERE email='$email' LIMIT 1";
				$result = $conn->query($sql);
				while($row = $result->fetch_assoc())
					$_SESSION["id"] = $row['id'];
				$conn->close();
				header("Location: dashboard.php");
			} else {
					echo "Error: " . $sql . "<br>" . $conn->error;
			}
		}
	}
?>
<!DOCTYPE html>
<html >
<head>
	<meta charset="UTF-8">
	<title>Flat HTML5/CSS3 Login Form</title>
	<?php include 'css.php';?>
	
	
			<link rel="stylesheet" href="css/style.css">
			<style type="text/css">
				.error{
					background: white;
					top: 0;
					position: absolute;
					width: 100%;
					left: 0;
					height: 3em;
					display: flex;
					align-items: center;
					justify-content: center;
					border-top: 2px solid #7aba57;
				}
			</style>
		<style type="text/css">
			strong {
				color: red;
				font-size: 12;
			}
			.error-div{
				padding: 0em 0 1em;
			}
			.radio1{
				display: flex;
				justify-content: center;
				align-items: baseline;
			}
		</style>
</head>

<body>
	<div class="login-page">
	<div class="form">
		<form class="register-form" method="POST" action="index.php" id="reg-form">
			<input name="first_name" type="text" placeholder="First Name">
				<br>
				<div class="error-div"><strong id="error-first"></strong></div>
			<input name="middle_name" type="text" placeholder="Middle Name">
				<br>
				<div class="error-div"><strong id="error-middle"></strong></div>
				<input name="last_name" type="text" placeholder="Last Name">
				<br>
				<div class="error-div"><strong id="error-last"></strong></div>
				 <div class="form-group col-sm-12 radio1">
				<label for="Gender">Gender</label>
				<input type="radio" name="gender" value="Male" checked>Male
				<input type="radio" name="gender" value="Female">Female
				</div>
				<br>
				<div class="error-div"><strong id="error-gender"></strong></div>
				<input name="dob" type="text" placeholder="DOB">
				<br>
				<div class="error-div"><strong id="error-dob"></strong></div>

				<input  name="email" type="email" placeholder="Email">
				<br>
				<div class="error-div"><strong id="error-email"></strong></div>

				<input  name="password" type="password" placeholder="Password">
				<br>
				<div class="error-div"><strong id="error-pass"></strong></div>

				<input  name="confirm_password" type="password" placeholder="Confirm Password">
				<br>
				<div class="error-div"><strong id="error-cpass"></strong></div>


			<button>create</button>
			<p class="message">Already registered? <a href="#">Sign In</a></p>
		</form>
		<form class="login-form" method="POST" action="index.php" id="log-form">
			<input name="email" type="email" placeholder="username">
			<br>
			<div class="error-div"><strong id="error-email"></strong></div>
			<input name="password" type="password" placeholder="password">
			<br>
			<div class="error-div"><strong id="error-pass"></strong></div>
			<button type="submit">Go</button>
			<p class="message">Not registered? <a href="#">Create an account</a></p>
		</form>
	</div>
</div>
		<?php include 'js.php';?>
		<script src="js/main.js"></script>
		<script type="text/javascript">
			$(function(){
				$('input[name="dob"]').datepicker();
			});

			$('#log-form').submit(function(e){
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
		<script type="text/javascript">
			$(function(){
				$('input[name="dob"]').datepicker();
			});

			$('#reg-form').submit(function(e){
				e.preventDefault();
				fname = $(this).find('input[name="first_name"]').val();
				mname = $(this).find('input[name="middle_name"]').val();
				lname = $(this).find('input[name="last_name"]').val();
				email = $(this).find('input[name="email"]').val();
				dob   = $(this).find('input[name="dob"]').val();
				pass  = $(this).find('input[name="password"]').val();
				cpass = $(this).find('input[name="confirm_password"]').val();

				$('strong').html('')

				if( fname == '' )
					$('#error-first').html('First name required');
				else if( mname == '' )
					$('#error-middle').html('Middle name required');
				else if( lname == '' )
					$('#error-last').html('Last name required');
				else if( dob == '' )
					$('#error-dob').html('Birthday date required');
				else if( email == '' )
					$('#error-email').html('Email required');
				else if( pass == '' )
					$('#error-pass').html('Password required');
				else if( pass != cpass )
					$('#error-cpass').html('Password confirmation failed');
				else this.submit();
			});
		</script>


</body>
</html>

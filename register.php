<?php
	include 'connect.php';
	include 'check.php';
	ob_start();
	session_start();

	if( loggedin() )
		header("Location: dashboard.php");

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
		<form class="form-inline" method="POST" action="register.php" id="reg-form">
			<div class="form-group col-sm-12">
	      <label for="First Name">First Name</label>
	      <input class="form-control" name="first_name" type="text">
	      <br>
	      <strong id="error-first"></strong>
	    </div>
    	<div class="form-group col-sm-12">
	      <label for="Middle Name">Middle Name</label>
	      <input class="form-control" name="middle_name" type="text">
	      <br>
	      <strong id="error-middle"></strong>
	    </div>
	    <div class="form-group col-sm-12">
	      <label for="Last Name">Last Name</label>
	      <input class="form-control" name="last_name" type="text">
	      <br>
	      <strong id="error-last"></strong>
	    </div>

	    <div class="form-group col-sm-12">
	      <label for="Gender">Gender</label>
	      <label class="radio-inline"><input type="radio" name="gender" value="Male" checked>Male</label>
				<label class="radio-inline"><input type="radio" name="gender" value="Female">Female</label>
				<br>
				<strong id="error-gender"></strong>
	    </div>

	    <div class="form-group col-sm-12">
	      <label for="Birthday">Birthday</label>
	      <input class="form-control" name="dob" type="text">
	      <br>
	      <strong id="error-dob"></strong>
	    </div>

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
	      <label for="Confirm Password">Confirm Password</label>
	      <input class="form-control" name="confirm_password" type="password">
	      <br>
	      <strong id="error-cpass"></strong>
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
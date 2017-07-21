<?php
	include 'connect.php';
	ob_start();
	session_start();
	$id  = $_SESSION['id'];
	$sql = "SELECT * FROM users WHERE id='$id' LIMIT 1";
	$result = $conn->query($sql);
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
		<div role="tabpanel">
			<h5>Settings</h5>
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane active" id="about">
					<?php while($row = $result->fetch_assoc()) { ?>

						<ul>
							<li>Email: <?php echo $row['email'] ?></li>
							<li>Name: <?php echo $row['first_name'] ?> <?php echo $row['middle_name'] ?> <?php echo $row['last_name'] ?></li>
							<li>Gender: <?php echo $row['gender'] ?></li>
							<li>Birthday: <?php echo $row['dob'] ?></li>
							<li>Password: *********</li>
							<li>
								<form method="POST" action="logout.php">
									<button type="submit" class="btn btn-success">Logout</button>
								</form>
							</li>
							<li><button onclick="goBack()" type="button" class="btn btn-danger">Go back</button></li>
						</ul>
					<?php } ?>
				</div>
			</div>
		</div>

		<?php include 'js.php';?>
		<script>
			function goBack() {
			  window.history.back();
			}
		</script>
	</body>
</html>
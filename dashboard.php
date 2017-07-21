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
			<ul class="nav nav-tabs tab-nav" role="tablist">
			  <li class="active"><a href="#about" role="tab" data-toggle="tab">About</a></li>
			  <li><a href="settings.php">Settings</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane active" id="about">
					<?php while($row = $result->fetch_assoc()) { ?>
						Email: <?php echo $row['email'] ?>
						Name: <?php echo $row['first_name'] ?> <?php echo $row['middle_name'] ?> <?php echo $row['last_name'] ?>
						Gender: <?php echo $row['gender'] ?>
						Birthday: <?php echo $row['dob'] ?>
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
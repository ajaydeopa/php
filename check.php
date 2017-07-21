<?php
	function loggedin()
	{
		if( isset($_SESSION['id']) && !empty($_SESSION['id']) )
			return true;
		return false;
	}
?>
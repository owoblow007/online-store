<?php

		unset($_SESSION['id']);
		unset($_SESSION['email']);

		header("Location:adminlogin.php");
?>
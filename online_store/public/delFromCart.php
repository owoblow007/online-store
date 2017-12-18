<?php
		include 'include/db.php';

		include 'include/controllers.php';

		delFromCart($conn, $_GET['cart_id']);
		
?>
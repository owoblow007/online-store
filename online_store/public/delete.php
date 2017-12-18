<?php

	include 'include/db.php';

	include 'include/controllers.php';


	delCart($conn, $_GET['cart_id']);

?>
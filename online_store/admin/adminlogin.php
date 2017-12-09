<?php
$page_title = "Admin Login";
include 'include/db.php';
include 'include/header.php';
include 'include/functions.php';

$error = [];

if(array_key_exists('login', $_POST)){

if(empty($_POST['email'])){
$error['email'] = "Please enter email";

}


if(empty($_POST['password'])){
  $error['password'] = "please enter password";
}

if(empty($error)){
$clean = array_map('trim', $_POST);

$chk = adminLogin($conn, $clean);


  $_SESSION['id'] = $chk[1]['admin_id'];
  $_SESSION['email'] = $chk[1]['email'];

  redirect("location:adminhome.php");

	}

}






 ?>




<div class="wrapper">
		<h1 id="register-label">Admin Login</h1>
		<hr>
		<form id="register"  action ="" method ="POST">

			<div>


				<?php
					if(isset($_GET['msg']))
					echo '<span class="err">'. $_GET['msg']. '</span>';

				$display = displayErrors($error, 'email');
				echo $display;
				?>
				<label>email:</label>
				<input type="text" name="email" placeholder="email">
			</div>
			<div>
				<?php
				if(isset($_GET['msg']))
					echo '<span class="err">'. $_GET['msg']. '</span>';
				$pass = 'password';
				$display = displayErrors($error, $pass);
				echo $display;
				?>
				<label>password:</label>
				<input type="password" name="password" placeholder="password">
			</div>


			<input type="submit" name="login" value="Login">
		</form>

		<h4 class="jumpto">No Account Yet?<a href="register.php">Register</a></h4>

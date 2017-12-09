<?php
  $page_title = "User Registration";

  // connect to the database
  include 'include/db.php';

  // load all functions properties
  include 'include/controllers.php';

  // load headers
  include 'include/header3.php';
  $error = [];
  if (array_key_exists('login', $_POST)) {
    # code...
      if(empty($_POST['email'])){
        $error['email'] = 'Enter Your Email';
      }
      if(empty($_POST['pass'])){
        $error['pass'] = 'Provide Your Password';
      }
      if(empty($error)){
    $clean = array_map('trim', $_POST);

     $chk = userLogin($conn, $clean);

    $_SESSION['username'] = $chk[1]['username'];
    $_SESSION['id'] = $chk[1]['user_id'];

     header("Location:Home.php");

       }
  }
if(isset($_GET['msg'])){
          echo '<span class="form-error">'. $_GET['msg']. '</span>';
}
?>


<div class="main">
    <div class="login-form">
      <form class="def-modal-form" action="" method="POST">
        <div class="cancel-icon close-form"></div>
        <label for="login-form" class="header"><h3>Login</h3></label>
        <?php if(isset($_GET['msg']))
          echo '<span class="form-error">'. $_GET['msg']. '</span>'; ?>
        <?php
           $display = displayErrors($error, 'email'); echo $display; ?>
        <input type="text" name="email" class="text-field email" placeholder="Email">
        <!-- <p class="form-error">invalid email</p> -->
          <?php 
                 $display = displayErrors($error, 'pass'); echo $display;?>
        <input type="password" name="pass" class="text-field password" placeholder="Password">
        
        <!-- <p class="form-error">wrong password</p> -->
        <input type="submit" name="login" class="def-button login" value="Login">
      </form>
    </div>
  </div>

  <?php
  include 'include/footer.php';

?>
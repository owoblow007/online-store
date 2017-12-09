<?php
    
    include 'include/db.php';

    include 'include/regheader.php';

    include 'include/controllers.php';

    $error = [];

    if(array_key_exists('register', $_POST)){

        if(empty($_POST['firstname'])){
            $error['firstname'] = 'Provide Your Firstname';   
        }
        

        if(empty($_POST['lastname'])){
            $error['lastname'] = 'Enter Your Lastname';
        }
        

        if(empty($_POST['email'])){
            $error['email'] = 'Enter Your Email';
        }

        if(doesEmailExist($conn,$_POST['email'])){
             $error['email'] = "*email already exists";
         }

        if(empty($_POST['username'])){
            $error['username'] = 'Enter Your Username';
        }
        /*if(doesUsernameExist($conn, $_POST['username'])){
            $error['username'] = '*username already exists';
        }*/

        if(empty($_POST['password'])){
            $error['password'] = 'Enter Your Password';
        }

        if(empty($_POST['pword'])){
            $error['pword'] = 'Re-enter Your Password';
        }

        if($_POST['pword'] != $_POST['password']){
            $error['pword'] = 'Your Password Does not match';
        }
        if(empty($error)){
            $clean = array_map('trim', $_POST);
           doUserRegistration($conn, $clean);
        }
    }

?>


<div class="main">
    <div class="registration-form">
      <form id="user_registration" class="def-modal-form" action="" method="POST">
        <div class="cancel-icon close-form"></div>
        <label for="registration-from" class="header"><h3>User Registration</h3></label>
         <?php $display = displayErrors($error, 'firstname'); echo $display; ?>
        <input type="text" name="firstname" class="text-field first-name" placeholder="Firstname">
         <?php $display = displayErrors($error, 'lastname'); echo $display; ?>
        <input type="text" name="lastname" class="text-field last-name" placeholder="Lastname" >
         <?php $display = displayErrors($error, 'email'); echo $display; ?>
        <input type="email" name="email" class="text-field email" placeholder="Email">
         <?php $display = displayErrors($error, 'username'); echo $display; ?>
         <input type="text" name="username" class="text-field username" placeholder="Username">
          <?php $display = displayErrors($error, 'password'); echo $display; ?>
        <input type="password" name="password" class="text-field password" placeholder="Password">
         <?php $display = displayErrors($error, 'pword'); echo $display; ?>
        <input type="password" name="pword" class="text-field confirm-password" placeholder="Confirm Password">
        <input type="submit" name="register" class="def-button" value="Register">
        <p class="login-option">Have an account already?<a href="login.php"> Login</p>
      </form>
    </div>
  </div>

  <?php
        include 'include/footer.php';
  ?>
<?php 
      include 'include/header3.php';

      include 'include/db.php';

      include 'include/controllers.php';

      include 'include/class.Checkout.php';

      if (isset($_SESSION['id'])) {
        # code...
          $uid = $_SESSION['id'];
      }
      if(isset($_SESSION['id'])){
        $checkout = new Checkout();

        $totalPurchase = '$'. $checkout->getTotal($conn, $uid);
      }else{

          $checkout = new Checkout();

          $totalPurchase = '$'.$checkout->getTotal($conn, $sid);
          $Tologin ='<a href="login.php">'."<em>Please Login To Checkout</em"
      }

      $errors = [];
      if(array_key_exists('chkt', $_POST)) {

          if(empty($_POST['phoneNumber'])){
              $errors['phoneNumber'] = 'Please Enter Your Phone Number';
        }

          if(empty($_POST['address'])) {
              $errors['address'] = 'Please Enter the address';
          }

          if (empty($_POST['code'])) {
              $errors['code'] = "Please Enter Post Code";
          }
          if()
      }
 ?>

<div class="main">
    <div class="checkout-form">
      <form class="def-modal-form">
        <div class="total-cost">
          <h3>$2000 Total Purchase</h3>
        </div>
        <div class="cancel-icon close-form"></div>
        <label for="login-form" class="header"><h3>Checkout</h3></label>
        <input type="text"  class="text-field phone" placeholder="Phone Number">
        <input type="text" name="addy" class="text-field address" placeholder="Address">
        <input type="text" name="code" class="text-field post-code" placeholder="Post Code">
        <input type="submit" name="chkt" class="def-button checkout" value="Checkout">
      </form>
    </div>
  </div>

  <?php 
        include 'include/footer.php';
   ?>
<?php 
      $page_title = "Checkout";

      $body_id    = "checkout";

      include 'include/user_header.php';

      //include 'include/db.php';

      include 'include/controllers.php';

      include_once 'include/class.Checkout.php';

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
          $Tologin ='<a href="login.php">'."<em>Please Login To Checkout</em";
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
          if(empty($errors)){
            $clean = array_map('trim', $_POST);

            $checkout->insertIntoCheckout($conn, $uid, $clean, $totalPurchase);
          }
      }
 ?>

<div class="main">
    <div class="checkout-form">
      <form class="def-modal-form">
        <div class="total-cost">
          <h3><?php echo $totalPurchase; ?>Total Purchase <?php if(!isset($_SESSION['id'])) echo '<hr>'.$Tologin ?></h3>
        </div>
        <div class="cancel-icon close-form"></div>
        <label for="login-form" class="header"><h3>Checkout</h3></label>
        <input type="number" maxlength="11" name="phoneNumber"  class="text-field phone" placeholder="Phone Number">
        <?php $display = displayErrors($errors, 'phoneNumber'); echo $display; ?>
        <input type="text" name="address" class="text-field address" placeholder="Address">
        <?php $display = displayErrors($errors, 'address'); echo $display; ?>
        <input type="text" name="code" class="text-field post-code" placeholder="Post Code">
        <?php $display = displayErrors($errors, 'code'); echo $display;?>
        <input type="submit" name="chkt" class="def-button checkout" value="Checkout">
      </form>
    </div>
  </div>

  <?php 
        include 'include/footer.php';
   ?>
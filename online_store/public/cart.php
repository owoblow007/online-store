<?php 
      
      $page_title = "Cart";

      $body_id = "Cart";
      include 'include/catheader.php';

      include 'include/controllers.php';

      include 'include/db.php';

    



      if(isset($_SESSION['id'])){
        $uid = $_SESSION['id'];
      }
 ?>



<div class="main">
    <table class="cart-table">
      <thead>
        <tr>
          <th><h3>Item</h3></th>
          <th><h3>Price</h3></th>
          <th><h3>Quantity</h3></th>
          <th><h3>Total</h3></th>
          <th><h3>Update</h3></th>
          <th><h3>Remove</h3></th>
        </tr>
      </thead>
      <tbody>
        <tr>
            <?php

                  if(!isset($_SESSION['id'])){
                      $data = selectFromCart($conn, $sid);

                      while ($row = $data->fetch(PDO::FETCH_ASSOC)){
                        
                      $rowBook = getBookByID($conn, $row['book_id']);
                      
            ?>
          <td><div class="book-cover" style="background: url('../url<?php echo $rowBook['file_path']?>');
          background-size: cover;
          background-position: center;
          background-repeat: no-repeat;"></div></td>

          <td><p class="book-price"><?php echo $rowBook['price']?></p></td>
          <td><p class="quantity"><?php echo $row['quantity']?></p></td>
            
          <td><p class="total"><?php echo '$'.($rowBook['price'] * $row['quantity'])?></p></td>
          <td>
           <?php include 'update.php';?>
          </td>
          <td>

            <!-- <form class="update">
              <input type="number" class="text-field qty">
              <input type="submit" class="def-button change-qty" value="Change Qty">
            </form>
          </td>
          <td> -->
            <a href="<?php echo "delete.php?cart_id=".$row['cart_id'];?>" class="def-button remove-item">Remove Item</a>
          </td>
        </tr>
        <?php }}?>
            <?php
                  if(isset($_SESSION['id'])){
                    $data = selectFromCart($conn, $uid);
                    while ($row = $data->fetch(PDO::FETCH_ASSOC)) {
                        $rowBook = getBookByID($conn, $row['book_id']);
                    
                  
            ?>
          <td><div class="book-cover" style="background: url('../<?php echo $rowBook['file_path']?>');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;"></div></td>
          <td><p class="book-price"><?php echo $rowBook['price']?></p></td>
          <td><p class="quantity"><?php echo $row['quantity']?></p></td>
          <td><p class="total"><?php echo '$'.($rowBook['price'] * $row['quantity'])?></p></td>
          <td>
            <?php include 'update.php'; ?>
            <!-- <form class="update">
              <input type="number" class="text-field qty">
              <input type="submit" class="def-button change-qty" value="Change Qty">
            </form> -->
          </td>
          <td>
          <a href="<?php echo "delete.php?cart_id=".$row['cart_id'];?>" class="def-button remove-item">Remove Item</a>
          </td>
        </tr>
            <?php }}?>
        <tr>
            <?php
              if(isset($_SESSION['id'])) {
                $data = selectFromCart($conn, $uid);
                while ($row = $data->fetch(PDO::FETCH_ASSOC)) {
                  $rowBook = getBookByID($conn, $row['book_id']);
                
            ?>
          <td><div class="book-cover" style="background: url('../<?php echo $rowBook['file_path']?>'); 
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;"></div></td>
          <td><p class="book-price"><?php echo $rowBook['price']?></p></td>
          <td><p class="quantity"><?php echo $row['quantity']?></p></td>
          <td><p class="total"><?php echo '$'.($rowBook['price']* $row['quantity'])?></p></td>
          <td>
            <?php include 'update.php';?>
            <!-- <form class="update">
              <input type="number" class="text-field qty">
              <input type="submit" class="def-button change-qty" value="Change Qty">
            </form> -->
          </td>
          <td>
            <a href="<?php echo "delete.php?cart_id=".row['cart_id'];?>" class="def-button remove-item">Remove Item</a>
          </td>
        </tr>
            <?php }}?>
       <!--  <tr>
          <td><div class="book-cover" style="background: url('img/4.jpg');background-size: contain;background-position: center;background-repeat: no-repeat;"></div></td>
          <td><p class="book-price">$50</p></td>
          <td><p class="quantity">5</p></td>
          <td><p class="total">$250</p></td>
          <td>
            <form class="update">
              <input type="number" class="text-field qty">
              <input type="submit" class="def-button change-qty" value="Change Qty">
            </form>
          </td>
          <td>
            <a href="#" class="def-button remove-item">Remove Item</a>
          </td>
        </tr> -->
      </tbody>
    </table>
    <div class="cart-table-actions">
      <button class="def-button previous">previous</button>
      <button class="def-button next">next</button>
      <div class="index">
        <a href="#"><p>1</p></a>
        <a href="#"><p>2</p></a>
        <a href="#"><p>3</p></a>
      </div>
      <a href="checkout.php"><button class="def-button checkout">Checkout</button></a>
    </div>
    
  </div>

  
  <?php 
        include 'include/footer.php';
   ?>
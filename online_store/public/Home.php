<?php
      
      $page_title = 'Home';

      $body_id    = 'home';

      include 'include/user_header.php';

      include 'include/controllers.php';

      include 'include/class.RecentlyViewed.php';

     

      $recent = new RecentlyViewed();

      if (isset($_SESSION['id'])) {
        $uid = $_SESSION['id'];
      }

?>

<div class="main">
    <div class="book-display">


      <?php
        topSelling($conn, function($data){
      ?>
      <a href="<?php echo "preview.php?book_id=".$data['book_id']?>"><div class="display-book"
        style="background: url('../<?php echo $data['file_path'];?>');
        background-size: contain;
        background-position: center;
        background-repeat: no-repeat;"></div></a>
      <div class="info">
        <h2 class="book-title"><?php echo $data['title'];?></h2>
        <h3 class="book-author"><?php echo $data['author'];?></h3>
        <h3 class="book-price"><?php echo $data['price'];?></h3>

          <?php  }); ?>
        
      </div>
    </div>
    <div class="trending-books horizontal-book-list">
      <h3 class="header">Trending</h3>
      <ul class="book-list">
        <?php
              trending($conn, function($data){
                while ($row = $data->fetch(PDO::FETCH_ASSOC)) {
                  
                
        ?>
        <li class="book">
          <a href="<?php echo "preview.php?book_id=".$row['book_id']?>"><div class="book-cover" style="background: url('../<?php echo $row['file_path'];?>');
           background-size: cover;
           background-position: center;
           background-repeat: no-repeat; "></div></a>
          <div class="book-price"><p><?php echo $row['price'];?></p></div>
        </li>
        <?php  } });?>
        <!-- <li class="book">
          <a href="#"><div class="book-cover"></div></a>
          <div class="book-price"><p>$90</p></div>
        </li>
        <li class="book">
          <a href="#"><div class="book-cover"></div></a>
          <div class="book-price"><p>$250</p></div>
        </li>
        <li class="book">
          <a href="#"><div class="book-cover"></div></a>
          <div class="book-price"><p>$50</p></div>
        </li> -->
      </ul>
    </div>
    
    <div class="recently-viewed-books horizontal-book-list">
      <h3 class="header">Recently Viewed</h3>
      <ul class="book-list">
        <div class="scroll-back"></div>
        <div class="scroll-front"></div>
        <?php 
          rv($conn, function($data){
            while($row = $data->fetch(PDO::FETCH_ASSOC)){ ?>
        <li class="book">
          <a href="<?php echo "preview.php?book_id=".$row['book_id']?>"><div class="book-cover" style="background: url('../<?php echo $row['file_path'];?>');
          background-size: cover;
          background-position: center;
          background-repeat: no-repeat;"></div></a>
          <div class="book-price"><p><?php echo $row['price'];?></p></div>
        </li>
        <?php } });?>

         <?php 
        include "recentlyviewed.php"; ?>
      </ul>
    </div>
    
  </div>

 <?php 


 include 'include/footer.php';

  ?>

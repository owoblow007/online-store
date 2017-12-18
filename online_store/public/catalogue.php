<?php 
      
      $page_title = "Catalogue";

      $body_id    =  "catalogue";

      include 'include/db.php';

      include 'include/controllers.php';


      include 'include/user_header.php';

      
      //include 'include/side-bar.php';

      include 'include/class.Pagination.php';

      include 'include/class.RecentlyViewed.php';


      $recent = new RecentlyViewed();

      if(isset($_SESSION['id'])){
        $uid = $_SESSION['id'];
      }

      $paginate = new Pagination();
 ?>

 <?php
        include 'category.php';
 ?>



<div class="main">
    <div class="main-book-list horizontal-book-list">
      <ul class="book-list">

          <?php if(isset($_GET['cat_id'])){

            $catID = $_GET['cat_id'];
          } else{

            $catID = firstPreview($conn);

          }

          if (isset($_GET['p'])) {
             # code...
            $page = $_GET['p'];
           } else{
            $page = $paginate->all($conn, $catID);
           }
           if (isset($_GET['s'])) {
             # code...
            $start = $_GET['s'];
           }
           else{
            $start = 0;
           }

           $stmt = $conn->prepare("SELECT * FROM books WHERE category_id=:id LIMIT :start, 2 ");
           $stmt->bindParam(':id', $catID);
           $j = (int)$start;
           $stmt->bindParam(':start', $j, PDO::PARAM_INT);
           $stmt->execute();

           while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
             
           
          ?>

        <li class="book">

          <a href="<?php echo "preview.php?book_id=".$row['book_id']?>"><div class="book-cover"
            style="background: url('../<?php echo $row['file_path'];?>');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;"></div></a>
          <div class="book-price"><p><?php echo $row['price']?></p></div>
        </li>
        <?php } ?>
      </ul>
        <div class="actions">
          <?php
            $curpage = ceil($start / 2) + 1;
            $start   = ($curpage - 1) * 2;
            $next    = $start + 2;
            $prev    = $start - 2;

            if ($start > 0) {
              # code...
              echo '<a href="catalogue.php?p='.$page.'&s='.$prev.'&cat_id='.$catID.'"><button class="def-button next">Prev</button></a>';
            }
            if ($curpage != $page) {
              # code...
              echo '<a href="catalogue.php?p='.$page. '&s= .$next.&cat_id='.$catID.'"><button class="def-button next">Next</button></a>';
            }
          ?>
        </div>
        </div>
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
        </li>
        <li class="book">
          <a href="#"><div class="book-cover"></div></a>
          <div class="book-price"><p>$250</p></div>
        </li>
        <li class="book">
          <a href="#"><div class="book-cover"></div></a>
          <div class="book-price"><p>$50</p></div>
        </li>
        <li class="book">
          <a href="#"><div class="book-cover"></div></a>
          <div class="book-price"><p>$125</p></div>
        </li>
        <li class="book">
          <a href="#"><div class="book-cover"></div></a>
          <div class="book-price"><p>$90</p></div>
        </li>
      </ul>
      <div class="actions">
        <button class="def-button previous">Previous</button> 
        <button class="def-button next">Next</button> -->
      </div>
    </div>
    <div class="recently-viewed-books horizontal-book-list">
      <h3 class="header">&nbsp;&nbsp;&nbsp;&nbsp; Recently Viewed</h3>
      <ul class="book-list">
        <div class="scroll-back"></div>
        <div class="scroll-front"></div>
        <?php include 'recentlyviewed.php';?>
       <!--  <li class="book">
          <a href="#"><div class="book-cover"></div></a>
          <div class="book-price"><p>$250</p></div>
        </li>
        <li class="book">
          <a href="#"><div class="book-cover"></div></a>
          <div class="book-price"><p>$50</p></div>
        </li>
        <li class="book">
          <a href="#"><div class="book-cover"></div></a>
          <div class="book-price"><p>$125</p></div>
        </li>
        <li class="book">
          <a href="#"><div class="book-cover"></div></a>
          <div class="book-price"><p>$90</p></div>
        </li>  -->
      </ul>
    </div>
    
  </div>

   <?php 
          include 'include/catfooter.php';
   ?>
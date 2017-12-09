<?php



$page_title = "ADD PRODUCTS";
$selectedLnk= "products.php"; $selected_name="PRODUCTS";
$firstLnk = "adminhome.php" ; $first_name = "HOME";
$secondLnk = "category.php"; $second_name = "CATEGORY";
$thirdLnk = "addProducts.php"; $third_name = "ADD PRODUCTS";
$forthLnk = ""; $forth_name = "";


$page_title = "Products";
include 'include/db.php';
include 'include/header2.php';
include 'include/functions.php';



 ?>
 <table id="tab">



   <thead>
     <tr>
       <th>Book id</th>
       <th>Title</th>
       <th>Author</th>
       <th>Category</th>
       <th>Price</th>
       <th>Year</th>
       <th>ISBN</th>
       <th>File Path</th>
       <th>Flag</th>

     </tr>
   </thead>
   <tbody>
     <?php

     viewProducts($conn);


     ?>

         </tbody>
 </table>
         </tbody>
 </table>
<?php
include 'include/footer.php';
?>
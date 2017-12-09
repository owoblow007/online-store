<?php 

			$page_title = "Book Preview";

			$body_id    = "bookpreview";

			include 'include/db.php';

			include 'include/functions.php';

			include 'include/header3.php';

			include 'include/class.RecentlyViewed.php';

			$recent = new RecentlyViewed();

			if(isset($_SESSION['id'])){
				$uid = $_SESSION['id'];
			}

			if(isset($_GET['book_id'])){
				$item = getBookByID($conn, $_GET['book_id']);
			}

			if(!isset($_SESSION['id'])){
				$recent->insertIntoRecentlyViewed($conn, $sid, $item['book_id']);
			}

			else{
				$recent->insertIntoRecentlyViewed($conn, $uid, $item['book_id']);
			}

			if(array_key_exists('submit', $_POST)){
				$clean = array_map('trim', $_POST);

				insertIntoReview($conn, $uid, $item['book_id'], $clean);
			}

			$errors = [];

			if(array_key_exists('enter', $_POST)){
				if(empty($_POST['quantity'])){
					$errors['quantity'] = 'You have not chosen any amount!';
				}
				if(empty($errors)){
					$clean = array_map('trim', $_POST);

					if(!$_SESSION['id']){
						addToCart($conn, $sid, $item['book_id'], $clean);
					}
					else{
						addToCart($conn, $uid, $item['book_id'], $clean);
					}
					redirect("preview.php?book_id=".$item['book_id']);

				}
			}

 ?>

 <div class="main">
 	<p class="global-error"> <?php if(isset($errors['quantity'])) { echo $errors['quantity']; }?></p>
<div class="book-display">
	<div class="display-book" style="background: url('../<?php echo $item['file_path']; ?>');
	background-size: cover;
	background-position: center;
	background-repeat: no-repeat;"></div>

<div class="info">
	<h2 class="book-title"><?php echo $item['title'];?></h2>
	<h3 class="book-author"><?php echo $item['author'];?></h3>
	<h3 class="book-price"><?php echo $item['price']; ?></h3>

	<form action="<?php echo "preview.php?book_id=".$item['book_id'];?>" method="POST">
		<label for="book-amount">Quantity</label>
		<input type="number" min="0" class="book-amount text-field" name="quantity">
		<input class="def-button add-to-cart" type="submit" name="enter" value="Add to Cart">
	</form>
</div>	
</div>
 <div class="book-reviews">
 	<h3 class="header">Reviews</h3>
 	<ul class="review-list">
 		
 		<?php
 			$view = ViewReview($conn, $item['book_id']);
 			echo $view;
 		?>
 	</ul>
 	<div class="add-comment">
 		<h3 class="header">Add your Comment</h3>
 		

 		<form class="comment" action="<?php echo "preview.php?book_id=".$item['book_id'];?>" method="POST">
 			<textarea class="text-field" name="review" placeholder="write something"></textarea>

 		<button class="def-button post-comment" type="submit" name="submit">ADD COMMENT</button>	
 		</form>
 	</div>
 	</div>	
 	</div>

 	<?php
 			include 'include/footer.php';
 	?>
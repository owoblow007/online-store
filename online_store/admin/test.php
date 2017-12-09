<?php 
		//progarm to an interface not an implementation
		//favor composition over inheritance
		interface iDownloadable{
			public function downloadLink();
		}
	
		abstract class Product {
			protected $title;
			protected $price;
			protected $type;

			/*public function __construct($title, $price){
				$this->title = $title;
				$this->price = $price;
			}*/

			/*public function setTitle($title) {
				$this->title = $title;
			}*/
			public function getTitle(){
				return $this->title;
			}
			public function getPrice(){
				return $this->price;
			}
			public function getType(){
				return $this->type;
			}
			public abstract function display();
		}

		//instatiating
		//$prod = new Product("a bronze head", 300, "book");
		//echo $prod->getTitle();
		

		class Book extends Product implements iDownloadable {
			private $pageCount;

			public function __construct($title, $price, $pages){

					//call an overridden constructor
					//parent::__construct($title, $price);
					$this->type = "Book";
					$this->title = $title;
					$this->price = $price;
					$this->pageCount = $pages;
					
			}

			public function setPageCount($pages){
				$this->pageCount = $pages;
			}

			public function getPageCount(){
				return $this->pageCount;
			}
			public function display(){
					echo $this->getType();
					echo "-";
					echo $this->getTitle();
					echo "-";
					echo $this->getPrice();
					echo '-';
					echo $this->getPageCount();
			}

			/* @override */
			public function downloadLink(){}
		}

		class DVD extends Product implements iDownloadable{
			private $lengthCount;
			private $genre;

			public function __construct($title, $price, $length){
					//parent::__construct($title, $price);
					$this->type = "DVD";
					$this->title = $title;
					$this->price = $price;
					$this->lengthCount = $length;
					//$this->genre = $genre; 
			}
			public function setlengthCount($length){
				$this->lengthCount = $length;
			}
			public function getlengthCount(){
				return $this->lengthCount;
			}
			public function display(){
				echo $this->getType();
				echo "-";
				echo $this->getTitle();
				echo "-";
				 echo $this->getLengthCount();	

			}
			public function downloadLink(){}
		}
		class Shoe extends Product{
			protected $size;

			public function __construct($title, $price, $size) {
				$this->type = "Shoes";
				$this->title = $title;
				$this->price = $price;
				$this->size = $size;
			}
			public function getSize(){
				return $this->size;
			}
			public function display(){
				echo $this->getType();
				echo '-';
				echo $this->getSize();
			}
		}
		 $newBook = new Book("measuring time", 200, 1000);
		 echo $newBook->display();
		// echo '<hr>';
		// echo $newBook->getPageCount();

		 echo "<hr>";

		 $newDVD = new DVD("The Flash", 500, 350);
		 	echo $newDVD->display();
		 //echo $newDVD->getTitle();
		// echo $newDVD->getType();
		 //echo "<hr>";
		 //echo $newDVD->getLengthCount();

		 echo '<hr>';

		 $newShoes = new Shoe('Black Shoes', '$200', 45);
		 echo $newShoes->display();
 ?>
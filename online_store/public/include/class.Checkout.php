<?php
		class Checkout {
			private $total;
			private $totalPur = 0;
			private $quantity;
			private $tq = 0; //Total Quantity
			private $sub;  //Price From Book Table Without the Dollar sign



				private function GetItemPrice($dbconn, $bkid) {
					$statement = $dbconn->prepare("SELECT * FROM books WHERE book_id=:bi");
					$statement->bindParam(':bi', $bkid);
					$statement->execute();

					$rowBook = $statement->fetch(PDO::FETCH_ASSOC);
					$this->sub = substr($rowBook['price'], 1);
				}

				private function SelectFromCart($dbconn, $userID){
					$stmt = $dbconn->prepare("SELECT * FROM cart WHERE user_id=:id");
					$stmt->bindParam(':id', $userID);
					$stmt->execute();

					return $stmt;
				}

				public function getTotal($dbconn, $userID){

					$cart = $this->SelectFromCart($dbconn, $userID);
					
						# code...
						while ($row = $cart->fetch(PDO::FETCH_ASSOC)) {
							
							$this->GetItemPrice($dbconn, $row['book_id']);
							$this->total = $this->sub *$row['quantity'];
							$this->totalPur += $this->total;
						}
						return $this->totalPur;
					}
				public function quantity($dbconn, $userID){

					$cart = $this->SelectFromCart($dbconn, $userID);

					while($row = $cart->fetch(PDO::FETCH_ASSOC)) {
						$this->quantity = $row['quantity'];
						$this->tq += $this->quantity;
					}
					return $this->tq;
				}	

					public function insertIntoCheckout($dbconn, $userID, $input, $tp) {

						$stmt = $dbconn->prepare("INSERT INTO checkout(phoneNumber, address, post_code, user_id, total_purchase) VALUES(:pn, :ad, :pc, :ui, :tp)");

						$data = [

									':pn'=>$input['phoneNumber'],
									':ad'=>$input['address'],
									':pc'=>$input['code'],
									':ui'=>$userID,
									':tp'=>$tp

						];
						$stmt->execute($data);
						redirect("Home.php?msg=Thank You For Shopping With Us, Your Goods will be shipped to you within 2days");
					}

				}
		

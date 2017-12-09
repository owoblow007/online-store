<?php

function doesEmailExist($dbconn, $input){ #placeholders are just there
  $result = false;

  $stmt = $dbconn -> prepare("SELECT * FROM admin WHERE email = :em");
  $stmt->bindParam(":em",$input);
  $stmt->execute();
  $count = $stmt->rowCount();
  if($count>0){
    $result = true;
  }
  return $result;
}




function doAdminRegister($dbconn, $input){
$hash = password_hash($input['password'], PASSWORD_BCRYPT);

#insert data

$stmt = $dbconn->prepare("INSERT INTO admin(firstname,lastname,email,hash) VALUES(:fn, :ln, :e, :h)");

#bind params...
$data = [ ':fn' => $input['fname'],
  ':ln' => $input['lname'],
  ':e' => $input['email'],
  ':h' => $hash
];

$stmt->execute($data);
}







function displayErrors($error, $field)
{
  $result= "";
  if (isset($error[$field]))
  {
    $result = '<span class="err">'.$error[$field].'</span>';
  }
  return $result;
}


function adminLogin($dbconn, $input){
  $result = [];

  $stmt = $dbconn->prepare("SELECT * FROM admin WHERE email = :e ");

  $stmt ->bindParam(":e", $input['email']);
  $stmt->execute();

  $row = $stmt->fetch(PDO::FETCH_BOTH);

  if($stmt->rowCount() !=1 || !password_verify($input['password'], $row['hash'])){
    header('Location:adminlogin.php?msg=incorrect email or password');
    exit();
  }else{
    $result[] = true;
    $result[] = $row;
    extract ($row);
    $_SESSION['id'] = $admin_id;
    $_SESSION['email'] = $firstname;

    header("Location:adminhome.php");
  }

return $result;
//return $_SESSION['name'];

}



function addCategory($dbconn, $post){

$stmt = $dbconn->prepare("INSERT INTO category(category_name, date_created) VALUES(:cat,NOW())");

$stmt->bindParam(":cat",$post['categ']);

$stmt->execute();

$success = "Category Succefully Added";
header("Location:category.php?success=$success");
}


function viewProducts($dbconn){



  $stmt = $dbconn->prepare("SELECT * FROM books");

  $stmt->execute();

  while($record = $stmt->fetch()){

echo "<tr>";
echo "<td>".$record['book_id']."</td>";

echo "<td>".$record['title']."</td>";
echo "<td>".$record['author']."</td>";
echo "<td>".$record['cat_id']."</td>";
echo "<td>".$record['price']."</td>";
echo "<td>".$record['year']."</td>";
echo "<td>".$record['isbn']."</td>";
echo "<td>".$record['image_path']."</td>";
echo "<td>".$record['flag']."</td>";

echo "<td><a href=\"editProducts.php?book_id=".$record['book_id']."\">edit</a></td>";
echo "<td><a href=\"deleteProducts.php?book_id=".$record['book_id']."\">delete</a></td>";
echo "</tr>";
  }
}



function viewCategories($dbconn){



  $stmt = $dbconn->prepare("SELECT * FROM category");

  $stmt->execute();

  while($record = $stmt->fetch()){

echo "<tr>";
echo "<td>".$record['category_id']."</td>";

echo "<td>".$record['category_name']."</td>";
echo "<td>".$record['date_created']."</td>";
echo "<td><a href=\"editCategory.php?id=".$record['category_id']."&name=".$record['category_name']."\">edit</a></td>";
echo "<td><a href=\"deleteCategory.php?id=".$record['category_id']."&name=".$record['category_name']."\">delete</a></td>";
echo "</tr>";
  }
}


function viewCategory($dbconn){



  $stmt = $dbconn->prepare("SELECT * FROM category");

  $stmt->execute();

  while($record = $stmt->fetch()){
    extract($record);


echo "<option value=\" $category_name\">$category_name</option>";
  }
}



function editCategory($dbconn, $post, $get){

  $stmt = $dbconn->prepare("UPDATE category SET category_name=:name WHERE category_id= :id");

  $stmt->bindParam(":name" , $post['category']);
  $stmt -> bindParam(":id", $get['id']);
  $stmt->execute();

  header("Location:category.php");
}

function getCategoryById($dbconn,$get){
$stmt= $dbconn->prepare("SELECT * FROM category WHERE category_id = :cat");

$stmt->bindParam(":cat", $get['id']);
$stmt->execute();

$cal = $stmt->fetch(PDO::FETCH_BOTH);
extract($cal);



return $category_name;




}


function getProductNameById($dbconn,$get){
$stmt= $dbconn->prepare("SELECT * FROM books WHERE book_id = :cat");

$stmt->bindParam(":cat", $get['book_id']);
$stmt->execute();

$cal = $stmt->fetch(PDO::FETCH_BOTH);
extract($cal);



return $title;




}





function deleteCategory($dbconn, $get){



  $stmt= $dbconn->prepare("DELETE FROM category WHERE category_id=:id");

  $stmt -> bindParam(":id", $get['id']);

  $stmt->execute();
header("Location:category.php");

}



function deleteProduct($dbconn, $get){



  $stmt= $dbconn->prepare("DELETE FROM books WHERE book_id=:id");

  $stmt -> bindParam(":id", $get['book_id']);

  $stmt->execute();
header("Location:products.php");

}


function uploadFiles($input, $name, $upDIR){
  $result = [];

  $rnd = rand(0000000, 9999999);
  $strip_name = str_replace(" ", "_", $input[$name]['name']);

  $filename= $rnd.$strip_name;
  $destination = $upDIR.$filename;

  if(!move_uploaded_file($input[$name]['tmp_name'], $destination)){
    $result[] = false;

}else{
    $result[] = true;
    $result[] = $destination;
}
return $result;
}

function addProducts($dbconn,$post,$destination){

$stmt = $dbconn->prepare("INSERT INTO books VALUES(NULL,:title,:author,:cat_id,:price,:year,:isbn,:destn,:fl)");


    $data = [
      ':title' => $post['title'],
    ':author' => $post['author'],
    ':cat_id' => $post['cat'],
    ':price' => $post['price'],
    ':year' => $post['year'],
    ':isbn' => $post['isbn'],
    ':fl' => $post['img'],
    ':destn' => $destination
  ];

   $stmt->execute($data);

    $success = "product Successfully added";

    header("Location:addProducts.php?success=$success");
}

function getProductById($dbconn,$get){


$stmt= $dbconn->prepare("SELECT * FROM books WHERE book_id = :cat");

$stmt->bindParam(":cat", $get['book_id']);
$stmt->execute();

$cal = $stmt->fetch(PDO::FETCH_BOTH);




return $cal;




}


function editProducts($dbconn,$post,$destination,$get){
$result = [];
$stmt = $dbconn->prepare("UPDATE books SET title=:title, author=:author, cat_id=:category, price=:price, year=:year, isbn=:IS, image_path=:destn, flag=:fl WHERE book_id =:id");


    $data = [
      ':title' => $post['title'],
    ':author' => $post['author'],
    ':category' => $post['cat'],
    ':price' => $post['price'],
    ':year' => $post['year'],
    ':IS' => $post['isbn'],
    ':fl' => $post['img'],
    ':destn' => $destination,
    ':id' => $get['id']
  ];

    $stmt->execute($data);


    $success = "Done";
    header("Location:products.php?success=$success");
}


function doesUserNameExist($dbconn, $input){
      $result = false;

    $stmt = $dbconn->prepare("SELECT * FROM user WHERE username = :un");
    $stmt->bindparams(':un', $input);
    $stmt->execute();
    $count = $stmt->rowCount();
    if($count>0){
        $result = true;
      }
        return result;
    }

    function doesMailExist($dbconn, $mail){
      $result = false;

      $stmt = $dbconn->prepare("SELECT * FROM user WHERE email = :em");
      $stmt->bindparams(":em", $mail);
      $stmt->execute();
      $check = $stmt->rowCount();
      if($check>0){
        $result = true;
      }

      return $result;
    }
  
  function doUserRegistration($dbconn, $input){
    $hash = password_hash($input['password'], PASSWORD_BCRYPT);

    $stmt = $dbconn->prepare("INSERT INTO user(firstname, lastname, email, username, hash) VALUES(:fn, :ln, :em, :us, :h");
    $data = [':fn' => $input['fname'],
         ':ln' => $input['lname'],
         ':em' => $input['mail'],
         ':us' => $input['name'],
         ':h'  => $hash
  ];
    $stmt->execute($data);

  }
  function displayError($show, $errors){
      $result = '';
      if(isset($show[$errors])){
        $result = "<span class='form-error'>.$show[$error].</span>";
      }
      return $result;
  }

 ?>

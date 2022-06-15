<?php
session_start();
include_once("../connect/connectDB.php");
$product = getProducts($conn);

if (isset($_SESSION['id'])) {
  if (isset($_POST['save_pr'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $account_id = $_SESSION['id'];
    $category_id = $_POST['category_id'];

    $sql = "INSERT INTO products (name,price, quantity,account_id,category_id) 
    VALUES ('$name', '$price', '$quantity', '$account_id', '$category_id')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
      $id = mysqli_insert_id($conn);
      $filename = $_FILES["images"]["name"];
      $tempname = $_FILES["images"]["tmp_name"];
      $folder = "../images/" . $filename;

      $sql = "INSERT INTO product_images (images,productID) VALUES ('$filename','$id')";
      $result = mysqli_query($conn, $sql);
      if (move_uploaded_file($tempname, $folder)) {
        echo "<h3>  Image uploaded successfully!</h3>";
      } else {
        echo "<h3>  Failed to upload image!</h3>";
      }
    }
    $_SESSION['message'] = "Create new product successfully";
    header('location: listProduct.php');
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <title>Create Users</title>
</head>

<body>
  <h2>Create Products</h2>
  <form action="createProduct.php" method="post" enctype="multipart/form-data" class="form-horizontal" id="createForm">
    <div class="form-group">
      <label class="control-label col-sm-2" for="name">Name <span class="text-danger">(*)</span>:</label>
      <div class="col-sm-6">
        <input type="text" name="name" class="form-control" id="name" placeholder="Enter name">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="price">Price<span class="text-danger">(*)</span>:</label>
      <div class="col-sm-6">
        <input type="text" name="price" class="form-control" id="price" placeholder="Enter price">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="name">Quantiy<span class="text-danger">(*)</span>:</label>
      <div class="col-sm-6">
        <input type="text" name="quantity" class="form-control" id="quantity" placeholder="Enter quantity">
      </div>
    </div>
    <div class="form-group">
      <div class="form-group">
        <label class="control-label col-sm-2" for="category_id">Category_id <span class="text-danger">(*)</span>:</label>
        <div class="col-sm-6">
          <select name="category_id" class="form-control" id="category_id">
            <?php $category = getCategory($conn);
            foreach ($category as $cat) {
              echo "<option value='" . $cat->id . "'>" . $cat->title . "</option>";
            }
            ?>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-2" for="Image">Image:</label>
        <div class="col-sm-6">
          <input type="file" name="images">
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
          <button type="submit" name="save_pr" class="btn btn-default">Create Products</button>
        </div>
      </div>
  </form>
</body>

</html>

<?php

function getCategory($conn)
{
  $category = [];
  $sql = "SELECT id,title FROM categories ";
  if ($result = $conn->query($sql)) {
    while ($obj = $result->fetch_object()) {
      $category[] = $obj;
    }
    $result->close();
  }
  return $category;
}

function getProducts($conn)
{
  $product = "";
  $sql = "SELECT products.*, accounts.name as account_name,categories.title as categoriy_title FROM products INNER JOIN accounts ON products.account_id = accounts.id INNER JOIN categories ON products.category_id = categories.id";
  if ($result = $conn->query($sql)) {
    $product = mysqli_fetch_object($result);
    $result->close();
  }
  return $product;
}

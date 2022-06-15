<?php
include_once("../connect/connectDB.php");
session_start();
if (!isset($_SESSION['email'])) {
  header("location: login.php");
}
if (isset($_GET['logout'])) {
  session_destroy();
  unset($_SESSION['email']);
  header("location: ../login.php");
}
?>

<?php if (isset($_SESSION['email'])) : ?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>List Product</title>
  </head>

  <body>
    <nav class="navbar navbar-inverse">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="#"></a>
        </div>
        <ul class="nav navbar-nav">
          <li class="active"><a href="#">Home</a></li>
          <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Page 1 <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="#">Page 1-1</a></li>
              <li><a href="#">Page 1-2</a></li>
              <li><a href="#">Page 1-3</a></li>
            </ul>
          </li>
          <li><a href="#">Page 2</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="#"><span class="glyphicon glyphicon-user"><?php echo $_SESSION['name']; ?></span></a></li>
          <li><a href="listProduct.php?logout"><span class="glyphicon glyphicon-log-in"></span> Log out</a></li>
        </ul>
      </div>
    </nav>
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3">
          <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') : ?>
            <a href="../admin/listAdministration.php" class="list-group-item">Admin Management</a>
          <?php endif ?>
          <a href="../product/listProduct.php" class="list-group-item">Products Management</a>
        </div>
        <div class="col-sm-9">
          <h2>List of Products</h2>
          <p><a href="../product/createProduct.php" class="btn btn-primary">Create new products</a></p>
          <table class="table">
            <?php
            if (isset($_SESSION['message'])) {
              echo $_SESSION['message'];
              unset($_SESSION['message']);
            }
            $result = getProducts($conn);
            if ($result->num_rows) {
              echo "<table border='1'>
                      <tr>
                          <th>ID</th>
                          <th>Image</th>
                          <th>Name</th>
                          <th>Price</th>
                          <th>Quantity</th>
                          <th>Category_ID</th>
                          <th>Account</th>
                          <th>Created_at</th>
                          <th>Update_at</th>
                          <th>Action</th>
                      </tr>";
              $k = 1;
              while ($row = $result->fetch_assoc()) {

                echo "<tr>";
                echo "<td>" . $k++ . "</td>";
                echo "<td><img  style = 'width:50px;height:50px;' src='../images/" . $row['pr_images'] . "'></td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['price'] . "</td>";
                echo "<td>" . $row['quantity'] . "</td>";
                echo "<td>" . $row['category_id'] . "</td>";
                echo "<td>" . $row['name_account'] . "</td>";
                echo "<td>" . $row['created_at'] . "</td>";
                echo "<td>" . $row['updated_at'] . "</td>";
                echo "<td>
                        <a href='../product/handlerPR.php?pid={$row['id']}'>Delete</a> || 
                        <a href='../product/detail.php?detailid={$row['id']}'>Detail</a> || 
                        <a href='../product/edit.php?id={$row['id']}'>Edit</a>
                      </td>";
                echo "</tr>";
              }
            } else {
              echo "0 results";
            }
            $conn->close();
            ?>

          </table>
        </div>
      </div>
    </div>
    <footer style="text-align:center; margin-top:100px; background-color:aliceblue">
      <p>Author: Huumanh</p>
      <p><a href="mailto:Huumanh@example.com">Huumanh@example.com</a></p>
    </footer>
  </body>

  </html>

<?php endif ?>
<?php

function getProducts($conn)
{

  if ($_SESSION['role'] == 'admin') {
    $sql = "SELECT products.*, product_images.images as pr_images, accounts.name as name_account
      FROM products INNER JOIN product_images 
      ON product_images.productID = products.id INNER JOIN accounts 
      ON accounts.id = products.account_id";
    if ($result = $conn->query($sql)) {
      return $result;
    }
  }
  $id = $_SESSION['id'];
  $sql = "SELECT products.*, product_images.images as pr_images, accounts.name as name_account
    FROM products INNER JOIN product_images 
    ON product_images.productID = products.id INNER JOIN accounts 
    ON accounts.id = products.account_id WHERE products.account_id = $id";
  if ($result = $conn->query($sql)) {
    return $result;
  }
}

?>

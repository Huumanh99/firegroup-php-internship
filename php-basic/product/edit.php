<?php
session_start();
include_once("../connect/connectDB.php");
include("./handlerPR.php");

if (!isset($_GET['edit'])) {
    $id = isset($_GET['id']) ? (int)$_GET['id'] : '';
    $update = true;
    $record =  getProduct($conn, $id);

    if (count($record) > 0) {
        $record = getProduct($conn, $id);
        $name =  $record['name'];
        $price = $record['price'];
        $quantity =  $record['quantity'];
        $account_id = $_SESSION['id'];
        $category_id = $record['category_id'];
        $record = $record['images'];
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
    <title>Edit User</title>
</head>

<body>
    <h2>Edit user</h2>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="row mb">
                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal" id="createForm">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="name">Name <span class="text-danger">(*)</span>:</label>
                            <div class="col-sm-6">
                                <input type="text" name="name" class="form-control" value="<?php echo $name; ?>" id="name" placeholder="Enter name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="price">Price<span class="text-danger">(*)</span>:</label>
                            <div class="col-sm-6">
                                <input type="text" name="price" class="form-control" value="<?php echo $price; ?>" id="price" placeholder="Enter price">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="name">Quantiy<span class="text-danger">(*)</span>:</label>
                            <div class="col-sm-6">
                                <input type="text" name="quantity" class="form-control" value="<?php echo $quantity; ?>" id="quantity" placeholder="Enter quantity">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="category_id">Category_id <span class="text-danger">(*)</span>:</label>
                                <div class="col-sm-6">
                                    <select name="category_id" class="form-control" id="category_id">
                                        <?php $category = getCategories($conn);
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
                                    <button type="submit" name="update_pr" class="btn btn-default">Update Products</button>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<?php
function getProduct($conn, $id)
{
    $product = "";
    $sql = "SELECT * FROM products INNER JOIN product_images ON products.id = product_images.productID WHERE products.id = $id";
    if ($result = $conn->query($sql)) {
        $product = mysqli_fetch_array($result);
        $result->close();
    }
    return $product;
}

function getCategories($conn)
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

?>

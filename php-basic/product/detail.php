<?php include_once("../connect/connectDB.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Detail</title>
</head>

<body>
    <div class="col-sm-9">
        <h2>Detail Products</h2>
        <table class="table">
            <?php

            $result = getProducts($conn);
            if ($result->num_rows) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "Images: <img  style = 'width:50px;height:50px;' src='../images/" . $row['pr_images'] . "'><br>";
                    echo "Account: " . $row['name_account'] . "<br>";
                    echo "Name:" . $row['name'] . "<br>";
                    echo "Price:" . $row['price'] . "<br>";
                    echo "Quantity" . $row['quantity'] . "<br>";
                    echo "<td>" . $row['name_account'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "0 results";
            }
            $conn->close();
            ?>

        </table>
    </div>
</body>

</html>
<?php

function getProducts($conn)
{
    $accountId = $_GET['detailid'];
    $sql = "SELECT products.*, product_images.images as pr_images, accounts.name as name_account
    FROM products INNER JOIN product_images 
    ON product_images.productID = products.id INNER JOIN accounts 
    ON accounts.id = products.account_id WHERE products.id = $accountId";

    if ($result = $conn->query($sql)) {
        return $result;
    }
}
return false;

?>

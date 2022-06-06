<?php
    include_once("./connect/connectDB.php");
    $sql = "select * from products";
    $result = mysqli_query($conn,$sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body>
    <div class="boxcenter" style =" margin: 20px; flex-direction: column;
    align-items: center; display: flex;
    gap: 10px;">
        <div class="row mb header" style="text-align:center;">
            <h1>SHOPPING</h1>
        </div>
        <div class="row mb menu">
            <a href="list_cart.php ">
                <em class="fa fa-shopping-cart" style="font-size:20px;color:red; float: right;">Giỏ hàng<sup tyle="font-size:100px">
                    <?php session_start(); if(!empty ( $_SESSION['cart'])) {echo count( $_SESSION['cart']);} ?></sup>
                </em>
                    <?php if( isset( $_SESSION['user_id'] ) ): ?>
                    <p class="text-danger"> <?= $_SESSION['success'] ?></p>
                <?php 
                    'endif'; 
                    unset($_SESSION["success"]);
                ?><?php endif; ?>
            </a>
        </div>
        <div class="row mb" style="text-align:center;width: 100%;display: flex; justify-content: center;">
            <?php
            $sql = "SELECT * FROM products";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // output dữ liệu trên trang
                echo "<table border='1'>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Produced_date</th>
                    </tr>";
                while ($row = $result->fetch_assoc()) { 
                    echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['quantity'] . "</td>";
                        echo "<td>" . $row['price'] . "</td>";
                        echo "<td>" . $row['produced_date'] . "</td>";
                        echo "<td><a href =cart.php?id={$row['id']}>Add To Cart</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "0 results";
            }
            $conn->close();
            ?>
        </div>
    </div>
</body>

</html>

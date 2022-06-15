<?php
include_once("./connect/connectDB.php");
session_start();

//Get id shopping cart
$id = isset($_GET['id']) ? (int)$_GET['id'] : '';
$product = getProduct($conn, $id);

if (!empty($product)) {

    if (!empty($_SESSION['cart'])) {

        if ($_SESSION['cart'][$id]['quantity'] >= $product->quantity) {
            $_SESSION['message'] = 'Quantity only ' . $product->quantity . ' ';
        } else {
            if (isset($_SESSION['cart'][$id])) {
                $qty = $_SESSION['cart'][$id]['quantity'] += 1;
            } else {
                $qty = $_SESSION['cart'][$id]['quantity'] = 1;
            }

            $_SESSION['cart'][$id] = array(
                'id' => $product->id,
                'quantity' => $qty,
                'name' => $product->name,
                'price' => $product->price,
                'produced_date' => $product->produced_date,
            );

            $_SESSION['message'] = 'Add to cart successfully';
        }
        header("Location: products.php");
        exit();
    } else {
        //Not existed yet
        $_SESSION['cart'][$id] = array(
            'id' => $product->id,
            'quantity' => 1,
            'name' => $product->name,
            'price' => $product->price,
            'produced_date' => $product->produced_date,
        );
        $_SESSION['message'] = 'Created successfully';
        header("Location: products.php");
        exit();
    }
} else {
    $_SESSION['message'] = 'Truyền ' . $id . '  không có trong DB';
    header("Location: products.php");
    exit();
}

function getProduct($conn, $id)
{
    $product = "";
    $sql = "SELECT * FROM carts WHERE id = $id";
    if ($result = $conn->query($sql)) {
        $product = mysqli_fetch_object($result);
        $result->close();
    }

    return $product;
}

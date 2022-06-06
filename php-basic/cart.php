<?php
include_once("./connect/connectDB.php");
session_start();

//Lấy id sản phẩm cần thêm vào giỏ hàng
$id = isset($_GET['id']) ? (int)$_GET['id'] : '';
$product = getProduct($conn, $id)[0];
if ($product) {
    if (isset($_SESSION['cart'])) {
        // Đã tồn tại
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

        $_SESSION['success'] = 'Tồn tại giỏ hàng ! cập nhật mới thành công';
        header("Location: products.php");
        exit();
    } else {
        $_SESSION['cart'][$id] = array(
            'id' => $product->id,
            'quantity' => 1,
            'name' => $product->name,
            'price' => $product->price,
            'produced_date' => $product->produced_date,
        );
        $_SESSION['success'] = 'Tạo mới thành công';
        header("Location: products.php");
        exit();
    }
} else {
    $_SESSION['success'] = 'Không tồn tại sản phẩm trong db';
    header("Location: products.php");
    exit();
}

function getProduct($conn, $id)
{
    $products = [];
    $sql = "SELECT * FROM products WHERE id = $id";
    if ($result = $conn->query($sql)) {
        while ($row = $result->fetch_object()) {
            $products[] = $row;
        }
        $result->close();
    }

    return $products;
}

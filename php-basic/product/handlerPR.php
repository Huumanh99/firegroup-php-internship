<?php

include_once("../connect/connectDB.php");

$id = isset($_GET['id']) ? (int)$_GET['id'] : '';

//Edit   
if (isset($_POST['update_pr'])) {
        if (isset($_SESSION['name'])) {
                $name = $_POST['name'];
                $price = $_POST['price'];
                $quantity = $_POST['quantity'];
                $category_id = $_POST['category_id'];
                $account_id = $_SESSION['id'];
                $sql = "UPDATE products SET name='" . $name . "',price=$price, quantity=$quantity, account_id=$account_id, category_id=$category_id  WHERE id=$id ";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                        $filename = $_FILES["images"]["name"];
                        $tempname = $_FILES["images"]["tmp_name"];
                        $folder = "../images/" . $filename;
                        $sql = "UPDATE product_images SET images ='" . $filename . "' WHERE productID=$id";
                        $result = mysqli_query($conn, $sql);
                        if (move_uploaded_file($tempname, $folder)) {
                                echo "<h3>  Image uploaded successfully!</h3>";
                        } else {
                                echo "<h3>  Failed to upload image!</h3>";
                        }
                }
                $_SESSION['message'] = "Update '.$id.' successfully";
                header('location: listProduct.php');
        }
}

//Delete 
if (isset($_GET['pid'])) {
        session_start();
        $productId = $_GET['pid'];
        $loggedUserId = $_SESSION['id'];
        $loggedUserRole = $_SESSION['role'];

        $product = mysqli_query($conn, "SELECT account_id  FROM products WHERE id=$productId");
        $accountId =  $product->fetch_object()->account_id;

        $productAccount = getAccount($conn, $accountId);
        if (!$productAccount) {
                $_SESSION['message'] = "Not found product account";
                header('Location: listProduct.php');
                exit;
        }

        if ($loggedUserRole == 'admin' && $productAccount->role == 'admin' && $accountId != $loggedUserId) {
                $_SESSION['message'] = "Can not delete product";
                header('Location: listProduct.php');
                exit;
        }

        mysqli_query($conn, "DELETE FROM products WHERE id=$productId");
        $_SESSION['message'] = "Delete $productId successfully";
        header('Location: listProduct.php');
}

function getAccount($conn, $id)
{
        $account = mysqli_query($conn, "SELECT id, name, email, role FROM accounts where id=$id");
        if ($res = $account->fetch_object()) {
                return $res;
        }
        $conn->close();
        return false;
}

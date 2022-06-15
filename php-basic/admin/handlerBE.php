<?php
session_start();
include_once("../connect/connectDB.php");
$role = "";
$name = "";
$email = "";
$password = "";
$id = isset($_GET['id']) ? (int)$_GET['id'] : '';

//Edit
if (isset($_POST['update'])) {
    if ($_POST['role'] == 'admin') {
        $accounts = mysqli_query($conn, "SELECT *  FROM accounts WHERE id = $id");
        if ($accounts->fetch_assoc()['role'] == 'admin') {
            $_SESSION['message'] = "You can not update '.$id.' Admin";
            header('location: listAdministration.php');
        } else {
            $role = $_POST['role'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            mysqli_query($conn, "UPDATE accounts SET role='$role',name='$name', email='$email' WHERE id=$id");
            $_SESSION['message'] = "Update '.$id.' successfully";
            header('Location: listAdministration.php');
        }
    } else {
        $accounts = mysqli_query($conn, "SELECT *  FROM accounts WHERE id = $id");
        if ($accounts->fetch_assoc()['role'] == 'user') {
            $role = $_POST['role'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            mysqli_query($conn, "UPDATE accounts SET role='$role',name='$name', email='$email' WHERE id=$id");
            $_SESSION['message'] = "Update '.$id.' successfully";
            header('Location: listAdministration.php');
        }
    }
}

//Delete
if (isset($_GET['aid'])) {
    $accountId = $_GET['aid'];
    if ($_SESSION['role'] == 'admin') {
        $accounts = mysqli_query($conn, "SELECT *  FROM accounts WHERE id = $accountId");
        if ($accounts->fetch_assoc()['role'] == 'user') {
            mysqli_query($conn, "DELETE FROM accounts WHERE id=$accountId");
            $_SESSION['message'] = "Delete '.$id.' successfully";
            header('Location: listAdministration.php');
            exit();
        } else {
            $_SESSION['message'] = "Can not delete '.$id.' Admin";
            header('Location: listAdministration.php');
        }
    }
}

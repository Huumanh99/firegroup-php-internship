<?php
session_start();
include_once("./connect/connectDB.php");

// Check logged user or not
if (isset($_COOKIE['email'])) {
  if ($_SESSION['role'] == 'admin') {
    header('location:  ./admin/listAdministration.php');
  } else {
    header('location: ./user/listUser.php');
  }
}

// Register 
$name = "";
$email    = "";
$errors = array();
if (isset($_POST['register'])) {

  // receive all input values from the form
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);
  $password_confirm = mysqli_real_escape_string($conn, $_POST['password_confirm']);

  if (empty($name)) {
    array_push($errors, "Name is required");
  }
  if (empty($email)) {
    array_push($errors, "Email is required");
  }
  if (empty($password)) {
    array_push($errors, "Password is required");
  }
  if ($password != $password_confirm) {
    array_push($errors, "The two passwords do not match");
  }

  // first check the database to make sure 
  // a user does not already exist with the same name and/or email
  $user_check_query = "SELECT * FROM accounts WHERE name='$name' OR email='$email' LIMIT 1";
  $result = mysqli_query($conn, $user_check_query);
  $user = mysqli_fetch_assoc($result);

  if ($user) { // if user exists
    if ($user['name'] === $name) {
      array_push($errors, "name already exists");
    }

    if ($user['email'] === $email) {
      array_push($errors, "email already exists");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
    $password = md5($password);

    $query = "INSERT INTO accounts (name, email, password) 
  			  VALUES('$name', '$email', '$password')";
    mysqli_query($conn, $query);
    $_SESSION['name'] = $name;
    $_SESSION['success'] = "You have registered successfully";
    header('location: login.php');
  }
}

// Use cookies to save emails and passwords
if (isset($_COOKIE['email']) && $_COOKIE['password']) {
  $email = mysqli_real_escape_string($conn, $_COOKIE['email']);
  $password = mysqli_real_escape_string($conn, $_COOKIE['password']);

  if (count($errors) == 0) {
    $password = md5($password);
    $query = "SELECT * FROM accounts WHERE  email='$email' AND password='$password'";
    $results = mysqli_query($conn, $query);
    if (mysqli_num_rows($results) > 0) {
      $val = mysqli_fetch_array($results);
      $_SESSION['id'] = $val['id'];
      $_SESSION['name'] = $val['name'];
      $_SESSION['role'] = $val['role'];
      $_SESSION['email'] = $email;
      $_SESSION['success'] = "You are now logged in";

      if ( $_SESSION['role'] && $_SESSION['role'] == 'admin') {
        header('location:  ./admin/listAdministration.php');
      } else {
        header('location: ./product/listProduct.php');
      }
    }
  } else {
    array_push($errors, "Wrong email/password combination");
  }
}

// Check and login
if (isset($_POST['login'])) {

  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);

  if (empty($email)) {
    array_push($errors, "Email is required");
  }
  if (empty($password)) {
    array_push($errors, "Password is required");
  }
  if (isset($_POST["remember_me"])) {
    setcookie("email", $_POST["email"], time() + 86400, '/');
    setcookie("password", $_POST["password"], time() + 86400, '/');
    header('location:  ./admin/listAdministration.php');
  } else {
    if (count($errors) == 0) {
      $password = md5($password);
      $query = "SELECT * FROM accounts WHERE  email='$email' AND password='$password'";
      $results = mysqli_query($conn, $query);
      if (mysqli_num_rows($results) > 0) {
        $val = mysqli_fetch_array($results);
        $_SESSION['id'] = $val['id'];
        $_SESSION['name'] = $val['name'];
        $_SESSION['role'] = $val['role'];
        $_SESSION['email'] = $email;
        $_SESSION['success'] = "You are now logged in";

        if ($_SESSION['role'] == 'admin') {
          header('location:  ./admin/listAdministration.php');
        } else {
          header('location: ./product/listProduct.php');
        }
      }
    } else {
      array_push($errors, "Wrong email/password combination");
    }
  }
}

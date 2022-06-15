<?php
include('handler.php');
if (isset($_COOKIE['email'])) {
    $email = $_COOKIE['email '];
    header('location:  ./admin/listAdministration.php');
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login form</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./style/styles.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <main>
        <div class="container">
            <div class="login">
                <form action="login.php" method="post">
                    <?php include('errors.php'); ?>
                    <h1>Form Login</h1>
                    <div class="input-box">
                        <input type="text" name="email" value="<?php echo $email; ?>" placeholder="Input email" id="email">
                    </div>
                    <div class="input-box">
                        <input type="password" name="password" value="<?php echo $password; ?>" placeholder="Input password" id="password">
                    </div>
                    <div class="btn-box">
                        <button name="login" type="submit">Login</button>
                        Ghi nhớ đăng nhập: <input type="checkbox" name="remember_me" id="remember_me" value="1" /><br />
                        <p class="link">Not yet a member? <a href="register.php">Sign up</a></p>

                    </div>
                </form>

            </div>
        </div>
    </main>
</body>

</html>

<?php include('handler.php'); ?>
<!DOCTYPE html>
<html>

<head>
    <title>Register form</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./style/styles.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <main>
        <div class="container">
            <div class="register-form">
                <form action="register.php" method="post">

                    <?php include('errors.php'); ?>

                    <h1>Form Register Account</h1>
                    <div class="input-box">
                        <input type="text" id="name" name="name" value="<?php echo $name; ?>" placeholder="Input name">
                    </div>
                    <div class="input-box">
                        <input type="text" id="email" name="email" value="<?php echo $email; ?>" placeholder="Input email">
                    </div>
                    <div class="input-box">
                        <input type="password" name="password" placeholder="Input password">
                    </div>

                    <div class="input-box">
                        <input type="password" id="password_confirm" name="password_confirm" placeholder=" Input confirm password">
                    </div>
                    <div class="btn-box">
                        <button type="submit" name="register">Register</button>
                        <p>Already a member? <a href="login.php">Sign in</a></p>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>

</html>

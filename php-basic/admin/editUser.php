<?php
include_once("../connect/connectDB.php");
include("./handlerBE.php");

if (!isset($_GET['edit'])) {
    $id = isset($_GET['id']) ? (int)$_GET['id'] : '';
    $update = true;
    $record =  getAccount($conn, $id);
    if (count($record) > 0) {
        $record = getAccount($conn, $id);
        $role =  $record['role'];
        $name = $record['name'];
        $email =  $record['email'];
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
                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="Role">Role:</label>
                            <div class="col-sm-6">
                                <select name="role" class="form-control" id="role">
                                    <option value="admin" <?php if ($role == "admin") echo 'selected="selected"'; ?>>Admin</option>
                                    <option value="user" <?php if ($role == "user") echo 'selected="selected"'; ?>>User</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="Name">Name (*):</label>
                            <div class="col-sm-6">
                                <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="email">Email(*)</label>
                            <div class="col-sm-6">
                                <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button class="btn" type="submit" name="update" style="background: #556B2F;">update</button>
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
function getAccount($conn, $id)
{
    $product = "";
    $sql = "SELECT * FROM accounts WHERE id = $id";
    if ($result = $conn->query($sql)) {
        $product = mysqli_fetch_array($result);
        $result->close();
    }
    return $product;
}

?>

<?php
session_start();
include_once("../connect/connectDB.php");
?>
<?php if (isset($_SESSION['id']) && !empty($_SESSION['id'])) : ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <title>Admin</title>
    </head>

    <body>
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#"></a>
                </div>
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#">Home</a></li>
                    <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Page 1 <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Page 1-1</a></li>
                            <li><a href="#">Page 1-2</a></li>
                            <li><a href="#">Page 1-3</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Page 2</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#"><span class="glyphicon glyphicon-user"><?php echo $_SESSION['name']; ?></span></a></li>
                    <li><a href="../unset-cookie.php"><span class="glyphicon glyphicon-log-in"></span> Log out</a></li>
                </ul>
            </div>
        </nav>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3">
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == "admin") : ?>
                        <a href="listAdministration.php" class="list-group-item">Admin Management</a>
                    <?php endif ?>
                    <a href="../product/listProduct.php" class="list-group-item">Products Management</a>
                </div>
                <?php if (isset($_SESSION['name']) && $_SESSION['role'] == "admin") : ?>
                    <div class="col-sm-9">
                        <h2 style="text-align: center">List of Users</h2>
                        <div class="row mb" style="text-align:center;width: 100%;display: flex; justify-content: center;">
                            <?php
                            $result = getDb($conn);
                            if ($result->num_rows) {
                                echo "<table border='1'>
                                <tr>
                                    <th>STT</th>
                                    <th>Role</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Created_at</th>
                                    <th>Update_at</th>
                                    <th>Action</th>
                                </tr>";
                                $key = 1;
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $key++ . "</td>";
                                    echo "<td>" . $row['role'] . "</td>";
                                    echo "<td>" . $row['name'] . "</td>";
                                    echo "<td>" . $row['email'] . "</td>";
                                    echo "<td>" . $row['created_at'] . "</td>";
                                    echo "<td>" . $row['updated_at'] . "</td>";
                                    echo "<td>
                                <a href='../admin/handlerBE.php?aid={$row['id']}'>Delete</a> || 
                                <a href='../admin/editUser.php?id={$row['id']}'>Edit</a>
                                </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "0 results";
                            }
                            $conn->close();
                            ?>
                        </div>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </body>

    </html>
<?php endif ?>
<?php
function getDb($conn)
{
    $sql = "SELECT * FROM accounts";
    if ($result = $conn->query($sql)) {
        return $result;
    }
    $conn->close();
}
?>

<?php
session_start();
if (!empty($_GET['action']) && $_GET['action'] == 'delete') {
    $id = $_GET['id'];
    unset($_SESSION['cart'][$id]);
    header("Location: list_cart.php");
    exit;
}
?>

<?php if (isset($_SESSION['cart'])) : ?>
    <div style="text-align:center;">
        <h2>Danh sách sản phẩm</h2>
    </div>
    <div style="text-align:center;">
        <h2><a href="products.php">Tiếp tục mua</a></h2>
    </div>
    <div style=" margin: 20px; flex-direction: column;
    align-items: center; display: flex;
    gap: 10px;">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID Products</th>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Produced_date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($_SESSION['cart'] as $key => $val) { ?>
                    <tr>
                        <td><?= $key ?></td>
                        <td><?= $val['name'] ?></td>
                        <td><?= $val['quantity'] ?></td>
                        <td><?= $val['price'] ?>Đ</td>
                        <td><?= $val['produced_date'] ?></td>
                        <td><a href="list_cart.php?id=<?php echo $key ?>&action=delete">Xóa</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
<?php else : ?>
    <p>Không có gì trong giỏ</p>

<?php endif; ?>
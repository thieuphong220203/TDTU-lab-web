<?php
require_once("db.php");
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$sql = "SELECT * FROM product";
$result = mysqli_query($conn, $sql);
?>

<?php
$sql = "SELECT count(*) FROM product";
$res = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($res);
$count = $row['count(*)'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Trang chủ - Danh sách sản phẩm</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        td {
            vertical-align: middle;
        }

        img {
            max-height: 100px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col col-md-10">
                <h3 class="my-4 text-center">Product List</h3>
                <div class="d-flex justify-content-between">
                    <a class="btn btn-sm btn-secondary mb-4" href="add_product.php">Add Product</a>
                    <a href="logout.php">Logout</a>
                </div>
                <table class="table-bordered table table-hover text-center">
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td class='align-middle'><img
                           src='../images/{$row['image']}'></td>";
                        echo "<td class='align-middle'>{$row['name']}</td>";
                        echo "<td class='align-middle'>{$row['price']} VND</td>";
                        echo "<td class='align-middle'>{$row['description']}</td>";
                        echo "<td class='align-middle'>";
                        echo "<button type='button' class='btn btn-sm btn-primary mr-1 edit-btn' data-product-id={$row['id']} data-product-name='{$row['name']}' data-product-price='{$row['price']}' data-product-desc='{$row['description']}'>
                           <i class='fas fa-pen'></i></button>";
                        echo "<button type='button' class='btn btn-sm btn-danger delete-btn' data-product-id='{$row['id']}'>
                           <i class='fas fa-trash-alt'></i></button>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
                <p class="text-right">Total products: <strong><?php echo $count ?></strong></p>
            </div>
        </div>
    </div>

    <!-- Delete Confirm Modal -->
    <div id="deleteModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <hp class="modal-title">Delete a Product</hp>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete <strong>iPhone XS MAX</strong> ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                    <form action="delete.php" method="POST">
                        <input type="hidden" name="product_id" id="delete_product_id" />
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </div>

            </div>

        </div>
    </div>


    <!-- Edit Confirm Modal -->
    <div id="editModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <hp class="modal-title">Update product <strong>iPhone XS MAX</strong></hp>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="edit.php">
                        <div class="form-group">
                            <label for="name">Product Name</label>
                            <input id="name" name="name" type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input id="price" name="price" type="number" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="desc">Description</label>
                            <input id="desc" name="desc" type="text" class="form-control">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>

                    <input type="hidden" name="product_id" id="edit_product_id">
                    <button type="submit" class="btn btn-sm btn-success">Save</button>
                </div>
                </form>

            </div>

        </div>
    </div>

    <script>
        $(document).ready(function() {

            // show delete confirm
            $(".delete-btn").click(function() {
                var productId = $(this).data("product-id"); // Get product ID from the button
                $("#delete_product_id").val(productId); // Set product ID in the hidden field
                $('#deleteModal').modal({
                    backdrop: 'static',
                    keyboard: false
                });
            });

            // show edit confirm
            $(".edit-btn").click(function() {

                $('#editModal').modal({
                    backdrop: 'static',
                    keyboard: false
                });
            });

            $(".edit-btn").click(function() {
                let productId = $(this).data("product-id");
                let productName = $(this).data("product-name");
                let productPrice = $(this).data("product-price");
                let productDesc = $(this).data("product-desc");

                $("#edit_product_id").val(productId); // Set product ID
                $("#name").val(productName); // Set product name
                $("#price").val(productPrice); // Set product price
                $("#desc").val(productDesc); // Set product description

                $("#edit_product_id").val(productId);
            });
        });
    </script>

</body>

</html>
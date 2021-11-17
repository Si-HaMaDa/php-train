<?php
$title  = 'Products Page';

require_once 'includes/header.php';

require_once 'includes/sidebar.php';

if ($_GET['deleteProduct']) {
    $stmt = $conn->prepare("DELETE FROM products WHERE id='" . $_GET['deleteProduct'] . "'");
    $stmt->execute();
    echo "<script>window.location = 'products.php';</script>";
}

$stmt = $conn->prepare("SELECT COUNT(*) FROM products WHERE name LIKE '%" . $_GET['search'] . "%'");
$total = $stmt->execute();
$total = $stmt->fetch()[0];

$totalPages = ceil($total / 10) ? ceil($total / 10) : 1;
$page = isset($_GET['page']) && $_GET['page'] > 0 ? $_GET['page'] : 1;
$page = $page > $totalPages ? $totalPages : $page;
$start = ($page - 1) * 10;


$stmt = $conn->prepare("SELECT * FROM products WHERE name LIKE '%" . $_GET['search'] . "%' LIMIT " . $start . ", 10");
$stmt->execute();
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$result = $stmt->fetchAll();
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <?php if ($errormsg) {
    ?>
        <div class="alert m-4 alert-danger"><?php echo $errormsg; ?></div>
    <?php
    } ?>
    <h2>Products</h2>
    <a href="addproduct.php" class="btn btn-success">Add</a>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">name</th>
                    <th scope="col">category</th>
                    <th scope="col">seller</th>
                    <th scope="col">price</th>
                    <th scope="col">stock</th>
                    <th scope="col">image</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php

                if (count($result) > 0) {
                    foreach ($result as $productKey => $productValue) {
                        echo '<tr>
                                <td>' . $productValue['id'] . '</td>
                                <td>' . $productValue['name'] . '</td>
                                <td>' . $productValue['category'] . '</td>
                                <td>' . $productValue['seller'] . '</td>
                                <td>' . $productValue['price'] . '</td>
                                <td>' . $productValue['stock'] . '</td>
                                <td><img width="75" src="' . $productValue['image'] . '"></td>
                                <td>
                                    <a href="editproduct.php?editProduct=' . $productValue['id'] . '" class="btn btn-primary btn-sm">Edit</a> |
                                    <a href="products.php?deleteProduct=' . $productValue['id'] . '" class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>';
                    }
                }
                ?>
            </tbody>

        </table>
        <style>
            .active {
                background: #ccc;
            }
        </style>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item"><a class="page-link" href="products.php?page=1"> START </a></li>
                <!-- <li class="page-item"><a class="page-link" href="products.php?page=<?= $page < 2 ?  1 : $page - 1 ?>"> Pervious </a></li> -->

                <?php
                // Create pgination links 
                for ($i = $page - 2; $i <= $page + 2; $i++) {

                    if ($i < 1) continue; // Skip if page less than 1

                    if ($i > $totalPages) break; // Stop the loop if we reach max pages

                    if ($i == $page) {
                        echo '<li class="page-item"><a class="active page-link" href="javascript:;">' . $i . '</a></li>';
                    } else {
                        echo '<li class="page-item"><a class="page-link" href="products.php?page=' . $i . '">' . $i . '</a></li>';
                    }
                }
                ?>

                <!-- <li class="page-item"><a class="page-link" href="products.php?page=<?= $page >= $totalPages ? $totalPages : $page + 1 ?>"> Next </a></li> -->
                <li class="page-item"><a class="page-link" href="products.php?page=<?= $totalPages ?>"> END </a></li>
            </ul>
        </nav>
    </div>
</main>

<?php

require_once 'includes/footer.php';

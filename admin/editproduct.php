<?php
require_once 'includes/header.php';

require_once 'includes/sidebar.php';

$stmt = $conn->prepare("SELECT * FROM products WHERE id='" . $_GET['editProduct'] . "'");
$stmt->execute();
$product = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$product = $stmt->fetchAll()[0];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $errormsg = '';
    $uploadOk = 1;

    $target_file = $product['image'];

    if (!empty($_FILES["image"]["tmp_name"])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        $uploadOk = ($check !== false) ? 1 : 0;
        // Check if file already exists
        if (file_exists($target_file)) {
            $errormsg .= "Sorry, file already exists.<br>";
            $uploadOk = 0;
        }
        // Allow certain file formats
        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            $errormsg .= "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $errormsg .=  "Sorry, your file was not uploaded.<br>";
            // if everything is ok, try to upload file
        } else {
            if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $errormsg .= "Sorry, there was an error uploading your file.";
            }
        }
    }

    if (!filter_var($_POST['price'], FILTER_VALIDATE_INT)) {
        $errormsg .= "Please set price.";
        $uploadOk = 0;
    }

    if ($uploadOk != 0) {
        $stmt = $conn->prepare("UPDATE products SET name=:name, category=:category, seller=:seller, price=:price, stock=:stock, description=:description, image=:image WHERE id='" . $_GET['editProduct'] . "'");

        $stmt->bindParam(':name', test_input($_POST['name']));
        $stmt->bindParam(':category', test_input($_POST['category']));
        $stmt->bindParam(':seller', test_input($_POST['seller']));
        $stmt->bindParam(':price', test_input($_POST['price']));
        $stmt->bindParam(':stock', test_input($_POST['stock']));
        $stmt->bindParam(':description', test_input($_POST['description']));
        $stmt->bindParam(':image', $target_file);
        // use exec() because no results are returned
        $stmt->execute();
        // echo "New record created successfully.";
        echo "<script>window.location = 'products.php';</script>";
    }
}
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <?php if ($errormsg) {
    ?>
        <div class="alert m-4 alert-danger"><?= $errormsg ?></div>
    <?php
    } ?>
    <h2>Edit Product</h2>
    <div class="container">

        <form method="POST" enctype="multipart/form-data">
            <div class="form-group m-3">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="name@example.com" value="<?= $product['name'] ?>">
            </div>
            <div class="form-group m-3">
                <label for="category">Category name</label>
                <input type="text" class="form-control" name="category" id="category" placeholder="category name" value="<?= $product['category'] ?>">
            </div>
            <div class="form-group m-3">
                <label for="seller">Seller name</label>
                <input type="text" class="form-control" name="seller" id="seller" placeholder="Seller name" value="<?= $product['seller'] ?>">
            </div>
            <div class="form-group m-3">
                <label for="price">Price</label>
                <input type="number" class="form-control" name="price" id="price" placeholder="Price" value="<?= $product['price'] ?>">
            </div>
            <div class="form-group m-3">
                <label for="stock">Stock</label>
                <input type="number" class="form-control" name="stock" id="stock" placeholder="stock" value="<?= $product['stock'] ?>">
            </div>
            <div class="form-group m-3">
                <label for="description">Description</label>
                <textarea class="form-control" name="description" id="description" placeholder="description"><?= $product['description'] ?></textarea>
            </div>
            <div class="form-group m-3">
                <label for="image">Image</label>
                <input type="file" class="form-control" name="image" id="image" placeholder="image">
                <img width="300" src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit">Edit product</button>
        </form>
    </div>
</main>

<?php

require_once 'includes/footer.php';

<?php
require_once 'includes/header.php';

require_once 'includes/sidebar.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $errormsg = '';

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $uploadOk = 1;
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

    if (!filter_var($_POST['price'], FILTER_VALIDATE_INT)) {
        $errormsg .= "Please set price.";
        $uploadOk = 0;
    }

    if ($uploadOk != 0) {
        $stmt = $conn->prepare("INSERT INTO products (name, category, seller, price, stock, description, image) VALUES (:name,:category,:seller,:price,:stock, :description, :image)");

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
        <div class="alert m-4 alert-danger"><?php echo $errormsg; ?></div>
    <?php
    } ?>
    <h2>Add Product</h2>
    <div class="container">

        <form method="POST" enctype="multipart/form-data">
            <div class="form-group m-3">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="name">
            </div>
            <div class="form-group m-3">
                <label for="category">Category name</label>
                <input type="text" class="form-control" name="category" id="category" placeholder="category name">
            </div>
            <div class="form-group m-3">
                <label for="seller">Seller name</label>
                <input type="text" class="form-control" name="seller" id="seller" placeholder="Seller name">
            </div>
            <div class="form-group m-3">
                <label for="price">Price</label>
                <input type="number" class="form-control" name="price" id="price" placeholder="Price">
            </div>
            <div class="form-group m-3">
                <label for="stock">Stock</label>
                <input type="number" class="form-control" name="stock" id="stock" placeholder="stock">
            </div>
            <div class="form-group m-3">
                <label for="description">Description</label>
                <textarea class="form-control" name="description" id="description" placeholder="description"></textarea>
            </div>
            <div class="form-group m-3">
                <label for="image">Image</label>
                <input type="file" class="form-control" name="image" id="image" placeholder="image">
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit">Save product</button>
        </form>
    </div>
</main>

<?php

require_once 'includes/footer.php';

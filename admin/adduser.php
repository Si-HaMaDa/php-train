<?php
require_once 'includes/header.php';

require_once 'includes/sidebar.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $conn->prepare("SELECT email FROM users WHERE email='" . $_POST['email'] . "'");
    $stmt->execute();
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();

    if (count($result) > 0) {
        $error = 'true';
        $errorMSG = 'Email Already registerd';
    } else {
        $sql = "INSERT INTO users (name, email, password, isAdmin) VALUES ('" . test_input($_POST['name']) . "', '" . test_input($_POST['email']) . "', '" . test_input($_POST['password']) . "', '" . (int)$_POST['isAdmin'] . "')";
        // use exec() because no results are returned
        $conn->exec($sql);

        // echo "New record created successfully.";
        echo "<script>window.location = 'users.php';</script>";
    }
}
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <?php if ($errormsg) {
    ?>
        <div class="alert m-4 alert-danger"><?php echo $errormsg; ?></div>
    <?php
    } ?>
    <h2>Add Users</h2>
    <div class="container">

        <form method="POST">
            <div class="form-group m-3">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="name@example.com">
            </div>
            <div class="form-group m-3">
                <label for="email">Email address</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com">
            </div>
            <div class="form-group m-3">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Password">
            </div>
            <div class="checkbox form-group mb-3">
                <label>
                    <input type="checkbox" value="1" name="isAdmin"> Is Admin
                </label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit">Save user</button>
        </form>
    </div>
</main>

<?php

require_once 'includes/footer.php';

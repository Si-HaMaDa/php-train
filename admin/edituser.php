<?php
require_once 'includes/header.php';

require_once 'includes/sidebar.php';

$stmt = $conn->prepare("SELECT * FROM users WHERE id='" . $_GET['editUser'] . "'");
$stmt->execute();
$user = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$user = $stmt->fetchAll()[0];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $pass = ' ';

    if ($_POST['password']) {
        $pass = ",password='" . password_hash($_POST['password'], PASSWORD_DEFAULT) . "' ";
    }

    $sql = "UPDATE users SET name='" . test_input($_POST['name']) . "', email='" . test_input($_POST['email']) . "',  isAdmin='" . (int)$_POST['isAdmin'] . "'" . $pass . "WHERE id=" . $_GET['editUser'] . "";

    // use exec() because no results are returned
    $conn->exec($sql);

    echo "<script>window.location = 'users.php';</script>";
}
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <?php if ($errormsg) {
    ?>
        <div class="alert m-4 alert-danger"><?= $errormsg ?></div>
    <?php
    } ?>
    <h2>Edit Users</h2>
    <div class="container">

        <form method="POST">
            <div class="form-group m-3">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="name@example.com" value="<?= $user['name'] ?>">
            </div>
            <div class="form-group m-3">
                <label for="email">Email address</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com" value="<?= $user['email'] ?>">
            </div>
            <div class="form-group m-3">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Password" value="">
            </div>
            <div class="checkbox form-group mb-3">
                <label>
                    <input <?= $user['isAdmin'] ? 'checked' : '' ?> type="checkbox" value="1" name="isAdmin"> Is Admin
                </label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit">Edit user</button>
        </form>
    </div>
</main>

<?php

require_once 'includes/footer.php';

/* 
$sql = "UPDATE users SET name='" . test_input($_POST['name']) . "', email='" . test_input($_POST['email']) . "',  isAdmin='" . (int)$_POST['isAdmin'] . "'";

// UPDATE users SET name='me', email='email@m.com',  isAdmin='1' 

// UPDATE users SET name='me', email='email@m.com',  isAdmin='1' WHERE id=1

// UPDATE users SET name='me', email='email@m.com',  isAdmin='1', password='123456'

if ($_POST['password']) {
    $sql .= ",password='" . password_hash($_POST['password'], PASSWORD_DEFAULT) . "'";
}

$sql .= " WHERE id=" . $_GET['editUser'] . "";
*/
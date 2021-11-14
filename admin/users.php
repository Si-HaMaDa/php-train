<?php
$title  = 'Users Page';

require_once 'includes/header.php';

require_once 'includes/sidebar.php';

if ($_GET['deleteUser']) {
    if ($_GET['deleteUser'] == $_SESSION['email']) {
        $errormsg = 'You cant delete';
    } else {
        $stmt = $conn->prepare("DELETE FROM users WHERE email='" . $_GET['deleteUser'] . "'");
        $stmt->execute();
        echo "<script>window.location = 'users.php';</script>";
    }
}

$stmt = $conn->prepare("SELECT * FROM users");
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
    <h2>Users</h2>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">name</th>
                    <th scope="col">email</th>
                    <th scope="col">phone</th>
                    <th scope="col">isAdmin</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php

                if (count($result) > 0) {
                    foreach ($result as $userKey => $userValue) {
                        echo '<tr>
                                <td>' . ($userKey + 1) . '</td>
                                <td>' . $userValue['name'] . '</td>
                                <td>' . $userValue['email'] . '</td>
                                <td>' . $userValue['phone'] . '</td>
                                <td>' . $userValue['isAdmin'] . '</td>
                                <td>
                                    <a href="#" class="btn btn-primary btn-sm">Edit</a> |
                                    <a href="users.php?deleteUser=' . $userValue['email'] . '" class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>';
                    }
                }
                ?>
            </tbody>

        </table>
    </div>
</main>

<?php

require_once 'includes/footer.php';

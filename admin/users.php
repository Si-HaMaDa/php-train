<?php
$title  = 'Users Page';

require_once 'includes/header.php';

require_once 'includes/sidebar.php';

if ($_GET['deleteUser']) {
    // if ($_GET['deleteUser'] == $_SESSION['email']) {
    //     $errormsg = 'You cant delete';
    // } else {
    $stmt = $conn->prepare("DELETE FROM users WHERE id='" . $_GET['deleteUser'] . "'");
    $stmt->execute();
    echo "<script>window.location = 'users.php';</script>";
    // }
}

$stmt = $conn->prepare("SELECT COUNT(*) FROM users");
$total = $stmt->execute();
$total = $stmt->fetch()[0];

$totalPages = ceil($total / 10);

$page = $_GET['page'] <= 0 ? '1' : $_GET['page'];
$page = $page > $totalPages ? $totalPages : $page;
$start = ($page - 1) * 10;

$stmt = $conn->prepare("SELECT * FROM users LIMIT " . $start . ", 10");
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
    <a href="adduser.php" class="btn btn-success">Add</a>
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
                        // <td>' . ($userKey + 1 + ($page - 1) * 10) . '</td>
                        echo '<tr>
                                <td>' . $userValue['id'] . '</td>
                                <td>' . $userValue['name'] . '</td>
                                <td>' . $userValue['email'] . '</td>
                                <td>' . $userValue['phone'] . '</td>
                                <td>' . $userValue['isAdmin'] . '</td>
                                <td>
                                    <a href="edituser.php?editUser=' . $userValue['id'] . '" class="btn btn-primary btn-sm">Edit</a> |
                                    <a href="users.php?deleteUser=' . $userValue['id'] . '" class="btn btn-danger btn-sm">Delete</a>
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
                <li class="page-item"><a class="page-link" href="users.php?page=1"> START </a></li>
                <!-- <li class="page-item"><a class="page-link" href="users.php?page=<?= $page < 2 ?  1 : $page - 1 ?>"> Pervious </a></li> -->

                <?php
                // Create pgination links 
                for ($i = $page - 2; $i <= $page + 2; $i++) {

                    if ($i < 1) continue; // Skip if page less than 1

                    if ($i > $totalPages) break; // Stop the loop if we reach max pages

                    if ($i == $page) {
                        echo '<li class="page-item"><a class="active page-link" href="javascript:;">' . $i . '</a></li>';
                    } else {
                        echo '<li class="page-item"><a class="page-link" href="users.php?page=' . $i . '">' . $i . '</a></li>';
                    }
                }
                ?>

                <!-- <li class="page-item"><a class="page-link" href="users.php?page=<?= $page >= $totalPages ? $totalPages : $page + 1 ?>"> Next </a></li> -->
                <li class="page-item"><a class="page-link" href="users.php?page=<?= $totalPages ?>"> END </a></li>
            </ul>
        </nav>
    </div>
</main>

<?php

require_once 'includes/footer.php';

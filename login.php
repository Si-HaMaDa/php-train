<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['signout']) {
    $_SESSION['login'] = null;
    setcookie('login', null, time());
}

if ($_SESSION['login'] || $_COOKIE['login']) {
    header('location: ./admin/index.php');
    die();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "php-train";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }

    try {
        if ($_POST['type'] == 'register') {

            $stmt = $conn->prepare("SELECT email, password FROM users WHERE email='" . $_POST['email'] . "'");
            $stmt->execute();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetchAll();

            if (count($result) > 0) {
                $error = 'true';
                $errorMSG = 'Email Already registerd';
            } else {
                $sql = "INSERT INTO users (name, email, password) VALUES ('" . $_POST['name'] . "', '" . $_POST['email'] . "', '" . $_POST['password'] . "')";
                // use exec() because no results are returned
                $conn->exec($sql);


                echo "New record created successfully, You can login NOW";
            }
        } else {

            $stmt = $conn->prepare("SELECT * FROM users WHERE email='" . $_POST['email'] . "' AND password='" . $_POST['password'] . "'");
            $stmt->execute();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetchAll();

            if (count($result) > 0) {
                if ($result[0]['isAdmin']) {
                    if ($_POST['remeber'] == 'on') {
                        setcookie('login', true, time() + (86400 * 30));
                        setcookie('email', $result[0]['email'], time() + (86400 * 30));
                    } else {
                        $_SESSION['login'] = true;
                        $_SESSION['email'] = $result[0]['email'];
                    }
                    header('location: admin/index.php');
                    die();
                } else {
                    if ($_POST['remeber'] == 'on') {
                        setcookie('login', true, time() + (86400 * 30));
                        setcookie('email', $result[0]['email'], time() + (86400 * 30));
                    } else {
                        $_SESSION['login'] = true;
                        $_SESSION['email'] = $result[0]['email'];
                    }
                    header('location: index.php');
                    die();
                }
            } else {
                $error = true;
            }
            // use exec() because no results are returned
            var_dump($result);
            echo "New record created successfully";
        }
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
    $conn = null;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="assets/css/login.css">
</head>

<body>
    <h2>Weekly Coding Challenge #1: Sign in/up Form</h2>
    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>?name=fromget" method="POST">
                <h1>Create Account</h1>
                <input type="text" placeholder="Name" name="name" />
                <input type="email" placeholder="Email" name="email" />
                <input type="password" placeholder="Password" name="password" />
                <?php if ($error) : ?>
                    <span style="color: red"><?php echo $errorMSG; ?></span>
                <?php endif; ?>
                <input type="submit" value="register" name="type">
            </form>
        </div>
        <div class="form-container sign-in-container">
            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>?name=fromget" method="POST">
                <h1>Sign in</h1>
                <input type="email" placeholder="Email" name="email" />
                <input type="password" placeholder="Password" name="password" />
                <input type="checkbox" name="remeber" id="remember">
                <label for="remember">Rember me</label>
                <?php if ($error) : ?>
                    <span style="color: red">Check youe user and password</span>
                <?php endif; ?>
                <input type="submit" value="login" name="type">
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Welcome Back!</h1>
                    <p>To keep connected with us please login with your personal info</p>
                    <button class="ghost" id="signIn">Sign In</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Hello, Friend!</h1>
                    <p>Enter your personal details and start journey with us</p>
                    <button class="ghost" id="signUp">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <p>
            Created with <i class="fa fa-heart"></i> by
            <a target="_blank" href="https://florin-pop.com">Florin Pop</a>
            - Read how I created this and how you can join the challenge
            <a target="_blank" href="https://www.florin-pop.com/blog/2019/03/double-slider-sign-in-up-form/">here</a>.
        </p>
    </footer>

    <script>
        const signUpButton = document.getElementById('signUp');
        const signInButton = document.getElementById('signIn');
        const container = document.getElementById('container');

        signUpButton.addEventListener('click', () => {
            container.classList.add("right-panel-active");
        });

        signInButton.addEventListener('click', () => {
            container.classList.remove("right-panel-active");
        });
    </script>
</body>

</html>
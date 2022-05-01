<?php
// Firstly, initialize the session to save the user state
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["is_loggedin"]) && $_SESSION["is_loggedin"] === true) {
    header("location: dashboard.php");
    exit;
}

// Include config file to load our database connection 
require_once "config.php";

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = '{$username}' and password='{$password}'";

        // query the database 
        $result = mysqli_query($connection, $sql);

        $row = mysqli_num_rows($result);

        // Password is correct, so start a new session
        if ($row == 1) {
            session_start();

            // Store data in session variables
            $_SESSION["is_loggedin"] = true;
            $_SESSION["id"] = $id;
            $_SESSION["username"] = $username;

            // Redirect user to welcome page
            header("location: dashboard.php");
        } else {
            $error =  "username or password is incorrect";
        }
    }

    // Close connection
    mysqli_close($connection);
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="uft-8">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style3.css">
    <title>Members area</title>
</head>

<body>
    <nav>
         <a href="index.html">Home</a> 
    </nav>
    <h1>Members area</h1>
    <main class="container-x">
        <img src="images/jersey.jpg" alt="jersey">

        <?php if (!is_null($error) && !empty($error)) { ?>
            <div class="error-msg">
                <?php echo $error; ?>
            </div>
        <?php } ?>


        <div class="success-msg">
            Welcome Back!
        </div>
        <br><br><br>

        <div class="form-container">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

                <div class="form-input">
                    <div class="">
                        <i class="fa fa-user fa-2x cust" aria-hidden="true"></i>
                        <input class="username" type="text" name="username" value="" placeholder="Enter Username" required>
                    </div>
                    <div class="">
                        <i class="fa fa-lock fa-2x cust" aria-hidden="true"></i>
                        <input class="password" type="password" name="password" value="" placeholder="Enter Password" required minlength="8">
                    </div>


                    <div class="login">
                        <div class="f-password"><a href="#">Forgot Password?</a></div>

                        <input class="submit" type="submit" name="submit" value="Login">

                    </div>
                </div>

            </form>
        </div>
    </main>

    <footer class="footer">
        <main class="footer-list">
            <a href="#" class="footer-link">Home</a>
            <a href="#" class="footer-link">Lakers</a>
            <a href="#" class="footer-link">Bulls</a>
            <a href="#" class="footer-link">Customer reviews</a>
            <a href="#" class="footer-link">Contact us</a>
        </main>
    </footer>
</body>

</html>
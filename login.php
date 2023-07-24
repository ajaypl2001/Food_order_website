<?php include "partials/dbconnect.php" ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Food Order System</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>

<body>
    <div class="login">
        <h1 class="text-center">Login</h1>
        <br>

        <?php
        if (isset($_SESSION['login'])) {
            echo $_SESSION['login'];
            unset($_SESSION['login']);
        }

        if (isset($_SESSION['no-login-massage'])) {
            echo $_SESSION['no-login-massage'];
            unset($_SESSION['no-login-massage']);
        }
        ?>

        <br>
        <!-- login form starts here  -->
        <form action="" method="POST">
            <span>Username:</span> <br>
            <input type="text" name="username" placeholder="Enter Username"><br><br>
            <span>Password:</span> <br>
            <input type="password" name="password" placeholder="Enter Password"><br><br>
            <input type="submit" name="submit" value="Login" class="btn-primary">
            <br><br>
        </form>
        <!-- login form ends here  -->
        <p class="text-center">Created By : <a href="https://www.facebook.com/">Abhimanyu Kumar</a></p>
    </div>
</body>

</html>

<?php

// Check Wether the Submit Button Clicked or Not 
if (isset($_POST['submit'])) {
    // Process for login
    //1. Get the Data from Login Form
    $username = $_POST['username'];
    $password = $_POST['password'];


    //SQL to Check whether the user with username and password Exists or Not 
    $sql = "SELECT * FROM tbl_admin WHERE username = '$username' AND password = '$password'";
    //Execute SQL Query
    $result = mysqli_query($conn, $sql);
    //count rows to check whether the user exists or not
    $rows = mysqli_num_rows($result);

    if ($rows == 1) {
        //User available and login successfully
        $_SESSION['login'] = "<div class='success'>Login Successfully</div>";
        $_SESSION["user"] = $username; //TO check whether the user logged in or not and logout will unset it
        //Redirect to Home page / Dashboard
        // print_r($siteurl);
        header("Location: " . $siteurl . "admin/");
    } else {
        //Failed to Login
        $_SESSION['login'] = "<div class='error text-center'>Username or Password did not Matched</div>";
        //Redirect to Home page / Dashboard
        // header("location :" . $siteurl . "admin/login.php");
    }
}

?>
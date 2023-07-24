<?php include "partials/menu.php" ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>
        <br><br>

        <?php

        if (isset($_SESSION["add"])) {
            echo $_SESSION["add"]; 
            unset($_SESSION["add"]); 
            echo "<br><br><br>";
        }

        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name</td>
                    <td>
                        <input type="text" name="full_name" placeholder="Enter Your Full Name">
                    </td>
                </tr>
                <tr>
                    <td>Username</td>
                    <td>
                        <input type="text" name="username" placeholder="Your Username">
                    </td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td>
                        <input type="password" name="password" placeholder="Enter Password">
                    </td>
                </tr>
                <tr>
                    <td class="colspan-2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php include "partials/footer.php" ?>

<?php

//process the value from the form and save it in database

//check whether the submit button clicked or not

if (isset($_POST["submit"])) {
    //1. Get the data from form
    $full_name = $_POST["full_name"];
    $username = $_POST["username"];
    $password = $_POST["password"]; //password encryption with MD5
    if ($full_name != "" && $username != "" && $password != "") {
    //2. Sql Query to Save the Data into Database
    $sql = "INSERT INTO `tbl_admin`( `full_name`, `username`, `password`) VALUES ('$full_name','$username','$password ')";

    //3. Execute Query to Data into Database
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn, $sql));

    //4. check whether the (Query is Exquited) Data is Inserted or Not display appropriate massage
    if ($result == true) {
        //Data Inserted
        // echo "Data Insrted";
        //Create a Session Variables to Display Massage
        $_SESSION["add"] = "<div class='success'>Admin Added Successfully</div>";
        //Redirect pags to Manage Admin
        header("location:" . $siteurl . "admin/manage-admin.php");
    } else {
        //Failed To Insert Data
        // echo "Failed to Insert Data";
        //Create a Session Variables to Display Massage
        $_SESSION["add"] = "<div class='error'>Failed TO Add Admin</div>";
        //Redirect pags to Add Admin
        header("location:" . $siteurl . "admin/add-admin.php");
    }
}else{
    echo "All Input Field is required";
}
}

?>
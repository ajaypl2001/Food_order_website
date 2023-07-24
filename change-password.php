<?php include "partials/menu.php" ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br><br>

        <?php

        //Get the ID of Selected Admin
        if (isset($_GET["id"])) {
            $id = $_GET["id"];
        }
        ?>
        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Current Password</td>
                    <td>
                        <input type="password" name="current_password" placeholder="Old Password" ?>
                    </td>
                </tr>
                <tr>
                    <td>New Password</td>
                    <td>
                        <input type="password" name="new_password" placeholder="New Password" ?>
                    </td>
                </tr>
                <tr>
                    <td>Confirm Password</td>
                    <td>
                        <input type="password" name="confirm_password" placeholder="Confirm Password" ?>
                    </td>
                </tr>
                <tr>
                    <td class="colspan-2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" class="btn-secondary" value="Change Password">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php

//check whether the submit button is clicked or not
if (isset($_POST["submit"])) {

    //Get the Data from Form
    $id = $_POST["id"];
    $current_password = $_POST["current_password"];
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];


    //Check whether the user with current ID and current Password Exists or Not
    $sql = "SELECT*FROM `tbl_admin`  WHERE id = $id AND password = '$current_password'";

    //Execute the Query
    $result = mysqli_query($conn, $sql);

    if ($result == true) {
        //Check whether the data is available or not
        $num = mysqli_num_rows($result);

        if ($num == 1) {
            //user Exists and Password can be Changed
            // echo "User Found";
            // Check whether the new password and confirm password match or not
            if ($new_password == $confirm_password) {

                //Update the password
                $sql1 = "UPDATE `tbl_admin` SET `password`='$new_password' WHERE id = $id";

                // Execute Sql Query
                $result1 = mysqli_query($conn, $sql1);

                if ($result1 == true) {

                    //Displaying success massage
                    //Redirect to massage admin page with success massage
                    $_SESSION["change-pwd"] = "<div class='success'>Password Changed Successfully.</div>";
                    //Redirect to Manage Admin Page with massage(success/error)
                    header("location:" . $siteurl . "admin/manage-admin.php");
                } else {

                    //Displaying error massage
                    //Redirect to massage admin page with error massage
                    $_SESSION["change-pwd"] = "<div class='error'>Failed to Change Password.</div>";
                    //Redirect to Manage Admin Page with massage(success/error)
                    header("location:" . $siteurl . "admin/manage-admin.php");
                }
            } else {

                //Redirect to massage admin page with error massage
                $_SESSION["pwd-not-match"] = "<div class='error'>Password did not Match.</div>";
                //Redirect to Manage Admin Page with massage(success/error)
                header("location:" . $siteurl . "admin/manage-admin.php");
            }
        } else {
            //User does not Exist set massage and Redirect
            $_SESSION["user-not-found"] = "<div class='error'>User not Found.</div>";
            //Redirect to Manage Admin Page with massage(success/error)
            header("location:" . $siteurl . "admin/manage-admin.php");
        }
    }
}

?>

<?php include "partials/footer.php" ?>